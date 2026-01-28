<?php
class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            "mysql:host=localhost;dbname=address_book;charset=utf8mb4",
            "addressbook",
            "Passw0rd!",
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}

