<section class="row menu-top">
    <div class="col-lg-4">
        <a href="<?php echo URL_SITE; ?>" target="_self"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Retour sur <?php echo NAME_SITE; ?></a>
    </div>
    <div class="col-lg-4 text-center">
        Connecté en tant que : <strong><?php echo $_SESSION['user']['user_name']; ?></strong>
    </div>
    <div class="col-lg-4 text-right">
        <a href="logout.php">Logout</a>
    </div>
</section>