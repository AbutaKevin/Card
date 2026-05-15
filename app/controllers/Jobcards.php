<?php

require_once dirname(__DIR__) . '/models/JobCard.php';
require_once dirname(__DIR__) . '/models/Staff.php';
require_once dirname(__DIR__) . '/models/ActivityLog.php';

class Jobcards extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->requireAuth();
        $jobCard = new JobCardModel();
        $data = ['cards' => $jobCard->all()];
        $this->view('jobcards/index', $data);
    }

    public function generate($staffId = null) {
        $this->requireAuth();
        $this->authorize(['Admin', 'ICT Officer', 'HR Officer']);
        $staffModel = new StaffModel();
        $jobCard = new JobCardModel();
        $staff = $staffModel->get($staffId);

        if (!$staff) {
            http_response_code(404);
            echo 'Staff not found.';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                echo 'Invalid token.';
                exit;
            }
            $cardNumber = 'CARD-' . strtoupper(substr(md5($staff['id_number'] . time()), 0, 10));
            $qrText = APP_URL . '/verify/show/' . urlencode($cardNumber);
            $qrFile = 'card_' . $staffId . '_' . time() . '.png';
            if (!is_dir(QR_DIR)) {
                mkdir(QR_DIR, 0755, true);
            }
            $qrPath = QR_DIR . '/' . $qrFile;
            $this->createQrCode($qrText, $qrPath);

            $payload = [
                'staff_id' => $staffId,
                'card_number' => $cardNumber,
                'issued_at' => sanitize($_POST['issued_at'] ?? $staff['date_issued']),
                'expires_at' => sanitize($_POST['expires_at'] ?? $staff['expiry_date']),
                'qr_code' => $qrFile,
            ];
            $jobCard->generateForStaff($staffId, $payload);
            $log = new ActivityLogModel();
            $log->log(['user_id' => $_SESSION['user']['id'], 'action' => 'Generate card', 'target_type' => 'JobCard', 'target_id' => 0, 'description' => 'Generated card for ' . $staff['full_name']]);
            header('Location: ' . APP_URL . '/jobcards');
            exit;
        }

        $data = ['staff' => $staff];
        $this->view('jobcards/generate', $data);
    }

    public function show($id = null) {
        $this->requireAuth();
        $jobCard = new JobCardModel();
        $card = $jobCard->find($id);
        if (!$card) {
            http_response_code(404);
            echo 'Job card not found.';
            exit;
        }
        $this->view('jobcards/view', ['card' => $card]);
    }

    public function delete($id = null) {
        $this->requireAuth();
        $this->authorize(['Admin', 'ICT Officer', 'HR Officer']);

        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            echo 'Invalid request.';
            exit;
        }

        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            echo 'Invalid token.';
            exit;
        }

        $jobCard = new JobCardModel();
        $card = $jobCard->find($id);
        if (!$card) {
            http_response_code(404);
            echo 'Job card not found.';
            exit;
        }

        // Optionally remove QR code image file
        if (!empty($card['qr_code'])) {
            $qrPath = QR_DIR . '/' . $card['qr_code'];
            if (file_exists($qrPath)) {
                @unlink($qrPath);
            }
        }

        if ($jobCard->delete($id)) {
            $log = new ActivityLogModel();
            $log->log(['user_id' => $_SESSION['user']['id'], 'action' => 'Delete card', 'target_type' => 'JobCard', 'target_id' => $id, 'description' => 'Deleted job card for ' . $card['full_name']]);
            header('Location: ' . APP_URL . '/jobcards');
            exit;
        }

        echo 'Failed to delete job card.';
        exit;
    }

    public function print() {
        $this->requireAuth();
        $jobCard = new JobCardModel();
        
        // Get IDs from query parameter (comma-separated)
        $ids = isset($_GET['ids']) ? explode(',', $_GET['ids']) : [];
        $ids = array_filter(array_map('intval', $ids)); // Validate IDs
        
        if (empty($ids)) {
            http_response_code(400);
            echo 'No cards selected for printing.';
            exit;
        }
        
        // Fetch all selected cards
        $cards = [];
        foreach ($ids as $id) {
            $card = $jobCard->find($id);
            if ($card) {
                $cards[] = $card;
            }
        }
        
        if (empty($cards)) {
            http_response_code(404);
            echo 'No valid cards found.';
            exit;
        }
        
        $this->view('jobcards/print', ['cards' => $cards]);
    }

    private function createQrCode($text, $path) {
        if (!function_exists('imagepng')) {
            return false;
        }
        $size = 250;
        $img = imagecreate($size, $size);
        $bg = imagecolorallocate($img, 255, 255, 255);
        $fg = imagecolorallocate($img, 0, 0, 0);
        imagefill($img, 0, 0, $bg);
        $font = __DIR__ . '/../views/../assets/fonts/arial.ttf';
        if (file_exists($font)) {
            imagettftext($img, 10, 0, 10, 20, $fg, $font, substr($text, 0, 40));
        } else {
            imagestring($img, 3, 10, 10, substr($text, 0, 40), $fg);
        }
        imagepng($img, $path);
        imagedestroy($img);
        return true;
    }
}
