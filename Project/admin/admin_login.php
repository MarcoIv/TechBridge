<?php
require "../config.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=? AND role='admin'");
    $stmt->execute([$_POST["email"]]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($_POST["password"], $admin["password_hash"])) {
        $_SESSION["admin_id"] = $admin["id"];
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Invalid admin login.";
    }
}
include "../header.php";
?>

<!--
This is the admin login screen. It checks with the database for a user with the provided email and an admin role. If found, it verifies the password using password_verify. 
If the credentials are correct, it sets a session variable to indicate the admin is logged in and redirects to the admin dashboard. If the login fails, it displays an error message. 
The page includes a simple form for entering the admin email and password.
-->

<div class="admin-header">
    <h2>Admin Login</h2>
    <p>Access the TechBridge administration panel.</p>
</div>

<div class="admin-dashboard">
    <div class="admin-card form-card">

        <?php if (isset($error)): ?>
            <p style="color: var(--danger); font-weight: 600; margin-bottom: 10px;">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <form method="POST" class="styled-form">

            <div class="form-group">
                <label for="email">Admin Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Admin Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="admin-btn">Login</button>

        </form>

    </div>
</div>

<?php include "../footer.php"; ?>