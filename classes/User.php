<?php

namespace app\classes;

class User
{
    public $id;
    public $login;
    public $phone;
    public $email;
    public $password_hash;

    public static function findByParam($field, $value)
    {
        $db = self::getDb();

        $sql = "SELECT * FROM user WHERE {$field} = :value";

        return $db->findObject($sql, self::class, [
            ':value' => $value
        ]);

    }

    private static function getDb()
    {
        $config = require __DIR__ . '/../config.php';
        return new Db($config['db']['user'], $config['db']['pass'], $config['db']['database']);
    }

    public static function findByUsername($username)
    {
        $db = self::getDb();

        $sql = "SELECT * FROM user WHERE phone = :username OR email = :username LIMIT 1";

        return $db->findObject($sql, self::class, [
            ':username' => $username
        ]);
    }

    /**
     * @return User|null
     */
    public static function getUser(): ?User
    {
        $id = Session::read('user_id');
        if ($id && $user = self::findByParam('id', $id)) {
            return $user;
        }
        return null;
    }

    public function create()
    {
        $db = self::getDb();

        $sql = 'INSERT INTO user (login, phone, email, password_hash) VALUES (:login, :phone, :email, :password_hash)';

        return $db->execute($sql, [
            ':login' => $this->login,
            ':phone' => $this->phone,
            ':email' => $this->email,
            ':password_hash' => $this->password_hash,
        ]);
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): void
    {
        $this->login = $login;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @param mixed $password_hash
     */
    public function setPasswordHash($password_hash): void
    {
        $this->password_hash = $password_hash;
    }

    public function update(ProfileForm $form)
    {
        $config = require __DIR__ . '/../' . 'config.php';

        $set_sql = '';
        $params = [
            ':id' => $this->id,
        ];

        foreach (['login', 'email', 'phone'] as $param) {
            if ($this->$param !== $form->$param) {
                $set_sql .= "{$param} = :{$param}, ";
                $params[":{$param}"] = $form->$param;
            }
        }

        if (!empty($form->new_password)) {
            $new_password_hash = md5($config['salt'] . $form->new_password);
            $set_sql .= "password_hash = :password_hash, ";
            $params[":password_hash"] = $new_password_hash;
        }

        if ($set_sql !== '') {
            $set_sql = rtrim($set_sql, ' ,');
            $db = self::getDb();

            $sql = "UPDATE user SET {$set_sql} WHERE id = :id";
            return $db->execute($sql, $params);
        }

        return true;
    }
}