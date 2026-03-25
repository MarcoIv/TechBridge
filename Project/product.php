<?php
require "config.php";
$helpPage = "catalogue.php";
$activePage = "catalogue";
include "header.php";

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

$opts = $pdo->prepare("SELECT * FROM product_options WHERE product_id = ?");
$opts->execute([$id]);
$options = $opts->fetchAll();
?>

<!--
This is the product details page. It displays detailed information about a specific product, including its image and description, 
as well as a list of available options that can be selected to calculate the total price.
-->

<div class="admin-header">
    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
    <p>View product details, pricing, and available options.</p>
</div>

<div class="admin-dashboard">

    <!-- Product Details Card -->
    <div class="admin-card form-card">

        <div class="styled-form">

            <div class="form-group">
                <label>Product Image</label>
                <img src="assets/products/<?php echo htmlspecialchars($product['image']); ?>"
                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                    style="max-width: 300px; border-radius: 8px; box-shadow: var(--card-shadow);">
            </div>

            <div class="form-group">
                <label>Description</label>
                <div class="readonly-field multiline">
                    <?php echo nl2br(htmlspecialchars(trim($product['description']))); ?>
                </div>
            </div>

            <div class="form-group">
                <label>Base Price</label>
                <div class="readonly-field">
                    $<?php echo htmlspecialchars($product['base_price']); ?>
                </div>
            </div>

        </div>
    </div>

    <!-- Options + Total Card -->
    <div class="admin-card form-card">
        <h3>Options & Pricing</h3>

        <div class="styled-form">
            <?php foreach ($options as $o): ?>
                <div class="form-group option-row">
                    <label>
                        <input type="checkbox" name="options[]" value="<?php echo $o['id']; ?>"
                            data-extra="<?php echo $o['extra_price']; ?>">
                        <span class="option-name"><?php echo htmlspecialchars($o['name']); ?></span>
                        <span class="option-price">+$<?php echo number_format($o['extra_price'], 2); ?></span>
                    </label>
                </div>
            <?php endforeach; ?>

            <div class="form-group">
                <label>Total Price</label>
                <div class="readonly-field">
                    $<span id="totalPrice"><?php echo $product['base_price']; ?></span>
                </div>
            </div>
        </div>
    </div>

</div>
 <!-- Script for updating total price -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const basePrice = parseFloat(document.getElementById("basePrice")?.textContent || "<?php echo $product['base_price']; ?>");
        const totalPriceEl = document.getElementById("totalPrice");
        const checkboxes = document.querySelectorAll("input[name='options[]']");

        function updateTotal() {
            let total = basePrice;
            checkboxes.forEach(cb => {
                if (cb.checked) total += parseFloat(cb.dataset.extra);
            });
            totalPriceEl.textContent = total.toFixed(2);
        }

        checkboxes.forEach(cb => cb.addEventListener("change", updateTotal));
    });
</script>

<?php include "footer.php"; ?>