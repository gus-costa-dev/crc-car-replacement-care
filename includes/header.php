<?php 
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/../config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C.R.C. Car Replacement Care</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
</head>
<body>

<?php if (isset($_SESSION['user_id'])): ?>
<nav class="navbar">
    <div class="nav-brand">🚗 C.R.C. Car Replacement Care</div>
    <div class="nav-links">
        <a href="<?php echo BASE_URL; ?>/pages/dashboard.php">Dashboard</a>
        <a href="<?php echo BASE_URL; ?>/pages/claims/index.php">Claims</a>
        <a href="<?php echo BASE_URL; ?>/pages/vehicles/index.php">Vehicles</a>
    </div>
    <div class="nav-user">
        👤 <?php echo htmlspecialchars($_SESSION['user_name']); ?>
        <a href="<?php echo BASE_URL; ?>/pages/auth/logout.php">Logout</a>
    </div>
</nav>
<?php endif; ?>