<?php 
// Đảm bảo $data['rider'] tồn tại để tránh lỗi
$riderName = isset($data['rider']['name']) ? htmlspecialchars($data['rider']['name']) : 'Không rõ';
$pageTitle = 'Chi tiết Rider: ' . $riderName;
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">
    <?php if (isset($data['rider']) && !empty($data['rider'])): ?>
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Rider Images -->
            <div class="md:w-1/2 space-y-4">
                <div>
                    <img src="/webrank/public/<?= htmlspecialchars($data['rider']['photo1_url'] ?? '') ?>" 
                         alt="Ảnh 1 của <?= $riderName ?>" 
                         class="w-full h-auto object-cover rounded-lg shadow-md"
                         onerror="this.onerror=null;this.src='https://placehold.co/600x400/e2e8f0/333?text=Image+Not+Found';">
                </div>
                <div>
                    <img src="/webrank/public/<?= htmlspecialchars($data['rider']['photo2_url'] ?? '') ?>" 
                         alt="Ảnh 2 của <?= $riderName ?>" 
                         class="w-full h-auto object-cover rounded-lg shadow-md"
                         onerror="this.onerror=null;this.src='https://placehold.co/600x400/e2e8f0/333?text=Image+Not+Found';">
                </div>
            </div>

            <!-- Rider Details -->
            <div class="md:w-1/2">
                <h1 class="text-4xl font-bold text-gray-900 mb-2"><?= $riderName ?></h1>
                <p class="text-xl text-blue-600 font-semibold mb-6"><?= htmlspecialchars($data['rider']['team'] ?? 'Không có đội') ?></p>

                <div class="space-y-4">
                    <div class="flex items-center">
                        <span class="font-bold w-32">Tuổi:</span>
                        <span class="text-gray-700"><?= htmlspecialchars($data['rider']['age'] ?? 'N/A') ?></span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-bold w-32">Ngày sinh:</span>
                        <span class="text-gray-700"><?= htmlspecialchars($data['rider']['formatted_dob'] ?? 'N/A') ?></span>
                    </div>
                    <div class="flex items-start">
                        <span class="font-bold w-32 mt-1">Nội dung thi đấu:</span>
                        <span class="text-gray-700 flex-1"><?= htmlspecialchars($data['rider']['assigned_categories'] ?? 'Chưa đăng ký hạng mục') ?></span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-bold w-32">Thứ hạng tốt nhất:</span>
                        <span class="text-gray-700"><?= htmlspecialchars($data['rider']['best_rank'] ?? 'Chưa có hạng') ?></span>
                    </div>
                </div>
                
                <div class="mt-8">
                    <a href="/webrank/rankings" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                        &larr; Quay lại Bảng xếp hạng
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p class="text-center text-red-500">Không tìm thấy thông tin vận động viên.</p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
