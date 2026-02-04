<?php
class Database
{
    private PDO $pdo;
    private static bool $envLoaded = false;

    public function __construct()
    {
        self::loadEnv();

        $host = getenv('DB_HOST') ?: 'localhost';
        $name = getenv('DB_NAME') ?: 'address_book';
        $user = getenv('DB_USER') ?: 'addressbook';
        $pass = getenv('DB_PASS') ?: 'Passw0rd!';

        $this->pdo = new PDO(
            "mysql:host={$host};dbname={$name};charset=utf8mb4",
            $user,
            $pass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    private static function loadEnv(): void
    {
        if (self::$envLoaded) {
            return;
        }

        $path = __DIR__ . '/../.env';
        if (!is_readable($path)) {
            self::$envLoaded = true;
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            $parts = explode('=', $line, 2);
            if (count($parts) !== 2) {
                continue;
            }

            $key = trim($parts[0]);
            $value = trim($parts[1]);

            if ($key === '') {
                continue;
            }

            $firstChar = $value[0] ?? '';
            $lastChar = $value[strlen($value) - 1] ?? '';
            if (($firstChar === '"' && $lastChar === '"') || ($firstChar === "'" && $lastChar === "'")) {
                $value = substr($value, 1, -1);
            }

            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }

        self::$envLoaded = true;
    }
}
