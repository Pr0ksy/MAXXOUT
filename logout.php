<?php
session_start();

// Uništavanje sesije
session_unset();
session_destroy();

// Preusmeravanje na login stranicu
header('Location: login.php');
exit();
?>