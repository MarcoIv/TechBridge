<?php
require "../config.php";

// Only admins allowed
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

// Handle enable/disable actions
if (isset($_POST["toggle_id"])) {
    $userId = (int) $_POST["toggle_id"];

    // Prevent admin from disabling themselves
    if ($userId !== (int) $_SESSION["user_id"]) {

        // Get current status
        $stmt = $pdo->prepare("SELECT status FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $current = $stmt->fetchColumn();

        if ($current !== false) {

            // Normalize
            $current = strtolower($current);

            // Toggle between active and disabled
            if ($current === "active") {
                $newStatus = "disabled";
            } else {
                $newStatus = "active";
            }

            // Update status
            $update = $pdo->prepare("UPDATE users SET status = ? WHERE id = ?");
            $update->execute([$newStatus, $userId]);
        }
    }

    header("Location: users_list.php");
    exit;
}

// Fetch all users
$stmt = $pdo->query("SELECT id, name, email, role, status FROM users ORDER BY id DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "../header.php";
?>

<!--
This is the user management page for the admin panel. It displays a table of all registered users, showing their ID, name, email, role, and account status.
Admins can enable or disable user accounts directly from this page. The "Actions" column contains a button to toggle the user's status between active and disabled.
Admins cannot disable their own account to prevent accidental lockout.
-->

<div class="admin-header">
    <h2>Manage Users</h2>
    <p>View all registered users and their account status.</p>
</div>

<div class="request-list-container">
    <table class="request-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?php echo $u["id"]; ?></td>

                    <td><?php echo htmlspecialchars($u["name"]); ?></td>

                    <td><?php echo htmlspecialchars($u["email"]); ?></td>

                    <td>
                        <span class="user-role-badge role-<?php echo strtolower($u["role"]); ?>">
                            <?php echo ucfirst($u["role"]); ?>
                        </span>
                    </td>

                    <td>
                        <span class="user-status-badge status-<?php echo strtolower($u["status"]); ?>">
                            <?php echo ucfirst($u["status"]); ?>
                        </span>
                    </td>

                    <td>
                        <?php if ($u["id"] !== (int) $_SESSION["user_id"]): ?>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="toggle_id" value="<?php echo $u["id"]; ?>">
                                <button type="submit" class="admin-btn-secondary">
                                    <?php echo $u["status"] === "active" ? "Disable" : "Enable"; ?>
                                </button>
                            </form>
                        <?php else: ?>
                            <span style="opacity:0.6;">(You)</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include "../footer.php"; ?>