<?php require_once dirname(__DIR__, 2) . '/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Staff Management</h1>
        <p class="text-muted">Create, review and filter employee records for job card issuance.</p>
    </div>
    <a class="btn btn-primary" href="<?php echo APP_URL; ?>/staff/add">Add Staff</a>
</div>
<div class="card mb-4 p-3">
    <form class="row g-3" method="get" action="">
        <div class="col-md-4">
            <input type="text" class="form-control" name="search" placeholder="Search by name, ID, station or department" value="<?php echo htmlspecialchars($data['filters']['search']); ?>">
        </div>
        <div class="col-md-3">
            <select class="form-select" name="status">
                <option value="">All statuses</option>
                <option value="Active" <?php echo $data['filters']['status'] === 'Active' ? 'selected' : ''; ?>>Active</option>
                <option value="Inactive" <?php echo $data['filters']['status'] === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-secondary w-100">Filter</button>
        </div>
    </form>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>ID Number</th>
                    <th>Designation</th>
                    <th>Station</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['staff'] as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($item['id_number']); ?></td>
                        <td><?php echo htmlspecialchars($item['designation']); ?></td>
                        <td><?php echo htmlspecialchars($item['station']); ?></td>
                        <td><?php echo htmlspecialchars($item['department_name']); ?></td>
                        <td><?php echo htmlspecialchars($item['status']); ?></td>
                        <td class="text-end table-actions">
                            <a class="btn btn-sm btn-outline-success" href="<?php echo APP_URL; ?>/jobcards/generate/<?php echo $item['id']; ?>">Generate</a>
                            <a class="btn btn-sm btn-outline-primary" href="<?php echo APP_URL; ?>/staff/edit/<?php echo $item['id']; ?>">Edit</a>
                            <form action="<?php echo APP_URL; ?>/staff/delete/<?php echo $item['id']; ?>" method="post" class="d-inline">
                                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger" data-confirm="Delete this staff record?">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once dirname(__DIR__, 2) . '/views/layouts/footer.php'; ?>
