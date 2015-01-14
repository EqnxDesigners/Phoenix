<!-- 
****************************************
***** MODULE DE GESTION DES MEDIAS *****
***** V. 2.0 (C)e-novinfo 2013     *****
****************************************
-->

<!-- CHARGEMENT DES FICHIERS CONNEXES -->
<?php include 'module.class.php'; ?>
<?php include 'module.ctrl.php'; ?>

<!-- MODULE -->
<div id="module_wrapper">
	<h1>MEDIAS</h1>
	<div class="module_name" id="<?php echo $_SESSION['module']; ?>"></div>
	
	<!-- SOUS-MENU -->
	<div id="submenu">
            &nbsp;
	</div>

	<!-- INCLUDE DES EDITIONS DE LISTES -->
	<div id="liste">
		<?php include($page_to_load); ?>
	</div>
</div>




