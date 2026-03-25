<?php
// Simple logout script that destroys the session and redirects to the home page
session_start();
session_destroy();
header("Location: index.php");
exit;