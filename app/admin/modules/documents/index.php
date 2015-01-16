<?php require_once(dirname(__FILE__).'/functions.php'); ?>

<section class="row" id="module-wrapper">
    <h1>Documents</h1>
    <nav class="row">
        <div class="small-12 columns" id="mnu-gest">
            <i class="fa fa-plus btn" role="add"></i>
            &nbsp;   
        </div>
        <div class="small-12 columns masked" id="return-to-gest">
            <i class="fa fa-arrow-left btn" role="back-to-gest"></i>
        </div>
    </nav>
    <section class="row">
        <?php display_alert(); ?>
        <div class="small-12 columns listing" id="wrapper-gestion">
            <?php the_Listing(); ?>
        </div>
        
        <div class="small-12 columns masked" id="wrapper-adding">
            <form name="form_add" action="modules/clients/ajax.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="small-12 columns">
                        <input type="text" name="societe" placeholder="Société" list="societe-in-db" autocomplete="off">
                        <?php autocomplete('societe-in-db'); ?>
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
                    <div class="small-12 columns text-right">
                        <input type="reset" class="button alert" name="clear-forms" value="Annuler">
                        <input type="submit" class="button success" name="publish" value="Ajouter">
                    </div>
                </div>
            </form>
        </div>
        
        <div class="small-12 columns masked" id="wrapper-editing">
        
        </div>
        
    </section>
</section>

<script src="modules/config/module.js"></script>
