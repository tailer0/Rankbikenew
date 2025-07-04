<?php 
    // Define the base path for your project.
    // If your project is in a subfolder (e.g., http://localhost/webrank), set this to '/webrank'.
    // If your project is at the root (e.g., http://localhost), set this to an empty string ''.
    define('BASE_URL_PATH', '/webrank'); 
    
    require_once __DIR__ . '/../layouts/admin_header.php'; 
?>

<style>
    /* Custom styles for a better UI */

    /* Image Preview Styling */
    .image-preview-container {
        width: 100%;
        padding-top: 75%; /* 4:3 Aspect Ratio */
        position: relative;
        border-radius: 0.75rem;
        overflow: hidden;
        background-color: #f3f4f6; /* gray-100 */
        border: 2px dashed #d1d5db; /* gray-300 */
        transition: all 0.3s ease;
    }

    .image-preview-container:hover {
        border-color: #3b82f6; /* blue-500 */
        background-color: #e5e7eb; /* gray-200 */
    }

    .image-preview-label {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #6b7280; /* gray-500 */
    }

    .image-preview-label svg {
        width: 3rem;
        height: 3rem;
        margin-bottom: 0.5rem;
        color: #9ca3af; /* gray-400 */
    }

    .image-preview-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Overlay for existing images */
    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .image-preview-container:hover .image-overlay {
        opacity: 1;
    }

    /* Custom Checkbox Scrollbar */
    .category-list::-webkit-scrollbar {
        width: 6px;
    }
    .category-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .category-list::-webkit-scrollbar-thumb {
        background: #a8a8a8;
        border-radius: 10px;
    }
    .category-list::-webkit-scrollbar-thumb:hover {
        background: #888;
    }
</style>

