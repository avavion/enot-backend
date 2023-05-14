<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\Application;
use App\Services\Auth;
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
                Validator::RULE_REQUIRED
            ]
        ]);

        $validated = $validator->validated();

        if (!$validated) {
            Application::$app->session->set('errors', $validator->getErrorMessages());

            return Application::$app->response->redirect('/signin');
        }

        if (!Auth::attempt($request->getInputData())) {
            Application::$app->session->set('errors', [
                'message' => 'Invalid Credentilas'
            ]);

            return Application::$app->response->redirect('/signin');
        }

        return Application::$app->response->redirect('/');
    }

    public function signup(Request $request)
    {
        $data = $request->getInputData();

        $validator = new Validator($data, [
            'email' => [
                Validator::RULE_EMAIL,
                Validator::RULE_REQUIRED,
            ],
            'password' => [
                Validator::RULE_REQUIRED,
            ],
            'username' => [
                Validator::RULE_REQUIRED,
            ]
        ]);

        $validated = $validator->validated();

        if (!$validated) {
            Application::$app->session->set('errors', $validator->getErrorMessages());

            return Application::$app->response->redirect('/signup');
        }

        if (!is_null(User::query()->where('email', '=', $data['email'])->first())) {
            Application::$app->session->set('errors', ['message' => 'User has been created!']);

            return Application::$app->response->redirect('/signup');
        }

        User::query()->create([
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
