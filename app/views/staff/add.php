<?php require_once dirname(__DIR__, 2) . '/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Add Staff</h1>
        <p class="text-muted">Register a new employee record before generating their job card.</p>
    </div>
    <a class="btn btn-outline-secondary" href="<?php echo APP_URL; ?>/staff">Back</a>
</div>
<div class="card p-4">
    <?php if (!empty($data['errors'])): ?>
        <div class="alert alert-danger">
        <?php foreach ($data['errors'] as $error): ?>
            <div><?php echo $error; ?></div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">ID Number</label>
                <input type="text" name="id_number" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Designation</label>
                <input type="text" name="designation" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Station</label>
                <input type="text" name="station" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Department</label>
                <select name="department_id" class="form-select" required>
                    <option value="">Choose department</option>
                    <?php foreach ($data['departments'] as $dept): ?>
                        <option value="<?php echo $dept['id']; ?>"><?php echo htmlspecialchars($dept['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Passport Photo</label>
                <input type="file" name="passport_photo" class="form-control" accept="image/*">
            </div>
            <div class="col-md-6">
                <label class="form-label">Date Issued</label>
                <input type="date" name="date_issued" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Expiry Date</label>
                <input type="date" name="expiry_date" class="form-control" required>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Save Staff</button>
        </div>
    </form>
</div>
<?php require_once dirname(__DIR__, 2) . '/views/layouts/footer.php'; ?>
