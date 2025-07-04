<?php require_once __DIR__ . '/../layouts/admin_header.php'; ?>
/*
 * Quản lý vận động viên
 * Hiển thị danh sách các vận động viên, cho phép thêm, sửa, xóa
 */
<main class="flex-1 p-6 bg-gray-100">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Quản Lý Vận Động Viên</h1>
        <a href="/webrank/admin/createRider" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
            + Thêm Rider Mới
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">Tên</th>
                    <th class="p-3">Đội</th>
                    <th class="p-3">Ngày Sinh</th>
                    <th class="p-3 text-right">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['riders'])): ?>
                    <tr>
                        <td colspan="5" class="p-3 text-center">Chưa có rider nào.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($data['riders'] as $rider): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3"><?= $rider['id'] ?></td>
                            <td class="p-3 font-semibold"><?= htmlspecialchars($rider['name']) ?></td>
                            <td class="p-3"><?= htmlspecialchars($rider['team']) ?></td>
                            <td class="p-3"><?= htmlspecialchars($rider['formatted_dob']) ?></td>
                            <td class="p-3 text-right">
                                <a href="/webrank/admin/editRider/<?= $rider['id'] ?>" class="text-blue-600 hover:text-blue-800 mr-4">Sửa</a>
                                <a href="/webrank/admin/deleteRider/<?= $rider['id'] ?>" 
                                   class="text-red-600 hover:text-red-800" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa rider này không? Hành động này không thể hoàn tác.');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/admin_footer.php'; ?>
