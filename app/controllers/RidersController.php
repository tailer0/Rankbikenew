<?php
// app/controllers/RidersController.php

// Yêu cầu model cần thiết
require_once __DIR__ . '/../models/Rider.php';

class RidersController {

    /**
     * Hiển thị trang chi tiết của một rider.
     * @param int $id The ID of the rider from the URL.
     */
    public function show($id) {
        // Kiểm tra xem ID có hợp lệ không
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            die('Invalid Rider ID');
        }

        $riderModel = new Rider();
        $data['rider'] = $riderModel->findById($id);

        // Nếu không tìm thấy rider, hiển thị lỗi
        if (!$data['rider']) {
            die('Rider not found.');
        }

        // Tải view và truyền dữ liệu vào
        require_once __DIR__ . '/../views/riders/show.php';
    }
}
