<?php

namespace App\Services;

final class Request
{
    private array $parsed_url;

    public function __construct()
    {
        $this->parsed_url = parse_url($this->getRequestUrl());
    }

    public function getRequestUrl(): string
    {
        return $_SERVER['REQUEST_URI'] ?? '/';
    }

    public function getPath(): string
    {
        return $this->getParsedUrl()['path'];
    }

    private function getParsedUrl(): array
    {
        return $this->parsed_url;
    }

    public function getInputData(): array
    {
        $body = [];

        foreach ($_POST as $key => $value) {
            $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return array_merge($this->getQueryData(), $body);
    }

    public function getQueryData(): array
    {
        $body = [];

        foreach ($_GET as $key => $value) {
            $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $body;
    }

    public function getHttpMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }
}