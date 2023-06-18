<?php

namespace app\classes;

class LoginController extends Controller
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
            $form = new LoginForm();
            $form->setUsername($_POST['username']);
            $form->setPassword($_POST['password']);

            $form->validateForm();

            if (count($form->errors) === 0) {
                $form->login();
                header('Location: /profile');
            }
        };

        require_once __DIR__ . '/../pages/login.php';

        Session::unset('success');
    }
}