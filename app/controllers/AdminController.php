<?php
// app/controllers/AdminController.php

require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/Rider.php';
require_once __DIR__ . '/../models/Category.php';

class AdminController {

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login() {
        require_once __DIR__ . '/../views/admin/login.php';
    }

    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $adminModel = new Admin();
            $admin = $adminModel->findByUsername($username);

            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $admin['username'];
                header('Location: /webrank/admin/dashboard');
                exit;
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
                require_once __DIR__ . '/../views/admin/login.php';
            }
        }
    }
    
    // --- REGISTER NEW ADMIN METHODS ---

    /**
     * Hiển thị form đăng ký admin mới.
     * SỬA LỖI 1: Tạm thời vô hiệu hóa checkAuth() để cho phép tạo tài khoản đầu tiên.
     */
    public function show_register_form() {
        // $this->checkAuth(); // Vô hiệu hóa dòng này
        require_once __DIR__ . '/../views/admin/register_admin.php';
    }

    /**
     * Xử lý việc tạo tài khoản admin mới.
     * SỬA LỖI 2: Đổi tên hàm thành registerAdmin (camelCase) để khớp với router.
     */
    public function registerAdmin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $data = [];

            if (empty($username) || empty($password)) {
                $data['error_message'] = 'Tên đăng nhập và mật khẩu không được để trống.';
            } elseif ($password !== $confirm_password) {
                $data['error_message'] = 'Mật khẩu và xác nhận mật khẩu không khớp.';
            } else {
                $adminModel = new Admin();
                if ($adminModel->create($username, $password)) {
                    // Tạo thành công, chuyển hướng về trang đăng nhập với thông báo
                    $_SESSION['success_message'] = 'Tạo tài khoản admin mới thành công! Vui lòng đăng nhập.';
                    header('Location: /webrank/admin/login');
                    exit;
                } else {
                    $data['error_message'] = 'Tên đăng nhập đã tồn tại hoặc có lỗi xảy ra.';
                }
            }
            
            // Nếu có lỗi, tải lại view đăng ký với thông báo lỗi
            require_once __DIR__ . '/../views/admin/register_admin.php';
        }
    }

    public function dashboard() {
        $this->checkAuth();
        
        // Khởi tạo các model cần thiết
        $riderModel = new Rider();
        $categoryModel = new Category();

        // Lấy dữ liệu đếm từ các model
        $data['total_riders'] = $riderModel->countAll();
        $data['total_categories'] = $categoryModel->countAll();
        
        // Tải view và truyền dữ liệu vào
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    public function logout() {
        session_destroy();
        header('Location: /webrank/admin/login');
        exit;
    }
    
    protected function checkAuth() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /webrank/admin/login');
            exit;
        }
    }
    
    // --- RIDER CRUD METHODS ---
    public function manageRiders() {
        $this->checkAuth();
        $riderModel = new Rider();
        $data['riders'] = $riderModel->getAll();
        require_once __DIR__ . '/../views/admin/riders_manage.php';
    }

    public function createRider() {
        $this->checkAuth();
        $categoryModel = new Category();
        
        $data['form_action'] = '/webrank/admin/storeRider';
        $data['page_title'] = 'Thêm Rider Mới';
        $data['rider'] = null;
        $data['all_categories'] = $categoryModel->getAll(); // Lấy tất cả hạng mục
        $data['rider_categories'] = []; // Rider mới chưa có hạng mục nào
        
        require_once __DIR__ . '/../views/admin/rider_form.php';
    }

    public function storeRider() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $photo1_path = $this->handleUpload('photo1');
            $photo2_path = $this->handleUpload('photo2');

            $data = [
                'name' => $_POST['name'],
                'date_of_birth' => $_POST['date_of_birth'],
                'team' => $_POST['team'],
                'photo1_url' => $photo1_path,
                'photo2_url' => $photo2_path,
                'category_ids' => $_POST['categories'] ?? [] // Lấy danh sách ID hạng mục
            ];

            $riderModel = new Rider();
            $riderModel->create($data);

            header('Location: /webrank/admin/manageRiders');
            exit;
        }
    }

    public function editRider($id) {
         $this->checkAuth();
        $riderModel = new Rider();
        $categoryModel = new Category();
        
        $data['rider'] = $riderModel->findById($id);
        if (!$data['rider']) die('Rider not found');

        $data['form_action'] = '/webrank/admin/updateRider/' . $id;
        $data['page_title'] = 'Chỉnh Sửa Rider';
        $data['all_categories'] = $categoryModel->getAll();
        $data['rider_categories'] = $riderModel->getCategoryIds($id); // Lấy các hạng mục rider đang tham gia
        
        require_once __DIR__ . '/../views/admin/rider_form.php';
    }

    public function updateRider($id) {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $riderModel = new Rider();
            $oldRider = $riderModel->findById($id);

            $photo1_path = $this->handleUpload('photo1', $oldRider['photo1_url']);
            $photo2_path = $this->handleUpload('photo2', $oldRider['photo2_url']);

            $data = [
                'name' => $_POST['name'],
                'date_of_birth' => $_POST['date_of_birth'],
                'team' => $_POST['team'],
                'photo1_url' => $photo1_path,
                'photo2_url' => $photo2_path,
                'category_ids' => $_POST['categories'] ?? []
            ];

            $riderModel->update($id, $data);

            header('Location: /webrank/admin/manageRiders');
            exit;
        }
    }

    public function deleteRider($id) {
        $this->checkAuth();
        $riderModel = new Rider();
        $riderModel->delete($id);
        header('Location: /webrank/admin/manageRiders');
        exit;
    }

    // --- CATEGORY CRUD METHODS ---
    public function manageCategories() {
        $this->checkAuth();
        $categoryModel = new Category();
        $data['categories'] = $categoryModel->getAll();
        require_once __DIR__ . '/../views/admin/categories_manage.php';
    }

    public function createCategory() {
        $this->checkAuth();
        $data['form_action'] = '/webrank/admin/storeCategory';
        $data['page_title'] = 'Thêm Hạng Mục Mới';
        $data['category'] = null;
        require_once __DIR__ . '/../views/admin/category_form.php';
    }

    public function storeCategory() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = ['name' => $_POST['name'], 'description' => $_POST['description']];
            $categoryModel = new Category();
            $categoryModel->create($data);
            header('Location: /webrank/admin/manageCategories');
            exit;
        }
    }

    public function editCategory($id) {
        $this->checkAuth();
        $categoryModel = new Category();
        $data['category'] = $categoryModel->findById($id);
        if (!$data['category']) die('Category not found');
        $data['form_action'] = '/webrank/admin/updateCategory/' . $id;
        $data['page_title'] = 'Chỉnh Sửa Hạng Mục';
        require_once __DIR__ . '/../views/admin/category_form.php';
    }

    public function updateCategory($id) {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = ['name' => $_POST['name'], 'description' => $_POST['description']];
            $categoryModel = new Category();
            $categoryModel->update($id, $data);
            header('Location: /webrank/admin/manageCategories');
            exit;
        }
    }

    public function deleteCategory($id) {
        $this->checkAuth();
        $categoryModel = new Category();
        $categoryModel->delete($id);
        header('Location: /webrank/admin/manageCategories');
        exit;
    }
    
    private function handleUpload($fileKey, $existingPath = null) {
        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] == UPLOAD_ERR_OK) {
            if ($existingPath && file_exists(__DIR__ . '/../../public/' . $existingPath)) {
                unlink(__DIR__ . '/../../public/' . $existingPath);
            }
            $uploadDir = 'img/riders/';
            $fileName = uniqid() . '-' . basename($_FILES[$fileKey]['name']);
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], __DIR__ . '/../../public/' . $targetPath)) {
                return $targetPath;
            }
        }
        return $existingPath;
    }
}
