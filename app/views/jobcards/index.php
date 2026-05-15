<?php require_once dirname(__DIR__, 2) . '/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Job Cards</h1>
        <p class="text-muted">View generated identity cards and manage issuance records.</p>
    </div>
    <div>
        <button class="btn btn-success me-2" id="printBtn" onclick="printSelectedCards()" disabled>
            <i class="bi bi-printer"></i> Print Selected
        </button>
    </div>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="cardsTable">
            <thead>
                <tr>
                    <th style="width: 40px;"><input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)"></th>
                    <th>Card Number</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Station</th>
                    <th>Issued</th>
                    <th>Expires</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['cards'] as $card): ?>
                    <tr>
                        <td><input type="checkbox" class="card-checkbox" value="<?php echo $card['id']; ?>" onchange="updatePrintButton()"></td>
                        <td><?php echo htmlspecialchars($card['card_number']); ?></td>
                        <td><?php echo htmlspecialchars($card['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($card['department_name']); ?></td>
                        <td><?php echo htmlspecialchars($card['station']); ?></td>
                        <td><?php echo htmlspecialchars($card['issued_at']); ?></td>
                        <td><?php echo htmlspecialchars($card['expires_at']); ?></td>
                        <td class="text-end">
                            <div class="btn-group" role="group">
                                <a class="btn btn-sm btn-outline-primary" href="<?php echo APP_URL; ?>/jobcards/show/<?php echo $card['id']; ?>">View</a>
                                <?php if (in_array($_SESSION['user']['role'], ['Admin', 'ICT Officer', 'HR Officer'])): ?>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmCardDelete(<?php echo $card['id']; ?>, '<?php echo htmlspecialchars(addslashes($card['full_name'])); ?>')">
                                        Delete
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCardModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Delete Job Card</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the card for <strong id="deleteCardName"></strong>?</p>
                <p class="text-danger mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteCardForm" method="post" style="display:inline;">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <button type="submit" class="btn btn-danger">Delete Card</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmCardDelete(cardId, fullName) {
    document.getElementById('deleteCardName').textContent = fullName;
    document.getElementById('deleteCardForm').action = '<?php echo APP_URL; ?>/jobcards/delete/' + cardId;
    const modal = new bootstrap.Modal(document.getElementById('deleteCardModal'));
    modal.show();
}
</script>

<?php require_once dirname(__DIR__, 2) . '/views/layouts/footer.php'; ?>
