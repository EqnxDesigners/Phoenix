<h3>Création</h3>

<!-- SOUS-MENU -->
<div id="submenu">
	<a href="?module=<?php echo $_SESSION['module']; ?>&page=gestion&gerer=<?php echo $_GET['gerer']; ?>">Fermer</a>
        &nbsp;|&nbsp;
        <a class="tool" id="new-article">Nouvel article</a>
</div>

<div class="row">
    <form name="form_add_article" action="<?php echo $_SERVER['PHP_SELF']; ?>?module=<?php echo $_SESSION['module']; ?>&page=<?php echo $_GET['page']; ?>&gerer=<?php echo $_GET['gerer']; ?>" method="POST" enctype="multipart/form-data">
        <div class="nine columns">
            <div class="twelve mobile-four columns text-center">
                <?php if(isset($alert)) { echo '<div class="alert-box alert">'.$alert.'</div>'; } ?>
                <?php if(isset($recorded)) { echo '<div class="alert-box secondary">'.$recorded.'</div>'; } ?>
                <?php if(isset($success)) { echo '<div class="alert-box success">'.$success.'</div>'; } ?>
            </div>
            <div class="three mobile-two columns">
                <?php echo $module->getSelectPages('static', $_SESSION['page']); ?>
            </div>
            <div class="six columns text-center">
                <?php if(isset($_SESSION['id_article'])) { echo 'Référence article courrant : '.$_SESSION['id_article']; } ?>
            </div>
            <div class="three columns text-right">
                <?php echo $module->getSelectLangues($_SESSION['lang']); ?>
            </div>
            <div class="twelve columns">&nbsp;</div>
            <div class="twelve columns">
                <label for="titre">Titre</label>
                <input type="text" name="titre" id="media-titre" placeholder="Titre" value="<?php $module->getFieldValue('titre'); ?>">
            </div>
            <div class="twelve columns">
                <div id="lst-medias-images" style="display:none;"><?php echo $module->getLstMediasInterface('1'); ?></div>
                <div id="lst-medias-videos" style="display:none;"><?php echo $module->getLstMediasInterface('2'); ?></div>
                <div id="lst-medias-docs" style="display:none;"><?php echo $module->getLstMediasInterface('3'); ?></div>
                <textarea name="article" class="big-txt-area" id="create-article"><?php $module->getArticleContent(); ?></textarea>
            </div>
        </div>
        <div class="three columns" id="lst_all_medias">
            <div class="twelve columns">
                <input type="submit" name="add_article" value="Publier" class="button expand success">
                <br>
                <input type="submit" name="rec_article" value="Enregistrer" class="button expand primary">
            </div>
            <div class="twelve columns" style="margin-top: 24px;">
                <?php if($module->checkIfMultiLang()) { ?>
                    <input type="checkbox" name="for-all-lang" value="1">&nbsp;Idem dans toutes les langues
                <?php } ?>
            </div>
        </div>
    </form>
</div>