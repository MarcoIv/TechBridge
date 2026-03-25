<?php
require "../config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$id = $_GET["id"];

// Delete options first
$pdo->prepare("DELETE FROM product_options WHERE product_id = ?")->execute([$id]);

// Delete product
$pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);

header("Location: products_list.php");
exit;