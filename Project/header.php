<?php require_once "config.php"; ?>

<?php
// Detect if we are inside the /admin/ or /help/ folder
$path = $_SERVER['PHP_SELF'];

$isAdminFolder = strpos($path, '/admin/') !== false;
$isHelpFolder = strpos($path, '/help/') !== false;

$base = ($isAdminFolder || $isHelpFolder) ? '../' : '';

// Ensure $activePage exists
if (!isset($activePage)) {
    $activePage = "";
}
?>

<!--
This is the header included on all pages. It contains the navigation bar with links to the home page, about page, catalogue, and user/admin dashboard. 
It also includes a help link if $helpPage is set (for context-sensitive help), and displays the logged-in user's name with a logout option if they are authenticated.
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <!-- SEO Requirements -->
    <title>TechBridge</title>
    <meta name="description"
        content="TechBridge – A service request and product catalogue platform built with PHP and MySQL.">
    <meta name="keywords" content="TechBridge, PHP, MySQL, catalogue, service requests, IT services">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon" href="<?php echo $base; ?>assets/images/favicon.png">

    <!-- Theme Stylesheet -->
    <link id="themeStylesheet" rel="stylesheet" href="<?php echo $base; ?>assets/css/<?php echo $activeTheme; ?>">

    <!-- Main JS -->
    <script src="<?php echo $base; ?>assets/js/main.js" defer></script>
</head>

<body>

    <nav class="main-nav">

        <div class="nav-left">
            <a href="<?php echo $base; ?>index.php" class="<?= ($activePage === 'home') ? 'active' : '' ?>">Home</a>
            <a href="<?php echo $base; ?>about.php" class="<?= ($activePage === 'about') ? 'active' : '' ?>">About</a>
            <a href="<?php echo $base; ?>catalogue.php"
                class="<?= ($activePage === 'catalogue') ? 'active' : '' ?>">Catalogue</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="<?php echo $base; ?>admin/admin_dashboard.php"
                        class="<?= ($activePage === 'admin') ? 'active' : '' ?>">Admin Panel</a>
                <?php else: ?>
                    <a href="<?php echo $base; ?>dashboard.php"
                        class="<?= ($activePage === 'dashboard') ? 'active' : '' ?>">Dashboard</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="nav-right">
            <?php if (isset($helpPage)): ?>
                <a class="help-icon" href="<?php echo $base; ?>help/<?php echo $helpPage; ?>">❓ Help</a>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="hello-user">Hello, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
                <a href="<?php echo $base; ?>logout.php">Logout</a>
            <?php else: ?>
                <a href="<?php echo $base; ?>register.php"
                    class="<?= ($activePage === 'register') ? 'active' : '' ?>">Register</a>
                <a href="<?php echo $base; ?>login.php" class="<?= ($activePage === 'login') ? 'active' : '' ?>">Login</a>
            <?php endif; ?>
        </div>

        <!-- Hamburger button (mobile only) -->
        <button class="hamburger" id="hamburger-btn">
            <span></span>
            <span></span>
            <span></span>
        </button>

    </nav>

    <!-- Mobile dropdown menu -->
    <div id="mobile-menu">
        <a href="<?php echo $base; ?>index.php" class="<?= ($activePage === 'home') ? 'active' : '' ?>">Home</a>
        <a href="<?php echo $base; ?>about.php" class="<?= ($activePage === 'about') ? 'active' : '' ?>">About</a>
        <a href="<?php echo $base; ?>catalogue.php"
            class="<?= ($activePage === 'catalogue') ? 'active' : '' ?>">Catalogue</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="<?php echo $base; ?>admin/admin_dashboard.php"
                    class="<?= ($activePage === 'admin') ? 'active' : '' ?>">Admin Dashboard</a>
            <?php else: ?>
                <a href="<?php echo $base; ?>dashboard.php"
                    class="<?= ($activePage === 'dashboard') ? 'active' : '' ?>">Dashboard</a>
            <?php endif; ?>
            <a href="<?php echo $base; ?>logout.php">Logout</a>
        <?php else: ?>
            <a href="<?php echo $base; ?>register.php"
                class="<?= ($activePage === 'register') ? 'active' : '' ?>">Register</a>
            <a href="<?php echo $base; ?>login.php" class="<?= ($activePage === 'login') ? 'active' : '' ?>">Login</a>
        <?php endif; ?>

        <?php if (isset($helpPage)): ?>
            <a href="<?php echo $base; ?>help/<?php echo $helpPage; ?>">❓ Help</a>
        <?php endif; ?>
    </div>

    <hr>

    <main>