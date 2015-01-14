<h3>Création</h3>

<!-- SOUS-MENU -->
<div id="submenu">
	<a href="?module=<?php echo $_SESSION['module']; ?>&page=gestion"><img src="imgs/bton_close.png" /></a>
</div>

<?php if($_GET['gerer'] == 'medias') { ?>
    <div class="row">
        <div class="six mobile-four columns">
            <form name="form_add_medias" action="<?php echo $form_url; ?>" method="POST" enctype="multipart/form-data" class="custom">
                <div class="twelve columns alert-box alert text-center" id="alert-box" style="display: none;"></div>
                <?php if(isset($alert)) { echo $module->getMsgBox($alert); } ?>
                <?php if(isset($_GET['alert'])) { echo $module->getMsgBox($_GET['alert']); } ?>
                <div class="twelve columns">
                    <label for="file_url">Fichier à uploader</label>
                    <input type="file" name="file_url" id="media-file">
                </div>
                <div class="twelve columns">
                    <label for="vids_url" style="margin-top: 22px;">URL YouTube</label>
                    <div class="row collapse">
                        <div class="eleven columns">
                            <input type="text" name="vids_url" id="media-url" placeholder="http://youtu.be/v1uyQZNg2vE">
                        </div>
                        <div class="one columns">
                            <span class="postfix"><img src="imgs/bton_search.png" style="margin-top:2px;" class="sub-tool" role="open-vid-options"></span>
                        </div>
                    </div>


                </div>
                <!-- Options pour une image -->
                <div class="row pop-box" id="options-img-content">
                    <div class="twelve columns">
                        <h3>Options</h3>
                        <div class="twelve columns">
                            <label for="titre">Titre</label>
                            <input type="text" name="img-titre" id="img-titre" placeholder="Titre">
                        </div>
                        <div class="twelve columns">
                            <label for="alt">Text Alt</label>
                            <input type="text" name="img-alt" id="img-alt" placeholder="Text Alt">
                        </div>
                        <div class="twelve columns">
                            <label for="legende">Légende</label>
                            <input type="text" name="img-legende" id="img-legende" placeholder="Légende">
                        </div>
                        <div class="twelve columns">
                            <h4>Formats prédéfinis</h4>
                            <?php echo $module->getFormLstFormat(); ?>
                        </div>
                        <div class="twelve columns" style="margin-bottom: 12px;">
                            <h4>Format personnalisé</h4>
                            Si une seule dimension est précisée, l'image sera ajutée proportionnellement.
                        </div>
                        <div class="six columns">
                            <input type="text" name="custom-width" placeholder="Fixer la largeur en pixel">
                        </div>
                        <div class="six columns">
                            <input type="text" name="custom-height" placeholder="Fixer la hauteur en pixel">
                        </div>
                        <div class="twelve columns text-right">
                            <input type="submit" name="add_media" value="Uploader" class="button success">
                        </div>
                    </div>
                </div>
                <!-- Options pour un document -->
                <div class="row pop-box" id="options-doc-content">
                    <div class="twelve columns">
                        <h3>Options</h3>
                        <div class="twelve columns">
                            <label for="titre">Titre</label>
                            <input type="text" name="doc-titre" id="doc-titre" placeholder="Titre">
                        </div>
                        <div class="twelve columns">
                            <label for="alt">Text Alt</label>
                            <input type="text" name="doc-alt" id="doc-alt" placeholder="Text Alt">
                        </div>
                        <div class="twelve columns">
                            <label for="legende">Légende</label>
                            <input type="text" name="doc-legende" id="doc-legende" placeholder="Légende">
                        </div>
                        <div class="twelve columns text-right">
                            <input type="submit" name="add_media" value="Uploader" class="button success">
                        </div>
                    </div>
                </div>
                <!-- Options pour une video -->
                <div class="row pop-box" id="options-vid-content">
                    <div class="twelve columns">
                        <h3>Options</h3>
                        <div class="twelve columns">
                            <label for="titre">Titre</label>
                            <input type="text" name="vid-titre" id="vid-titre" placeholder="Titre">
                        </div>
                        <div class="twelve columns">
                            <label for="alt">Text Alt</label>
                            <input type="text" name="vid-alt" id="vid-alt" placeholder="Text Alt">
                        </div>
                        <div class="twelve columns">
                            <label for="legende">Légende</label>
                            <input type="text" name="vid-legende" id="vid-legende" placeholder="Légende">
                        </div>
                        <div class="twelve columns text-right">
                            <input type="submit" name="add_media" value="Uploader" class="button success">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="type-media" id="type-media" value="">
            </form>
        </div>
        <div class="six mobile-four columns">
            <div class="row pop-box" id="medias-preview">
                <h3>Prévisualisation</h3>
                <div div class="twelve columns" id="img-thumb"></div>
                <div div class="twelve columns" id="vid-thumb"></div>
                <div class="twelve columns flex-video" id="vid-preview"></div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if($_GET['gerer'] == 'slideshow') { ?>
    <div class="row">
        <div class="six columns" style="margin-bottom:12px;">
            <a class="sub-tool" role="open-add-slide" style="margin-bottom:12px;">Nouveau Slideshow</a>
            <div class="twelve columns alert-box alert text-center" id="alert-box" style="display: none;"></div>
            <?php if(isset($alert)) { echo $module->getMsgBox($alert); } ?>
            <?php if(isset($_GET['alert'])) { echo $module->getMsgBox($_GET['alert']); } ?>
        </div>
    </div>
    <!-- CREATION D'UN SLIDESHOW -->
    <div class="row pop-box" id="add-slideshow" style="margin-bottom: 40px; background: #efefef; padding: 15px 0;">
        <div class="six columns">
            <div class="twelve columns">
                <img src="imgs/bton_close.png" class="tool" role="close_pop_box">
            </div>
            <div class="twelve columns">
                <h3>Créer un slideshow</h3>
            </div>
            <form name="add-slide" action="<?php echo $form_url; ?>" method="POST" enctype="multipart/form-data" class="custom">
                <div class="twelve columns">
                    <input type="text" name="titre" placeholder="Titre">
                </div>                
                <div class="twelve columns">
                    <input type="submit" name="add_slide" value="Créer" class="button success">
                </div>
            </form>
        </div>
    </div>
    <!-- LISTE DES SLIDESHOWS -->
    <div class="row">
        <div class="four columns" id="lst-slideshows">
            <?php echo $module->getLayoutSlideshow(); ?>
        </div>
        <div class="four columns" id="lst-imgs-dispo">
            &nbsp;
        </div>
        <div class="four columns" id="lst-imgs-in-slide">
            &nbsp;
        </div>
    </div>
<?php } ?>
