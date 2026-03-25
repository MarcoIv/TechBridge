<?php
require "../config.php";
$helpPage = "admin.php";
$activePage = "admin";
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit;
}
include "../header.php";
?>

<!-- 
ADMIN DASHBOARD 
Provides an overview of administrative functions, allowing the admin to manage requests, products, users, themes, and monitor system activity from a central location.
Only the admin can access this page. Each section has a brief description and a link to the respective management page. If the user is not an admin, they are redirected to the login page.
-->

<div class="admin-header">
    <h2>Admin Dashboard</h2>
    <p>Manage users, requests, themes, and system activity.</p>
</div>

<div class="admin-dashboard">

    <div class="admin-card">
        <h3>Requests</h3>
        <p>View and respond to all user service requests.</p>
        <a class="admin-btn" href="requests_list.php">Manage Requests</a>
    </div>

    <div class="admin-card">
        <h3>Products</h3>
        <p>Add, edit, and delete products and options.</p>
        <a href="products_list.php" class="admin-btn">Manage Products</a>
        </a>
    </div>


    <div class="admin-card">
        <h3>Users</h3>
        <p>View registered users and manage accounts.</p>
        <a class="admin-btn" href="users_list.php">Manage Users</a>
    </div>

    <div class="admin-card">
        <h3>Themes</h3>
        <p>Switch between available site themes.</p>
        <a class="admin-btn" href="themes.php">Change Theme</a>
    </div>

    <div class="admin-card">
        <h3>Monitor</h3>
        <p>View system activity and performance charts.</p>
        <a class="admin-btn" href="monitor.php">View Monitor</a>
    </div>



</div>

<?php include "../footer.php"; ?>