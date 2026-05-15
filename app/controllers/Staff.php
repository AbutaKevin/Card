<?php

require_once dirname(__DIR__) . '/models/Staff.php';
require_once dirname(__DIR__) . '/models/Department.php';
require_once dirname(__DIR__) . '/models/ActivityLog.php';

class Staff extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->requireAuth();
        $model = new StaffModel();
        $department = new DepartmentModel();

        $search = sanitize($_GET['search'] ?? '');
        $status = sanitize($_GET['status'] ?? '');

        $data = [
            'staff' => $model->search($search, ['status' => $status]),
            'departments' => $department->all(),
            'filters' => ['search' => $search, 'status' => $status],
        ];

        $this->view('staff/index', $data);
    }

    public function add() {
        $this->requireAuth();
        $this->authorize(['Admin', 'HR Officer']);
        $department = new DepartmentModel();
        $staff = new StaffModel();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                $errors[] = 'Invalid request token.';
            }

            $payload = [
                'full_name' => sanitize($_POST['full_name'] ?? ''),
                'id_number' => sanitize($_POST['id_number'] ?? ''),
                'designation' => sanitize($_POST['designation'] ?? ''),
                'station' => sanitize($_POST['station'] ?? ''),
                'department_id' => sanitize($_POST['department_id'] ?? ''),
                'passport_photo' => '',
                'date_issued' => sanitize($_POST['date_issued'] ?? ''),
                'expiry_date' => sanitize($_POST['expiry_date'] ?? ''),
                'status' => sanitize($_POST['status'] ?? 'Active'),
            ];

            if (empty($payload['full_name']) || empty($payload['id_number']) || empty($payload['department_id'])) {
                $errors[] = 'Full name, ID number, and department are required.';
            }

            if (empty($errors)) {
                if (!empty($_FILES['passport_photo']['tmp_name'])) {
                    $payload['passport_photo'] = $this->handleUpload($_FILES['passport_photo'], 'photos');
                }
                $staff->create($payload);
                $log = new ActivityLogModel();
                $log->log(['user_id' => $_SESSION['user']['id'], 'action' => 'Create staff', 'target_type' => 'Staff', 'target_id' => 0, 'description' => 'Added staff record: ' . $payload['full_name']]);
                header('Location: ' . APP_URL . '/staff');
                exit;
            }
        }

        $data = ['departments' => $department->all(), 'errors' => $errors];
        $this->view('staff/add', $data);
    }

    public function edit($id = null) {
        $this->requireAuth();
        $this->authorize(['Admin', 'HR Officer']);
        $department = new DepartmentModel();
        $staffModel = new StaffModel();
        $errors = [];

        $record = $staffModel->get($id);
        if (!$record) {
            http_response_code(404);
            echo 'Staff record not found';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                $errors[] = 'Invalid request token.';
            }

            $payload = [
                'id' => $id,
                'full_name' => sanitize($_POST['full_name'] ?? ''),
                'id_number' => sanitize($_POST['id_number'] ?? ''),
                'designation' => sanitize($_POST['designation'] ?? ''),
                'station' => sanitize($_POST['station'] ?? ''),
                'department_id' => sanitize($_POST['department_id'] ?? ''),
                'passport_photo' => $record['passport_photo'],
                'date_issued' => sanitize($_POST['date_issued'] ?? ''),
                'expiry_date' => sanitize($_POST['expiry_date'] ?? ''),
                'status' => sanitize($_POST['status'] ?? 'Active'),
            ];

            if (empty($payload['full_name']) || empty($payload['id_number'])) {
                $errors[] = 'Full name and ID number are required.';
            }

            if (empty($errors)) {
                if (!empty($_FILES['passport_photo']['tmp_name'])) {
                    $payload['passport_photo'] = $this->handleUpload($_FILES['passport_photo'], 'photos');
                }
                $staffModel->update($payload);
                $log = new ActivityLogModel();
                $log->log(['user_id' => $_SESSION['user']['id'], 'action' => 'Update staff', 'target_type' => 'Staff', 'target_id' => $id, 'description' => 'Updated staff record: ' . $payload['full_name']]);
                header('Location: ' . APP_URL . '/staff');
                exit;
            }
        }

        $data = ['staff' => $record, 'departments' => $department->all(), 'errors' => $errors];
        $this->view('staff/edit', $data);
    }

    public function delete($id = null) {
        $this->requireAuth();
        $this->authorize(['Admin', 'HR Officer']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                header('Location: ' . APP_URL . '/staff');
                exit;
            }
            $model = new StaffModel();
            $record = $model->get($id);
            if ($record) {
                $model->delete($id);
                $log = new ActivityLogModel();
                $log->log(['user_id' => $_SESSION['user']['id'], 'action' => 'Delete staff', 'target_type' => 'Staff', 'target_id' => $id, 'description' => 'Deleted staff record: ' . $record['full_name']]);
            }
        }
        header('Location: ' . APP_URL . '/staff');
        exit;
    }

    private function handleUpload($file, $folder) {
        $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($file['type'], $allowed) || $file['size'] > 2 * 1024 * 1024) {
            return '';
        }
        $targetDir = UPLOAD_DIR . '/' . $folder;
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        $filename = uniqid() . '_' . basename($file['name']);
        $destination = $targetDir . '/' . $filename;
        move_uploaded_file($file['tmp_name'], $destination);
        return $folder . '/' . $filename;
    }
}
