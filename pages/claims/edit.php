<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

// Session check
if (!isset($_SESSION['user_id'])) {
    header('Location: <?php echo BASE_URL; ?>/pages/auth/login.php');
    exit;
}

// Get claim ID from URL
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

// --- GET EXISTING CLAIM ---
try {
    $pdo  = getDBConnection();
    $stmt = $pdo->prepare("SELECT * FROM claims WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $claim = $stmt->fetch();

    if (!$claim) {
        header('Location: index.php');
        exit;
    }

    // Get available vehicles for dropdown
    $stmt     = $pdo->prepare("
        SELECT id, make, model, registration 
        FROM vehicles 
        WHERE status = 'available' OR id = :vehicle_id
    ");
    $stmt->execute([':vehicle_id' => $claim['vehicle_id']]);
    $vehicles = $stmt->fetchAll();

} catch (PDOException $e) {
    header('Location: index.php');
    exit;
}
?>

<div class="container">

    <div class="page-header">
        <h1>✏️ Edit Claim #<?php echo $claim['id']; ?></h1>
        <div>
            <a href="view.php?id=<?php echo $claim['id']; ?>" class="btn-secondary">← Back to View</a>
            <a href="index.php" class="btn-secondary">← Back to Claims</a>
        </div>
    </div>

    <div class="form-card">

        <!-- Pass the claim ID to JS via a hidden input -->
        <input type="hidden" id="claim_id" value="<?php echo $claim['id']; ?>">

        <div id="claim-message"></div>

        <h3>Claimant Details</h3>
        <div class="form-row">
            <div class="form-group">
                <label>Full Name *</label>
                <input type="text" id="claimant_name" 
                    value="<?php echo htmlspecialchars($claim['claimant_name']); ?>">
            </div>
            <div class="form-group">
                <label>Phone *</label>
                <input type="text" id="claimant_phone" 
                    value="<?php echo htmlspecialchars($claim['claimant_phone']); ?>">
            </div>
        </div>

        <div class="form-group">
            <label>Email *</label>
            <input type="email" id="claimant_email" 
                value="<?php echo htmlspecialchars($claim['claimant_email']); ?>">
        </div>

        <h3>Accident Details</h3>
        <div class="form-row">
            <div class="form-group">
                <label>Accident Date *</label>
                <input type="date" id="accident_date" 
                    value="<?php echo $claim['accident_date']; ?>">
            </div>
            <div class="form-group">
                <label>Accident Location *</label>
                <input type="text" id="accident_location" 
                    value="<?php echo htmlspecialchars($claim['accident_location']); ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>At Fault Driver *</label>
                <input type="text" id="at_fault_driver" 
                    value="<?php echo htmlspecialchars($claim['at_fault_driver']); ?>">
            </div>
            <div class="form-group">
                <label>At Fault Insurer *</label>
                <input type="text" id="at_fault_insurer" 
                    value="<?php echo htmlspecialchars($claim['at_fault_insurer']); ?>">
            </div>
        </div>

        <h3>Vehicle Assignment</h3>
        <div class="form-group">
            <label>Assign Replacement Vehicle</label>
            <select id="vehicle_id">
                <option value="">-- No vehicle yet --</option>
                <?php foreach ($vehicles as $vehicle): ?>
                    <option value="<?php echo $vehicle['id']; ?>"
                        <?php echo ($claim['vehicle_id'] == $vehicle['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars(
                            $vehicle['make'] . ' ' .
                            $vehicle['model'] . ' (' .
                            $vehicle['registration'] . ')'
                        ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Claim Status</label>
            <select id="status">
                <option value="pending"   <?php echo $claim['status'] === 'pending'   ? 'selected' : ''; ?>>Pending</option>
                <option value="approved"  <?php echo $claim['status'] === 'approved'  ? 'selected' : ''; ?>>Approved</option>
                <option value="rejected"  <?php echo $claim['status'] === 'rejected'  ? 'selected' : ''; ?>>Rejected</option>
                <option value="completed" <?php echo $claim['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
            </select>
        </div>

        <button id="edit-claim-btn">Save Changes</button>

    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>