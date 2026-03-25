<?php
session_start();
// Database connection settings
// Database is called skillbridge because that was what I was calling this project before adding products so I moved it to a new name.
$host = "localhost";
$dbname = "ivanovi1_skillbridge";
$username = "ivanovi1_skillbridge";
$password = "BNgaqW2hrAzLdm9mnMd8";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$stmt = $pdo->query("SELECT css_file FROM themes WHERE is_active = 1 LIMIT 1");
$activeTheme = $stmt->fetchColumn();
?>