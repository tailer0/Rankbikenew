<?php require_once __DIR__ . '/../layouts/admin_header.php'; ?>

<main class="flex-1 p-6 bg-gray-100">
    <h1 class="text-2xl font-bold mb-6">Tạo Tài Khoản Admin Mới</h1>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-lg mx-auto">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?= $_SESSION['success_message'] ?></span>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($data['error_message'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?= $data['error_message'] ?></span>
            </div>
        <?php endif; ?>

        <form action="/webrank/admin/registerAdmin" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-bold mb-2">Tên Đăng Nhập Mới:</label>
                <input type="text" id="username" name="username" required
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-bold mb-2">Mật Khẩu:</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-6">
                <label for="confirm_password" class="block text-gray-700 font-bold mb-2">Xác Nhận Mật Khẩu:</label>
                <input type="password" id="confirm_password" name="confirm_password" required
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    Tạo Tài Khoản
                </button>
            </div>
        </form>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/admin_footer.php'; ?>
