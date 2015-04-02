<?php
session_start();
$_SESSION = array();
unset($_SESSION);
session_unset();
session_destroy();
header("location: index_spip.php");
?>