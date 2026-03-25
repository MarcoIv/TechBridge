<?php
require "../config.php";

$helpPage = "themes.php";

// Only admins allowed
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit;
}

// Handle theme change
if (isset($_POST["theme_id"])) {
    $pdo->query("UPDATE themes SET is_active = 0");
    $stmt = $pdo->prepare("UPDATE themes SET is_active = 1 WHERE id = ?");
    $stmt->execute([$_POST["theme_id"]]);
    header("Location: admin_dashboard.php");
    exit;

}

// Fetch themes
$themes = $pdo->query("SELECT * FROM themes")->fetchAll();

include "../header.php";
?>

<!--
This is the theme management page for the admin panel. It allows admins to select and apply a theme to the entire site.
-->

    <div class="admin-header">
        <h2>Change Theme</h2>
        <p>Select a theme and apply it to the entire site.</p>
    </div>

    <div class="theme-card">
        <form method="POST" class="theme-form">

            <?php foreach ($themes as $t): ?>
                <label class="theme-option">
                    <input 
                        type="radio" 
                        name="theme_id" 
                        value="<?php echo $t['id']; ?>"
                        <?php if ($t['is_active']) echo "checked"; ?>
                    >
                    <span><?php echo htmlspecialchars($t['name']); ?></span>
                </label>
            <?php endforeach; ?>

            <button class="request-btn" type="submit">Apply Theme</button>
        </form>
    </div>

<?php include "../footer.php"; ?>