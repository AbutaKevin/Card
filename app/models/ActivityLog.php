<?php

class ActivityLogModel extends Model {
    public function __construct() {
        parent::__construct();
    }

    public function log($data) {
        $stmt = $this->db->prepare('INSERT INTO activity_logs (user_id, action, target_type, target_id, description, created_at) VALUES (:user_id, :action, :target_type, :target_id, :description, NOW())');
        return $stmt->execute($data);
    }

    public function latest($limit = 10) {
        $stmt = $this->db->prepare('SELECT al.*, u.full_name AS user_name FROM activity_logs al LEFT JOIN users u ON al.user_id = u.id ORDER BY al.created_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
