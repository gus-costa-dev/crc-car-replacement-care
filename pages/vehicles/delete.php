<?php
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: <?php echo BASE_URL; ?>/pages/auth/login.php');
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

try {
    $pdo  = getDBConnection();
    $stmt = $pdo->prepare("DELETE FROM vehicles WHERE id = :id");
    $stmt->execute([':id' => $id]);

    header('Location: index.php');
    exit;

} catch (PDOException $e) {
    header('Location: index.php');
    exit;
}