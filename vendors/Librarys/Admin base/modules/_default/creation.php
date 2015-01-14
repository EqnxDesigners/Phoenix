<h3>Création</h3>

<!-- SOUS-MENU -->
<div id="submenu">
	<a href="?module=<?php echo $_SESSION['module']; ?>&page=gestion&gerer=<?php echo $_GET['gerer']; ?>"><img src="imgs/bton_close.png" /></a>
</div>

<?php if($elem_to_manage == 'pages') { ?>
<div class="row">
    <form name="form_add_page" action="<?php echo $_SERVER['PHP_SELF']; ?>?module=<?php echo $_SESSION['module']; ?>&page=<?php echo $_GET['page']; ?>&gerer=<?php echo $_GET['gerer']; ?>" method="POST" enctype="multipart/form-data" class="custom">
        <div class="twelve mobile-four columns">
            <label for="page_name">Nom de la page</label>
        </div>
        <div class="six mobile-four columns end">
            <input type="text" name="page_name">
        </div>
        <div class="twelve mobile-four columns">
            <label for="cat">Catégorie de la page</label>
        </div>
        <div class="six mobile-four columns end">
            <?php echo $module->getSelectCat(); ?>
        </div>
        <?php foreach($module->getLstLang() as $lang) { ?>
        <div class="twelve mobile-four columns">
            <label for="title_<?php echo $lang['langue']; ?>">Title <?php echo strtoupper($lang['langue']); ?></label>
        </div>
        <div class="six mobile-four columns end">
            <input type="text" name="title_<?php echo $lang['langue']; ?>">
        </div>
        <?php } ?>
        <div class="twelve mobile-four columns">
            <label for="template">Template</label>
        </div>
        <div class="six mobile-four columns end">
            <?php echo $module->getSelectTemplate(); ?>
        </div>
        <div class="twelve mobile-four columns" style="margin-top: 12px;">
            <input type="checkbox" name="publie_now" value="1">
            Publier immédiatement la page
        </div>
        <div class="six mobile-four columns end text-right">
            <input type="submit" name="add_page" value="Ajouter" class="button success">
        </div>
    </form>
</div>
<?php } ?>