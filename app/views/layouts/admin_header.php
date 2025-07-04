<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100">
<div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
        <div class="p-4 text-2xl font-bold border-b border-gray-700">
            ADMIN
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="/webrank/admin/dashboard" class="block px-4 py-2 rounded hover:bg-gray-700">Bảng Điều Khiển</a>
            <a href="/webrank/admin/manageRiders" class="block px-4 py-2 rounded hover:bg-gray-700">Quản Lý VĐV</a>
            <a href="/webrank/admin/manageCategories" class="block px-4 py-2 rounded hover:bg-gray-700">Quản Lý Hạng Mục</a>
            <a href="/webrank/admin/showRegisterForm" class="block px-4 py-2 rounded hover:bg-gray-700">Tạo Admin Mới</a>
        </nav>
        <div class="p-4 border-t border-gray-700">
            <a href="/webrank/admin/logout" class="block text-center bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Đăng Xuất
            </a>
        </div>
    </aside>
    <div class="flex-1 flex flex-col overflow-y-auto">
