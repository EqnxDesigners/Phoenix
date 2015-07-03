<?php require_once(dirname(__FILE__).'/functions.php'); ?>

<section class="row" id="module-wrapper">
    <h1>Events</h1>
    
    <nav class="row">
        <div id="mnu-gest">
            <div class="small-6 columns">
                <i class="fa fa-plus btn" role="add"></i>
            </div>
            <div class="small-6 columns">
                &nbsp;
            </div>
        </div>
        <div class="masked" id="return-to-gest">
            <div class="small-6 columns">
                <i class="fa fa-arrow-left btn" role="back-to-gest"></i>
            </div>
        </div>
    </nav>
    
    <section class="row">
        <?php display_alert(); ?>
        <div class="small-12 columns listing" id="wrapper-gestion">
            <?php the_Listing(); ?>
        </div>
        <div class="small-12 columns masked" id="wrapper-adding">
            <form name="form_add_news" action="modules/news/ajax.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="small-9 columns" id="form-trad-wrapper">
                        <?php the_trad_fields(); ?>
                    </div>
                    <div class="small-3 columns">
                        <div class="row">
                            <div class="small-12 columns">
                                <?php select_lang(); ?>
                            </div>
                            <div class="small-12 columns">
                                <input type="checkbox" name="idem-all-lang" id="idem-all-lang">
                                <label>Idem dans toutes les langues</label>
                            </div>

                            <div class="small-12 columns">
                                <input type="text" name="date-diffusion" class="datepicker" placeholder="Date de diffusion">
                            </div>
                            <div class="small-12 columns">
                                <input type="text" name="date-revocation" class="datepicker" placeholder="Date de révocation">
                            </div>
                            <div class="small-12 columns">
                                <label for="news-img">Ajouter une image</label>
                                <input type="file" name="news-img">
                            </div>
                            <div class="small-6 columns">
                                <input type="reset" class="button alert expand" name="clear-forms" value="Annuler">
                            </div>
                            <div class="small-6 columns">
                                <input type="submit" class="button expand" name="save-news" value="Enregistrer">
                            </div>
                            <div class="small-12 columns">
                                <input type="submit" class="button success expand" name="publish-news" value="Publier">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="small-12 columns masked" id="wrapper-editing">
        </div>
    </section>
</section>

<script src="modules/news/module.js"></script>