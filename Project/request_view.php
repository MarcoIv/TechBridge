<?php
require "config.php";
$activePage = "dashboard";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET["id"];

$stmt = $pdo->prepare("SELECT * FROM requests WHERE id=? AND user_id=?");
$stmt->execute([$id, $_SESSION["user_id"]]);
$request = $stmt->fetch();

if (!$request) {
    die("Request not found.");
}

include "header.php";
?>

<!--
This is the request details page. It displays detailed information about a specific support request, including its title, 
description, category, and status. It also shows any responses from the admin team related to this request.
-->

<div class="admin-header">
    <h2><?php echo htmlspecialchars($request["title"]); ?></h2>
    <p>View your request details and any responses from the admin team.</p>
</div>

<div class="admin-dashboard">

    <!-- Request Details Card -->
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
                    <?php echo nl2br(htmlspecialchars($request["description"])); ?>
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

    <!-- Responses Card -->
    <div class="admin-card form-card">
        <h3>Responses</h3>

        <?php
        $stmt = $pdo->prepare("SELECT * FROM responses WHERE request_id=?");
        $stmt->execute([$id]);
        $responses = $stmt->fetchAll();

        if (count($responses) === 0) {
            echo "<p>No responses yet.</p>";
        } else {
            echo "<div class='response-list'>";
            foreach ($responses as $res) {
                echo "
                    <div class='response-item'>
                        <strong>Admin:</strong><br>
                        " . nl2br(htmlspecialchars($res["message"])) . "
                    </div>
                ";
            }
            echo "</div>";
        }
        ?>
    </div>

</div>

<?php include "footer.php"; ?>