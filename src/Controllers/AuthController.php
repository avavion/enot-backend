<?php

namespace App\Controllers;

use App\Services\Application;
use App\Services\Request;
use App\Services\Session;
use App\Services\Validator;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
        $validator = new Validator($request->getInputData(), [
            'email' => [
                Validator::RULE_EMAIL,
                Validator::RULE_REQUIRED,
            ],
            'password' => [
                Validator::RULE_MIN => 6,
                Validator::RULE_REQUIRED
            ]
        ]);
        
        $validated = $validator->validated();

        if (!$validated) {
            // Session::set('errors', $validator->getErrorMessages());

            // return Application::$app->response->redirect('/signin');
        }

        // return Application::$app->response->redirect('/');
    }

    public function signup()
    {
    }
}
