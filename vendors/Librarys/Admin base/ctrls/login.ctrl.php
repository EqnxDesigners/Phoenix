<?php
//Login membres
if(isset($_POST['logmein'])) {
	//Nouvelle instance de la class MAIN
	$main = new MAIN('1', '1');
	
	//Login
	try {
		$main->cmsLogin($_POST['user_login'], $_POST['user_pass']);
	}
	catch (Exception $e) {
		$alert = $e->getMessage();
	}
}
?>























