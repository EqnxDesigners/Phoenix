<?php
//----- Check If Token ------------------------------------
if(!isset($_GET['token'])) {
    // Si pas de token, retour sur le site
    header("location: http://www.equinoxemis.ch");
}

//----- Fichier de configuration --------------------------
require_once dirname(__DIR__).'/config/config.inc.php';

//----- Class ---------------------------------------------
require_once dirname(__DIR__).'/class/PHPMailer/PHPMailerAutoload.php';
spl_autoload_register(function($class) {
    require_once dirname(__DIR__).'/class/'.$class.'.class.php';
});

//----- Fonctions -----------------------------------------
require_once dirname(__FILE__).'/functions.php';

//----- Header meta datas ---------------------------------
include_once dirname(__FILE__).'/config/header.meta.php';

//----- Templates -----------------------------------------
$Client = new Clients();
try {
    $client = $Client->getClientByToken($_GET['token']);
}
catch (PDOException $e) {
    $alert = $e;
}
?>

<div id="verif-box">
    <a href="http://www.equinoxemis.ch" title="Equinoxe MIS Development" target="_blank">
        <img src="images/logo_equinoxe.png" />
    </a>
    <form name="form_valid" id="form_valid" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        
        <div class="row">
            <div class="small-12 columns text-left">
                <h1>Validation du compte</h1>
            </div>
        </div>
        
        <div class="row">
            <div class="small-12 columns text-left">
                <h2>Merci de vérifier vos données.</h2>
            </div>
        </div>
        
        <div class="row">
            <div class="small-12 columns">
                <input type="text" name="societe" placeholder="Société" value="<?php echo $client->societe; ?>">
            </div>
            <div class="small-2 columns">
                <select name="titre">
                    <option value="<?php echo $client->titre; ?>" selected><?php echo ($client->nom === 'M.' ? 'Monsieur' : 'Madame'); ?></option>
                    <option value="M.">Monsieur</option>
                    <option value="Mme">Madame</option>
                </select>
            </div>
            <div class="small-5 columns">
                <input type="text" name="nom" placeholder="Nom" value="<?php echo $client->nom; ?>">
            </div>
            <div class="small-5 columns">
                <input type="text" name="prenom" placeholder="Prénom" value="<?php echo $client->prenom; ?>">
            </div>
            <div class="small-6 columns" >
                <input type="email" name="email" placeholder="E-mail" value="<?php echo $client->email; ?>" required="required">
            </div>
            <div class="small-6 columns">
                <input type="text" name="telephone" placeholder="Téléphone" value="<?php echo $client->telephone; ?>" pattern="[0-9\s]*">
            </div>
            <div class="small-6 columns">
                <input type="text" name="mobile" placeholder="Mobile" value="<?php echo $client->fax; ?>" pattern="[0-9\s]*">
            </div>
            <div class="small-6 columns">
                <input type="text" name="fax" placeholder="Fax" value="<?php echo $client->mobile; ?>" pattern="[0-9\s]*">
            </div>
        </div>
        
        <div class="row">
            <div class="small-12 columns text-left">
                <h2>Saisissez votre mot de passe dans les deux champs ci-dessous.</h2>
            </div>
        </div>
        
        <div class="row" id="validation-pwd">
            <div class="small-6 columns">
                <input type="password" name="password" placeholder="Mot de passe" id="mdp-ref">
            </div>
            <div class="small-6 columns">
                <input type="password" name="password-conf" placeholder="Confirmer le mot de passe" id="mdp-conf">
            </div>
        </div>
        
        <div class="row">
            <div class="small-12 columns text-right">
                <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                <input type="hidden" name="iditem" value="<?php echo $client->id; ?>">
                <a id="valide-account" class="button success radius" disabled>Valider</a>
            </div>
        </div>
        
    </form>
    <div class="row nav">
        <div class="col-lg-12 text-center">
            <a href="<?php echo URL_SITE; ?>" target="_self"><i class="fa fa-chevron-circle-left"></i>&nbsp;Retour sur <?php echo NAME_SITE; ?></a>
        </div>
    </div>
</div>
<div class="copyright text-center" style="margin-top: 22px;">
    &COPY; Equinoxe MIS Development | 2015
</div>

<?php
//----- Footer meta datas ---------------------------------
include_once dirname(__FILE__).'/config/footer.meta.php';
?>