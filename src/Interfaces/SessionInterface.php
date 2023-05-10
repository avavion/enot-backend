<?php

namespace App\Interfaces;

interface SessionInterface
{
    static public function get(string $key): mixed;

    static public function set(string $key, mixed $value): void;

    static public function exists(string $key): bool;

    public function run(): void;
}
