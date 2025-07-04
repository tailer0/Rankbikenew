<?php
// app/models/Category.php
require_once __DIR__ . '/../core/Database.php';

class Category {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM categories ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO categories (name, description) VALUES (:name, :description)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':name' => $data['name'],
            ':description' => $data['description']
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE categories SET name = :name, description = :description WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':description' => $data['description']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    /**
     * Đếm tổng số hạng mục trong CSDL.
     */
    public function countAll() {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM categories");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
