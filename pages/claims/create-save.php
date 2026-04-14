<?php
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create.php');
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
$claimantName    = trim($_POST['claimant_name'] ?? '');
$claimantPhone   = trim($_POST['claimant_phone'] ?? '');
$claimantEmail   = trim($_POST['claimant_email'] ?? '');
$accidentDate    = trim($_POST['accident_date'] ?? '');
$accidentLocation = trim($_POST['accident_location'] ?? '');
$atFaultDriver   = trim($_POST['at_fault_driver'] ?? '');
$atFaultInsurer  = trim($_POST['at_fault_insurer'] ?? '');
$vehicleId       = $_POST['vehicle_id'] ?? null;
$status          = trim($_POST['status'] ?? 'pending');

// Convert empty vehicle_id to null for the database
if (empty($vehicleId)) {
    $vehicleId = null;
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

// --- INSERT INTO DATABASE ---
try {
    $pdo  = getDBConnection();
    $stmt = $pdo->prepare("
        INSERT INTO claims (
            claimant_name,
            claimant_phone,
            claimant_email,
            accident_date,
            accident_location,
            at_fault_driver,
            at_fault_insurer,
            vehicle_id,
            status
        ) VALUES (
            :claimant_name,
            :claimant_phone,
            :claimant_email,
            :accident_date,
            :accident_location,
            :at_fault_driver,
            :at_fault_insurer,
            :vehicle_id,
            :status
        )
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
        ':status'            => $status
    ]);

    echo json_encode([
        'success'  => true,
        'message'  => 'Claim created successfully!',
        'redirect' => BASE_URL . '/pages/claims/index.php'
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Something went wrong. Please try again.'
    ]);
}