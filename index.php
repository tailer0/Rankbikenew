<?php
// index.php

// Lấy URL từ tham số 'url'
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// SỬA LỖI: Bỏ qua thư mục gốc 'webrank' khỏi URL để router hoạt động đúng.
// Điều này rất quan trọng khi dự án không nằm ở thư mục gốc của web server.
if (isset($url[0]) && strtolower($url[0]) == 'webrank') {
    // Xóa phần tử 'webrank' khỏi mảng URL
    array_shift($url);
}

// Bây giờ, $url[0] sẽ là controller thực sự (hoặc rỗng nếu là trang chủ)
$controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'HomeController';

// $url[1] sẽ là action
$action = !empty($url[1]) ? $url[1] : 'index';

// Tạo đường dẫn đến file controller
$controllerFile = 'app/controllers/' . $controllerName . '.php';

// Kiểm tra xem file controller có tồn tại không
if (!file_exists($controllerFile)) {
    // Xử lý không tìm thấy controller
    die('Controller not found: ' . $controllerName);
}

// Yêu cầu file controller
require_once $controllerFile;

// Khởi tạo controller
$controller = new $controllerName();

// Kiểm tra xem phương thức (action) có tồn tại trong controller không
if (!method_exists($controller, $action)) {
    // Xử lý không tìm thấy action
    die('Action not found in controller: ' . $controllerName . ' -> ' . $action);
}

// Gọi action với các tham số còn lại của URL (nếu có)
// Các tham số sẽ bắt đầu từ $url[2]
call_user_func_array([$controller, $action], array_slice($url, 2));
