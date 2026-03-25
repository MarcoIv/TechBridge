<?php
require "../config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $_POST["name"];
    $description = $_POST["description"];
    $base_price = $_POST["base_price"];

    $imageName = null;
    if (!empty($_FILES["image"]["name"])) {
        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "../assets/products/" . $imageName);
    }
    // Insert product into database
    $stmt = $pdo->prepare("INSERT INTO products (name, description, image, base_price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $description, $imageName, $base_price]);

    header("Location: products_list.php");
    exit;
}

include "../header.php";
?>

<!--
This is the product add page for the admin panel. It allows admins to add new products to the inventory. The page includes a form for entering product 
details such as name, description, image, and base price. The image is uploaded to the server and stored in the 'products' directory.
-->

<div class="admin-header">
    <h2>Add Product</h2>
</div>

<form method="POST" enctype="multipart/form-data" class="theme-form">

    <label>Name</label>
    <input type="text" name="name" required>

    <label>Description</label>
    <textarea name="description" required></textarea>

    <label>Base Price</label>
    <input type="number" step="0.01" name="base_price" required>

    <label>Image</label>
    <input type="file" name="image">

    <button class="admin-btn">Add Product</button>
</form>

<?php include "../footer.php"; ?>