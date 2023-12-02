<?php
session_start();

// Destroy the session
session_destroy();

// Redirect the user back to the current page
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>
