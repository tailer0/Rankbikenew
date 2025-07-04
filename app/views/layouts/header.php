<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Tiêu đề trang sẽ được truyền từ controller hoặc view con -->
    <title><?= $pageTitle ?? 'WEBRANK CYCLING' ?></title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/webrank/" class="text-2xl font-bold text-blue-600">WEBRANK CYCLING</a>
            <div>
                <a href="/webrank/" class="text-gray-600 hover:text-blue-500 px-4">Trang Chủ</a>
                <a href="/webrank/rankings" class="text-gray-600 hover:text-blue-500 px-4">Xếp Hạng</a>
                <a href="/webrank/admin/dashboard" class="text-gray-600 hover:text-blue-500 px-4">Admin</a>
            </div>
        </nav>
    </header>

    <!-- Bắt đầu nội dung chính của trang -->
    <main class="container mx-auto px-6 py-8">
