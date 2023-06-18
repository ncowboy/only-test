<?php

namespace app\classes;

class Request
{
    private $requestString;

    public function __construct()
    {
        Session::start();
        $this->requestString = $_SERVER['REQUEST_URI'];
        $this->resolve();
    }

    /**
     * @return void
     */
    public function resolve(): void
    {
        switch ($this->requestString) {
            case '/':
                (new IndexController())->run();
                break;
            case '/register':
                (new RegisterController())->run();
                break;
            case '/login':
                (new LoginController())->run();
                break;
            case '/profile':
                (new ProfileController())->run();
                break;
            case '/logout':
                (new LogoutController())->run();
                break;
            default:
                break;
        }
    }
}