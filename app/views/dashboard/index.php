<?php
/** @var array $data */
require_once dirname(__DIR__) . '/layouts/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="text-muted">Job Card System for Generating and Managing Job Cards for Casuals,Attachés and Interns</p>
    </div>
</div>
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card p-3 card-stat">
            <div class="text-muted">Total Job Cards</div>
            <h3><?php echo number_format($data['totalCards']); ?></h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 card-stat">
            <div class="text-muted">Active Staff</div>
            <h3><?php echo number_format($data['activeStaff']); ?></h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 card-stat">
            <div class="text-muted">Expired Cards</div>
            <h3><?php echo number_format($data['expiredCards']); ?></h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 card-stat">
            <div class="text-muted">Recent Activity</div>
            <h3><?php echo count($data['recentLogs']); ?></h3>
        </div>
    </div>
</div>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card p-3">
            <h5 class="mb-3">Recent Activity Logs</h5>
            <ul class="list-group list-group-flush">
                <?php foreach ($data['recentLogs'] as $log): ?>
                    <li class="list-group-item">
                        <strong><?php echo htmlspecialchars($log['action']); ?></strong>
                        <div class="small text-muted"><?php echo htmlspecialchars($log['description']); ?></div>
                        <div class="small text-muted">By <?php echo htmlspecialchars($log['user_name']); ?> · <?php echo $log['created_at']; ?></div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card p-3">
            <h5 class="mb-3">Recently Added Staff</h5>
            <div class="list-group">
                <?php foreach ($data['recentStaff'] as $staff): ?>
                    <div class="list-group-item">
                        <div class="fw-bold"><?php echo htmlspecialchars($staff['full_name']); ?></div>
                        <div class="small text-muted"><?php echo htmlspecialchars($staff['designation']); ?> · <?php echo htmlspecialchars($staff['department_name']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
