<!-- 
*******************************************
***** MODULE DE GESTION DE LA SIDEBAR *****
***** V. 1.0 (C)e-novinfo 2013        *****
*******************************************
--> 

<!-- CHARGEMENT DES FICHIERS CONNEXES -->
<?php include 'module.class.php'; ?>
<?php include 'module.ctrl.php'; ?>

<!-- MODULE -->
<div id="module_wrapper">
	<h1>SIDEBAR</h1>
	<div class="module_name" id="<?php echo $_SESSION['module']; ?>"></div>
	
	<!-- SOUS-MENU -->
	<div id="submenu">
		<!--
                <a href="?module=<?php echo $_SESSION['module'].'&page=gestion&gerer=articles'; ?>" target="_self">Articles</a>
		&nbsp;|&nbsp;
		<a href="?module=<?php echo $_SESSION['module'].'&page=gestion&gerer=categories'; ?>" target="_self">Catégories</a>
		&nbsp;|&nbsp;
		<a href="?module=<?php echo $_SESSION['module'].'&page=gestion&gerer=videos'; ?>" target="_self">Vidéos</a>
                -->
	</div>

	<!-- INCLUDE DES EDITIONS DE LISTES -->
	<div id="liste">
		<?php include($page_to_load); ?>
	</div>
</div>