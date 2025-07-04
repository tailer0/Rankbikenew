<?php 
$pageTitle = 'Bảng Xếp Hạng Đua Xe Đạp';
require_once __DIR__ . '/../layouts/header.php'; 
?>

<h1 class="text-3xl font-bold mb-6 text-center">Bảng Xếp Hạng</h1>

<!-- Search Form -->
<div class="mb-8 max-w-lg mx-auto">
    <form action="/webrank/rankings" method="GET" class="flex">
        <input type="text" name="search" placeholder="Tìm kiếm rider theo tên..." 
               class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500"
               value="<?= htmlspecialchars($data['searchQuery'] ?? '') ?>">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-r-md hover:bg-blue-700">
            Tìm
        </button>
    </form>
</div>

<?php if (isset($data['searchResults'])): ?>
    <!-- Search Results -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Kết quả tìm kiếm cho "<?= htmlspecialchars($data['searchQuery']) ?>"</h2>
        <?php if (empty($data['searchResults'])): ?>
            <p>Không tìm thấy rider nào.</p>
        <?php else: ?>
            <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-3">Tên</th>
                                <th class="p-3">Đội</th>
                                <th class="p-3">Tuổi</th>
                                <th class="p-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['searchResults'] as $rider): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3"><?= htmlspecialchars($rider['name']) ?></td>
                                    <td class="p-3"><?= htmlspecialchars($rider['team']) ?></td>
                                    <td class="p-3"><?= htmlspecialchars($rider['age']) ?></td>
                                    <td class="p-3 text-right">
                                        <a href="/webrank/riders/show/<?= $rider['id'] ?>" class="text-blue-600 hover:underline">Xem chi tiết</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
        <?php endif; ?>
    </div>
<?php else: ?>
    <!-- Main Ranking Tabs -->
    <div x-data="{ tab: 'over18' }">
                <div class="border-b border-gray-200 mb-6">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button @click="tab = 'over18'" :class="{ 'active': tab === 'over18' }" class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Trên 18 Tuổi
                        </button>
                        <button @click="tab = 'under18'" :class="{ 'active': tab === 'under18' }" class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Dưới 18 Tuổi
                        </button>
                        <button @click="tab = 'timetrial'" :class="{ 'active': tab === 'timetrial' }" class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Cá Nhân Tính Giờ
                        </button>
                    </nav>
                </div>

                <!-- Over 18 Table -->
                <div x-show="tab === 'over18'" class="bg-white p-6 rounded-lg shadow-lg">
                    <?php render_ranking_table($data['over18'] ?? [], 'position'); ?>
                </div>

                <!-- Under 18 Table -->
                <div x-show="tab === 'under18'" class="bg-white p-6 rounded-lg shadow-lg" style="display: none;">
                    <?php render_ranking_table($data['under18'] ?? [], 'position'); ?>
                </div>

                <!-- Time Trial Table -->
                <div x-show="tab === 'timetrial'" class="bg-white p-6 rounded-lg shadow-lg" style="display: none;">
                    <?php render_ranking_table($data['timeTrial'] ?? [], 'time'); ?>
                </div>
            </div>
    
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

<?php
// Helper function to render a ranking table
function render_ranking_table($riders, $type = 'position') {
    if (empty($riders)) {
        echo "<p>Chưa có dữ liệu cho hạng mục này.</p>";
        return;
    }
    
    $isTimeTrial = ($type === 'time');
    
    echo '<table class="w-full text-left">';
    echo '<thead><tr class="bg-gray-200">';
    echo '<th class="p-3">Hạng</th>';
    echo '<th class="p-3">Tên</th>';
    echo '<th class="p-3">Đội</th>';
    echo '<th class="p-3">Tuổi</th>';
    if ($isTimeTrial) {
        echo '<th class="p-3">Thời gian</th>';
    }
    echo '<th class="p-3"></th>';
    echo '</tr></thead><tbody>';
    
    $rank = 1;
    foreach ($riders as $rider) {
        echo '<tr class="border-b hover:bg-gray-50">';
        echo '<td class="p-3 font-bold">' . ($isTimeTrial ? $rank : htmlspecialchars($rider['position'])) . '</td>';
        echo '<td class="p-3">' . htmlspecialchars($rider['name']) . '</td>';
        echo '<td class="p-3">' . htmlspecialchars($rider['team']) . '</td>';
        echo '<td class="p-3">' . htmlspecialchars($rider['age']) . '</td>';
        if ($isTimeTrial) {
            $seconds = $rider['time_in_seconds'];
            $timeFormatted = sprintf('%02d:%02d:%02d', floor($seconds / 3600), floor(($seconds % 3600) / 60), $seconds % 60);
            echo '<td class="p-3">' . $timeFormatted . '</td>';
        }
        echo '<td class="p-3 text-right"><a href="/webrank/riders/show/' . $rider['id'] . '" class="text-blue-600 hover:underline">Xem chi tiết</a></td>';
        echo '</tr>';
        $rank++;
    }
    
    echo '</tbody></table>';
}
?>
