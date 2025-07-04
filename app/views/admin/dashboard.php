<?php require_once __DIR__ . '/../layouts/admin_header.php'; ?>
/*
 * Bảng điều khiển quản trị viên
 * Hiển thị tổng quan về số lượng VĐV và hạng mục thi đấu
 */
<main class="flex-1 p-6 bg-gray-100">
    <h1 class="text-2xl font-bold mb-6">Bảng Điều Khiển</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1: Total Riders -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
            <div class="bg-blue-500 text-white rounded-full h-12 w-12 flex items-center justify-center mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tổng Số VĐV</p>
                <p class="text-2xl font-bold">
                    <!-- Hiển thị dữ liệu thật -->
                    <?= htmlspecialchars($data['total_riders'] ?? 0) ?>
                </p>
            </div>
        </div>

        <!-- Card 2: Total Categories -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
             <div class="bg-green-500 text-white rounded-full h-12 w-12 flex items-center justify-center mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Hạng Mục Thi Đấu</p>
                <p class="text-2xl font-bold">
                     <!-- Hiển thị dữ liệu thật -->
                     <?= htmlspecialchars($data['total_categories'] ?? 0) ?>
                </p>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/admin_footer.php'; ?>
