<?php

namespace App\Services;

use PDO;

class Database
{
    protected PDO $pdo;

    public function __construct(array $config)
    {
        ["dsn" => $dsn, "username" => $username, "password" => $password] = $config;

        $this->pdo = new PDO($dsn, $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("SET CHARSET utf8;");
    }

    public function getPDO()
    {
        return $this->pdo;
    }
}
