<?php
require_once __DIR__ . '/../../includes/header.php';

// If user is already logged in, send them to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: <?php echo BASE_URL; ?>/pages/dashboard.php');
    exit;
}
?>

<div class="container">
    <div class="auth-box">
        <h1>C.R.C. Car Replacement Care</h1>
        <h2>Staff Login</h2>

        <!-- This div will show errors/success messages from AJAX -->
        <div id="login-message"></div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Enter your email">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Enter your password">
        </div>

        <button id="login-btn">Login</button>

        <p class="auth-link">
            Don't have an account? 
            <a href="register.php">Register here</a>
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>