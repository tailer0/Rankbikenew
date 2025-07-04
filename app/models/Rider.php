<?php
// app/models/Rider.php
require_once __DIR__ . '/../core/Database.php';

class Rider {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Lấy tất cả riders để hiển thị trong trang admin
    public function getAll() {
        try {
            $stmt = $this->db->prepare("
                SELECT id, name, team, DATE_FORMAT(date_of_birth, '%d/%m/%Y') as formatted_dob 
                FROM riders 
                ORDER BY name ASC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * SỬA LỖI: Cập nhật lại câu truy vấn để lấy dữ liệu chính xác và ổn định hơn.
     */
    public function findById($id) {
        try {
            $stmt = $this->db->prepare("
                SELECT
                    r.*, -- Lấy tất cả các cột từ bảng riders (bao gồm photo1_url, photo2_url)
                    DATE_FORMAT(r.date_of_birth, '%d/%m/%Y') as formatted_dob,
                    TIMESTAMPDIFF(YEAR, r.date_of_birth, CURDATE()) AS age,
                    -- Dùng subquery để lấy danh sách hạng mục từ bảng trung gian
                    (SELECT GROUP_CONCAT(c.name SEPARATOR ', ')
                     FROM categories c
                     JOIN rider_category_pivot p ON c.id = p.category_id
                     WHERE p.rider_id = r.id) as assigned_categories,
                    -- Dùng subquery để lấy thứ hạng tốt nhất từ bảng rankings
                    (SELECT MIN(rnk.position)
                     FROM rankings rnk
                     WHERE rnk.rider_id = r.id) as best_rank
                FROM riders r
                WHERE r.id = :id
            ");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    
    // Tìm kiếm rider theo tên (đã có)
    public function searchByName($name) {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    id, 
                    name, 
                    team,
                    TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) AS age
                FROM riders 
                WHERE name LIKE :name
            ");
            $stmt->execute(['name' => '%' . $name . '%']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Sửa lại hàm create để nhận thêm category_ids
    public function create($data) {
        try {
            $this->db->beginTransaction();
            $sql = "INSERT INTO riders (name, date_of_birth, team, photo1_url, photo2_url) 
                    VALUES (:name, :date_of_birth, :team, :photo1_url, :photo2_url)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':name' => $data['name'],
                ':date_of_birth' => $data['date_of_birth'],
                ':team' => $data['team'],
                ':photo1_url' => $data['photo1_url'],
                ':photo2_url' => $data['photo2_url']
            ]);
            $riderId = $this->db->lastInsertId();
            $this->syncCategories($riderId, $data['category_ids'] ?? []);
            $this->db->commit();
            return $riderId;
        } catch (PDOException $e) {
            $this->db->rollBack();
            die($e->getMessage());
        }
    }

    // Sửa lại hàm update để nhận thêm category_ids
    public function update($id, $data) {
        try {
            $this->db->beginTransaction();
            $sql = "UPDATE riders SET 
                        name = :name, 
                        date_of_birth = :date_of_birth, 
                        team = :team,
                        photo1_url = :photo1_url,
                        photo2_url = :photo2_url
                    WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':name' => $data['name'],
                ':date_of_birth' => $data['date_of_birth'],
                ':team' => $data['team'],
                ':photo1_url' => $data['photo1_url'],
                ':photo2_url' => $data['photo2_url']
            ]);
            $this->syncCategories($id, $data['category_ids'] ?? []);
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            die($e->getMessage());
        }
    }
  
    public function getCategoryIds($riderId) {
        $stmt = $this->db->prepare("SELECT category_id FROM rider_category_pivot WHERE rider_id = :rider_id");
        $stmt->execute([':rider_id' => $riderId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Đồng bộ hóa các hạng mục cho một rider.

    private function syncCategories($riderId, $categoryIds) {
        $stmt = $this->db->prepare("DELETE FROM rider_category_pivot WHERE rider_id = :rider_id");
        $stmt->execute([':rider_id' => $riderId]);
        if (!empty($categoryIds)) {
            $sql = "INSERT INTO rider_category_pivot (rider_id, category_id) VALUES ";
            $params = [];
            $placeholders = [];
            foreach ($categoryIds as $catId) {
                $placeholders[] = "(?, ?)";
                $params[] = $riderId;
                $params[] = $catId;
            }
            $sql .= implode(', ', $placeholders);
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
        }
    }

    // Xóa một rider
    public function delete($id) {
        try {
            $rider = $this->findById($id);
            if ($rider) {
                if ($rider['photo1_url'] && file_exists(__DIR__ . '/../../public/' . $rider['photo1_url'])) {
                    unlink(__DIR__ . '/../../public/' . $rider['photo1_url']);
                }
                if ($rider['photo2_url'] && file_exists(__DIR__ . '/../../public/' . $rider['photo2_url'])) {
                    unlink(__DIR__ . '/../../public/' . $rider['photo2_url']);
                }
            }
            
            $stmt = $this->db->prepare("DELETE FROM riders WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            die("Could not delete rider. They might be part of existing rankings. Error: " . $e->getMessage());
        }
    }

    //Đếm tổng số rider trong CSDL.

    public function countAll() {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM riders");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
