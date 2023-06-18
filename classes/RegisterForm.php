<?php

namespace app\classes;

class RegisterForm
{
    public string $login;
    public string $phone;
    public string $email;
    public string $password;
    public string $password_repeat;
    public array $errors = [];

    private array $labels = [
        'login' => 'Логин',
        'phone' => 'Телефон',
        'email' => 'Email',
        'password' => 'Пароль',
        'password_repeat' => 'Повтор пароля',
    ];

    /**
     * @return bool
     */
    public function validateForm(): bool
    {
        $this->checkPhone();
        $this->checkMin('phone', 7);
        $this->checkMinLength('login', 3);
        $this->checkMinLength('password', 6);
        $this->checkPasswordEqual();
        $this->checkEmail();
        $this->checkUnique('login');
        $this->checkUnique('phone');
        $this->checkUnique('email');

        return empty($this->errors);
    }

    /**
     * @return bool|\PDOStatement
     */
    public function register()
    {
        $user = new User();
        $config = require __DIR__ . '/../config.php';

        $user->setPhone($this->phone);
        $user->setEmail($this->email);
        $user->setLogin($this->login);
        $user->setPasswordHash(md5($config['salt'] . $this->password));

        return $user->create();
    }

    /**
     * @return void
     */
    private function checkPhone(): void
    {
        if ($this->checkEmpty('phone') && !is_numeric($this->phone)) {
            $this->errors['phone'] = 'Номер телефона должен состоять только из цифр';
        }
    }

    /**
     * @param string $field
     * @return void
     */
    private function checkUnique(string $field): void
    {
        $user = User::findByParam($field, $this->$field);
        if ($this->checkEmpty($field) && $user) {
            $this->errors[$field] = "Такой {$this->labels[$field]} уже зарегистрирован в системе";
        }
    }

    /**
     * @param string $field
     * @param int $min
     * @return void
     */
    private function checkMinLength(string $field, int $min): void
    {
        if ($this->checkEmpty($field) && mb_strlen($this->$field) < $min) {
            $this->errors[$field] = "Поле {$this->labels[$field]} должно быть не короче {$min} символов";
        }
    }

    /**
     * @param string $field
     * @param int $min
     * @return void
     */
    private function checkMin(string $field, int $min): void
    {
        if ($this->checkEmpty($field) && mb_strlen((string)$this->$field) < $min) {
            $this->errors[$field] = "Поле {$this->labels[$field]} должно состоять не менее, чем из {$min} цифр";
        }
    }

    /**
     * @return void
     */
    private function checkEmail(): void
    {
        if ($this->checkEmpty('email') && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Невалидный email';
        }
    }

    /**
     * @return void
     */
    private function checkPasswordEqual(): void
    {
        if ($this->checkEmpty('password_repeat') && $this->password !== $this->password_repeat) {
            $this->errors['password_repeat'] = 'Введённые пароли не совпадают';
        }
    }

    /**
     * @param $field
     * @return bool
     */
    private function checkEmpty($field): bool
    {
        if (empty($this->$field)) {
            $this->errors[$field] = " Заполните поле {$this->labels[$field]}";
            return false;
        }
        return true;
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
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @param mixed $password_repeat
     */
    public function setPasswordRepeat($password_repeat): void
    {
        $this->password_repeat = $password_repeat;
    }
}