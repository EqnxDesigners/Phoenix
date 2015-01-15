<?php
//----- Fichier de configuration --------------------------
require_once dirname(__DIR__).'/config/config.inc.php';

//----- Class ---------------------------------------------
spl_autoload_register(function($class) {
    require_once dirname(__DIR__).'/class/'.$class.'.class.php';
});

//----- Fonctions -----------------------------------------
require_once dirname(__FILE__).'/functions.php';

//----- Header meta datas ---------------------------------
include_once dirname(__FILE__).'/config/header.meta.php';

//----- Templates -----------------------------------------
if(isset($_GET['token'])) {
    echo 'TOKEN : '.$_GET['token'];
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
            <div class="small-12 columns">
                <input type="text" name="societe" placeholder="Société">
            </div>
            <div class="small-2 columns">
                <select name="titre">
                    <option value="M." selected>Monsieur</option>
                    <option value="Mme">Madame</option>
                </select>
            </div>
            <div class="small-5 columns">
                <input type="text" name="nom" placeholder="Nom">
            </div>
            <div class="small-5 columns">
                <input type="text" name="prenom" placeholder="Prénom">
            </div>
            <div class="small-6 columns" >
                <input type="email" name="email" placeholder="E-mail" required="required">
            </div>
            <div class="small-6 columns">
                <input type="text" name="telephone" placeholder="Téléphone" pattern="[0-9\s]*">
            </div>
            <div class="small-6 columns">
                <input type="text" name="mobile" placeholder="Mobile" pattern="[0-9\s]*">
            </div>
            <div class="small-6 columns">
                <input type="text" name="fax" placeholder="Fax" pattern="[0-9\s]*">
            </div>
        </div>
        
        <div class="row">
            <div class="small-12 columns text-right">
                <a id="valide-account" class="button success radius">Valider</a>
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