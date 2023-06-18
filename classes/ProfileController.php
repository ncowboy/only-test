<?php

namespace app\classes;

class ProfileController extends Controller
{

    public function run(): void
    {
        $user = User::getUser();

        if ($user) {
            if (!empty($_POST)) {
                $form = new ProfileForm($user);
                $form->setLogin($_POST['login']);
                $form->setEmail($_POST['email']);
                $form->setPassword($_POST['new_password']);
                $form->setPasswordRepeat($_POST['password-repeat']);
                $form->setPhone($_POST['phone']);

                $form->validateForm();
                if (count($form->errors) === 0 && $user->update($form)) {
                    $updated = true;
                }
            };

            require_once __DIR__ . '/../pages/' . 'profile.php';

        } else {
            header('Location: /login');
        }
    }
}