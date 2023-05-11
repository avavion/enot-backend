<?php

namespace App\Services;

use Exception;
use CurlHandle;
use Error;

class Parser
{
    protected string $content;

    protected array $config = [CURLOPT_RETURNTRANSFER => 1];

    protected CurlHandle $curl;

    public function getResource(string $url): Parser
    {
        try {
            $this->curl = curl_init($url);

            curl_setopt_array($this->getCurl(), $this->getConfig());

            $this->setContent(curl_exec($this->getCurl()));

            curl_close($this->getCurl());

            return $this;
        } catch (Exception $e) {
            throw new Error($e->getMessage());
        }
    }

    private function getCurl(): CurlHandle
    {
        return $this->curl;
    }

    private function getConfig(): array
    {
        return $this->config;
    }

    private function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function toArray()
    {
        return json_decode($this->getContent(), JSON_OBJECT_AS_ARRAY);
    }

    public function toJSON()
    {
        return json_encode($this->getContent());
    }
}
