<?php
// app/core/Controller.php

/**
 * Đây là Controller cơ sở.
 * Tất cả các controller khác có thể kế thừa từ lớp này
 * để sử dụng các thuộc tính và phương thức chung.
 */
class Controller {
    /**
     * Nạp một model.
     * @param string $model Tên của model.
     * @return object
     */
    public function model($model) {
        // Yêu cầu file model
        require_once '../app/models/' . $model . '.php';
        // Khởi tạo model
        return new $model();
    }

    /**
     * Nạp một view.
     * @param string $view Tên của view.
     * @param array $data Dữ liệu để truyền cho view.
     */
    public function view($view, $data = []) {
        // Kiểm tra xem file view có tồn tại không
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            // Nếu file không tồn tại, báo lỗi
            die('View does not exist');
        }
    }
}
