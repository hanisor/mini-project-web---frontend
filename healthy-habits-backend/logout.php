<?php
session_start();
session_unset();
session_destroy();
header("Location: ../html/index.html"); // Redirect to login page or homepage
exit();
?>
