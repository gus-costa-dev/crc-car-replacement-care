<?php
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Session check
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized'
    ]);
    exit;
}

// --- BACKEND VALIDATION ---
$id              = $_POST['claim_id'] ?? null;
$claimantName    = trim($_POST['claimant_name'] ?? '');
$claimantPhone   = trim($_POST['claimant_phone'] ?? '');
$claimantEmail   = trim($_POST['claimant_email'] ?? '');
$accidentDate    = trim($_POST['accident_date'] ?? '');
$accidentLocation = trim($_POST['accident_location'] ?? '');
$atFaultDriver   = trim($_POST['at_fault_driver'] ?? '');
$atFaultInsurer  = trim($_POST['at_fault_insurer'] ?? '');
$vehicleId       = $_POST['vehicle_id'] ?? null;
$status          = trim($_POST['status'] ?? 'pending');

if (empty($vehicleId)) {
    $vehicleId = null;
}

if (!$id) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid claim ID'
    ]);
    exit;
}

if (
    empty($claimantName)  ||
    empty($claimantPhone) ||
    empty($claimantEmail) ||
    empty($accidentDate)  ||
    empty($accidentLocation) ||
    empty($atFaultDriver) ||
    empty($atFaultInsurer)
) {
    echo json_encode([
        'success' => false,
        'message' => 'Please fill in all required fields'
    ]);
    exit;
}

if (!filter_var($claimantEmail, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid email address'
    ]);
    exit;
}

// --- UPDATE DATABASE ---
try {
    $pdo  = getDBConnection();
    $stmt = $pdo->prepare("
        UPDATE claims SET
            claimant_name     = :claimant_name,
            claimant_phone    = :claimant_phone,
            claimant_email    = :claimant_email,
            accident_date     = :accident_date,
            accident_location = :accident_location,
            at_fault_driver   = :at_fault_driver,
            at_fault_insurer  = :at_fault_insurer,
            vehicle_id        = :vehicle_id,
            status            = :status
        WHERE id = :id
    ");

    $stmt->execute([
        ':claimant_name'     => $claimantName,
        ':claimant_phone'    => $claimantPhone,
        ':claimant_email'    => $claimantEmail,
        ':accident_date'     => $accidentDate,
        ':accident_location' => $accidentLocation,
        ':at_fault_driver'   => $atFaultDriver,
        ':at_fault_insurer'  => $atFaultInsurer,
        ':vehicle_id'        => $vehicleId,
        ':status'            => $status,
        ':id'                => $id
    ]);

    echo json_encode([
        'success'  => true,
        'message'  => 'Claim updated successfully!',
        'redirect' => BASE_URL . '/pages/claims/view.php?id=' . $id
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Something went wrong. Please try again.'
    ]);
}