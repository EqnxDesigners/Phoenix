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
            <h2>Articles</h2>
        </div>
    </div>
    
    <!-- Sous-menu -->
    <div class="row sub-menu">
        <div class="col-lg-12">
            <div class="btn btn-primary btn-xs" role="open-add-form">Ajouter un article</div>
        </div>
    </div>
    
    <!-- Formulaire d'ajout -->
    <!--<div class="row pop-form" id="add-form">-->
    <div class="row" id="add-form">
        <div class="col-lg-9"><h3>Nouvel article</h3></div>
        <div class="col-lg-3"><h3 id="box-title">Publier</h3></div>
        <?php if(isset($alert_add)) { ?><div class="alert alert-danger" role="add-form"><?php echo $alert_add; ?></div><?php } ?>
        <div class="col-lg-9 new-art-content" id="art-editor">
            <div id="new-art-content"></div>
            <!-- Ajouter une row -->
            <div class="row">
                <div class="col-lg-12 text-center add-row">
                    <div class="btn btn-default btn-xs">
                        <span class="glyphicon glyphicon-plus"></span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3">
            <div id="publish-box">
                <div class="row">
                    <div class="col-lg-6 text-center">
                        <button type="button" class="btn btn-primary btn-block">Enregistrer</button>
                    </div>
                    <div class="col-lg-6 text-center">
                        <button type="button" class="btn btn-success btn-block">Publier</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="checkbox">
                            <label>
                                <input id="publish-all-lang" type="checkbox"> Publier dans toutes les langues
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h4>Langues</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9">
                        <select id="select-lang" class="form-control">
                            <option value="1" selected="">Français</option>
                            <option value="2">Deutsch</option>
                            <option value="3">English</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <div class="btn btn-default btn-xs">
                            <span class="glyphicon glyphicon-refresh"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h4>Catégories</h4>
                    </div>
                </div>
            </div>
            <div id="medias-box"></div>
        </div>
    </div>
    
    <!-- Formulaire d'edition -->
    <div class="row pop-form" id="edit-form"></div>
    
    <!-- Listing -->
    <div class="row listing" id="listing">
        <?php //the_listing(); ?>
    </div>
    
    <!-- #MODULE CATEGORIES -->
</div>
</section>