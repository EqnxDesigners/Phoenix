<?php require_once dirname(__FILE__).'/functions.php'; ?>
<?php include_once dirname(__FILE__).'/module.ctrl.php'; ?>
<script src="modules/<?php echo $_GET['module']; ?>/module.script.js"></script>


<?php the_top_menu(); ?>

<section class="row">
<div class="col-lg-2 menu-main no-gutter">
<?php the_main_menu($_GET['module']); ?>
</div>
<div class="col-lg-10">
    <!-- MODULE PAGES -->
    
    <!-- Titre -->
    <div class="row" id="module-top">
        <div class="col-lg-12">
            <h2>Pages</h2>
        </div>
    </div>
    
    <!-- Sous-menu -->
    <div class="row sub-menu">
        <div class="col-lg-12">
            <div class="btn btn-primary btn-xs" role="open-add-form">Ajouter une page</div>
        </div>
    </div>
    
    <!-- Formulaire d'ajout -->
    <div class="row pop-form" id="add-form">
        <div class="col-lg-12"><h3>Ajouter une page</h3></div>
        <?php if(isset($alert_add)) { ?><div class="alert alert-danger" role="add-form"><?php echo $alert_add; ?></div><?php } ?>
        <form name="form_add" id="form_add" action="<?php dirname(__FILE__).'/module.ctrl.php'; ?>" method="post">
            <div class="row">
                <div class="col-lg-12 form-group">
                    <label for="page_name">Nom de la page <small>(CMS uniquement)</small></label>
                    <input type="text" class="form-control" name="page_name" id="page_name" placeholder="ex. Accueil">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <h4>Intitulé du menu <small>(nom du menu)</small></h4>
                    <?php txt_fields_by_lang('menu'); ?>
                </div>
                <div class="col-lg-4">
                    <h4>Page URL <small>(URL rewrite)</small></h4>
                    <?php txt_fields_by_lang('url'); ?>
                </div>
                <div class="col-lg-4">
                    <h4>Titre de la page <small>(Titre complémentaire)</small></h4>
                    <?php txt_fields_by_lang('title'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <h4>Template <small>(Mise en page particulière)</small></h4>
                    <?php pages_templates(); ?>
                </div>
                <div class="col-lg-6">
                    <h4>Page parent <small>(Crée un sous-menu)</small></h4>
                    <?php pages_selector(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="checkbox">
                        <label>
                            <input name="page_active" id="page_active" type="checkbox" value="1" checked>
                            Publier la page immédiatement
                        </label>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="checkbox">
                        <label>
                            <input name="page_menu" id="page_menu" type="checkbox" value="1" checked>
                            Générer un menu
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-right">
                    <input type="reset" name="reset-form" class="btn btn-danger" value="Annuler">
                    <input type="submit" name="add-item" class="btn btn-success" value="Ajouter">
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
    
    <!-- #MODULE PAGES -->
</div>
</section>

