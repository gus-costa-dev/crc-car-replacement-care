<?php
// Start the session if it hasn't started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Tell the browser NEVER to cache any page that includes this file
// This means after logout, the back button won't show protected pages
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');