<?php

require_once dirname(__DIR__) . '/models/User.php';
require_once dirname(__DIR__) . '/models/ActivityLog.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Auth extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function login() {
        if (!empty($_SESSION['user'])) {
            header('Location: ' . APP_URL . '/dashboard');
            exit;
        }

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                $errors[] = 'Invalid request token.';
            }
            $username = sanitize($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $errors[] = 'Enter username and password.';
            }

            if (empty($errors)) {
                $userModel = new UserModel();
                $user = $userModel->getByUsername($username);
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'full_name' => $user['full_name'],
                        'username' => $user['username'],
                        'role' => $user['role'],
                    ];
                    if (method_exists($userModel, 'updateLogin')) {
                        $userModel->updateLogin($user['id']);
                    }
                    $log = new ActivityLogModel();
                    $log->log(['user_id' => $user['id'], 'action' => 'Login', 'target_type' => 'User', 'target_id' => $user['id'], 'description' => 'User logged in']);
                    header('Location: ' . APP_URL . '/dashboard');
                    exit;
                }
                $errors[] = 'Invalid credentials.';
            }
        }

        $data = ['errors' => $errors];
        $this->view('auth/login', $data);
    }

    public function index() {
        header('Location: ' . APP_URL . '/auth/login');
        exit;
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ' . APP_URL . '/auth/login');
        exit;
    }

    public function forgotPassword() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }

        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            echo json_encode(['success' => false, 'message' => 'Invalid token']);
            exit;
        }

        $email = sanitize($_POST['email'] ?? '');

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Please enter a valid email address']);
            exit;
        }

        $userModel = new UserModel();
        $user = $userModel->getByEmail($email);

        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'No account found with this email address']);
            exit;
        }

        // Generate reset token
        $resetToken = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Store reset token (you might want to create a separate table for this)
        $userModel->storeResetToken($user['id'], $resetToken, $expiry);

        $resetLink = APP_URL . "/auth/reset-password?token=" . $resetToken;
        $subject = "Password Reset - " . APP_NAME;

        $htmlBody = '<p>Hello ' . htmlspecialchars($user['full_name']) . ',</p>' .
            '<p>You requested a password reset. Click the button below to reset your password:</p>' .
            '<p><a href="' . htmlspecialchars($resetLink) . '" style="display:inline-block;padding:10px 18px;border-radius:4px;background:#2d5016;color:#ffffff;text-decoration:none;">Reset Password</a></p>' .
            '<p>This link will expire in 1 hour.</p>' .
            '<p>If you did not request this, please ignore this email.</p>' .
            '<p>Best regards,<br>' . APP_NAME . ' Team</p>';

        $plainBody = "Hello " . $user['full_name'] . ",\n\n" .
            "You requested a password reset. Use the link below to reset your password:\n" .
            $resetLink . "\n\n" .
            "This link will expire in 1 hour.\n\n" .
            "If you did not request this, please ignore this email.\n\n" .
            "Best regards,\n" . APP_NAME . " Team";

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = MAIL_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;
            $mail->SMTPSecure = MAIL_SMTP_SECURE;
            $mail->Port = MAIL_PORT;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME);
            $mail->addAddress($user['email'], $user['full_name']);
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $htmlBody;
            $mail->AltBody = $plainBody;

            $mail->send();
            echo json_encode(['success' => true, 'message' => 'Password reset link sent to your email']);
            exit;
        } catch (Exception $e) {
            error_log('Mail error: ' . $e->getMessage());
            error_log('Mail debug: Host=' . MAIL_HOST . ', Port=' . MAIL_PORT . ', Secure=' . MAIL_SMTP_SECURE);
            echo json_encode(['success' => false, 'message' => 'Unable to send email. Please try again later.']);
            exit;
        }
    }

    public function resetPassword() {
        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            $data = ['errors' => ['Invalid reset token']];
            $this->view('auth/reset-password', $data);
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->getByResetToken($token);

        if (!$user) {
            $data = ['errors' => ['Invalid or expired reset token']];
            $this->view('auth/reset-password', $data);
            return;
        }

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                $errors[] = 'Invalid token';
            }

            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($password) || strlen($password) < 8) {
                $errors[] = 'Password must be at least 8 characters long';
            }

            if ($password !== $confirmPassword) {
                $errors[] = 'Passwords do not match';
            }

            if (empty($errors)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $userModel->updatePassword($user['id'], $hashedPassword);
                $userModel->clearResetToken($user['id']);

                $data = ['success' => 'Password reset successfully. You can now login with your new password.'];
                $this->view('auth/login', $data);
                return;
            }
        }

        $data = ['errors' => $errors, 'token' => $token];
        $this->view('auth/reset-password', $data);
    }
}
