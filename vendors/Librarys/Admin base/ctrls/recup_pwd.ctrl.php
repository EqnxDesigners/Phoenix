<?php
//Récupération du login
if(isset($_POST['send_login'])) {
	//Nouvelle instance de la class MAIN
	$main = new MAIN;

	//Procédure de récupération
	try {
		$main->recupPassword($_POST['user_login']);
	}
	catch (ERRORS $e) {
		$alert = $e->getMessage();
	}
}

//Mise à jour du mot de passe
if(isset($_POST['new_password'])) {
	//Nouvelle instance de la class MAIN
	$main = new MAIN;

	//Procédure de récupération
	try {
		$main->updatePassword($_GET['id'], $_GET['token'], $_POST['password'], $_POST['password_confirm']);
	}
	catch (ERRORS $e) {
		$alert = $e->getMessage();
	}
}
?>























