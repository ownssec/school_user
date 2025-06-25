<?php
class DB {
    private $host = "localhost";
    private $user = "root";
    private $pass = "qweqwe--";
    private $dbname = "studentDb";
    protected $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            exit("DB connection error: " . $e->getMessage());
        }
    }
}

