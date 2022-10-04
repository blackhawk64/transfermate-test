<?php

class Database
{
    private const HOST = "localhost";
    private const DATABASE = "bookscatalog";
    private const USER = "postgres";
    private const PASSWORD = "pssql";

    public function Connect()
    {
        try {
            $connection = "pgsql:host=".SELF::HOST.";port=5432;dbname=".SELF::DATABASE;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $pdo = new PDO($connection, SELF::USER, SELF::PASSWORD, $options);

            return $pdo;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}