<?php
// app/models/Admin.php
require_once __DIR__ . '/../core/Database.php';

class Admin {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findByUsername($username) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM admins WHERE username = :username");
            $stmt->execute(['username' => $username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    
     public function create($username, $password) {
        // Mã hóa mật khẩu trước khi lưu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        try {
            $stmt = $this->db->prepare("INSERT INTO admins (username, password) VALUES (:username, :password)");
            return $stmt->execute([
                ':username' => $username,
                ':password' => $hashedPassword
            ]);
        } catch (PDOException $e) {
            // Xử lý lỗi nếu username đã tồn tại
            if ($e->errorInfo[1] == 1062) { // 1062 là mã lỗi cho duplicate entry
                return false;
            }
            die($e->getMessage());
        }
    }
}
