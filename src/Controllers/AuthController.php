<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\Application;
use App\Services\Auth;
use App\Services\Request;
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

    public function signup(Request $request)
    {
        $data = $request->getInputData();

        // $validator = new Validator($data, []);

        // $validated = $validator->validated();

        // if (!$validated) {
        // }

        if (!is_null(User::query()->where('email', '=', $data['email'])->first())) {
            return Application::$app->response->redirect('/');
        }

        $user = User::query()->create([
            ...$data,
            'password' => password_hash($data['password'], PASSWORD_BCRYPT)
        ]);

        $user = User::query()->where('email', '=', $data['email'])->first();

        Auth::login($user);

        return Application::$app->response->redirect('/');
    }

    public function logout()
    {
        Auth::logout();

        return Application::$app->response->redirect('/');
    }
}
