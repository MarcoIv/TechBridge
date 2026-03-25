<?php
require "../config.php";
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM requests ORDER BY created_at DESC");
$requests = $stmt->fetchAll();

// Context-sensitive help
$helpPage = "admin.php";
include "../header.php";
?>

<!--
This is the requests list page for the admin panel. It displays a table of all user service requests, showing their ID, title, status, creation date, and available actions.
Admins can click on a request title to view and respond to the request, or click the delete button to remove the request from the system."
-->

<div class="admin-header">
    <h2>All Requests</h2>
    <p>View, manage, and respond to all user service requests.</p>
</div>

<div class="request-list-container">

    <table class="request-table">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Status</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($requests as $r): ?>
            <tr>
                <td><?php echo $r['id']; ?></td>

                <td>
                    <a href="request_reply.php?id=<?php echo $r['id']; ?>">
                        <?php echo htmlspecialchars($r['title']); ?>
                    </a>
                </td>

                <td>
                    <?php
                    $statusClass = "status-" . strtolower($r['status']);
                    ?>
                    <span class="status-badge <?php echo $statusClass; ?>">
                        <?php echo ucfirst($r['status']); ?>
                    </span>
                </td>

                <td><?php echo $r['created_at']; ?></td>

                <td>
                    <div class="request-actions">
                        <a class="request-btn" href="request_reply.php?id=<?php echo $r['id']; ?>">View</a>
                        <a class="request-btn request-btn-danger" href="request_delete.php?id=<?php echo $r['id']; ?>"
                            onclick="return confirm('Are you sure you want to delete this request?');">Delete</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>

</div>

<?php include "../footer.php"; ?>