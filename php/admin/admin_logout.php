<?php
session_start();
/* Complete */

session_unset();

session_destroy();
header("Location:admin_login.php");
?>