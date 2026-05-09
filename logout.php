<?php
// Start the session to access session variables
session_start();

// Destroy all session data to log out the user
session_destroy();

// Redirect the user to the admin login page after logout
header("Location: admin_login.php");

// Stop further script execution (optional but recommended)
exit();


?>
