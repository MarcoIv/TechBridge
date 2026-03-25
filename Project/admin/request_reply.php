<?php
require "../config.php";
$activePage = "admin";

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit;
}

$id = $_GET["id"];

$stmt = $pdo->prepare("SELECT * FROM requests WHERE id=?");
$stmt->execute([$id]);
$request = $stmt->fetch();
// If request doesn't exist, show error
if (!$request) {
    die("Request not found.");
}
// Handle response submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("INSERT INTO responses (request_id, admin_id, message) VALUES (?, ?, ?)");
    $stmt->execute([$id, $_SESSION["admin_id"], $_POST["message"]]);

    $pdo->prepare("UPDATE requests SET status='answered' WHERE id=?")->execute([$id]);

    header("Location: requests_list.php");
    exit;
}

include "../header.php";
?>

<!--
This is the request reply page for the admin panel. It allows admins to view the details of a specific user request and send a response back to the user.
The page displays the request title, category, description, and current status. Below the request details, there is a form for the admin to enter a response message. 
When the form is submitted, the response is saved to the database and the request status is updated to "answered". The admin is then redirected back to the requests list page.
-->

<div class="admin-header">
    <h2>Respond to Request</h2>
    <p>Review the request details and send your response to the user.</p>
</div>

<div class="admin-dashboard">

    <!-- Request Details -->
    <div class="admin-card form-card">
        <div class="styled-form">

            <div class="form-group">
                <label>Title</label>
                <div class="readonly-field">
                    <?php echo htmlspecialchars($request["title"]); ?>
                </div>
            </div>

            <div class="form-group">
                <label>Category</label>
                <div class="readonly-field">
                    <?php echo htmlspecialchars($request["category"]); ?>
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <div class="readonly-field multiline">
                    <?php echo nl2br(htmlspecialchars(trim($request["description"]))); ?>
                </div>
            </div>

            <div class="form-group">
                <label>Status</label>
                <span class="status <?php echo $request["status"]; ?>">
                    <?php echo htmlspecialchars($request["status"]); ?>
                </span>
            </div>

        </div>
    </div>

    <!-- Response Form -->
    <div class="admin-card form-card">
        <h3>Send Response</h3>

        <form method="POST" class="styled-form">

            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" required></textarea>
            </div>

            <button type="submit" class="admin-btn">Send Response</button>

        </form>
    </div>

</div>

<?php include "../footer.php"; ?>