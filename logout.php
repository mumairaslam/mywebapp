<?php
// logout.php
session_start();

// Destroy the session
session_destroy();

// Redirect to the home page or wherever you want the user to go after logging out
header("Location: index.php");
exit();
?>
