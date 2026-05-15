<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo APP_URL; ?>/../assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
    <aside class="sidebar p-3 vh-100">
        <div class="text-center mb-4">
            <img src="<?php echo APP_URL; ?>/../assets/img/logo.png" alt="Courts of Arms" class="img-fluid rounded mb-3" style="max-width: 120px;">
            <div class="navbar-brand text-white">Lands & Physical Planning</div>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link text-white" href="<?php echo APP_URL; ?>/dashboard">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <?php if (in_array($_SESSION['user']['role'], ['Super Admin', 'Admin', 'HR Officer', 'ICT Officer'])): ?>
                <a class="nav-link text-white" href="<?php echo APP_URL; ?>/staff">
                    <i class="fas fa-users me-2"></i>Staff Management
                </a>
            <?php endif; ?>
            <?php if (in_array($_SESSION['user']['role'], ['Super Admin', 'Admin', 'HR Officer', 'ICT Officer'])): ?>
                <a class="nav-link text-white" href="<?php echo APP_URL; ?>/jobcards">
                    <i class="fas fa-id-card me-2"></i>Job Cards
                </a>
            <?php endif; ?>
            <?php if (in_array($_SESSION['user']['role'], ['Super Admin', 'Admin'])): ?>
                <a class="nav-link text-white" href="<?php echo APP_URL; ?>/users">
                    <i class="fas fa-user-shield me-2"></i>User Management
                </a>
            <?php endif; ?>
            <a class="nav-link text-white" href="<?php echo APP_URL; ?>/reports">
                <i class="fas fa-chart-bar me-2"></i>Reports
            </a>
            <a class="nav-link text-white" href="<?php echo APP_URL; ?>/verify">
                <i class="fas fa-qrcode me-2"></i>Verification
            </a>
        </nav>
    </aside>
    <div class="flex-grow-1">
        <nav class="navbar navbar-expand bg-white border-bottom px-4">
            <div class="container-fluid">
                <div class="navbar-brand mb-0 h1"><?php echo APP_NAME; ?></div>
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-2"></i><?php echo htmlspecialchars($_SESSION['user']['full_name']); ?>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/users/change-password">
                            <i class="fas fa-key me-2"></i>Change Password
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?php echo APP_URL; ?>/auth/logout">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a></li>
                    </ul>
                </div>
            </div>
            </div>
        </nav>
        <main class="container py-4">
