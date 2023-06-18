<?php

namespace app\classes;

class ProfileForm
{
    public $login;
    public $phone;
    public $email;
    public $new_password;
    public $password_repeat;
    public $errors = [];

    private User $_user;

    public function __construct(User $user)
    {
        $this->_user = $user;
    }

    private $labels = [
        'login' => 'Логин',
        'phone' => 'Телефон',
        'email' => 'Email',
        'new_password' => 'Пароль',
        'password_repeat' => 'Повтор пароля',
    ];

    public function validateForm()
    {
        $this->checkPhone();
        $this->checkMin('phone', 7);
        $this->checkMinLength('login', 3);
        $this->checkMinLength('new_password', 6, false);
        $this->checkPasswordEqual();
        $this->checkEmail();
        $this->checkUnique('login');
        $this->checkUnique('phone');
        $this->checkUnique('email');

        return empty($this->errors);
    }

    private function checkPhone()
    {
        if ($this->checkEmpty('phone') && !is_numeric($this->phone)) {
            $this->errors['phone'] = 'Номер телефона должен состоять только из цифр';
            return false;
        }

        return true;
    }

    private function checkUnique($field)
    {
        $user = User::findByParam($field, $this->$field);
        if ($this->checkEmpty($field) && $this->_user->$field !== $this->$field && $user) {
            $this->errors[$field] = "Такой {$this->labels[$field]} уже зарегистрирован в системе";
            return false;
        }
        return true;
    }

    private function checkMinLength($field, $min, $to_check_empty = true)
    {
        $check_empty = $to_check_empty ? $this->checkEmpty($field) : true;

        if ($check_empty && !empty($this->$field) && mb_strlen($this->$field) < $min) {
            $this->errors[$field] = "Поле {$this->labels[$field]} должно быть не короче {$min} символов";
            return false;
        }
        return true;
    }

    private function checkMin($field, $min)
    {
        if ($this->checkEmpty($field) && mb_strlen((string)$this->$field) < $min) {
            $this->errors[$field] = "Поле {$this->labels[$field]} должно состоять не менее, чем из {$min} цифр";
            return false;
        }
        return true;
    }

    private function checkEmail()
    {
        if ($this->checkEmpty('email') && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Невалидный email';
            return false;
        }
        return true;
    }

    private function checkPasswordEqual()
    {
        if ($this->new_password !== $this->password_repeat) {
            $this->errors['password_repeat'] = 'Введённые пароли не совпадают';
            return false;
        }
        return true;
    }

    private function checkEmpty($field)
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
        $this->new_password = $password;
    }

    /**
     * @param mixed $password_repeat
     */
    public function setPasswordRepeat($password_repeat): void
    {
        $this->password_repeat = $password_repeat;
    }
}