<?php
require "config.php";
$activePage = "dashboard";
$helpPage = "users.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "user") {
    header("Location: login.php");
    exit;
}

include "header.php";
?>

<!--
This is the user dashboard page. It allows users to view their existing requests, create new ones, and manage their activity on the platform.
-->

<div class="admin-header">
    <h2>User Dashboard</h2>
    <p>View your requests, create new ones, and manage your activity.</p>
</div>

<div class="admin-dashboard">

    <!-- Create Request Card -->
    <div class="admin-card">
        <h3>Create New Request</h3>
        <p>Need help with something? Submit a new support request.</p>
        <a href="request_new.php" class="admin-btn">New Request</a>
    </div>

    <!-- Your Requests Card -->
    <div class="admin-card">
        <h3>Your Requests</h3>

        <?php
        $stmt = $pdo->prepare("SELECT * FROM requests WHERE user_id = ?");
        $stmt->execute([$_SESSION["user_id"]]);
        $rows = $stmt->fetchAll();

        if (count($rows) === 0) {
            echo "<p>You have not submitted any requests yet.</p>";
        } else {
            echo "
        <div class='request-list-container'>
            <table class='request-table'>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
        ";

            foreach ($rows as $r) {
                echo "
                <tr>
                    <td>{$r['title']}</td>
                    <td><span class='status {$r['status']}'>{$r['status']}</span></td>
                    <td>" . date("Y-m-d", strtotime($r['created_at'])) . "</td>
                    <td><a class='request-btn' href='request_view.php?id={$r['id']}'>Open</a></td>
                </tr>
            ";
            }

            echo "
                </tbody>
            </table>
        </div>
        ";
        }
        ?>
    </div>



</div>

<?php include "footer.php"; ?>