<?php
require_once __DIR__ . "../../init.php";
class Db
{

    private $pdo;

    public function __construct()
    {

        $host = $_ENV['DB_HOST'];
        $databaseName = $_ENV['DB_NAME'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];

        try {

            $dsn = "mysql:host=$host;dbname=$databaseName;";
            $pdo = new PDO($dsn, $username, $password);
        } catch (\PDOException $error) {
            $errorMessage = $error->getMessage();
            die("connection failed : $errorMessage");
        }
    }

    public function connect()
    {
        return $this->pdo;
    }
}
