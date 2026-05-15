<?php

class JobCardModel extends Model {
    public function __construct() {
        parent::__construct();
    }

    public function generateForStaff($staffId, $data) {
        $stmt = $this->db->prepare('INSERT INTO job_cards (staff_id, card_number, issued_at, expires_at, qr_code, created_at) VALUES (:staff_id, :card_number, :issued_at, :expires_at, :qr_code, NOW())');
        return $stmt->execute($data);
    }

    public function getByStaff($staffId) {
        $stmt = $this->db->prepare('SELECT * FROM job_cards WHERE staff_id = :staff_id ORDER BY created_at DESC LIMIT 1');
        $stmt->execute(['staff_id' => $staffId]);
        return $stmt->fetch();
    }

    public function find($id) {
        $stmt = $this->db->prepare('SELECT jc.*, s.full_name, s.id_number, s.designation, s.station, s.passport_photo, d.name AS department_name FROM job_cards jc JOIN staff s ON jc.staff_id = s.id JOIN departments d ON s.department_id = d.id WHERE jc.id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function all() {
        $stmt = $this->db->prepare('SELECT jc.*, s.full_name, s.id_number, s.designation, s.station, d.name AS department_name FROM job_cards jc JOIN staff s ON jc.staff_id = s.id JOIN departments d ON s.department_id = d.id ORDER BY jc.created_at DESC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM job_cards WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function count() {
        $stmt = $this->db->prepare('SELECT COUNT(*) as total FROM job_cards');
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
