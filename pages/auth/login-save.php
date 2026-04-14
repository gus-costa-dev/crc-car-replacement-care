<?php
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../config/database.php';

// This file should only be called via AJAX POST
// If someone tries to visit it directly, send them away
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

// --- BACKEND VALIDATION ---
$email    = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($email) || empty($password)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please fill in all fields'
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid email address'
    ]);
    exit;
}

// --- DATABASE CHECK ---
try {
    $pdo = getDBConnection();

    // PDO prepared statement - notice how the variable is NOT
    // directly in the query string - this prevents SQL injection!
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    // Check user exists and password is correct
    if (!$user || !password_verify($password, $user['password'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid email or password'
        ]);
        exit;
    }

    // --- LOGIN SUCCESS ---
    // Store user info in session
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_role'] = $user['role'];

    echo json_encode([
        'success'  => true,
        'message'  => 'Login successful! Redirecting...',
        'redirect' => '<?php echo BASE_URL; ?>/pages/dashboard.php'
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Something went wrong. Please try again.'
    ]);
}