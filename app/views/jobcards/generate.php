<?php require_once dirname(__DIR__, 2) . '/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Generate Job Card</h1>
        <p class="text-muted">Create a printable identity card for <?php echo htmlspecialchars($data['staff']['full_name']); ?>.</p>
    </div>
    <a class="btn btn-outline-secondary" href="<?php echo APP_URL; ?>/jobcards">Back</a>
</div>
<div class="card p-4">
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Date Issued</label>
                <input type="date" name="issued_at" class="form-control" value="<?php echo htmlspecialchars($data['staff']['date_issued']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Expiry Date</label>
                <input type="date" name="expires_at" class="form-control" value="<?php echo htmlspecialchars($data['staff']['expiry_date']); ?>" required>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Generate Card</button>
        </div>
    </form>
</div>
<?php require_once dirname(__DIR__, 2) . '/views/layouts/footer.php'; ?>
