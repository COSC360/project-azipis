<?php

// Start session
session_start();

// Unset all session variables
unset($_SESSION["loggedin"]);
unset($_SESSION["uid"]);
unset($_SESSION["username"]);
unset($_SESSION["email"]);
unset($_SESSION["description"]);
unset($_SESSION["avatarimgpath"]);
unset($_SESSION["firstname"]);
unset($_SESSION["lastname"]);

// Destroy the session
session_destroy();

// Redirect to homepage again.
header("Location: index.php");
exit;

?>