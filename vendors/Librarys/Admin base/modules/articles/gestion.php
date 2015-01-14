<h3>Gestion <?php echo ucfirst($elem_to_manage); ?></h3>

<!-- SOUS-MENU -->
<div id="submenu">
    <a class="tool" id="new-article">Ajouter un article</a>
</div>

<!-- GESTION DES ARTICLES -->
<div class="row">
    <div class="three mobile-two columns">
        <?php echo $module->getSelectCat('all', 'select-cat'); ?>
    </div>
    <div class="three mobile-two columns" id="select-pages-content">
        &nbsp;
    </div>
    <div class="six mobile-two columns">
        <img src="imgs/ajax-loader.gif" id="ajax-loader">
    </div>
    <div class="twelve mobile-four columns" id="listing-articles">
        <?php echo $module->getLayoutLstArticles(); ?>
    </div>
</div>
