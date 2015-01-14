<?php require_once dirname(__FILE__).'/functions.php'; ?>
<?php include_once dirname(__FILE__).'/module.ctrl.php'; ?>
<script src="modules/<?php echo $_GET['module']; ?>/module.script.js"></script>


<?php the_top_menu(); ?>

<section class="row">
<div class="col-lg-2 menu-main no-gutter">
<?php the_main_menu($_GET['module']); ?>
</div>
<div class="col-lg-10">
    <!-- MODULE CATEGORIES -->
    
    <!-- Titre -->
    <div class="row" id="module-top">
        <div class="col-lg-12">
            <h2>Catégories</h2>
        </div>
    </div>
    
    <!-- Sous-menu -->
    <div class="row sub-menu">
        <div class="col-lg-12">
            <div class="btn btn-primary btn-xs" role="open-add-form">Ajouter une catégories</div>
        </div>
    </div>
    
    <!-- Formulaire d'ajout -->
    <div class="row pop-form" id="add-form">
        <div class="col-lg-12"><h3>Ajouter une catégorie</h3></div>
        <?php if(isset($alert_add)) { ?><div class="alert alert-danger" role="add-form"><?php echo $alert_add; ?></div><?php } ?>
        <form name="form_add" id="form_add" action="<?php dirname(__FILE__).'/module.ctrl.php'; ?>" method="post">
            <div class="row">
                <div class="col-lg-4">
                    <h4>Intitulé de la categorie</h4>
                    <?php txt_fields_by_lang('categorie'); ?>
                    <div class="form-group">
                        <label for="cat_description">Description <small>(CMS uniquement)</small></label>
                        <input type="text" class="form-control" name="cat_description" id="cat_description" placeholder="ex. Articles de news">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>Catégorie parente</h4>
                            <?php cat_selector(); ?>
                        </div>
                    </div>
                    <div class="row">&nbsp;</div>
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <input type="reset" name="reset-form" class="btn btn-danger" value="Annuler">
                            <input type="submit" name="add-item" class="btn btn-success" value="Ajouter">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    &nbsp;
                </div>
            </div>
        </form>
    </div>
    
    <!-- Formulaire d'edition -->
    <div class="row pop-form" id="edit-form"></div>
    
    <!-- Listing -->
    <div class="row listing" id="listing">
        <?php the_listing(); ?>
    </div>
    
    <!-- #MODULE CATEGORIES -->
</div>
</section>

