<h3>Gestion <?php echo ucfirst($elem_to_manage); ?></h3>

<!-- SOUS-MENU -->
<div id="submenu">
<?php if($elem_to_manage == 'pages') { ?>
	<a href="?module=<?php echo $_SESSION['module']; ?>&page=creation&gerer=pages">Ajouter une page</a>
<?php } ?>
</div>

<!-- GESTION DES CATEGORIES -->
<?php if($elem_to_manage == 'categories') { ?>
<div class="row">
    <div class="twelve columns" id="lst_all_cats">
        <?php echo $module->getLayoutCats(); ?>
    </div>
</div>
<?php } ?>

<!-- GESTION DES PAGES -->
<?php if($elem_to_manage == 'pages') { ?>
<div class="row">
    <div class="three columns" style="margin-bottom: 22px;">
        <?php echo $module->getSelectCat('all', 'sort-by-cat'); ?>
    </div>
</div>
<div class="row">
    <div class="twelve columns" id="lst_all_pages">
        <?php echo $module->getLayoutPages(); ?>
    </div>
</div>
<?php } ?>

<!-- GESTION DU MENU PRINCIPAL -->
<?php if($elem_to_manage == 'mainmenu') { ?>
<div class="row">
    <div class="twelve columns" id="lst_all_menus">
        <?php echo $module->getLayoutMainMenu(); ?>
    </div>
</div>
<?php } ?>

<!-- GESTION DES OPTIONS -->
<?php if($elem_to_manage == 'options') { ?>
<div class="row">
    <div class="twelve columns" id="lst_all_options">
        <?php echo $module->getLayoutOptions(); ?>
    </div>
</div>
<?php } ?>

<!-- GESTION DES LANGUES -->
<?php if($elem_to_manage == 'langues') { ?>
<div class="row">
    <div class="twelve columns" id="lst_all_langues">
        <?php echo $module->getLayoutLangues(); ?>
    </div>
</div>
<?php } ?>

<!-- GESTION DES USERS -->
<?php if($elem_to_manage == 'users') { ?>
<div class="row">
    <div class="twelve columns" id="lst_all_users">
        <?php echo $module->getLayoutUsers(); ?>
    </div>
</div>
<?php } ?>