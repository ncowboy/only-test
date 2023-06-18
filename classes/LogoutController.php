<?php

namespace app\classes;

class LogoutController extends Controller
{
    public function run(): void
    {
        if (!empty($_POST)) {
            Session::unset('user_id');
            header('Location: /login');
        };
    }
}