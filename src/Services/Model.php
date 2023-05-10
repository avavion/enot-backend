<?php

namespace App\Services;

class Model
{
    public array $attributes = [];

    public array $fillable = [];

    static public function query(): Builder
    {
        return (new static)->newQuery();
    }

    public function newQuery(): Builder
    {
        return new Builder($this);
    }

    public function loadAttributes(array $data): Model
    {
        foreach ($data as $attribute => $value) {
            $this->attributes[$attribute] = $value;
        }

        return $this;
    }

    public function __get(string $name)
    {
        return $this->attributes[$name];
    }

    public function __set(string $name, $value): void
    {
        $this->attributes[$name] = $value;
    }
}