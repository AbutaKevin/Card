<?php require_once dirname(__DIR__, 2) . '/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Reports</h1>
        <p class="text-muted">Generate department, active staff, and expired card reports.</p>
    </div>
</div>
<div class="row g-4">
    <div class="col-md-6">
        <div class="card p-4">
            <h5>Active Staff</h5>
            <p class="text-muted">Export the current active staff list.</p>
            <div class="list-group list-group-flush">
                <?php foreach ($data['activeStaff'] as $member): ?>
                    <div class="list-group-item py-2"><?php echo htmlspecialchars($member['full_name']); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-4">
            <h5>Expired Cards</h5>
            <p class="text-muted">Review staff records whose cards have expired.</p>
            <div class="list-group list-group-flush">
                <?php foreach ($data['expiredCards'] as $member): ?>
                    <div class="list-group-item py-2"><?php echo htmlspecialchars($member['full_name']); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php require_once dirname(__DIR__, 2) . '/views/layouts/footer.php'; ?>
