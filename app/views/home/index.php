<?php 
$pageTitle = 'Trang Chủ - WEBRANK CYCLING';
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="text-center mb-12">
    <h1 class="text-4xl font-bold text-gray-900">Thư Viện Ảnh</h1>
    <p class="text-lg text-gray-600 mt-2">Những khoảnh khắc ấn tượng từ các giải đấu nhá.</p>
</div>

<?php if (empty($data['images'])): ?>
    <p class="text-center text-gray-500">Chưa có hình ảnh nào trong thư viện.</p>
<?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach ($data['images'] as $image): ?>
            <div class="bg-white rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                <img src="/webrank/public/<?= htmlspecialchars($image['image_url']) ?>" 
                     alt="<?= htmlspecialchars($image['caption'] ?? 'Cycling Image') ?>"
                     class="w-full h-64 object-cover"
                     onerror="this.onerror=null;this.src='https://placehold.co/400x400/e2e8f0/333?text=Image+Not+Found';">
                <?php if (!empty($image['caption'])): ?>
                    <div class="p-4">
                        <p class="text-gray-700"><?= htmlspecialchars($image['caption']) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
