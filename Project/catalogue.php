<?php
require "config.php";
$activePage = "catalogue";
$helpPage = "catalogue.php";
include "header.php";
$products = $pdo->query("SELECT * FROM products")->fetchAll();
?>

<!--
This is the main catalogue page for TechBridge, a service request and product catalogue platform for IT service providers.
It displays a grid of available service packages with images, descriptions, and links to view details.
-->

<h2>Service Catalogue</h2>

<div class="product-grid">
    <?php foreach ($products as $p): ?>
        <div class="product-card">
            <img src="assets/products/<?php echo htmlspecialchars($p['image']); ?>" alt="" loading="lazy">
            <h3><?php echo htmlspecialchars($p['name']); ?></h3>
            <p><?php echo htmlspecialchars($p['description']); ?></p>
            <a href="product.php?id=<?php echo $p['id']; ?>" class="request-btn">View Details</a>
        </div>
    <?php endforeach; ?>
</div>

<?php include "footer.php"; ?>