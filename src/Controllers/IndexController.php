<?php

namespace App\Controllers;

class IndexController extends Controller
{
    public function index(): string
    {
        return $this->render('index');
    }

    public function login()
    {
        return $this->render('login');
    }
}