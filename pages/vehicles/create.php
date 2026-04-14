<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

// Session check
if (!isset($_SESSION['user_id'])) {
    header('Location: <?php echo BASE_URL; ?>/pages/auth/login.php');
    exit;
}
?>

<div class="container">

    <div class="page-header">
        <h1>➕ Add Vehicle</h1>
        <a href="index.php" class="btn-secondary">← Back to Fleet</a>
    </div>

    <div class="form-card">

        <div id="vehicle-message"></div>

        <h3>Vehicle Details</h3>
        <div class="form-row">
            <div class="form-group">
                <label>Make *</label>
                <input type="text" id="make" placeholder="e.g. Toyota">
            </div>
            <div class="form-group">
                <label>Model *</label>
                <input type="text" id="model" placeholder="e.g. Camry">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Year *</label>
                <input type="number" id="year" placeholder="e.g. 2024" min="2000" max="2026">
            </div>
            <div class="form-group">
                <label>Registration *</label>
                <input type="text" id="registration" placeholder="e.g. ABC123">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Category *</label>
                <select id="category">
                    <option value="passenger">Passenger</option>
                    <option value="luxury">Luxury</option>
                    <option value="commercial">Commercial</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status *</label>
                <select id="status">
                    <option value="available">Available</option>
                    <option value="on_hire">On Hire</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>
        </div>

        <button id="create-vehicle-btn">Add Vehicle</button>

    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>