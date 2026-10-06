<?php
session_start();

// prevent caching issues on hosting
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

header("Location: dashboard.php");
exit();
?>