<!-- 
****************************************
***** MODULE DE GESTION DES MEDIAS *****
***** V. 2.0 (C)e-novinfo 2013     *****
****************************************
-->

<!-- CHARGEMENT DES FICHIERS CONNEXES -->
<link rel="stylesheet" href="modules/medias/default.css">
<?php include 'module.class.php'; ?>
<?php include 'module.ctrl.php'; ?>

<!-- MODULE -->
<div id="module_wrapper">
	<h1>MEDIAS</h1>
	<!--<div class="module_name" id="<?php echo $_SESSION['module']; ?>"></div>-->
	
	<!-- SOUS-MENU -->
	<div id="module-menu" style="border-bottom: 1px solid #666; padding-bottom: 8px;">
            <a href="?module=<?php echo $_SESSION['module']; ?>&page=gest_images" class="button secondary small">Gérer les images</a>
            <a href="?module=<?php echo $_SESSION['module']; ?>&page=gest_docs" class="button secondary small">Gérer les documents</a>
            <a href="?module=<?php echo $_SESSION['module']; ?>&page=gest_vids" class="button secondary small">Gérer les vidéos</a>
            <a href="?module=<?php echo $_SESSION['module']; ?>&page=gest_gallery" class="button secondary small">Gérer les galeries</a>
            <a href="?module=<?php echo $_SESSION['module']; ?>&page=gest_slides" class="button secondary small">Gérer les slideshows</a>
	</div>

	<!-- INCLUDE DES EDITIONS DE LISTES -->
	<div id="liste">
		<?php include($page_to_load); ?>
	</div>
</div>




