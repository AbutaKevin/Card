<?php

require_once dirname(__DIR__) . '/models/Staff.php';
require_once dirname(__DIR__) . '/models/Department.php';
require_once dirname(__DIR__) . '/models/JobCard.php';

class Reports extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->requireAuth();
        $staff = new StaffModel();
        $department = new DepartmentModel();

        $data = [
            'departments' => $department->all(),
            'activeStaff' => $staff->search('', ['status' => 'Active']),
            'expiredCards' => $staff->search('', ['status' => 'Inactive']),
        ];

        $this->view('reports/index', $data);
    }

    public function department($deptId = null) {
        $this->requireAuth();
        $dept = new DepartmentModel();
        $staff = new StaffModel();
        $department = $dept->get($deptId);
        if (!$department) {
            http_response_code(404);
            echo 'Department not found';
            exit;
        }
        $rows = $staff->search('', []);
        $filtered = array_filter($rows, function($item) use ($deptId) {
            return $item['department_id'] == $deptId;
        });
        $this->view('reports/department', ['department' => $department, 'staff' => $filtered]);
    }
}
