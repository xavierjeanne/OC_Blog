<?php

namespace Framework\Session;

class Session
{
    
    public function get(string $key, $default = null)
    {
        $this->ensureStarted();

        //if key exist in session, return $this
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }

        return $default;
    }

    public function set(string $key, $value):void
    {
        $this->ensureStarted();
        $_SESSION[$key]=$value;
    }

    public function delete(string $key):void
    {
        $this->ensureStarted();
        unset($_SESSION[$key]);
    }

    private function ensureStarted()
    {
        //start session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
