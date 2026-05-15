<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo APP_URL; ?>/../assets/css/style.css" rel="stylesheet">
    <style>
        .login-container {
            background: linear-gradient(135deg, #2d5016 0%, #4a7c2a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            max-width: 450px;
            width: 100%;
        }
        .login-header {
            background: linear-gradient(135deg, #2d5016 0%, #4a7c2a 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 2rem;
            text-align: center;
        }
        .login-header img {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
        }
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }
        .password-toggle:hover {
            color: #2d5016;
        }
        .btn-login {
            background: linear-gradient(135deg, #2d5016 0%, #4a7c2a 100%);
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #4a7c2a 0%, #2d5016 100%);
            transform: translateY(-1px);
        }
        .forgot-password {
            text-align: center;
            margin-top: 1rem;
        }
        .forgot-password a {
            color: #2d5016;
            text-decoration: none;
            font-weight: 500;
        }
        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <img src="<?php echo APP_URL; ?>/../assets/img/logo.png" alt="Logo" onerror="this.style.display='none'">
            <h3 class="mb-0">State Department for</h3>
            <h5 class="mb-0">Lands & Physical Planning</h5>
            <p class="mb-0 mt-2 opacity-75">Job Card Management System</p>
        </div>
        <div class="card-body p-4">
            <h4 class="card-title mb-3 text-center">System Login</h4>
            <p class="text-muted text-center mb-4">Enter your credentials to access the dashboard</p>

            <?php if (!empty($data['errors'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?php foreach ($data['errors'] as $error): ?>
                        <div><?php echo $error; ?></div>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($data['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo $data['success']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="post" action="" autocomplete="off">
                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-user me-2"></i>Username
                    </label>
                    <input type="text" name="username" class="form-control form-control-lg" required
                           placeholder="Enter your username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                </div>

                <div class="mb-3 position-relative">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-lock me-2"></i>Password
                    </label>
                    <input type="password" name="password" id="password" class="form-control form-control-lg" required
                           placeholder="Enter your password">
                    <i class="fas fa-eye password-toggle" id="passwordToggle" onclick="togglePassword()"></i>
                </div>

                <button type="submit" class="btn btn-login w-100 btn-lg mb-3">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                </button>
            </form>

            <div class="forgot-password">
                <a href="#" onclick="showForgotPassword()">
                    <i class="fas fa-key me-1"></i>Forgot Password?
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #2d5016 0%, #4a7c2a 100%); color: white;">
                <h5 class="modal-title">
                    <i class="fas fa-key me-2"></i>Reset Password
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="forgotPasswordForm">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <div id="forgotPasswordFeedback"></div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required placeholder="Enter your email">
                    </div>
                    <button type="submit" id="forgotPasswordSubmitBtn" class="btn btn-success w-100">
                        <i class="fas fa-paper-plane me-2"></i>Send Reset Link
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword() {
    const password = document.getElementById('password');
    const toggle = document.getElementById('passwordToggle');

    if (password.type === 'password') {
        password.type = 'text';
        toggle.classList.remove('fa-eye');
        toggle.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        toggle.classList.remove('fa-eye-slash');
        toggle.classList.add('fa-eye');
    }
}

function showForgotPassword() {
    const modal = new bootstrap.Modal(document.getElementById('forgotPasswordModal'));
    modal.show();
}

const forgotPasswordForm = document.getElementById('forgotPasswordForm');
const forgotPasswordFeedback = document.getElementById('forgotPasswordFeedback');
const forgotPasswordSubmitBtn = document.getElementById('forgotPasswordSubmitBtn');

forgotPasswordForm.addEventListener('submit', function(e) {
    e.preventDefault();
    forgotPasswordSubmitBtn.disabled = true;
    forgotPasswordSubmitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Sending...';
    forgotPasswordFeedback.innerHTML = '';

    const formData = new FormData(this);

    fetch('<?php echo APP_URL; ?>/auth/forgot-password', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        forgotPasswordSubmitBtn.disabled = false;
        forgotPasswordSubmitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Send Reset Link';

        const alertType = data.success ? 'success' : 'danger';
        forgotPasswordFeedback.innerHTML = '<div class="alert alert-' + alertType + ' py-2 mb-3">' + data.message + '</div>';

        if (data.success) {
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('forgotPasswordModal'));
                if (modal) {
                    modal.hide();
                }
                forgotPasswordFeedback.innerHTML = '';
            }, 1800);
        }
    })
    .catch(error => {
        forgotPasswordSubmitBtn.disabled = false;
        forgotPasswordSubmitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Send Reset Link';
        forgotPasswordFeedback.innerHTML = '<div class="alert alert-danger py-2 mb-3">An error occurred. Please try again.</div>';
    });
});
</script>
</body>
</html>
