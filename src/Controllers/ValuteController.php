<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Valute;
use App\Services\Application;
use App\Services\Auth;
use App\Services\Parser;
use App\Services\Request;

use Exception;

class ValuteController extends Controller
{
    protected Parser $parser;
    protected Valute $valute;

    public function __construct()
    {
        $this->valute = new Valute();
    }

    private function fetchValutes(): array
    {
        $this->parser = new Parser();

        $valutes = $this->parser->getResource('https://www.cbr-xml-daily.ru/daily_json.js')->toArray();

        return $valutes['Valute'];
    }

    private function getValuteFields(array $valute)
    {
        return [
            'char_code' => $valute['CharCode'],
            'name' => $valute['Name'],
            'value' => $valute['Value'],
        ];
    }

    private function getCharCode(array $valute)
    {
        return $this->getValuteFields($valute)['char_code'];
    }

    private function convertToRub(array $data)
    {
        $value = floatval($data['to_value']);

        $valute = $this->valute->getByChar($data['to_char']);

        $valute_value = $valute['value'];

        $converted_value = round($value * $valute_value, 4);

        return [
            'valute' => $valute,
            'from_value' => $converted_value,
            'to_value' => $value
        ];
    }

    private function convertFromRub(array $data)
    {
        $value = floatval($data['from_value']);

        $valute = $this->valute->getByChar($data['to_char']);

        $valute_value = $valute['value'];

        $converted_value = round($value / $valute_value, 4);

        return [
            'valute' => $valute,
            'from_value' => $value,
            'to_value' => $converted_value
        ];
    }

    public function convert(Request $request)
    {
        try {
            $data = $request->getInputData();

            $response = [
                'status' => true,
                'message' => 'Valute has been converted!',
            ];

            if (!boolval($data['from_to'])) {
                $response['data'] = $this->convertToRub($data);

                return Application::$app->response->json($response);
            }

            $response['data'] = $this->convertFromRub($data);

            return Application::$app->response->json($response);
        } catch (Exception $e) {
            return Application::$app->response->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        $data = $request->getQueryData();

        if (empty($data)) {
            Application::$app->response->setStatusCode(500);

            return Application::$app->response->redirect('/');
        }

        if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            Application::$app->response->setStatusCode(500);

            return Application::$app->response->redirect('/');
        }

        if (!User::isAdmin()) {
            Application::$app->response->setStatusCode(500);

            return Application::$app->response->redirect('/');
        }

        $valutes = $this->fetchValutes();

        foreach ($valutes as $valute) {
            $findValute = $this->valute->newQuery()->where('char_code', '=', $this->getCharCode($valute))->first();

            if (is_null($findValute)) {
                $this->valute->newQuery()->create($this->getValuteFields($valute));
            } else {
                $this->valute->newQuery()->update([...$this->getValuteFields($valute), 'id' => $findValute['id']]);
            }
        }

        // Auth::logout();

        Application::$app->response->setStatusCode(200);

        return Application::$app->response->redirect('/');
    }
}
