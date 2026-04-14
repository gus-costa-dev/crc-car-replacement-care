<?php
require_once __DIR__ . '/../../includes/header.php';

// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: <?php echo BASE_URL; ?>/pages/dashboard.php');
    exit;
}
?>

<div class="container">
    <div class="auth-box">
        <h1>C.R.C. Car Replacement Care</h1>
        <h2>Create Account</h2>

        <div id="register-message"></div>

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" placeholder="Enter your full name">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Enter your email">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Min 6 characters">
        </div>

        <div class="form-group">
            <label for="password-confirm">Confirm Password</label>
            <input type="password" id="password-confirm" placeholder="Repeat your password">
        </div>

        <button id="register-btn">Create Account</button>

        <p class="auth-link">
            Already have an account?
            <a href="login.php">Login here</a>
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>