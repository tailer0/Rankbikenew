<?php require_once __DIR__ . '/../layouts/admin_header.php'; ?>
/*
 * Quản lý hạng mục thi đấu
 * Hiển thị danh sách các hạng mục, cho phép thêm, sửa, xóa
 */
<main class="flex-1 p-6 bg-gray-100">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Quản Lý Hạng Mục Thi Đấu</h1>
        <a href="/webrank/admin/createCategory" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
            + Thêm Hạng Mục
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">Tên Hạng Mục</th>
                    <th class="p-3">Mô Tả</th>
                    <th class="p-3 text-right">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['categories'] as $category): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3"><?= $category['id'] ?></td>
                        <td class="p-3 font-semibold"><?= htmlspecialchars($category['name']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($category['description']) ?></td>
                        <td class="p-3 text-right">
                            <a href="/webrank/admin/editCategory/<?= $category['id'] ?>" class="text-blue-600 hover:text-blue-800 mr-4">Sửa</a>
                            <a href="/webrank/admin/deleteCategory/<?= $category['id'] ?>" 
                               class="text-red-600 hover:text-red-800" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa hạng mục này không?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/admin_footer.php'; ?>
