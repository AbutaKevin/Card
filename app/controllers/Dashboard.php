<?php

require_once dirname(__DIR__) . '/models/Staff.php';
require_once dirname(__DIR__) . '/models/JobCard.php';
require_once dirname(__DIR__) . '/models/ActivityLog.php';

class Dashboard extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->requireAuth();
        $staff = new StaffModel();
        $jobCard = new JobCardModel();
        $activity = new ActivityLogModel();

        $data = [
            'totalCards' => $jobCard->count(),
            'activeStaff' => $staff->activeCount(),
            'expiredCards' => $staff->expiredCount(),
            'recentLogs' => $activity->latest(8),
            'recentStaff' => array_slice($staff->all(), 0, 8),
        ];

        $this->view('dashboard/index', $data);
    }
}
