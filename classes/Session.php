<?php

namespace app\classes;

class Session
{
    /**
     * @return bool
     */
    public static function start(): bool
    {
        return session_start();
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public static function write(string $key, string $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @return void
     */
    public static function unset(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    /**
     * @param string $key
     * @return mixed|void
     */
    public static function read(string $key)
    {
        self::start();
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }
}