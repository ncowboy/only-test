<?php

namespace app\classes;

class LoginForm
{
    public string $username;
    public string $password;
    public array $errors = [];
    private User $_user;


    private array $labels = [
        'username' => 'Имя пользователя',
        'password' => 'Пароль'
    ];

    /**
     * @return bool
     */
    public function validateForm(): bool
    {
        $this->checkUsername();
        $this->checkPassword();

        return empty($this->errors);
    }

    /**
     * @return void
     */
    public function login(): void
    {
        Session::write('user_id', $this->_user->id);
    }

    /**
     * @param string $field
     * @return bool
     */
    private function checkEmpty(string $field): bool
    {
        if (empty($this->$field)) {
            $this->errors[$field] = " Заполните поле {$this->labels[$field]}";
            return false;
        }
        return true;
    }

    /**
     * @return void
     */
    private function checkUsername(): void
    {
        $user = User::findByUsername($this->username);

        if ($this->checkEmpty('username') && !$user) {
            $this->errors['username'] = 'Пользователь не найден';
        }

        $this->setUser($user);
    }

    /**
     * @param User $user
     * @return void
     */
    public function setUser(User $user): void
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

    /**
     * @return void
     */
    private function checkPassword(): void
    {
        if ($this->checkEmpty('password') && !$this->comparePassword()) {
            $this->errors['password'] = 'Неправильный пароль';
        }
    }

    /**
     * @return bool
     */
    private function comparePassword(): bool
    {
        $config = require __DIR__ . '/../' . 'config.php';

        return md5($config['salt'] . $this->password) === $this->_user->password_hash;
    }
}