<?php

namespace app\classes;

class RegisterController
{
    /**
     * @return void
     */
    public function run(): void
    {
        $user = User::getUser();
        if ($user) {
            header('Location: /profile');
        }

        if (!empty($_POST)) {
            $form = new RegisterForm();
            $form->setLogin($_POST['login']);
            $form->setEmail($_POST['email']);
            $form->setPassword($_POST['password']);
            $form->setPasswordRepeat($_POST['password-repeat']);
            $form->setPhone($_POST['phone']);

            $form->validateForm();

            if (count($form->errors) === 0 && $form->register()) {
                Session::write('success', 'success');
                header('Location: /login');
            }
        };

        require_once __DIR__ . '/../pages/register.php';
    }
}