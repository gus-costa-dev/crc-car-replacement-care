<?php
require_once 'config/database.php';

$pdo = getDBConnection();

if ($pdo) {
    echo "✅ Database connected successfully!";
}