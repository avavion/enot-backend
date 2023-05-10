<?php

namespace App\Services;

final class Response
{
    public function setStatusCode($code = 404): void
    {
        http_response_code($code);
    }

    public function redirect(string $location): bool
    {
        header("Location: {$location}");

        return true;
    }
}