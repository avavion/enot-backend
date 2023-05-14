<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Valute;

class IndexController extends Controller
{
    public function index(): string
    {
        $user = new User();
        $valute = new Valute();

        $users = $user->getUsers();
        $valutes = $valute->getValutes();

        return $this->render('index', compact('users', 'valutes'));
    }

    public function signin()
    {
        return $this->render('signin');
    }

    public function signup()
    {
        return $this->render('signup');
    }
}
