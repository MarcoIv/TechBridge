<?php
$activePage = "home";
include "header.php";
?>

<!--
This is the main landing page for the website. It includes a hero section with a welcome message and call-to-action button, 
a "How It Works" section with cards explaining the process, an intro video, and a coverage map showing the global reach of the service.
-->

<section class="hero">
  <h1>Welcome to TechBridge</h1>
  <p>Your on-demand platform for expert IT support, repairs, and tech solutions.</p>
  <a href="catalogue.php" class="primary-btn">Explore Services</a>
</section>

<!-- HOW IT WORKS -->
<section class="card-section">
  <h2>How It Works</h2>
  <div class="card-grid">
    <div class="admin-card">
      <h3>1. Create an Account</h3>
      <p>Register in seconds and set up your profile.</p>
    </div>
    <div class="admin-card">
      <h3>2. Submit a Request</h3>
      <p>Tell us what tech issue you’re facing.</p>
    </div>
    <div class="admin-card">
      <h3>3. Get Expert Help</h3>
      <p>A specialist responds with a solution.</p>
    </div>
    <div class="admin-card">
      <h3>4. Rate & Review</h3>
      <p>Track your history and rate your experience.</p>
    </div>
  </div>
</section>

<!-- INTRO VIDEO -->
<section class="card-section">
  <h2>Intro Video</h2>
  <div class="video-wrapper">
    <video autoplay muted loop playsinline preload="none">
      <source src="assets/media/4974708-sd_640_360_25fps.mp4" type="video/mp4">
      Your browser does not support the video tag.
    </video>
  </div>
</section>



<!-- COVERAGE MAP -->
<section class="card-section">
  <h2>Our Coverage</h2>
  <p>TechBridge supports users worldwide. Explore our global reach:</p>
  <div class="map-wrapper">
    <iframe src="https://www.openstreetmap.org/export/embed.html?bbox=-130,20,-60,55&layer=mapnik"
      style="border:0; width:100%; height:300px;">
    </iframe>
  </div>
</section>

<?php include "footer.php"; ?>