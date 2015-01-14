<?php
//Vérification de la SESSION
if($main->verifSession() != true) {
	header("Location: index.php");
}

//Chargelemt des modules
if(!isset($_GET['module'])) {
	$_SESSION['module'] = $main->getFirstModule();
}
else {
	$_SESSION['module'] = $_GET['module'];
}

//Logout
if(isset($_GET['logout'])) {
	$main->logOut();
	header("Location: index.php");
}

?>























