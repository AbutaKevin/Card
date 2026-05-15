<?php require_once dirname(__DIR__, 2) . '/views/layouts/header.php'; ?>

<style>
    @media print {
        body, .container-fluid { background: white !important; }
        .no-print { display: none; }
        .card-container { margin: 0 !important; padding: 0 !important; page-break-after: always; }
    }

    .card-container {
        width: 85.6mm;
        height: 53.98mm;
        background: white;
        border: 2px solid #2d5016;
        margin: 20px auto;
        font-family: Arial, sans-serif;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .card-header {
        background: white;
        padding: 8px 12px;
        border-bottom: 1px solid #ccc;
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 40px;
    }

    .card-header-left {
        display: flex;
        align-items: center;
        gap: 6px;
        flex: 1;
    }

    .card-logo {
        width: 70px;
        height: 32px;
        background: white;
        border: 1px solid #2d5016;
        border-radius: 2px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
    }

    .card-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 2px;
    }

    .card-header-text {
        font-size: 8px;
        font-weight: 900;
        line-height: 1.1;
        text-transform: uppercase;
    }

    .card-header-right {
        width: 70px;
        height: 32px;
        overflow: hidden;
        border: 1px solid #2d5016;
        border-radius: 2px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-header-right img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 1px;
    }

    .card-content {
        display: flex;
        height: calc(53.98mm - 40px - 18px);
        padding: 4px 8px;
        gap: 8px;
    }

    .card-photo {
        width: 28mm;
        height: 28mm;
        background: #f0f0f0;
        border: 1px solid #2d5016;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }

    .card-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        font-size: 10px;
        line-height: 1.2;
        font-weight: 600;
    }

    .detail-row {
        display: flex;
        gap: 1px;
    }

    .detail-label {
        font-weight: 900;
        min-width: 40px;
        text-transform: uppercase;
    }

    .detail-value {
        flex: 1;
        word-break: break-all;
        text-transform: uppercase;
        font-weight: 700;
    }

    .card-footer {
        background: #2d5016;
        color: white;
        text-align: center;
        padding: 6px;
        font-size: 10px;
        font-weight: 900;
        letter-spacing: 1px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .no-print {
        margin-bottom: 20px;
    }

    .btn {
        margin-right: 10px;
    }
</style>

<div class="no-print d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Identification Card Preview</h1>
        <p class="text-muted">Printable view for <?php echo htmlspecialchars($data['card']['full_name']); ?></p>
    </div>
    <div>
        <a class="btn btn-outline-secondary" href="<?php echo APP_URL; ?>/jobcards">Back</a>
        <button class="btn btn-primary" onclick="window.print()">Print Card</button>
    </div>
</div>

<div class="card-container">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-logo">
                <img src="<?php echo APP_URL; ?>/../assets/img/logo.png" alt="Department Logo">
            </div>
            <div class="card-header-text">
                STATE DEPARTMENT FOR<br>LANDS AND PHYSICAL<br>PLANNING
            </div>
        </div>
        <div class="card-header-right">
            <img src="<?php echo APP_URL; ?>/../assets/img/image.png" alt="Department Badge">
        </div>
    </div>

    <div class="card-content">
        <div class="card-photo">
            <?php 
            $photoPath = APP_URL . '/storage/uploads/' . htmlspecialchars($data['card']['passport_photo']);
            if (!empty($data['card']['passport_photo'])) {
                echo '<img src="' . $photoPath . '" alt="Staff Photo">';
            }
            ?>

        </div>

        <div class="card-details">
            <div class="detail-row">
                <span class="detail-label">NAME:</span>
                <span class="detail-value"><?php echo htmlspecialchars(strtoupper($data['card']['full_name'])); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">ID NO:</span>
                <span class="detail-value"><?php echo htmlspecialchars($data['card']['id_number']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">DSGN:</span>
                <span class="detail-value"><?php echo htmlspecialchars(strtoupper($data['card']['designation'])); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">STATION:</span>
                <span class="detail-value"><?php echo htmlspecialchars(strtoupper($data['card']['station'])); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">ISSUED:</span>
                <span class="detail-value"><?php echo htmlspecialchars($data['card']['issued_at']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">EXPIRES:</span>
                <span class="detail-value"><?php echo htmlspecialchars($data['card']['expires_at']); ?></span>
            </div>
        </div>
    </div>

    <div class="card-footer">
        IDENTIFICATION CARD
    </div>
</div>

<div class="no-print card mt-4">
    <div class="card-body">
        <h5>Card Details</h5>
        <table class="table table-sm">
            <tr>
                <td><strong>Card Number:</strong></td>
                <td><?php echo htmlspecialchars($data['card']['card_number']); ?></td>
            </tr>
            <tr>
                <td><strong>Department:</strong></td>
                <td><?php echo htmlspecialchars($data['card']['department_name']); ?></td>
            </tr>
            <tr>
                <td><strong>Expires:</strong></td>
                <td><?php echo htmlspecialchars($data['card']['expires_at']); ?></td>
            </tr>
        </table>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/views/layouts/footer.php'; ?>
