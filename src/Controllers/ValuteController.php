<?php

namespace App\Controllers;

use App\Models\Valute;
use App\Services\Application;
use App\Services\Auth;
use App\Services\Parser;
use App\Services\Request;

class ValuteController extends Controller
{
    protected Parser $parser;
    protected Valute $valute;

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

    public function update(Request $request)
    {
        $this->valute = new Valute();

        $data = $request->getQueryData();

        if (empty($data)) {
            Application::$app->response->setStatusCode(500);

            return Application::$app->response->redirect('/');
        }

        if (!Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
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

        Application::$app->response->setStatusCode(200);

        return Application::$app->response->redirect('/');
    }
}
