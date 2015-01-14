<!-- 
************************************
***** MODULE DE CONFIGURATION  *****
***** V. 2.0 (C)e-novinfo 2013 *****
************************************
-->

<!-- CHARGEMENT DES FICHIERS CONNEXES -->
<?php include 'module.class.php'; ?>
<?php include 'module.ctrl.php'; ?>

<!-- MODULE -->
<div id="module_wrapper">
	<h1>CONFIGURATION</h1>
	<div class="module_name" id="<?php echo $_SESSION['module']; ?>"></div>
	
	<!-- SOUS-MENU -->
	<div id="submenu">
            <a href="?module=<?php echo $_SESSION['module'].'&page=gestion&gerer=categories'; ?>" target="_self">Categories</a>
            &nbsp;|&nbsp;
            <a href="?module=<?php echo $_SESSION['module'].'&page=gestion&gerer=pages'; ?>" target="_self">Pages</a>
            &nbsp;|&nbsp;
            <a href="?module=<?php echo $_SESSION['module'].'&page=gestion&gerer=mainmenu'; ?>" target="_self">Menu principal</a>
            &nbsp;|&nbsp;
            <a href="?module=<?php echo $_SESSION['module'].'&page=gestion&gerer=options'; ?>" target="_self">Options</a>
            &nbsp;|&nbsp;
            <a href="?module=<?php echo $_SESSION['module'].'&page=gestion&gerer=langues'; ?>" target="_self">Langues</a>
            &nbsp;|&nbsp;
            <a href="?module=<?php echo $_SESSION['module'].'&page=gestion&gerer=users'; ?>" target="_self">Utilisateurs</a>
	</div>

	<!-- INCLUDE DES EDITIONS DE LISTES -->
	<div id="liste">
		<?php include($page_to_load); ?>
	</div>
</div>




