<?php
$activePage = "about";
include "header.php";
?>
<!--
This about page for TechBridge, a service request and product catalogue platform for IT service providers. 
It provides an overview of the project, its features, and includes a video demonstration. 
-->
<section class="hero">
    <h1>About TechBridge</h1>
    <p>Your trusted platform for on-demand IT support, expert services, and seamless tech solutions.</p>
</section>

<!-- ABOUT CONTENT -->
<section class="card-section">
    <div class="admin-card">
        <p>
            TechBridge is a service request and product catalogue platform designed for IT service providers.
            Users can register, submit support requests, browse available service packages, and track responses
            from administrators. Administrators can manage incoming requests, reply to users, and configure
            site-wide themes.
        </p>
    </div>
</section>

<!-- VIDEO -->
<section class="card-section">
    <div class="video-wrapper">
        <video autoplay muted loop playsinline preload="none">
            <source src="assets/media/5452529-sd_640_360_25fps.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <div class="video-wrapper">
        <video autoplay muted loop playsinline preload="none">
            <source src="assets/media/11537351-sd_640_360_30fps.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</section>

<!-- MORE INFO -->
<section class="card-section">
    <h2>Project Overview</h2>
    <div class="admin-card">
        <p>
            This project demonstrates a full PHP/MySQL web application with user authentication,
            admin tools, dynamic forms, theming, and a modular structure that makes it easy to update
            products, media, and content. 
        </p>
    </div>
</section>

<?php include "footer.php"; ?>