<?php

require_once dirname(__DIR__) . '/models/JobCard.php';
require_once dirname(__DIR__) . '/models/Staff.php';

class Verify extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view('verify/index', ['result' => null]);
    }

    public function show($cardNumber = null) {
        $cardNumber = sanitize($cardNumber ?: ($_GET['card_number'] ?? ''));
        $jobCard = new JobCardModel();
        $stmt = $jobCard->db->prepare('SELECT jc.*, s.full_name, s.id_number, s.designation, s.station, s.status, d.name AS department_name FROM job_cards jc JOIN staff s ON jc.staff_id = s.id JOIN departments d ON s.department_id = d.id WHERE jc.card_number = :card_number LIMIT 1');
        $stmt->execute(['card_number' => $cardNumber]);
        $record = $stmt->fetch();
        $result = null;
        if ($record) {
            $expired = strtotime($record['expires_at']) < time();
            $result = [
                'name' => $record['full_name'],
                'id_number' => $record['id_number'],
                'designation' => $record['designation'],
                'station' => $record['station'],
                'department' => $record['department_name'],
                'status' => $record['status'],
                'validity' => $expired ? 'Expired' : 'Valid',
                'issued_at' => $record['issued_at'],
                'expires_at' => $record['expires_at'],
            ];
        }
        $this->view('verify/show', ['result' => $result, 'card_number' => $cardNumber]);
    }
}
