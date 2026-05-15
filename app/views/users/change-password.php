<?php require_once dirname(__DIR__, 2) . '/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Change Password</h1>
        <p class="text-muted">Update your account password</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-4">
                <?php if (!empty($data['errors'])): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?php foreach ($data['errors'] as $error): ?>
                            <div><?php echo $error; ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($data['success'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo $data['success']; ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-lock me-2"></i>Current Password *
                        </label>
                        <input type="password" name="current_password" class="form-control" required
                               placeholder="Enter current password">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-key me-2"></i>New Password *
                        </label>
                        <input type="password" name="new_password" class="form-control" required
                               placeholder="Enter new password" minlength="8">
                        <div class="form-text">Minimum 8 characters</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-key me-2"></i>Confirm New Password *
                        </label>
                        <input type="password" name="confirm_password" class="form-control" required
                               placeholder="Confirm new password">
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/views/layouts/footer.php'; ?>