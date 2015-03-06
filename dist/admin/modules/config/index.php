<?php require_once(dirname(__FILE__).'/functions.php'); ?>

<section class="row" id="module-wrapper">
    <h1>Configuration</h1>
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
            <form name="form_add" action="modules/config/ajax.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="small-12 columns">
                        <input type="text" name="label" placeholder="Label / description">
                    </div>
                    <div class="small-4 columns">
                        <select name="type_var" class="type-var-select">
                            <option value="str" selected>String</option>
                            <option value="bool">Booléen</option>
                        </select>
                    </div>
                    <div class="small-8 columns" id="var_value">
                        <input type="text" name="value_var">
                    </div>
                    <div class="small-12 columns">
                        <input type="text" name="code_var" placeholder="Code de la variable">
                    </div>
                    <div class="small-12 columns text-right">
                        <input type="reset" class="button alert" name="clear-forms" value="Annuler">
                        <input type="submit" class="button success" name="publish" value="Publier">
                    </div>
                </div>
            </form>
        </div>
        
    </section>
</section>

<script src="modules/config/module.js"></script>