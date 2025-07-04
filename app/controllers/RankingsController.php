<?php
// app/controllers/RankingsController.php

// Require models
require_once __DIR__ . '/../models/Ranking.php';
require_once __DIR__ . '/../models/Rider.php';

class RankingsController {
    public function index() {
        $rankingModel = new Ranking();
        $riderModel = new Rider();
        
        // Khởi tạo $data để tránh lỗi "Undefined variable"
        $data = [
            'searchResults' => null,
            'searchQuery' => '',
            'under18' => [],
            'over18' => [],
            'timeTrial' => []
        ];
        
        $searchQuery = $_GET['search'] ?? '';
        
        if (!empty($searchQuery)) {
            // Nếu có tìm kiếm, hiển thị kết quả
            $data['searchResults'] = $riderModel->searchByName($searchQuery);
            $data['searchQuery'] = $searchQuery;
        } else {
            // Nếu không, hiển thị các bảng xếp hạng
            $data['under18'] = $rankingModel->getRankingsByAge('under_18');
            $data['over18'] = $rankingModel->getRankingsByAge('over_18');
            $data['timeTrial'] = $rankingModel->getTimeTrialRankings();
        }
        
        // Tải view
        require_once __DIR__ . '/../views/rankings/index.php';
    }
}

// Giả sử DefaultController sẽ trỏ đến RankingsController
class DefaultController extends RankingsController {}
