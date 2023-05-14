<?php

namespace App\Models;

use App\Services\Auth;
use App\Services\Model;

class User extends Model
{
    const IS_ADMIN = 'admin';

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

    static public function isAdmin()
    {
        return Auth::user()['role'] === User::IS_ADMIN;
    }
}
