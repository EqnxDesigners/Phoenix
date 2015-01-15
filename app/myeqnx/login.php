<div id="verif-box">
    <a href="http://www.equinoxemis.ch" title="Equinoxe MIS Development" target="_blank">
        <img src="images/logo_equinoxe.png" />
    </a>
    <form name="form_login" id="form_login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <?php if(isset($alert)) { ?><div class="alert alert-danger"><?php echo $alert; ?></div><?php } ?>
        
        <div class="row">
            <div class="small-12 columns">
                <input type="text" name="user_login" id="user_login" placeholder="E-mail">
            </div>
        </div>
        
        <div class="row">
            <div class="small-12 columns">
                <input type="password" name="user_password" id="user_password" placeholder="Mot de passe" autocomplete="off">
            </div>
        </div>
        
        <div class="row">
            <div class="small-12 columns">
                <a id="log-me-in" class="button radius expand">Se connecter</a>
            </div>
        </div>
        
    </form>
    <div class="row nav">
        <div class="col-lg-12 text-center">
            <a href="<?php echo URL_SITE; ?>" target="_self"><i class="fa fa-chevron-circle-left"></i>&nbsp;Retour sur <?php echo NAME_SITE; ?></a>
        </div>
        <div class="col-lg-12 text-center">
            <a href="recup_pwd.php" target="_self">Mot de passe oubli&eacute; ?</a>
        </div>
    </div>
</div>
<div class="copyright text-center" style="margin-top: 22px;">
    &COPY; Equinoxe MIS Development | 2014-2015
</div>