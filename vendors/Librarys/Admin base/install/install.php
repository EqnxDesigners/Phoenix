<?php
/************************************/
/* INSTALLATION ET PRECONFIGURATION */
/*          E-NOVINFO CMS           */
/************************************/

//Inclusion des fichiers
include'../includes/config.inc.php';
include'../class/db.class.php';
include'../class/main.class.php';

//Nouvelles instances
$db = new DB;
$main = new MAIN;

//Création des tables de bases
$req = "CREATE TABLE IF NOT EXISTS `cms_list_modules` (
	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `module_name` varchar(255) NOT NULL,
	  `module_path` varchar(255) NOT NULL,
	  `developped_for` varchar(255) NOT NULL,
	  `descriptif` varchar(255) NOT NULL,
	  `config` int(2) unsigned NOT NULL,
	  `tbl_params` varchar(255) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10";
mysql_query($req);

$req = "CREATE TABLE IF NOT EXISTS `cms_mainmenu` (
	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `id_module` int(10) unsigned NOT NULL,
	  `ordre` int(10) unsigned NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17";
mysql_query($req);

$req = "CREATE TABLE IF NOT EXISTS `cms_tokens` (
	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `id_user` int(10) unsigned NOT NULL,
	  `token` varchar(255) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
mysql_query($req);

$req = "CREATE TABLE IF NOT EXISTS `cms_users` (
	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `login` varchar(255) NOT NULL,
	  `password` varchar(255) NOT NULL,
	  `user_name` varchar(255) NOT NULL,
	  `email` varchar(255) NOT NULL,
	  `user_level` int(10) unsigned NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2";
mysql_query($req);

$req = "CREATE TABLE IF NOT EXISTS `langue` (
	  `IDLangue` int(11) NOT NULL AUTO_INCREMENT,
	  `Langue` varchar(250) DEFAULT NULL,
	  PRIMARY KEY (`IDLangue`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
mysql_query($req);


/* INSERTION DES DONNEES DE BASES  */

//Insertion du module de configuration
mysql_query("INSERT INTO `cms_mainmenu` (`id`, `id_module`, `ordre`) VALUES (1, 1, 1)");

//Insertion de l'utilisateur superuser
mysql_query("INSERT INTO `cms_users` (`id`, `login`, `password`, `user_name`, `email`, `user_level`) VALUES (1, 'enovinfo', '67efa23e1adf4678683c41302c88d88a', 'e-novinfo', 'jerome.clerc@e-novinfo.ch', 1)");

//Insertion de la liste des modules existants
mysql_query("INSERT INTO `cms_list_modules` (`id`, `module_name`, `module_path`, `developped_for`, `descriptif`, `config`, `tbl_params`) VALUES
	(1, 'configuration', 'default', 'e-novinfo', 'Module de configuration du CMS', 1, ''),
	(2, 'membres', 'membres_kiwanis', 'Kiwanis Club Entre-deux-Lacs', 'Gestion des membres du Kiwanis Club', 0, ''),
	(3, 'actions', 'actions_kiwanis', 'Kiwanis Club Entre-deux-Lacs', 'Gestion des actions du Kiwanis', 0, ''),
	(4, 'documents', 'documents_kiwanis', 'Kiwanis Club Entre-deux-Lacs', 'Gestion des documents a usage interne du Kiwanis', 0, ''),
	(5, 'equipes', 'equipes_fcorbe', 'FC Orbe', 'Gestion des equipes du FC Orbe', 0, ''),
	(6, 'matchs', 'matchs_fcorbe', 'FC Orbe', 'Calendrier et suivit des matchs du FC Orbe', 0, ''),
	(7, 'comite', 'comite_fcorbe', 'FC Orbe', 'Gestion des membres du comite', 0, ''),
	(8, 'news', 'news', 'FC Orbe', 'Gestion des news avec une image', 0, ''),
	(9, 'jobs', 'jobs', 'e-novinfo', 'Gestion des jobs et interfacage avec differente plate-forme d''emplois en ligne', 1, 'job_config'),
	(10, 'news', 'newsV2', 'e-novinfo', 'Gestion des news multilangue avec plusieurs images (v2)', 0, '')"
	);

//Insertion des langues
mysql_query("INSERT INTO `langue` (`IDLangue`, `Langue`) VALUES
	(1, 'fr'),
	(2, 'en')");


header("location: ../index_spip.php");

?>