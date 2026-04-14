<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

// Session check
if (!isset($_SESSION['user_id'])) {
    header('Location: <?php echo BASE_URL; ?>/pages/auth/login.php');
    exit;
}

// Get the claim ID from the URL
// e.g. view.php?id=1  →  $_GET['id'] = 1
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

// --- GET ONE CLAIM FROM DATABASE ---
try {
    $pdo  = getDBConnection();
    $stmt = $pdo->prepare("
        SELECT 
            claims.*,
            vehicles.make,
            vehicles.model,
            vehicles.registration,
            vehicles.category
        FROM claims
        LEFT JOIN vehicles ON claims.vehicle_id = vehicles.id
        WHERE claims.id = :id
    ");
    $stmt->execute([':id' => $id]);
    $claim = $stmt->fetch();

    // If no claim found, go back to list
    if (!$claim) {
        header('Location: index.php');
        exit;
    }

} catch (PDOException $e) {
    header('Location: index.php');
    exit;
}
?>

<div class="container">

    <div class="page-header">
        <h1>👁️ Claim #<?php echo $claim['id']; ?></h1>
        <div>
            <a href="edit.php?id=<?php echo $claim['id']; ?>" class="btn-primary">Edit Claim</a>
            <a href="index.php" class="btn-secondary">← Back to Claims</a>
        </div>
    </div>

    <div class="view-grid">

        <div class="view-card">
            <h3>👤 Claimant Details</h3>
            <table class="view-table">
                <tr>
                    <th>Full Name</th>
                    <td><?php echo htmlspecialchars($claim['claimant_name']); ?></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><?php echo htmlspecialchars($claim['claimant_phone']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($claim['claimant_email']); ?></td>
                </tr>
            </table>
        </div>

        <div class="view-card">
            <h3>🚗 Accident Details</h3>
            <table class="view-table">
                <tr>
                    <th>Accident Date</th>
                    <td><?php echo $claim['accident_date']; ?></td>
                </tr>
                <tr>
                    <th>Location</th>
                    <td><?php echo htmlspecialchars($claim['accident_location']); ?></td>
                </tr>
                <tr>
                    <th>At Fault Driver</th>
                    <td><?php echo htmlspecialchars($claim['at_fault_driver']); ?></td>
                </tr>
                <tr>
                    <th>At Fault Insurer</th>
                    <td><?php echo htmlspecialchars($claim['at_fault_insurer']); ?></td>
                </tr>
            </table>
        </div>

        <div class="view-card">
            <h3>🚙 Assigned Vehicle</h3>
            <table class="view-table">
                <?php if ($claim['make']): ?>
                    <tr>
                        <th>Vehicle</th>
                        <td><?php echo htmlspecialchars($claim['make'] . ' ' . $claim['model']); ?></td>
                    </tr>
                    <tr>
                        <th>Registration</th>
                        <td><?php echo htmlspecialchars($claim['registration']); ?></td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td><?php echo ucfirst($claim['category']); ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="no-vehicle">No vehicle assigned yet</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

        <div class="view-card">
            <h3>📋 Claim Status</h3>
            <table class="view-table">
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="status-badge status-<?php echo $claim['status']; ?>">
                            <?php echo ucfirst($claim['status']); ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Created</th>
                    <td><?php echo $claim['created_at']; ?></td>
                </tr>
            </table>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>