<?php
$helpPage = "content_updates.php";
require "../config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$stmt = $pdo->query("
    SELECT p.*, 
    (SELECT COUNT(*) FROM product_options WHERE product_id = p.id) AS option_count
    FROM products p ORDER BY p.id DESC
");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "../header.php";
?>

<!--
This is the product list page for the admin panel. It displays a table of all products in the inventory, showing their ID, name, base price, and the number of options they have.
Admins can click the "Edit" button to modify a product's details and options, or the "Delete" button to remove a product from the inventory.
The page is only accessible to admins and provides an overview of all products currently available in the system.
-->

<div class="admin-header">
    <h2>Manage Products</h2>
    <p>Add, edit, or delete products and their options.</p>
</div>

<a href="product_add.php" class="admin-btn">Add New Product</a>

<table class="request-table" style="margin-top:20px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Base Price</th>
            <th>Options</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($products as $p): ?>
            <tr>
                <td><?= $p["id"] ?></td>
                <td><?= htmlspecialchars($p["name"]) ?></td>
                <td>$<?= number_format($p["base_price"], 2) ?></td>
                <td><?= $p["option_count"] ?></td>
                <td class="request-actions">
                    <a href="product_edit.php?id=<?= $p["id"] ?>" class="request-btn">Edit</a>
                    <a href="product_delete.php?id=<?= $p["id"] ?>" class="request-btn request-btn-danger">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include "../footer.php"; ?>