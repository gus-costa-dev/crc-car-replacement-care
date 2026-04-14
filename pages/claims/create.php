<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

// Session check
if (!isset($_SESSION['user_id'])) {
    header('Location: <?php echo BASE_URL; ?>/pages/auth/login.php');
    exit;
}

// Get available vehicles for the dropdown
try {
    $pdo  = getDBConnection();
    $stmt = $pdo->prepare("
        SELECT id, make, model, registration 
        FROM vehicles 
        WHERE status = 'available'
    ");
    $stmt->execute();
    $vehicles = $stmt->fetchAll();
} catch (PDOException $e) {
    $vehicles = [];
}
?>

<div class="container">

    <div class="page-header">
        <h1>➕ New Accident Claim</h1>
        <a href="index.php" class="btn-secondary">← Back to Claims</a>
    </div>

    <div class="form-card">

        <div id="claim-message"></div>

        <h3>Claimant Details</h3>
        <div class="form-row">
            <div class="form-group">
                <label>Full Name *</label>
                <input type="text" id="claimant_name" placeholder="Enter full name">
            </div>
            <div class="form-group">
                <label>Phone *</label>
                <input type="text" id="claimant_phone" placeholder="Enter phone number">
            </div>
        </div>

        <div class="form-group">
            <label>Email *</label>
            <input type="email" id="claimant_email" placeholder="Enter email address">
        </div>

        <h3>Accident Details</h3>
        <div class="form-row">
            <div class="form-group">
                <label>Accident Date *</label>
                <input type="date" id="accident_date">
            </div>
            <div class="form-group">
                <label>Accident Location *</label>
                <input type="text" id="accident_location" placeholder="e.g. George St, Sydney NSW">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>At Fault Driver *</label>
                <input type="text" id="at_fault_driver" placeholder="At fault driver full name">
            </div>
            <div class="form-group">
                <label>At Fault Insurer *</label>
                <input type="text" id="at_fault_insurer" placeholder="e.g. AAMI, Allianz, NRMA">
            </div>
        </div>

        <h3>Vehicle Assignment</h3>
        <div class="form-group">
            <label>Assign Replacement Vehicle</label>
            <select id="vehicle_id">
                <option value="">-- No vehicle yet --</option>
                <?php foreach ($vehicles as $vehicle): ?>
                    <option value="<?php echo $vehicle['id']; ?>">
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
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <button id="create-claim-btn">Submit Claim</button>

    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>