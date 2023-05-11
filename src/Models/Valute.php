<?php

namespace App\Models;

use App\Services\Model;

class Valute extends Model
{
    public array $fillable = [
        "name",
        "char_code",
        "value"
    ];

    public function getTable(): string
    {
        return "valutes";
    }

    public function getValutes()
    {
        return $this->newQuery()->get();
    }
}
