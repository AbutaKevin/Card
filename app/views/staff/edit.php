<?php require_once dirname(__DIR__, 2) . '/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Edit Staff</h1>
        <p class="text-muted">Update employee details and renew issuance information.</p>
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
                <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($data['staff']['full_name']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">ID Number</label>
                <input type="text" name="id_number" class="form-control" value="<?php echo htmlspecialchars($data['staff']['id_number']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Designation</label>
                <input type="text" name="designation" class="form-control" value="<?php echo htmlspecialchars($data['staff']['designation']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Station</label>
                <input type="text" name="station" class="form-control" value="<?php echo htmlspecialchars($data['staff']['station']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Department</label>
                <select name="department_id" class="form-select" required>
                    <option value="">Choose department</option>
                    <?php foreach ($data['departments'] as $dept): ?>
                        <option value="<?php echo $dept['id']; ?>" <?php echo $dept['id'] == $data['staff']['department_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($dept['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="Active" <?php echo $data['staff']['status'] === 'Active' ? 'selected' : ''; ?>>Active</option>
                    <option value="Inactive" <?php echo $data['staff']['status'] === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Passport Photo</label>
                <input type="file" name="passport_photo" class="form-control" accept="image/*">
                <?php if (!empty($data['staff']['passport_photo'])): ?>
                    <div class="mt-2"><img src="<?php echo APP_URL; ?>/storage/uploads/<?php echo htmlspecialchars($data['staff']['passport_photo']); ?>" alt="Photo" width="100"></div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <label class="form-label">Date Issued</label>
                <input type="date" name="date_issued" class="form-control" value="<?php echo htmlspecialchars($data['staff']['date_issued']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Expiry Date</label>
                <input type="date" name="expiry_date" class="form-control" value="<?php echo htmlspecialchars($data['staff']['expiry_date']); ?>" required>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary">Update Staff</button>
        </div>
    </form>
</div>
<?php require_once dirname(__DIR__, 2) . '/views/layouts/footer.php'; ?>
