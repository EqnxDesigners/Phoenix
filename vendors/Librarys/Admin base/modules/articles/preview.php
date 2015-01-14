<?php
    
    include_once '../../../includes/config.inc.php';
    include_once '../../../class/db.class.php';
    include_once '../../../class/main.class.php';
    include_once '../../../class/secure.class.php';
    include_once '../../../class/config.class.php';
    include_once '../../includes/header.inc.php';
    include_once 'module.class.php';
    $module = new ARTICLES();
?>
<article class="eight columns collapse-left">
    <?php $module->buildArtPreview($_SESSION['id_article']); ?>
</article>
<?php
    include_once '../../includes/footer.inc.php';
?>