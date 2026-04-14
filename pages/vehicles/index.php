<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

// Session check
if (!isset($_SESSION['user_id'])) {
    header('Location: <?php echo BASE_URL; ?>/pages/auth/login.php');
    exit;
}

// --- GET ALL VEHICLES FROM DATABASE ---
try {
    $pdo  = getDBConnection();
    $stmt = $pdo->prepare("
        SELECT * FROM vehicles 
        ORDER BY created_at DESC
    ");
    $stmt->execute();
    $vehicles = $stmt->fetchAll();

} catch (PDOException $e) {
    $vehicles = [];
}
?>

<div class="container">

    <div class="page-header">
        <h1>🚙 Vehicle Fleet</h1>
        <a href="create.php" class="btn-primary">+ Add Vehicle</a>
    </div>

    <?php if (empty($vehicles)): ?>
        <div class="empty-state">
            <p>No vehicles yet. <a href="create.php">Add the first one</a>.</p>
        </div>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Vehicle</th>
                    <th>Year</th>
                    <th>Category</th>
                    <th>Registration</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehicles as $vehicle): ?>
                    <tr>
                        <td><?php echo $vehicle['id']; ?></td>
                        <td><?php echo htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']); ?></td>
                        <td><?php echo $vehicle['year']; ?></td>
                        <td><?php echo ucfirst($vehicle['category']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['registration']); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo $vehicle['status']; ?>">
                                <?php echo ucfirst(str_replace('_', ' ', $vehicle['status'])); ?>
                            </span>
                        </td>
                        <td class="actions">
                            <a href="edit.php?id=<?php echo $vehicle['id']; ?>">Edit</a>
                            <a href="delete.php?id=<?php echo $vehicle['id']; ?>"
                               class="delete-vehicle-link"
                               data-id="<?php echo $vehicle['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>