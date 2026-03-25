<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $pass = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND status='active'");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    // Verify password and log in
    if ($user && password_verify($pass, $user["password_hash"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["role"] = $user["role"];
        $_SESSION["name"] = $user["name"];

        if ($user["role"] === "admin") {
            header("Location: admin/admin_dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit;
    } else {
        $error = "Invalid login.";
    }
}

include "header.php";
?>

<!--
This is the login page. It contains a form for users to enter their email and password to access their account.
-->

<div class="admin-header">
    <h2>Login</h2>
    <p>Access your TechBridge account to manage requests and services.</p>
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
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="admin-btn">Login</button>

        </form>
    </div>
</div>

<?php include "footer.php"; ?>