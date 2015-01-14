<h3>Gestion <?php echo ucfirst($elem_to_manage); ?></h3>

<!-- SOUS-MENU -->
<div id="submenu">
    <a href="?module=<?php echo $_SESSION['module']; ?>&page=creation">Ajouter une news</a>
</div>

<!-- GESTION DES NEWS -->
<div class="row">
    <div class="twelve columns no-gutter">
        <div class="twelve columns" id="lst-news">
            <?php echo $module->getLayoutNews(); ?>
        </div>
    </div>
</div>
