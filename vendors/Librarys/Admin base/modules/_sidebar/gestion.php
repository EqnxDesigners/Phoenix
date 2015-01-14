<h3>Gestion <?php echo ucfirst($elem_to_manage); ?></h3>

<!-- SOUS-MENU -->
<div id="submenu">
    <a class="tool" role="new-article">Ajouter un widget</a>
</div>

<!-- GESTION DE LA SIDEBAR -->
<div class="row">
    <div class="twelve mobile-four columns text-center"><div class="alert-box secondary" id="helper">Sélectionnez une page</div></div>
</div>
<div class="row">
    <div class="four mobile-two columns" id="liste-pages">
        <h4>Pages</h4>
        <?php echo $module->getLayoutLstPages(); ?>
    </div>
    <div class="four mobile-two columns" id="list-widgets">
        <h4>Widgets</h4>
        <div id="list-widgets-content"></div>
        <?php //echo $module->getLayoutLstWidgets(); ?>
    </div>
    <div class="four mobile-four columns" id="assigned-widgets">
        <h4>Widgets assignés</h4>
        <div id="assigned-widgets-content"></div>        
    </div>
</div>
