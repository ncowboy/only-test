<?php

namespace app\classes;

use http\Header;

class IndexController extends Controller

{
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