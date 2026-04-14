<?php
// -----------------------------------------------
// API ENDPOINT: Submit a new accident claim
// -----------------------------------------------
// This file can be called from anywhere - no login needed
// It accepts POST requests and returns JSON responses
// -----------------------------------------------

// Allow requests from any domain (CORS)
// This is what makes it a true public API
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed. Use POST.'
    ]);
    exit;
}

// --- BACKEND VALIDATION ---
$firstName       = trim($_POST['first_name'] ?? '');
$lastName        = trim($_POST['last_name'] ?? '');
$phone           = trim($_POST['phone'] ?? '');
$email           = trim($_POST['email'] ?? '');
$state           = trim($_POST['state'] ?? '');
$accidentDate    = trim($_POST['accident_date'] ?? '');
$accidentLocation = trim($_POST['accident_location'] ?? '');
$atFaultDriver   = trim($_POST['at_fault_driver'] ?? '');
$atFaultInsurer  = trim($_POST['at_fault_insurer'] ?? '');

// Check required fields
if (
    empty($firstName)    ||
    empty($lastName)     ||
    empty($phone)        ||
    empty($email)        ||
    empty($state)        ||
    empty($accidentDate) ||
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

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid email address'
    ]);
    exit;
}

// Validate state
$validStates = ['NSW', 'VIC', 'QLD', 'WA', 'SA', 'TAS', 'ACT', 'NT'];
if (!in_array($state, $validStates)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please select a valid Australian state'
    ]);
    exit;
}

// --- INSERT INTO DATABASE ---
try {
    $pdo  = getDBConnection();

    // Combine first and last name for claimant_name
    $claimantName = $firstName . ' ' . $lastName;

    $stmt = $pdo->prepare("
        INSERT INTO claims (
            claimant_name,
            claimant_phone,
            claimant_email,
            accident_date,
            accident_location,
            at_fault_driver,
            at_fault_insurer,
            status
        ) VALUES (
            :claimant_name,
            :claimant_phone,
            :claimant_email,
            :accident_date,
            :accident_location,
            :at_fault_driver,
            :at_fault_insurer,
            'pending'
        )
    ");

    $stmt->execute([
        ':claimant_name'     => $claimantName,
        ':claimant_phone'    => $phone,
        ':claimant_email'    => $email,
        ':accident_date'     => $accidentDate,
        ':accident_location' => $accidentLocation,
        ':at_fault_driver'   => $atFaultDriver,
        ':at_fault_insurer'  => $atFaultInsurer
    ]);

    // Get the ID of the claim we just created
    $newClaimId = $pdo->lastInsertId();

    echo json_encode([
        'success'  => true,
        'message'  => 'Your claim has been submitted successfully. Our team will contact you shortly.',
        'claim_id' => $newClaimId
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Something went wrong. Please try again.'
    ]);
}