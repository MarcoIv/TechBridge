<?php
require "../config.php";

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit;
}

// Detect admin folder for correct relative paths
$isAdminFolder = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;
$base = $isAdminFolder ? '../' : '';

$db_status = $pdo ? "Online" : "Offline";

$users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$requests = $pdo->query("SELECT COUNT(*) FROM requests")->fetchColumn();
$responses = $pdo->query("SELECT COUNT(*) FROM responses")->fetchColumn();

// Request status counts for chart
$statusStmt = $pdo->query("SELECT status, COUNT(*) as c FROM requests GROUP BY status");
$statuses = $statusStmt->fetchAll(PDO::FETCH_KEY_PAIR);

$labels = array_keys($statuses);
$values = array_values($statuses);

include "../header.php";
?>

<!--
This is the monitor page for the admin panel. It displays real-time system status, including database connectivity, total users, requests, and responses. 
It also includes a chart showing the breakdown of request statuses (e.g., pending, completed). 
The page is only accessible to admins and provides a visual overview of system activity and performance.
All the data is pulled from the database using PDO queries, and the chart is rendered using Chart.js with data passed through data attributes on the canvas element.
-->

<div class="admin-header">
    <h2>System Monitor</h2>
    <p>Real‑time overview of system activity and performance.</p>
</div>

<div class="monitor-grid">

    <!-- System Stats Card -->
    <div class="monitor-card">
        <h3>System Status</h3>

        <p>Database:
            <strong class="<?php echo $db_status === 'Online' ? 'status-online' : 'status-offline'; ?>">
                <?php echo $db_status; ?>
            </strong>
        </p>

        <p>Total Users: <strong><?php echo $users; ?></strong></p>
        <p>Total Requests: <strong><?php echo $requests; ?></strong></p>
        <p>Total Responses: <strong><?php echo $responses; ?></strong></p>
    </div>

    <!-- Chart Card -->
    <div class="monitor-card">
        <h3>Request Status Breakdown</h3>

        <canvas id="requestsChart" data-labels='<?php echo json_encode($labels); ?>'
            data-values='<?php echo json_encode($values); ?>' style="max-width: 100%; margin-top: 20px;">
        </canvas>
    </div>

</div>


<!-- Load Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Load my charts.js using the SAME $base logic as header.php -->
<script src="<?php echo $base; ?>assets/js/charts.js"></script>

<?php include "../footer.php"; ?>