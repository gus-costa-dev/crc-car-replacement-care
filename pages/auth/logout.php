<?php
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../config/database.php';

// Destroy everything in the session
session_destroy();

// Send user back to login
header('Location: ' . BASE_URL . '/pages/auth/login.php');
exit;