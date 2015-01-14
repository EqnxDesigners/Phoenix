<?php
if(isset($_GET['action']) && $_GET['action'] == 'install') {
	include '../../includes/config.inc.php';
	include '../../class/db.class.php';
	
	$db = new DB();
	
	mysql_query("CREATE TABLE IF NOT EXISTS `news` (
	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `post_date` date NOT NULL,
	  `post_by` int(10) unsigned NOT NULL,
	  `categorie` int(10) unsigned NOT NULL,
	  `visible` int(1) unsigned NOT NULL COMMENT 'visible = 1 / invisible = 0',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");

	mysql_query("CREATE TABLE IF NOT EXISTS `news_categories` (
	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `categorie` varchar(255) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
	
	mysql_query("CREATE TABLE IF NOT EXISTS `news_img` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `img` varchar(250) NOT NULL,
	  `id_news` int(11) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
	
	mysql_query("INSERT INTO `news_categories` (`id`, `categorie`) VALUES
	(1, 'Actualit&eacute;s')");
	
	mysql_query("CREATE TABLE IF NOT EXISTS `traduction_news` (
	  `IDTraductionNews` int(11) NOT NULL AUTO_INCREMENT,
	  `TraductionTitre` varchar(250) NOT NULL,
	  `TraductionTexte` text NOT NULL,
	  `IDNews` int(11) NOT NULL,
	  `IDLangue` int(11) NOT NULL,
	  PRIMARY KEY (`IDTraductionNews`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");

	header("location: ../../dashboard.php?module=".$_SESSION['module']."&action=add_module&id=".$_GET['id']."");
}

//Désinstallation du module
if(isset($_GET['action']) && $_GET['action'] == 'uninstall') {
	include '../../includes/config.inc.php';
	include '../../class/db.class.php';
	
	$db = new DB();
	
	mysql_query("DROP TABLE  `news` ,
	`news_categories`,
	`news_img`,
	`traduction_news`
	");
	
	//TODO
	//Suppression des images
	
	header("location: ../../dashboard.php?module=".$_SESSION['module']."&action=rem_module&id=".$_GET['id']."");
}
?>













