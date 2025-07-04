<?php
// app/core/Database.php

class Database {
    private static $instance = null;
    private $conn;

    private $host = 'localhost';
    private $user = 'root'; // User mặc định của Laragon
    private $pass = '';     // Password mặc định của Laragon
    private $name = 'webrank'; // Tên database bạn đã tạo

    private function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->name;
        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch (PDOException $e) {
            die('Connection Failed: ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
