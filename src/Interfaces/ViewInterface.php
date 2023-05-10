<?php

namespace App\Interfaces;

interface ViewInterface
{
    public function renderView($view, array $data = []): string;

    static public function include(string $component): void;
}
