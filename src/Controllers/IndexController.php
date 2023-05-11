<?php

namespace App\Controllers;

use App\Models\User;

class IndexController extends Controller
{
    public function index(): string
    {
        $user = new User();

        $users = $user->getUsers();

        return $this->render('index', compact('users'));
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
