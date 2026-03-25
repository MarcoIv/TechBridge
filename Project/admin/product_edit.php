<?php
require "../config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$id = $_GET["id"];

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}

// Handle product update
if (isset($_POST["update_product"])) {

    $name = $_POST["name"];
    $description = $_POST["description"];
    $base_price = $_POST["base_price"];

    $imageName = $product["image"];

    if (!empty($_FILES["image"]["name"])) {
        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/" . $imageName);
    }

    $stmt = $pdo->prepare("UPDATE products SET name=?, description=?, base_price=?, image=? WHERE id=?");
    $stmt->execute([$name, $description, $base_price, $imageName, $id]);

    header("Location: product_edit.php?id=$id");
    exit;
}

// Handle adding option
if (isset($_POST["add_option"])) {
    $optName = $_POST["option_name"];
    $optPrice = $_POST["extra_price"];

    $stmt = $pdo->prepare("INSERT INTO product_options (product_id, name, extra_price) VALUES (?, ?, ?)");
    $stmt->execute([$id, $optName, $optPrice]);

    header("Location: product_edit.php?id=$id");
    exit;
}

// Handle deleting option
if (isset($_GET["delete_option"])) {
    $optId = $_GET["delete_option"];
    $stmt = $pdo->prepare("DELETE FROM product_options WHERE id = ?");
    $stmt->execute([$optId]);

    header("Location: product_edit.php?id=$id");
    exit;
}

// Fetch options
$stmt = $pdo->prepare("SELECT * FROM product_options WHERE product_id = ?");
$stmt->execute([$id]);
$options = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "../header.php";
?>

<!--
This is the product edit page for the admin panel. It allows admins to edit existing products, including changing the name, description, base price, and image.
Admins can also manage product options, which are additional features or add-ons that can be selected when ordering the product. Each option has a name and an extra price.
-->

<div class="admin-header">
    <h2>Edit Product</h2>
</div>

<form method="POST" enctype="multipart/form-data" class="theme-form">

    <input type="hidden" name="update_product" value="1">

    <label>Name</label>
    <input type="text" name="name" value="<?= htmlspecialchars($product["name"]) ?>" required>

    <label>Description</label>
    <textarea name="description" required><?= htmlspecialchars($product["description"]) ?></textarea>

    <label>Base Price</label>
    <input type="number" step="0.01" name="base_price" value="<?= $product["base_price"] ?>" required>

    <label>Image</label>
    <input type="file" name="image">

    <?php if ($product["image"]): ?>
        <img src="../assets/products/<?= $product["image"] ?>" style="width:120px;margin-top:10px;">
    <?php endif; ?>

    <button class="admin-btn">Save Changes</button>
</form>

<hr style="margin:30px 0;">

<h3>Product Options</h3>

<table class="request-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Extra Price</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($options as $opt): ?>
            <tr>
                <td><?= htmlspecialchars($opt["name"]) ?></td>
                <td>$<?= number_format($opt["extra_price"], 2) ?></td>
                <td>
                    <a href="product_edit.php?id=<?= $id ?>&delete_option=<?= $opt["id"] ?>"
                        class="request-btn request-btn-danger">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h4>Add New Option</h4>

<form method="POST" class="theme-form">
    <input type="hidden" name="add_option" value="1">

    <label>Option Name</label>
    <input type="text" name="option_name" required>

    <label>Extra Price</label>
    <input type="number" step="0.01" name="extra_price" required>

    <button class="admin-btn-secondary">Add Option</button>
</form>

<?php include "../footer.php"; ?>