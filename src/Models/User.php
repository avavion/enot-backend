<?php

namespace App\Models;

use App\Services\Model;

class User extends Model
{
    public array $fillable = [
        "username",
        "email",
        "password"
    ];

    public function getTable(): string
    {
        return "users";
    }

    public function getUsers()
    {
        return $this->newQuery()->get();
    }
}
