<?php

namespace App;

class Session
{
    public function setSession(string $name, array $array): void
    {
        //session_regenerate_id();
        $_SESSION[$name] = $array;
    }

    public function destroySession(): void
    {
        session_destroy();
    }

    public function unsetSession(string $name): void
    {
        unset($_SESSION[$name]);
    }

}