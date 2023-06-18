<?php

namespace app\classes;

class IndexController extends Controller

{
    /**
     * @return void
     */
    public function run(): void
    {
        $user = User::getUser();

        if ($user) {
            header('Location: /profile');
        } else {
            header('Location: /login');
        }
    }
}