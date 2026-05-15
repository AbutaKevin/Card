<?php require_once dirname(__DIR__, 2) . '/views/layouts/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4">
            <h1 class="page-title">Card Verification</h1>
            <p class="text-muted">Enter a card number or scan a QR code to confirm the job card validity.</p>
            <form method="get" action="<?php echo APP_URL; ?>/verify/show">
                <div class="mb-3">
                    <label class="form-label">Card Number</label>
                    <input type="text" name="card_number" class="form-control" placeholder="CARD-ABC123..." required>
                </div>
                <button class="btn btn-primary">Verify</button>
            </form>
        </div>
    </div>
</div>
<?php require_once dirname(__DIR__, 2) . '/views/layouts/footer.php'; ?>
