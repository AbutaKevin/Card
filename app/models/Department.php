<?php

class DepartmentModel extends Model {
    public function __construct() {
        parent::__construct();
    }

    public function all() {
        $stmt = $this->db->prepare('SELECT * FROM departments ORDER BY name');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function get($id) {
        $stmt = $this->db->prepare('SELECT * FROM departments WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
