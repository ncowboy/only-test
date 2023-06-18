<?php

namespace app\classes;

class Session
{
    public static function start()
    {
        return session_start();
    }

    public static function write($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function unset($key)
    {
        self::start();
        unset($_SESSION[$key]);
    }

    public static function read($key)
    {
        self::start();
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }
}