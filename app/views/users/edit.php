<?php require_once dirname(__DIR__, 2) . '/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Edit User</h1>
        <p class="text-muted">Update user account information and permissions</p>
    </div>
    <div>
        <a href="<?php echo APP_URL; ?>/users" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Users
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
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

                <form method="post" action="">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-user me-2"></i>Full Name *
                            </label>
                            <input type="text" name="full_name" class="form-control" required
                                   value="<?php echo htmlspecialchars($data['user']['full_name']); ?>"
                                   placeholder="Enter full name">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-at me-2"></i>Username *
                            </label>
                            <input type="text" name="username" class="form-control" required
                                   value="<?php echo htmlspecialchars($data['user']['username']); ?>"
                                   placeholder="Enter username">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-envelope me-2"></i>Email Address *
                        </label>
                        <input type="email" name="email" class="form-control" required
                               value="<?php echo htmlspecialchars($data['user']['email'] ?? ''); ?>"
                               placeholder="Enter email address">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-user-shield me-2"></i>User Role *
                        </label>
                        <select name="role" class="form-select" required
                                <?php echo ($_SESSION['user']['id'] == $data['user']['id'] && $_SESSION['user']['role'] !== 'Super Admin') ? 'disabled' : ''; ?>>
                            <option value="">Select a role</option>
                            <?php if ($_SESSION['user']['role'] === 'Super Admin' || $data['user']['role'] === 'Super Admin'): ?>
                                <option value="Super Admin" <?php echo $data['user']['role'] === 'Super Admin' ? 'selected' : ''; ?>>Super Admin</option>
                            <?php endif; ?>
                            <option value="Admin" <?php echo $data['user']['role'] === 'Admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="HR Officer" <?php echo $data['user']['role'] === 'HR Officer' ? 'selected' : ''; ?>>HR Officer</option>
                            <option value="ICT Officer" <?php echo $data['user']['role'] === 'ICT Officer' ? 'selected' : ''; ?>>ICT Officer</option>
                            <option value="Viewer" <?php echo $data['user']['role'] === 'Viewer' ? 'selected' : ''; ?>>Viewer</option>
                        </select>
                        <?php if ($_SESSION['user']['id'] == $data['user']['id'] && $_SESSION['user']['role'] !== 'Super Admin'): ?>
                            <div class="form-text">You cannot change your own role</div>
                            <input type="hidden" name="role" value="<?php echo htmlspecialchars($data['user']['role']); ?>">
                        <?php endif; ?>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?php echo APP_URL; ?>/users" class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/views/layouts/footer.php'; ?>