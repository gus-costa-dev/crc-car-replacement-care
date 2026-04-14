<?php
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized'
    ]);
    exit;
}

// --- BACKEND VALIDATION ---
$id           = $_POST['vehicle_id'] ?? null;
$make         = trim($_POST['make'] ?? '');
$model        = trim($_POST['model'] ?? '');
$year         = trim($_POST['year'] ?? '');
$registration = trim($_POST['registration'] ?? '');
$category     = trim($_POST['category'] ?? '');
$status       = trim($_POST['status'] ?? 'available');

if (!$id) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid vehicle ID'
    ]);
    exit;
}

if (
    empty($make)         ||
    empty($model)        ||
    empty($year)         ||
    empty($registration) ||
    empty($category)
) {
    echo json_encode([
        'success' => false,
        'message' => 'Please fill in all required fields'
    ]);
    exit;
}

if (!is_numeric($year) || $year < 2000 || $year > 2026) {
    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid year between 2000 and 2026'
    ]);
    exit;
}

// --- UPDATE DATABASE ---
try {
    $pdo  = getDBConnection();
    $stmt = $pdo->prepare("
        UPDATE vehicles SET
            make         = :make,
            model        = :model,
            year         = :year,
            registration = :registration,
            category     = :category,
            status       = :status
        WHERE id = :id
    ");

    $stmt->execute([
        ':make'         => $make,
        ':model'        => $model,
        ':year'         => $year,
        ':registration' => $registration,
        ':category'     => $category,
        ':status'       => $status,
        ':id'           => $id
    ]);

    echo json_encode([
        'success'  => true,
        'message'  => 'Vehicle updated successfully!',
        'redirect' => '<?php echo BASE_URL; ?>/pages/vehicles/index.php'
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Something went wrong. Please try again.'
    ]);
}