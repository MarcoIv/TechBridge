<?php
require "../config.php";

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: requests_list.php");
    exit;
}

$id = (int) $_GET['id'];

// Verify the request exists first
$stmt = $pdo->prepare("SELECT * FROM requests WHERE id = ?");
$stmt->execute([$id]);
$request = $stmt->fetch();

if (!$request) {
    // Nothing to delete, just go back
    header("Location: requests_list.php");
    exit;
}

// Delete the request
$deleteStmt = $pdo->prepare("DELETE FROM requests WHERE id = ?");
$deleteStmt->execute([$id]);

// Redirect back to list
header("Location: requests_list.php");
exit;