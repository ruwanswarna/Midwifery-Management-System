<?php

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $host = 'localhost';
        $dbname = 'moms_temp';
        $username = 'root';
        $password = '';

        $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

        $this->pdo = new PDO(
            $dsn,
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }
    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
