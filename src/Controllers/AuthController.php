<?php

namespace App\Controllers;

use App\Services\Application;
use App\Services\Request;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
        $formData = $request->getInputData();



        return Application::$app->response->redirect('/');
    }

    public function signup()
    {

    }
}