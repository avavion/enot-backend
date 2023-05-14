<?php

namespace App\Services;

use App\Models\User;

class Auth
{
    static private string $key = "auth";

    static public function user(): array|null
    {
        if (Application::$app->session->exists(self::$key)) {
            return User::query()->where('id', '=', Application::$app->session->get(self::$key))->first();
        }

        return null;
    }

    static public function login($user): void
    {
        Application::$app->session->set(self::$key, $user['id']);
    }

    static public function attempt(array $credentials)
    {
        $user = User::query()->where('email', '=', $credentials['email'])->first();

        if (is_null($user)) {
            return false;
        }

        if (!password_verify($credentials['password'], $user['password'])) {
            return false;
        }

        Application::$app->session->set(self::$key, $user['id']);

        return true;
    }

    static public function logout(): bool
    {
        if (Application::$app->session->exists(self::$key)) {
            Application::$app->session->delete(self::$key);

            return true;
        }

        return false;
    }
}
