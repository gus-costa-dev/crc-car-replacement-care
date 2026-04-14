<?php
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create.php');
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
$make         = trim($_POST['make'] ?? '');
$model        = trim($_POST['model'] ?? '');
$year         = trim($_POST['year'] ?? '');
$registration = trim($_POST['registration'] ?? '');
$category     = trim($_POST['category'] ?? '');
$status       = trim($_POST['status'] ?? 'available');

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

// --- INSERT INTO DATABASE ---
try {
    $pdo  = getDBConnection();

    // Check registration doesn't already exist
    $stmt = $pdo->prepare("SELECT id FROM vehicles WHERE registration = :registration");
    $stmt->execute([':registration' => $registration]);

    if ($stmt->fetch()) {
        echo json_encode([
            'success' => false,
            'message' => 'That registration is already in the system'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("
        INSERT INTO vehicles (make, model, year, registration, category, status)
        VALUES (:make, :model, :year, :registration, :category, :status)
    ");

    $stmt->execute([
        ':make'         => $make,
        ':model'        => $model,
        ':year'         => $year,
        ':registration' => $registration,
        ':category'     => $category,
        ':status'       => $status
    ]);

    echo json_encode([
        'success'  => true,
        'message'  => 'Vehicle added successfully!',
        'redirect' => '<?php echo BASE_URL; ?>/pages/vehicles/index.php'
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Something went wrong. Please try again.'
    ]);
}