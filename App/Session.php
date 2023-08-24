<?php

namespace App;

class Session
{

    public static function checkSession(string $name): bool
    {
        return isset($_SESSION[$name]);
    }

    public function setSession(string $name, array $array): void
    {
        //session_regenerate_id();
        $_SESSION[$name] = $array;
    }

    public static function destroySession(): void
    {
        session_destroy();
    }

    public function unsetSession(string $name): void
    {
        unset($_SESSION[$name]);
    }
}