<?php
// app/core/Database.php

class Database {
    // Giữ một instance của lớp
    private static $instance = null;
    private $conn;

    // Thông tin kết nối CSDL của Laragon
    private $host = 'localhost';
    private $user = 'root';
    private $pass = ''; // Mật khẩu mặc định của Laragon là rỗng
    private $name = 'webrank'; // Tên database bạn đã tạo

    // Hàm khởi tạo private để ngăn việc tạo đối tượng mới từ bên ngoài
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

    /**
     * Lấy một instance duy nhất của lớp Database (Singleton Pattern).
     * @return Database
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Trả về đối tượng kết nối PDO.
     * @return PDO
     */
    public function getConnection() {
        return $this->conn;
    }
}
