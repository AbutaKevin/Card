<?php

class StaffModel extends Model {
    public function __construct() {
        parent::__construct();
    }

    public function all() {
        $stmt = $this->db->prepare('SELECT s.*, d.name AS department_name FROM staff s LEFT JOIN departments d ON s.department_id = d.id ORDER BY s.full_name');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function get($id) {
        $stmt = $this->db->prepare('SELECT s.*, d.name AS department_name FROM staff s LEFT JOIN departments d ON s.department_id = d.id WHERE s.id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function search($query, $filters = []) {
        $sql = 'SELECT s.*, d.name AS department_name FROM staff s LEFT JOIN departments d ON s.department_id = d.id WHERE 1=1';
        $params = [];

        if (!empty($query)) {
            $sql .= ' AND (s.full_name LIKE :query OR s.id_number LIKE :query OR s.station LIKE :query OR d.name LIKE :query)';
            $params['query'] = '%' . $query . '%';
        }

        if (!empty($filters['status'])) {
            $sql .= ' AND s.status = :status';
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['issued'])) {
            $sql .= ' AND s.date_issued >= :issued_date';
            $params['issued_date'] = $filters['issued'];
        }

        $sql .= ' ORDER BY s.full_name';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare('INSERT INTO staff (full_name, id_number, designation, station, department_id, passport_photo, date_issued, expiry_date, status, created_at) VALUES (:full_name, :id_number, :designation, :station, :department_id, :passport_photo, :date_issued, :expiry_date, :status, NOW())');
        return $stmt->execute($data);
    }

    public function update($data) {
        $stmt = $this->db->prepare('UPDATE staff SET full_name = :full_name, id_number = :id_number, designation = :designation, station = :station, department_id = :department_id, passport_photo = :passport_photo, date_issued = :date_issued, expiry_date = :expiry_date, status = :status WHERE id = :id');
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM staff WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function expiredCount() {
        $stmt = $this->db->prepare('SELECT COUNT(*) as total FROM staff WHERE expiry_date < CURDATE()');
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function activeCount() {
        $stmt = $this->db->prepare('SELECT COUNT(*) as total FROM staff WHERE status = "Active"');
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
