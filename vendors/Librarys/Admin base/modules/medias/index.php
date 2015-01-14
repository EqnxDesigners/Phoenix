<?php require_once dirname(__FILE__).'/functions.php'; ?>
<?php include_once dirname(__FILE__).'/module.ctrl.php'; ?>
<script src="modules/<?php echo $_GET['module']; ?>/module.script.js"></script>

<?php the_top_menu(); ?>

<section class="row">
<div class="col-lg-2 menu-main no-gutter">
<?php the_main_menu($_GET['module']); ?>
</div>
<div class="col-lg-10">
    <!-- MODULE MEDIAS -->
    
    <!-- Titre -->
    <div class="row" id="module-top">
        <div class="col-lg-12">
            <h2>Médias</h2>
        </div>
    </div>
    
    <!-- Sous-menu -->
    <div class="row sub-menu">
        <div class="col-lg-12">
            <div class="btn btn-primary btn-xs" role="open-add-form">Ajouter un médias</div>
        </div>
    </div>
    
    <!-- Formulaire d'ajout -->
    <div class="row pop-form" id="add-form">
        <div class="row">
            <div class="col-lg-6"><h3>Ajouter un médias</h3></div>
            <div class="col-lg-6 text-right"><span class="glyphicon glyphicon-remove-circle"></span></div>
        </div>
        <div class="row">
            <?php if(isset($alert_add)) { ?><div class="alert alert-danger" role="add-form"><?php echo $alert_add; ?></div><?php } ?>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <form name="form_add" id="form_add" action="<?php dirname(__FILE__).'/module.ctrl.php'; ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="media-file">Ajouter un fichier</label>
                                <input type="file" name="media-file" id="media-file">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <input type="reset" name="reset-form" class="btn btn-danger" value="Annuler">
                            <input type="submit" name="add-item" class="btn btn-success" value="Ajouter">
                        </div>
                    </div>
                </form>
            </div>        
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="media-file">Glissez – déposez vos fichiers dans la « zone de drop » (max 10 fichiers – 20 Mo)</label>
                        </div>
                        <div class="upload_form_cont">
                            <div class="col-lg-4">
                                <div id="dropArea">Zone de drop</div>
                            </div>
                            <div class="col-lg-8">
                                <div class="info">
                                    <div>Fichiers restants : <span id="count">0</span></div>
                                    <div><input type="hidden" id="script_url" value="modules/medias/upload.php"/></div>
                                    <div><input type="hidden" id="url" value="modules/medias/upload.php"/></div>
                                    <h3>Résultat :</h3>
                                    <canvas width="500" height="20"></canvas>
                                    <div id="result"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Formulaire d'edition -->
    <div class="row pop-form" id="edit-form"></div>
    
    <!-- Listing -->
    <div class="row listing" id="listing">
        <div class="col-lg-8 library">
            <h3>Bibliothèque</h3>
            <?php the_listing(); ?>
        </div>
        <div class="col-lg-4">
            <h3>Edition</h3>
            <div class="row" id="edit-medias"><?php the_edit_box(); ?></div>
        </div>
    </div>
    
    <!-- #MODULE MEDIAS -->
</div>
</section>

