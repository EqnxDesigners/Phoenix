<div id="login-box">
    <a href="http://www.ilights.ch" title="Propuls&eacute; par Alana" target="_blank">
        <img src="imgs/logo_ilights.png" />
    </a>
    <form name="form_login" id="form_login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <?php if(isset($alert)) { ?><div class="alert alert-danger"><?php echo $alert; ?></div><?php } ?>
        <div class="form-group">
            <label for="user_login">Identifiant</label>
            <input type="text" name="user_login" id="user_login" class="form-control" placeholder="Identifiant">
        </div>
        <div class="form-group">
            <label for="user_pass">Mot de passe</label>
            <input type="password" name="user_pass" id="user_pass" class="form-control" placeholder="Mot de passe">
        </div>
        <a id="log-me-in" class="btn btn-primary btn-block">Se connecter</a>
    </form>
    <div class="row nav">
        <div class="col-lg-12 text-center">
            <a href="<?php echo URL_SITE; ?>" target="_self"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Retour sur <?php echo NAME_SITE; ?></a>
        </div>
        <!--
        <div class="col-lg-12 text-right">
            <a href="recup_pwd.php" target="_self">Mot de passe oubli&eacute; ?</a>
        </div>
        -->
    </div>
</div>
<div class="copyright text-center" style="margin-top: 22px;">
    &COPY; iLights - Web&Design | 2013-2014
</div>