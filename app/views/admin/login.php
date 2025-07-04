<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md">
        <form action="/webrank/admin/handleLogin" method="POST" class="bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Admin Login</h2>
            
            <!-- THÊM ĐOẠN MÃ NÀY: Hiển thị thông báo đăng ký thành công -->
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?= $_SESSION['success_message'] ?></span>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?= $error ?></span>
                </div>
            <?php endif; ?>
            
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" id="username" name="username" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" id="password" name="password" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                    Sign In
                </button>
            </div>
        </form>
        
        <div class="text-center mt-4">
            <a href="/webrank/admin/show_register_form" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Chưa có tài khoản? Tạo tài khoản Admin
            </a>
        </div>
    </div>
</body>
</html>
