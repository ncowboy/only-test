<?php

namespace app\classes;

class ProfileForm
{
    public string $login;
    public string $phone;
    public string $email;
    public string $new_password;
    public string $password_repeat;
    public array $errors = [];

    private User $_user;

    public function __construct(User $user)
    {
        $this->_user = $user;
    }

    private array $labels = [
        'login' => 'Логин',
        'phone' => 'Телефон',
        'email' => 'Email',
        'new_password' => 'Пароль',
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
        $this->checkMinLength('new_password', 6, false);
        $this->checkPasswordEqual();
        $this->checkEmail();
        $this->checkUnique('login');
        $this->checkUnique('phone');
        $this->checkUnique('email');

        return empty($this->errors);
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
        if ($this->checkEmpty($field) && $this->_user->$field !== $this->$field && $user) {
            $this->errors[$field] = "Такой {$this->labels[$field]} уже зарегистрирован в системе";
        }
    }

    /**
     * @param string $field
     * @param int $min
     * @param bool $to_check_empty
     * @return void
     */
    private function checkMinLength(string $field, int $min, bool $to_check_empty = true): void
    {
        $check_empty = !$to_check_empty || $this->checkEmpty($field);

        if ($check_empty && !empty($this->$field) && mb_strlen($this->$field) < $min) {
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
        if ($this->new_password !== $this->password_repeat) {
            $this->errors['password_repeat'] = 'Введённые пароли не совпадают';
        }
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