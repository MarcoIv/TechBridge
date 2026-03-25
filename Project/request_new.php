<?php
require "config.php";
$activePage = "dashboard";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("INSERT INTO requests (user_id, title, description, category) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $_SESSION["user_id"],
        $_POST["title"],
        $_POST["description"],
        $_POST["category"]
    ]);
    header("Location: dashboard.php");
    exit;
}

include "header.php";
?>

<!--
This is the create request page. It contains a form for users to submit new support requests, including a title, description, and optional category.
-->

<div class="admin-header">
    <h2>Create New Request</h2>
    <p>Submit a new support request and our team will get back to you shortly.</p>
</div>

<div class="admin-dashboard">

    <div class="admin-card form-card">
        <form method="POST" class="styled-form">

            <div class="form-group">
                <label for="title">Request Title</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="category">Category (optional)</label>
                <input type="text" id="category" name="category">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <button type="submit" class="admin-btn">Submit Request</button>

        </form>
    </div>

</div>

<?php include "footer.php"; ?>