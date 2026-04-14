<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

// Session check
if (!isset($_SESSION['user_id'])) {
    header('Location: <?php echo BASE_URL; ?>/pages/auth/login.php');
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

// --- GET EXISTING VEHICLE ---
try {
    $pdo  = getDBConnection();
    $stmt = $pdo->prepare("SELECT * FROM vehicles WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $vehicle = $stmt->fetch();

    if (!$vehicle) {
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
        <h1>✏️ Edit Vehicle #<?php echo $vehicle['id']; ?></h1>
        <a href="index.php" class="btn-secondary">← Back to Fleet</a>
    </div>

    <div class="form-card">

        <input type="hidden" id="vehicle_id" value="<?php echo $vehicle['id']; ?>">

        <div id="vehicle-message"></div>

        <h3>Vehicle Details</h3>
        <div class="form-row">
            <div class="form-group">
                <label>Make *</label>
                <input type="text" id="make" 
                    value="<?php echo htmlspecialchars($vehicle['make']); ?>">
            </div>
            <div class="form-group">
                <label>Model *</label>
                <input type="text" id="model" 
                    value="<?php echo htmlspecialchars($vehicle['model']); ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Year *</label>
                <input type="number" id="year" 
                    value="<?php echo $vehicle['year']; ?>" min="2000" max="2026">
            </div>
            <div class="form-group">
                <label>Registration *</label>
                <input type="text" id="registration" 
                    value="<?php echo htmlspecialchars($vehicle['registration']); ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Category *</label>
                <select id="category">
                    <option value="passenger"   <?php echo $vehicle['category'] === 'passenger'   ? 'selected' : ''; ?>>Passenger</option>
                    <option value="luxury"      <?php echo $vehicle['category'] === 'luxury'      ? 'selected' : ''; ?>>Luxury</option>
                    <option value="commercial"  <?php echo $vehicle['category'] === 'commercial'  ? 'selected' : ''; ?>>Commercial</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select id="status">
                    <option value="available"   <?php echo $vehicle['status'] === 'available'   ? 'selected' : ''; ?>>Available</option>
                    <option value="on_hire"     <?php echo $vehicle['status'] === 'on_hire'     ? 'selected' : ''; ?>>On Hire</option>
                    <option value="maintenance" <?php echo $vehicle['status'] === 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                </select>
            </div>
        </div>

        <button id="edit-vehicle-btn">Save Changes</button>

    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>