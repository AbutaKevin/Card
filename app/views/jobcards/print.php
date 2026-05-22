<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print ID Cards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f5f5f5;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .print-header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .print-header h1 {
            font-size: 24px;
            color: #2d5016;
            margin: 0;
        }

        .print-header p {
            color: #666;
            margin: 5px 0 0 0;
            font-size: 14px;
        }

        .print-actions {
            display: flex;
            gap: 10px;
        }

        .print-actions button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .print-actions .btn-back {
            background: #e9ecef;
            color: #333;
        }

        .print-actions .btn-back:hover {
            background: #dee2e6;
        }

        .print-actions .btn-print {
            background: #2d5016;
            color: white;
        }

        .print-actions .btn-print:hover {
            background: #1e3a0f;
            box-shadow: 0 4px 12px rgba(45, 80, 22, 0.3);
        }

        .print-container {
            width: 100%;
            max-width: 210mm;
            margin: 0 auto;
        }

        .print-page {
            background: white;
            padding: 5mm;
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 3mm;
            page-break-after: always;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .card-container {
            width: 85.6mm;
            height: 53.98mm;
            background: white;
            border: 2px solid #2d5016;
            display: flex;
            flex-direction: column;
            font-family: Arial, sans-serif;
            position: relative;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .card-header {
            background: white;
            padding: 8px 12px;
            border-bottom: 1px solid #ccc;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
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
            flex: 1;
            padding: 4px 8px;
            gap: 8px;
            overflow: hidden;
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
            overflow: hidden;
        }

        .detail-row {
            display: flex;
            gap: 1px;
        }

        .detail-label {
            font-weight: 900;
            min-width: 40px;
            text-transform: uppercase;
            flex-shrink: 0;
        }

        .detail-value {
            flex: 1;
            word-break: break-all;
            text-transform: uppercase;
            font-weight: 700;
            overflow: hidden;
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
            flex-shrink: 0;
        }

        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }

            .print-header,
            .print-actions {
                display: none;
            }

            .print-page {
                margin-bottom: 0;
                box-shadow: none;
                page-break-after: always;
                padding: 5mm !important;
                gap: 3mm !important;
                width: 210mm !important;
                height: 297mm !important;
            }

            .card-container {
                width: 85.6mm !important;
                height: 53.98mm !important;
                flex-shrink: 0 !important;
            }

            .print-container {
                max-width: 210mm !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            @page {
                size: A4 portrait;
                margin: 0;
                padding: 0;
            }
        }

        @media (max-width: 768px) {
            .print-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .print-actions {
                width: 100%;
                margin-top: 15px;
            }
        }
    </style>
</head>
<body>

    <div class="print-header">
        <div>
            <h1><i class="bi bi-printer"></i> Print ID Cards</h1>
            <p><?php echo count($data['cards']); ?> card(s) ready to print - Preview below</p>
        </div>
        <div class="print-actions">
            <button class="btn-back" onclick="history.back()"><i class="bi bi-arrow-left"></i> Back</button>
            <button class="btn-print" onclick="this.style.display='none'; document.querySelector('.print-header').style.display='none'; window.print(); this.style.display='block'; document.querySelector('.print-header').style.display='flex';"><i class="bi bi-printer"></i> Print Now</button>
        </div>
    </div>

    <div class="print-container">
        <div class="print-page">
            <?php 
            $cardsPerPage = 0;
            foreach ($data['cards'] as $card): 
                if ($cardsPerPage === 6 && $cardsPerPage > 0): 
            ?>
        </div>
        <div class="print-page">
            <?php 
                    $cardsPerPage = 0;
                endif;
            ?>
            <div class="card-container">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-logo">
                            <img src="<?php echo APP_URL; ?>/../assets/img/logo.png" alt="Department Logo">
                        </div>
                        <div class="card-header-text">
                            STATE DEPT<br>LANDS &<br>PLANNING
                        </div>
                    </div>
                    <div class="card-header-right">
                        <img src="<?php echo APP_URL; ?>/../assets/img/image.png" alt="Department Badge">
                    </div>
                </div>

                <div class="card-content">
                    <div class="card-photo">
                        <?php 
                        if (!empty($card['passport_photo'])) {
                            $photoPath = APP_URL . '/storage/uploads/' . htmlspecialchars($card['passport_photo']);
                            echo '<img src="' . $photoPath . '" alt="Staff Photo">';
                        }
                        ?>
                    </div>

                    <div class="card-details">
                        <div class="detail-row">
                            <span class="detail-label">NAME:</span>
                            <span class="detail-value"><?php echo htmlspecialchars(strtoupper($card['full_name'])); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">ID:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($card['id_number']); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">DEPT:</span>
                            <span class="detail-value"><?php echo htmlspecialchars(strtoupper($card['designation'])); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">STN:</span>
                            <span class="detail-value"><?php echo htmlspecialchars(strtoupper($card['station'])); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">ISSUE:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($card['issued_at']); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">EXP:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($card['expires_at']); ?></span>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    ID CARD
                </div>
            </div>
            <?php 
                $cardsPerPage++;
            endforeach; 
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
