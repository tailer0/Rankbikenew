<?php
// app/models/Ranking.php
require_once __DIR__ . '/../core/Database.php';

class Ranking {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Lấy bảng xếp hạng theo nhóm tuổi.
     * @param string $ageGroup 'under_18' hoặc 'over_18'
     * @return array
     */
    public function getRankingsByAge($ageGroup) {
        $operator = ($ageGroup === 'under_18') ? '<' : '>=';
        
        try {
            // Sửa lỗi: Tối ưu lại câu truy vấn, loại bỏ các cột không cần thiết
            // và sửa lại mệnh đề GROUP BY để đảm bảo tương thích.
            $sql = "
                SELECT 
                    r.id,
                    r.name,
                    r.team,
                    TIMESTAMPDIFF(YEAR, r.date_of_birth, CURDATE()) AS age,
                    MIN(rnk.position) as position
                FROM riders r
                JOIN rankings rnk ON r.id = rnk.rider_id
                WHERE 
                    TIMESTAMPDIFF(YEAR, r.date_of_birth, CURDATE()) $operator 18
                    AND rnk.position IS NOT NULL
                GROUP BY r.id, r.name, r.team
                ORDER BY position ASC
                LIMIT 50;
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Trong ứng dụng thực tế, bạn nên ghi log lỗi này thay vì die.
            die("Query failed: " . $e->getMessage());
        }
    }

    /**
     * Lấy bảng xếp hạng cá nhân tính giờ.
     * @return array
     */
    public function getTimeTrialRankings() {
        try {
            // Câu truy vấn này vốn đã đúng, chỉ cần đảm bảo nó chạy ổn định.
            $sql = "
                SELECT 
                    r.id,
                    r.name,
                    r.team,
                    TIMESTAMPDIFF(YEAR, r.date_of_birth, CURDATE()) AS age,
                    rnk.time_in_seconds,
                    c.name as category_name
                FROM riders r
                JOIN rankings rnk ON r.id = rnk.rider_id
                JOIN categories c ON rnk.category_id = c.id
                WHERE rnk.time_in_seconds IS NOT NULL
                ORDER BY rnk.time_in_seconds ASC
                LIMIT 50;
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
}
    