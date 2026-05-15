<?php

require_once dirname(__DIR__) . '/models/User.php';
require_once dirname(__DIR__) . '/models/ActivityLog.php';

class Users extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->requireAuth();
        $this->authorize(['Super Admin', 'Admin']);

        $userModel = new UserModel();
        $data = ['users' => $userModel->all()];
        $this->view('users/index', $data);
    }

    public function create() {
        $this->requireAuth();
        $this->authorize(['Super Admin', 'Admin']);

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                $errors[] = 'Invalid token';
            }

            $fullName = sanitize($_POST['full_name'] ?? '');
            $username = sanitize($_POST['username'] ?? '');
            $email = sanitize($_POST['email'] ?? '');
            $role = $_POST['role'] ?? 'Viewer';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($fullName) || empty($username) || empty($email)) {
                $errors[] = 'All fields are required';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address';
            }

            if (empty($password) || strlen($password) < 8) {
                $errors[] = 'Password must be at least 8 characters long';
            }

            if ($password !== $confirmPassword) {
                $errors[] = 'Passwords do not match';
            }

            // Check if username or email already exists
            $userModel = new UserModel();
            $existingUser = $userModel->getByUsername($username);
            if ($existingUser) {
                $errors[] = 'Username already exists';
            }

            $existingEmail = $userModel->getByEmail($email);
            if ($existingEmail) {
                $errors[] = 'Email address already exists';
            }

            if (empty($errors)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $userData = [
                    'full_name' => $fullName,
                    'username' => $username,
                    'password' => $hashedPassword,
                    'role' => $role,
                    'email' => $email
                ];

                if ($userModel->create($userData)) {
                    $log = new ActivityLogModel();
                    $log->log([
                        'user_id' => $_SESSION['user']['id'],
                        'action' => 'Create user',
                        'target_type' => 'User',
                        'target_id' => 0,
                        'description' => 'Created user account for ' . $fullName
                    ]);

                    header('Location: ' . APP_URL . '/users');
                    exit;
                } else {
                    $errors[] = 'Failed to create user account';
                }
            }
        }

        $data = ['errors' => $errors];
        $this->view('users/create', $data);
    }

    public function edit($id = null) {
        $this->requireAuth();
        $this->authorize(['Super Admin', 'Admin']);

        $userModel = new UserModel();
        $user = $userModel->getById($id);

        if (!$user) {
            http_response_code(404);
            echo 'User not found';
            exit;
        }

        // Super Admin can edit anyone, Admin can edit everyone except Super Admin
        if ($_SESSION['user']['role'] !== 'Super Admin' && $user['role'] === 'Super Admin') {
            http_response_code(403);
            echo 'Access denied';
            exit;
        }

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                $errors[] = 'Invalid token';
            }

            $fullName = sanitize($_POST['full_name'] ?? '');
            $username = sanitize($_POST['username'] ?? '');
            $email = sanitize($_POST['email'] ?? '');
            $role = $_POST['role'] ?? 'Viewer';
            $status = $_POST['status'] ?? 'Active';

            if (empty($fullName) || empty($username) || empty($email)) {
                $errors[] = 'All fields are required';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address';
            }

            // Check if username or email already exists (excluding current user)
            $existingUser = $userModel->getByUsername($username);
            if ($existingUser && $existingUser['id'] != $id) {
                $errors[] = 'Username already exists';
            }

            $existingEmail = $userModel->getByEmail($email);
            if ($existingEmail && $existingEmail['id'] != $id) {
                $errors[] = 'Email address already exists';
            }

            // Prevent changing own role if not Super Admin
            if ($_SESSION['user']['id'] == $id && $_SESSION['user']['role'] !== 'Super Admin') {
                $role = $user['role']; // Keep original role
            }

            if (empty($errors)) {
                $userData = [
                    'full_name' => $fullName,
                    'username' => $username,
                    'role' => $role,
                    'email' => $email
                ];

                if ($userModel->update($id, $userData)) {
                    $log = new ActivityLogModel();
                    $log->log([
                        'user_id' => $_SESSION['user']['id'],
                        'action' => 'Update user',
                        'target_type' => 'User',
                        'target_id' => $id,
                        'description' => 'Updated user account for ' . $fullName
                    ]);

                    header('Location: ' . APP_URL . '/users');
                    exit;
                } else {
                    $errors[] = 'Failed to update user account';
                }
            }
        }

        $data = ['user' => $user, 'errors' => $errors];
        $this->view('users/edit', $data);
    }

    public function delete($id = null) {
        $this->requireAuth();
        $this->authorize(['Super Admin', 'Admin']);

        $userModel = new UserModel();
        $user = $userModel->getById($id);

        if (!$user) {
            http_response_code(404);
            echo 'User not found';
            exit;
        }

        // Prevent deleting Super Admin accounts
        if ($user['role'] === 'Super Admin') {
            http_response_code(403);
            echo 'Cannot delete Super Admin accounts';
            exit;
        }

        // Prevent deleting own account
        if ($_SESSION['user']['id'] == $id) {
            http_response_code(403);
            echo 'Cannot delete your own account';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                echo 'Invalid token';
                exit;
            }

            if ($userModel->delete($id)) {
                $log = new ActivityLogModel();
                $log->log([
                    'user_id' => $_SESSION['user']['id'],
                    'action' => 'Delete user',
                    'target_type' => 'User',
                    'target_id' => $id,
                    'description' => 'Deleted user account for ' . $user['full_name']
                ]);

                header('Location: ' . APP_URL . '/users');
                exit;
            } else {
                echo 'Failed to delete user';
                exit;
            }
        }

        $data = ['user' => $user];
        $this->view('users/delete', $data);
    }

    public function changePassword() {
        $this->requireAuth();

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                $errors[] = 'Invalid token';
            }

            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                $errors[] = 'All password fields are required';
            }

            if (strlen($newPassword) < 8) {
                $errors[] = 'New password must be at least 8 characters long';
            }

            if ($newPassword !== $confirmPassword) {
                $errors[] = 'New passwords do not match';
            }

            // Verify current password
            $userModel = new UserModel();
            $user = $userModel->getById($_SESSION['user']['id']);

            if (!password_verify($currentPassword, $user['password'])) {
                $errors[] = 'Current password is incorrect';
            }

            if (empty($errors)) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                if ($userModel->updatePassword($_SESSION['user']['id'], $hashedPassword)) {
                    $log = new ActivityLogModel();
                    $log->log([
                        'user_id' => $_SESSION['user']['id'],
                        'action' => 'Change password',
                        'target_type' => 'User',
                        'target_id' => $_SESSION['user']['id'],
                        'description' => 'Changed password'
                    ]);

                    $data = ['success' => 'Password changed successfully'];
                    $this->view('users/change-password', $data);
                    return;
                } else {
                    $errors[] = 'Failed to change password';
                }
            }
        }

        $data = ['errors' => $errors];
        $this->view('users/change-password', $data);
    }
}