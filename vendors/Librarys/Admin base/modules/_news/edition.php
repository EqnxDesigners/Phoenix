<h3>Edition</h3>

<!-- SOUS-MENU -->
<div id="submenu">
	<a href="?module=<?php echo $_SESSION['module']; ?>&page=gestion"><img src="imgs/bton_close.png" /></a>
</div>

<div class="row">
    <div class="nine columns" id="form-content">
        <form name="form_add_news" action="<?php echo $form_url; ?>" method="POST" enctype="multipart/form-data" class="custom">
            <div class="eight columns">
                <div class="twelve columns alert-box alert text-center" id="alert-box" style="display: none;"></div>
                <?php if(isset($alert)) { echo $module->getMsgBox($alert); } ?>
                <?php if(isset($_GET['alert'])) { echo $module->getMsgBox($_GET['alert']); } ?>
                <div class="twelve columns">
                    <input type="text" name="titre" placeholder="Titre *" value="<?php echo $module->getValueToEdit($_GET['idnews'], 'titre'); ?>">
                </div>
                <div class="twelve columns">
                    <input type="text" name="sous-titre" placeholder="Sous-titre *" value="<?php echo $module->getValueToEdit($_GET['idnews'], 'sous_titre'); ?>">
                </div>
                <div class="twelve columns">
                    <textarea name="texte"><?php echo $module->getValueToEdit($_GET['idnews'], 'texte'); ?></textarea>
                </div>
                <div class="twelve columns" style="margin-top:8px;">
                    <input type="checkbox" name="to-app" id="to-app" value="1" <?php if($module->getValueToEdit($_GET['idnews'], 'to_app') == 1) { echo 'checked'; } ?>> Publier sur l'application mobile
                </div>
                <div class="twelve columns">
                    <input type="checkbox" name="to-app-home" id="to-app-home" value="1" <?php if($module->getValueToEdit($_GET['idnews'], 'to_app_home') == 1) { echo 'checked'; } ?>> Publier sur l'accueil de l'application mobile
                </div>
                <div class="twelve columns text-right">
                    <input type="hidden" name="img-slide" id="img-slide" value="<?php echo $module->getNewsImgIdToEdit($_GET['idnews'], '1'); ?>">
                    <input type="hidden" name="img-news" id="img-news" value="<?php echo $module->getNewsImgIdToEdit($_GET['idnews'], '2'); ?>">
                    <input type="hidden" name="idnews" value="<?php echo $_GET['idnews']; ?>">
                    <input type="submit" name="edit_news" value="Modifier" class="button success">
                </div>
            </div>
            <div class="four columns" id="linked-imgs">
                <div class="row">
                    <div class="four columns"><img src="../medias/images/<?php echo $module->getThumbToEdit($_GET['idnews'], '1'); ?>" id="slide-vignette"></div>
                    <div class="five columns">&nbsp;</div>
                    <div class="three columns tool-box"><img src="imgs/bton_next.png" class="sub-tool" linkto="1"></div>
                </div>
                <!--
                <div class="row">
                    <div class="four columns"><img src="../medias/images/<?php echo $module->getThumbToEdit($_GET['idnews'], '2'); ?>" id="news-vignette"></div>
                    <div class="five columns">&nbsp;</div>
                    <div class="three columns tool-box"><img src="imgs/bton_next.png" class="sub-tool" linkto="2"></div>
                </div>
                -->
            </div>
        </form>
    </div>
    <div class="three columns" id="lst-medias-images">
        &nbsp;
    </div>
</div>