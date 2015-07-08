<?php require_once(dirname(__FILE__).'/functions.php'); ?>

<section class="row" id="module-wrapper">
    <h1>Traductions</h1>
    
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
            <form name="form_add_trads" action="modules/traductions/ajax.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="small-12 columns panel">
                        <h3>Explications</h3>
                        <p class="row"><span class="small-4 columns">Lorem ipsum dolor##sit amet</span><span class="small-1 columns">=></span><span class="small-7 columns">&lt;p&gt;Lorem ipsum dolor&lt;/p&gt;&lt;p&gt;sit amet&lt;/p&gt;</span></p>
                        <p class="row"><span class="small-4 columns">Lorem ipsum dolor##</span><span class="small-1 columns">=></span><span class="small-7 columns">&lt;p&gt;Lorem ipsum dolor&lt;/p&gt;</span></p>
                        <p class="row"><span class="small-4 columns">Lorem ipsum dolor@@sit amet</span><span class="small-1 columns">=></span><span class="small-7 columns">Lorem ipsum dolor&lt;br /&gt;sit amet</span></p>
                        <p class="row"><span class="small-4 columns">Lorem %%PARAM0%% dolor %%PARAM1%% amet</span><span class="small-1 columns">=></span><span class="small-7 columns">Lorem ipsum dolor sit amet <small>("ipsum" et "sit" sont des variables passées en paramètre. Commencer la numérotation à 0)</small></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 columns" id="form-trad-wrapper">
                        <input type="text" name="code" value="<?php the_value('code'); ?>" placeholder="Code">
                    </div>
                </div>
<!--                    <div class="small-6 columns" id="form-trad-wrapper">-->
<!--                        <input type="text" name="date-event" value="--><?php //the_value('date-event'); ?><!--" class="datepicker" placeholder="Date de l'événement">-->
<!--                    </div>-->
<!--                    <div class="small-1 columns" id="form-trad-wrapper">-->
<!--                        <input type="number" name="event-hour" value="--><?php //the_value('event-hour'); ?><!--" placeholder="Heure">-->
<!--                    </div>-->
<!--                    <div class="small-1 columns text-center">-->
<!--                        &nbsp;h&nbsp;-->
<!--                    </div>-->
<!--                    <div class="small-1 columns end">-->
<!--                        <input type="number" name="event-min" value="--><?php //the_value('event-min'); ?><!--" placeholder="Minute">-->
<!--                    </div>-->
                <div class="row">
                    <?php the_trad_fields(); ?>
                </div>
                <div class="row">
                    <div class="small-6 columns small-centered" id="form-trad-wrapper">
                        <input type="submit" class="button success expand" name="add-event" value="Créer">
                    </div>
                </div>
            </form>
        </div>
        <div class="small-12 columns masked" id="wrapper-editing">
        </div>
    </section>
</section>

<script src="modules/traductions/module.js"></script>