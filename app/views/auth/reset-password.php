<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo APP_URL; ?>/../assets/css/style.css" rel="stylesheet">
    <style>
        .reset-container {
            background: linear-gradient(135deg, #2d5016 0%, #4a7c2a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .reset-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            max-width: 450px;
            width: 100%;
        }
        .reset-header {
            background: linear-gradient(135deg, #2d5016 0%, #4a7c2a 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 2rem;
            text-align: center;
        }
        .btn-reset {
            background: linear-gradient(135deg, #2d5016 0%, #4a7c2a 100%);
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-reset:hover {
            background: linear-gradient(135deg, #4a7c2a 0%, #2d5016 100%);
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
<div class="reset-container">
    <div class="reset-card">
        <div class="reset-header">
            <i class="fas fa-key fa-3x mb-3"></i>
            <h3 class="mb-0">Reset Password</h3>
            <p class="mb-0 mt-2 opacity-75">Enter your new password</p>
        </div>
        <div class="card-body p-4">
            <?php if (!empty($data['errors'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?php foreach ($data['errors'] as $error): ?>
                        <div><?php echo $error; ?></div>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="post" action="" autocomplete="off">
                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($data['token'] ?? ''); ?>">

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-lock me-2"></i>New Password
                    </label>
                    <input type="password" name="password" class="form-control form-control-lg" required
                           placeholder="Enter new password" minlength="8">
                    <div class="form-text">Password must be at least 8 characters long</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-lock me-2"></i>Confirm Password
                    </label>
                    <input type="password" name="confirm_password" class="form-control form-control-lg" required
                           placeholder="Confirm new password">
                </div>

                <button type="submit" class="btn btn-reset w-100 btn-lg mb-3">
                    <i class="fas fa-save me-2"></i>Reset Password
                </button>
            </form>

            <div class="text-center">
                <a href="<?php echo APP_URL; ?>/auth/login" class="text-decoration-none">
                    <i class="fas fa-arrow-left me-1"></i>Back to Login
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>