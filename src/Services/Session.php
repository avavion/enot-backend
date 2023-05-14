<?php

namespace App\Services;

use App\Interfaces\SessionInterface;

class Session implements SessionInterface
{
    public function __construct()
    {
        $this->run();
    }

    static public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    static public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    static public function exists(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    static public function delete(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function run(): void
    {
        session_start();
    }

    public function setOld(array $data)
    {
        $this->delete('old');

        $this->set('old', $data);
    }

    public function old(string $key)
    {
        if ($this->exists('old')) {
            return $this->get('old')[$key] ?? '';
        }

        return '';
    }
}
