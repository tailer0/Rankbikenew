<?php require_once __DIR__ . '/../layouts/admin_header.php'; ?>
'/* * Biểu mẫu thêm/sửa hạng mục thi đấu
 * Hiển thị biểu mẫu để thêm hoặc chỉnh sửa một hạng mục
 */'
<main class="flex-1 p-6 bg-gray-100">
    <h1 class="text-2xl font-bold mb-6"><?= $data['page_title'] ?></h1>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <form action="<?= $data['form_action'] ?>" method="POST">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Tên Hạng Mục:</label>
                <input type="text" id="name" name="name" required
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="<?= htmlspecialchars($data['category']['name'] ?? '') ?>">
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-700 font-bold mb-2">Mô Tả:</label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($data['category']['description'] ?? '') ?></textarea>
            </div>

            <div class="flex items-center justify-end">
                <a href="/webrank/admin/manageCategories" class="text-gray-600 mr-4">Hủy</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Lưu
                </button>
            </div>
        </form>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/admin_footer.php'; ?>
