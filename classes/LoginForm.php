<?php

namespace app\classes;

class LoginForm
{
    public $username;
    public $password;
    public $errors = [];
    private $_user;


    private $labels = [
        'username' => 'Имя пользователя',
        'password' => 'Пароль'
    ];

    public function validateForm()
    {
        $this->checkUsername();
        $this->checkPassword();

        return empty($this->errors);
    }

    public function login()
    {
        Session::write('user_id', $this->_user->id);
    }


    private function checkEmpty($field)
    {
        if (empty($this->$field)) {
            $this->errors[$field] = " Заполните поле {$this->labels[$field]}";
            return false;
        }
        return true;
    }

    private function checkUsername()
    {
        $user = User::findByUsername($this->username);

        if ($this->checkEmpty('username') && !$user) {
            $this->errors['username'] = 'Пользователь не найден';
            return false;
        }
        $this->setUser($user);
        return true;

    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->_user = $user;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    private function checkPassword()
    {
        if ($this->checkEmpty('password') && !$this->comparePassword()) {
            $this->errors['password'] = 'Неправильный пароль';
            return false;
        }
        return true;
    }

    private function comparePassword()
    {
        $config = require __DIR__ . '/../' . 'config.php';

        return md5($config['salt'] . $this->password) === $this->_user->password_hash;
    }
}