<main class="flex-1 p-4 sm:p-6 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800"><?= htmlspecialchars($data['page_title'] ?? 'Quản lý Rider') ?></h1>
            <p class="text-gray-500 mt-1">Điền thông tin chi tiết của vận động viên bên dưới.</p>
        </div>

        <!-- Form Container -->
        <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg">
            <form action="<?= htmlspecialchars($data['form_action'] ?? '') ?>" method="POST" enctype="multipart/form-data">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Left Column: Basic Info & Categories -->
                    <div class="lg:col-span-2 space-y-6">
                        <h2 class="text-xl font-semibold text-gray-700 border-b pb-3">Thông tin cơ bản</h2>

                        <!-- Rider Name -->
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Tên Rider <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow" value="<?= htmlspecialchars($data['rider']['name'] ?? '') ?>" placeholder="Ví dụ: Nguyễn Văn A">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Team -->
                            <div>
                                <label for="team" class="block text-sm font-bold text-gray-700 mb-2">Đội</label>
                                <input type="text" id="team" name="team" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow" value="<?= htmlspecialchars($data['rider']['team'] ?? '') ?>" placeholder="Ví dụ: Thăng Long Cycling">
                            </div>
                            <!-- Date of Birth -->
                            <div>
                                <label for="date_of_birth" class="block text-sm font-bold text-gray-700 mb-2">Ngày Sinh <span class="text-red-500">*</span></label>
                                <input type="date" id="date_of_birth" name="date_of_birth" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow" value="<?= htmlspecialchars($data['rider']['date_of_birth'] ?? '') ?>">
                            </div>
                        </div>

                        <!-- Categories -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Hạng Mục Thi Đấu</label>
                            <div class="category-list grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 border border-gray-300 rounded-lg max-h-48 overflow-y-auto bg-gray-50">
                                <?php if (!empty($data['all_categories'])): ?>
                                    <?php foreach ($data['all_categories'] as $category): ?>
                                        <label class="flex items-center space-x-3 cursor-pointer p-2 rounded-md hover:bg-blue-50 transition-colors">
                                            <input type="checkbox" name="categories[]" value="<?= $category['id'] ?>" class="form-checkbox h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-offset-0" <?= isset($data['rider_categories']) && in_array($category['id'], $data['rider_categories']) ? 'checked' : '' ?>>
                                            <span class="text-gray-700 select-none"><?= htmlspecialchars($category['name']) ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-gray-500 col-span-full text-center">Chưa có hạng mục nào được tạo. Vui lòng tạo hạng mục trước.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Image Uploads -->
                    <div class="lg:col-span-1 space-y-6">
                        <h2 class="text-xl font-semibold text-gray-700 border-b pb-3">Hình ảnh</h2>
                        
                        <!-- Photo 1 -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Ảnh 1 (Chân dung)</label>
                            <input type="file" id="photo1" name="photo1" accept=".jpg, .jpeg, .png" class="hidden" onchange="previewImage(event, 'preview-container1')">
                            <input type="hidden" name="remove_photo1" id="remove_photo1" value="0">
                            <div class="image-preview-container" id="preview-container1">
                                <?php 
                                    // Đảm bảo biến url đúng và tồn tại file
                                    $photo1_url = !empty($data['rider']['photo1_url']) ? $data['rider']['photo1_url'] : '';
                                    if ($photo1_url) :
                                        // Nếu là chỉnh sửa và có url, luôn hiển thị ảnh (không cần kiểm tra file_exists phía server, vì có thể file nằm ngoài root hoặc do quyền)
                                ?>
                                        <img src="<?= BASE_URL_PATH ?>/public/<?= htmlspecialchars($photo1_url) ?>" alt="Preview Ảnh 1" id="img-preview1">
                                        <div class="image-overlay">
                                            <label for="photo1" class="text-white font-bold py-2 px-4 rounded-lg bg-black bg-opacity-50 hover:bg-opacity-75 cursor-pointer">Đổi ảnh</label>
                                            <button type="button" class="text-white font-bold py-2 px-4 rounded-lg bg-red-600 bg-opacity-70 hover:bg-opacity-100" onclick="removeImage('preview-container1', 'remove_photo1')">Xóa</button>
                                        </div>
                                    <?php else: ?>
                                        <label for="photo1" class="image-preview-label">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                            <span>Nhấn để chọn ảnh</span>
                                        </label>
                                    <?php endif; ?>
                            </div>
                        </div>

                        <!-- Photo 2 -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Ảnh 2 (Xe đạp)</label>
                            <input type="file" id="photo2" name="photo2" accept=".jpg, .jpeg, .png" class="hidden" onchange="previewImage(event, 'preview-container2')">
                            <input type="hidden" name="remove_photo2" id="remove_photo2" value="0">
                            <div class="image-preview-container" id="preview-container2">
                                <?php 
                                    $photo2_url = !empty($data['rider']['photo2_url']) ? $data['rider']['photo2_url'] : '';
                                    if ($photo2_url) :
                                ?>
                                        <img src="<?= BASE_URL_PATH ?>/public/<?= htmlspecialchars($photo2_url) ?>" alt="Preview Ảnh 2" id="img-preview2">
                                        <div class="image-overlay">
                                            <label for="photo2" class="text-white font-bold py-2 px-4 rounded-lg bg-black bg-opacity-50 hover:bg-opacity-75 cursor-pointer">Đổi ảnh</label>
                                            <button type="button" class="text-white font-bold py-2 px-4 rounded-lg bg-red-600 bg-opacity-70 hover:bg-opacity-100" onclick="removeImage('preview-container2', 'remove_photo2')">Xóa</button>
                                        </div>
                                    <?php else: ?>
                                        <label for="photo2" class="image-preview-label">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                            <span>Nhấn để chọn ảnh</span>
                                        </label>
                                    <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200">
                    <a href="/webrank/admin/manageRiders" class="text-gray-600 font-medium mr-6 hover:text-gray-900 transition-colors">Hủy</a>
                    <button type="submit" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-8 rounded-lg transition-transform transform hover:scale-105 shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-300">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Lưu Thay Đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    const defaultUploadUI = `
        <label for="{inputId}" class="image-preview-label">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
            <span>Nhấn để chọn ảnh</span>
        </label>
    `;

    // Preview selected image
    function previewImage(event, containerId) {
        const container = document.getElementById(containerId);
        const file = event.target.files[0];
        const inputId = event.target.id;
        const removeInputId = 'remove_' + inputId;
        
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            container.innerHTML = ''; // Clear previous content

            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Image Preview';
            
            const overlay = document.createElement('div');
            overlay.className = 'image-overlay';
            overlay.innerHTML = `
                <label for="${inputId}" class="text-white font-bold py-2 px-4 rounded-lg bg-black bg-opacity-50 hover:bg-opacity-75 cursor-pointer">Đổi ảnh</label>
                <button type="button" class="text-white font-bold py-2 px-4 rounded-lg bg-red-600 bg-opacity-70 hover:bg-opacity-100" onclick="removeImage('${containerId}', '${removeInputId}')">Xóa</button>
            `;

            container.appendChild(img);
            container.appendChild(overlay);

            // Ensure the 'remove' flag is reset if a new image is chosen
            document.getElementById(removeInputId).value = '0';
        }
        reader.readAsDataURL(file);
    }

    // Remove image preview and flag for deletion
    function removeImage(containerId, removeInputId) {
        const container = document.getElementById(containerId);
        const inputId = containerId.replace('preview-container', 'photo');
        
        // Set hidden input to 1 to signal backend for deletion
        document.getElementById(removeInputId).value = '1';
        
        // Reset the file input
        document.getElementById(inputId).value = '';

        // Restore the default upload UI
        container.innerHTML = defaultUploadUI.replace('{inputId}', inputId);
    }
</script>

<?php require_once __DIR__ . '/../layouts/admin_footer.php'; ?>

<!-- Gợi ý cho vấn đề không hiển thị rider vừa thêm -->
<?php
// Nếu rider vừa thêm không hiển thị ở trang show/list, hãy kiểm tra lại controller sau khi thêm rider:
// - Đảm bảo controller redirect về trang danh sách (manageRiders) sau khi thêm thành công.
// - Đảm bảo model lấy dữ liệu mới nhất từ database.
// - Nếu dùng cache, hãy xóa cache hoặc load lại dữ liệu.
// - Nếu vẫn lỗi, kiểm tra lại câu truy vấn SQL và dữ liệu trả về.
?>
