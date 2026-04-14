<?php
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

// --- BACKEND VALIDATION ---
$name            = trim($_POST['name'] ?? '');
$email           = trim($_POST['email'] ?? '');
$password        = trim($_POST['password'] ?? '');
$passwordConfirm = trim($_POST['password_confirm'] ?? '');

if (empty($name) || empty($email) || empty($password) || empty($passwordConfirm)) {
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

if (strlen($password) < 6) {
    echo json_encode([
        'success' => false,
        'message' => 'Password must be at least 6 characters'
    ]);
    exit;
}

if ($password !== $passwordConfirm) {
    echo json_encode([
        'success' => false,
        'message' => 'Passwords do not match'
    ]);
    exit;
}

// --- DATABASE ---
try {
    $pdo = getDBConnection();

    // First check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);

    if ($stmt->fetch()) {
        echo json_encode([
            'success' => false,
            'message' => 'That email is already registered'
        ]);
        exit;
    }

    // Hash the password - NEVER store plain text!
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // INSERT the new user into the database
    $stmt = $pdo->prepare("
        INSERT INTO users (name, email, password, role)
        VALUES (:name, :email, :password, 'staff')
    ");
    $stmt->execute([
        ':name'     => $name,
        ':email'    => $email,
        ':password' => $hashedPassword
    ]);

    echo json_encode([
        'success'  => true,
        'message'  => 'Account created! Redirecting to login...',
        'redirect' => BASE_URL . '/pages/auth/login.php'
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Something went wrong. Please try again.'
    ]);
}