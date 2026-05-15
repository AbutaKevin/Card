<?php require_once dirname(__DIR__, 2) . '/views/layouts/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4">
            <h1 class="page-title">Verification Result</h1>
            <?php if (empty($data['result'])): ?>
                <div class="alert alert-warning">Card number <strong><?php echo htmlspecialchars($data['card_number']); ?></strong> could not be verified.</div>
            <?php else: ?>
                <div class="mb-4">
                    <h5><?php echo htmlspecialchars($data['result']['name']); ?></h5>
                    <p class="text-muted">Department: <?php echo htmlspecialchars($data['result']['department']); ?></p>
                </div>
                <ul class="list-group mb-3">
                    <li class="list-group-item"><strong>ID Number:</strong> <?php echo htmlspecialchars($data['result']['id_number']); ?></li>
                    <li class="list-group-item"><strong>Designation:</strong> <?php echo htmlspecialchars($data['result']['designation']); ?></li>
                    <li class="list-group-item"><strong>Station:</strong> <?php echo htmlspecialchars($data['result']['station']); ?></li>
                    <li class="list-group-item"><strong>Status:</strong> <?php echo htmlspecialchars($data['result']['status']); ?></li>
                    <li class="list-group-item"><strong>Validity:</strong> <?php echo htmlspecialchars($data['result']['validity']); ?></li>
                </ul>
            <?php endif; ?>
            <a class="btn btn-secondary" href="<?php echo APP_URL; ?>/verify">Back</a>
        </div>
    </div>
</div>
<?php require_once dirname(__DIR__, 2) . '/views/layouts/footer.php'; ?>
