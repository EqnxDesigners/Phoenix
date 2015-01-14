<!--<h3>Gestion <?php echo ucfirst($elem_to_manage); ?></h3>-->

<!-- SOUS-MENU -->
<div id="submenu">
    <a class="button secondary small" role="open-add-media">Ajouter des images</a>
    <!--<a role="open-add-format" class="sub-tool button secondary small">Formats personnalisés</a>
    &nbsp;|&nbsp;
    <a href="?module=<?php echo $_SESSION['module']; ?>&page=creation&gerer=slideshow">Slideshow</a>-->
</div>

<!-- GESTION DES FORMATS PREDEFINIS -->
<div class="row pop-box" id="add-media" style="margin-bottom: 40px; background: #efefef; padding: 15px 0;">
    <div class="twelve columns"><img src="imgs/bton_close.png" class="tool" role="close_pop_box"></div>
    <div class="six columns">
        <h3>Ajouter un format</h3>
        <form name="form_add_format" action="<?php echo $form_url; ?>" method="POST" enctype="multipart/form-data" class="custom">
            <div class="twelve columns">
                <input type="text" name="format" placeholder="Nom du format">
            </div>
            <div class="six columns">
                <input type="text" name="width" placeholder="Largeur [px]">
            </div>
            <div class="six columns">
                <input type="text" name="height" placeholder="Hauteur [px]">
            </div>
            <div class="twelve columns">
                <input type="submit" name="add_format" value="Ajouter" class="button success">
            </div>
        </form>
    </div>
    <div class="six columns">
        <h3>Formats disponibles</h3>
        <div id="list-formats-content">
            <?php echo $module->getLayoutFormats(); ?>
        </div>
    </div>
</div>

<!-- GESTION DES IMAGES -->
<div class="row">
    <!--<div class="twelve columns no-gutter">
        <div class="three columns" style="margin-bottom:22px;">
            <select id="media-selector">
                <option value="all" selected>Tous les types de médias</option>
                <option value ="1">Images</option>
                <option value="2">Vidéos</option>
                <option value="3">Documents</option>
            </select>
        </div>
    </div>-->
    <div class="twelve columns no-gutter">
        <div class="eight columns" id="lst-medias">
            <?php echo $module->getLayoutMedias('1'); ?>
        </div>
        <div class="four columns" id="media-details">
            &nbsp;
        </div>
        <!--
        <div class="four columns" id="lst-sub-medias">
            &nbsp;
        </div>
        <div class="four columns" id="lst-options-medias">
            <form name="form_edit_medias" action="<?php echo $form_url; ?>" method="POST" enctype="multipart/form-data" class="custom">
                <div class="twelve columns alert-box alert text-center" id="alert-box" style="display: none;"></div>
                <?php if(isset($alert)) { echo $module->getMsgBox($alert); } ?>
                <?php if(isset($_GET['alert'])) { echo $module->getMsgBox($_GET['alert']); } ?>
                <div class="twelve columns">
                    <label for="titre">Titre</label>
                    <input type="text" name="titre" id="img-titre" placeholder="Titre">
                </div>
                <div class="twelve columns">
                    <label for="alt">Text Alt</label>
                    <input type="text" name="alt" id="img-alt" placeholder="Text Alt">
                </div>
                <div class="twelve columns">
                    <label for="legende">Légende</label>
                    <input type="text" name="legende" id="img-legende" placeholder="Légende">
                </div>
                <div class="twelve columns text-right">
                    <input type="hidden" name="id_media" id="id-selected-media" value="">
                    <input type="submit" name="edit_media" value="Mettre à jour" class="button success">
                </div>
            </form>
        </div>
        -->
    </div>
</div>
