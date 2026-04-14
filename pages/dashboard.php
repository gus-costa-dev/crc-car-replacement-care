<?php

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';

// Session check
if (!isset($_SESSION['user_id'])) {
    header('Location: <?php echo BASE_URL; ?>/pages/auth/login.php');
    exit;
}

// --- GET STATS FOR DASHBOARD ---
try {
    $pdo = getDBConnection();

    // Count all claims
    $stmt        = $pdo->prepare("SELECT COUNT(*) as total FROM claims");
    $stmt->execute();
    $totalClaims = $stmt->fetch()['total'];

    // Count pending claims
    $stmt          = $pdo->prepare("SELECT COUNT(*) as total FROM claims WHERE status = 'pending'");
    $stmt->execute();
    $pendingClaims = $stmt->fetch()['total'];

    // Count approved claims
    $stmt           = $pdo->prepare("SELECT COUNT(*) as total FROM claims WHERE status = 'approved'");
    $stmt->execute();
    $approvedClaims = $stmt->fetch()['total'];

    // Count available vehicles
    $stmt              = $pdo->prepare("SELECT COUNT(*) as total FROM vehicles WHERE status = 'available'");
    $stmt->execute();
    $availableVehicles = $stmt->fetch()['total'];

    // Count vehicles on hire
    $stmt             = $pdo->prepare("SELECT COUNT(*) as total FROM vehicles WHERE status = 'on_hire'");
    $stmt->execute();
    $onHireVehicles   = $stmt->fetch()['total'];

    // Get 5 most recent claims
    $stmt         = $pdo->prepare("
        SELECT * FROM claims 
        ORDER BY created_at DESC 
        LIMIT 5
    ");
    $stmt->execute();
    $recentClaims = $stmt->fetchAll();

} catch (PDOException $e) {
    $totalClaims = $pendingClaims = $approvedClaims = 0;
    $availableVehicles = $onHireVehicles = 0;
    $recentClaims = [];
}
?>

<div class="container">

    <div class="page-header">
        <h1>👋 Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
        <a href="claims/create.php" class="btn-primary">+ New Claim</a>
    </div>

    <!-- STATS CARDS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?php echo $totalClaims; ?></div>
            <div class="stat-label">Total Claims</div>
        </div>
        <div class="stat-card stat-warning">
            <div class="stat-number"><?php echo $pendingClaims; ?></div>
            <div class="stat-label">Pending Claims</div>
        </div>
        <div class="stat-card stat-success">
            <div class="stat-number"><?php echo $approvedClaims; ?></div>
            <div class="stat-label">Approved Claims</div>
        </div>
        <div class="stat-card stat-info">
            <div class="stat-number"><?php echo $availableVehicles; ?></div>
            <div class="stat-label">Available Vehicles</div>
        </div>
        <div class="stat-card stat-danger">
            <div class="stat-number"><?php echo $onHireVehicles; ?></div>
            <div class="stat-label">Vehicles On Hire</div>
        </div>
    </div>

    <!-- RECENT CLAIMS -->
    <div class="section-header">
        <h2>📋 Recent Claims</h2>
        <a href="claims/index.php">View all →</a>
    </div>

    <?php if (empty($recentClaims)): ?>
        <div class="empty-state">
            <p>No claims yet. <a href="claims/create.php">Create the first one</a>.</p>
        </div>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Claimant</th>
                    <th>Accident Date</th>
                    <th>At Fault Insurer</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentClaims as $claim): ?>
                    <tr>
                        <td><?php echo $claim['id']; ?></td>
                        <td><?php echo htmlspecialchars($claim['claimant_name']); ?></td>
                        <td><?php echo $claim['accident_date']; ?></td>
                        <td><?php echo htmlspecialchars($claim['at_fault_insurer']); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo $claim['status']; ?>">
                                <?php echo ucfirst($claim['status']); ?>
                            </span>
                        </td>
                        <td class="actions">
                            <a href="claims/view.php?id=<?php echo $claim['id']; ?>">View</a>
                            <a href="claims/edit.php?id=<?php echo $claim['id']; ?>">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>