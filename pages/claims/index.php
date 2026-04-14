<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

// Session check - protected page
if (!isset($_SESSION['user_id'])) {
    header('Location: <?php echo BASE_URL; ?>/pages/auth/login.php');
    exit;
}

// --- GET ALL CLAIMS FROM DATABASE ---
try {
    $pdo  = getDBConnection();

    // Notice this JOIN - we're connecting claims to vehicles
    // so we can show the vehicle details alongside the claim
    $stmt = $pdo->prepare("
        SELECT 
            claims.id,
            claims.claimant_name,
            claims.claimant_phone,
            claims.claimant_email,
            claims.accident_date,
            claims.accident_location,
            claims.at_fault_driver,
            claims.at_fault_insurer,
            claims.status,
            claims.created_at,
            vehicles.make,
            vehicles.model,
            vehicles.registration
        FROM claims
        LEFT JOIN vehicles ON claims.vehicle_id = vehicles.id
        ORDER BY claims.created_at DESC
    ");
    $stmt->execute();
    $claims = $stmt->fetchAll();

} catch (PDOException $e) {
    $claims = [];
}
?>

<div class="container">

    <div class="page-header">
        <h1>🚗 Accident Claims</h1>
        <a href="create.php" class="btn-primary">+ New Claim</a>
    </div>

    <?php if (empty($claims)): ?>
        <div class="empty-state">
            <p>No claims yet. <a href="create.php">Create the first one</a>.</p>
        </div>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Claimant</th>
                    <th>Accident Date</th>
                    <th>Location</th>
                    <th>At Fault Driver</th>
                    <th>Vehicle Assigned</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($claims as $claim): ?>
                    <tr>
                        <td><?php echo $claim['id']; ?></td>
                        <td>
                            <?php echo htmlspecialchars($claim['claimant_name']); ?><br>
                            <small><?php echo htmlspecialchars($claim['claimant_phone']); ?></small>
                        </td>
                        <td><?php echo $claim['accident_date']; ?></td>
                        <td><?php echo htmlspecialchars($claim['accident_location']); ?></td>
                        <td><?php echo htmlspecialchars($claim['at_fault_driver']); ?></td>
                        <td>
                            <?php if ($claim['make']): ?>
                                <?php echo htmlspecialchars($claim['make'] . ' ' . $claim['model']); ?><br>
                                <small><?php echo htmlspecialchars($claim['registration']); ?></small>
                            <?php else: ?>
                                <span class="no-vehicle">Not assigned</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="status-badge status-<?php echo $claim['status']; ?>">
                                <?php echo ucfirst($claim['status']); ?>
                            </span>
                        </td>
                        <td class="actions">
                            <a href="view.php?id=<?php echo $claim['id']; ?>">View</a>
                            <a href="edit.php?id=<?php echo $claim['id']; ?>">Edit</a>
                            <a href="delete.php?id=<?php echo $claim['id']; ?>" 
                               class="delete-link"
                               data-id="<?php echo $claim['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>