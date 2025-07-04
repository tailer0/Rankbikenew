<?php
// app/models/Gallery.php

// SỬA LỖI: Thêm dòng này để nạp lớp Database
require_once __DIR__ . '/../core/Database.php';

class Gallery {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Lấy tất cả ảnh từ bảng gallery_images.
     * @return array
     */
    public function getAllImages() {
        try {
            $stmt = $this->db->prepare("
                SELECT id, image_url, caption 
                FROM gallery_images 
                ORDER BY uploaded_at DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
