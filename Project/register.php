<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $pass = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $pass]);

    header("Location: login.php");
    exit;
}

include "header.php";
?>

<div class="admin-header">
    <h2>Create an Account</h2>
    <p>Register to access TechBridge services and manage your support requests.</p>
</div>

<div class="admin-dashboard">
    <div class="admin-card form-card">

        <form method="POST" class="styled-form">

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="admin-btn">Register</button>

        </form>

    </div>
</div>

<?php include "footer.php"; ?>