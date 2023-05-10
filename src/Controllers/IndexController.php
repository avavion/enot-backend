<?php

namespace App\Controllers;

class IndexController extends Controller
{
    public function index(): string
    {
        return $this->render('index');
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
