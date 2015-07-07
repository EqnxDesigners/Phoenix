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
            <form name="form_add_events" action="modules/events/ajax.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="small-6 columns" id="form-trad-wrapper">
                        <input type="text" name="event-title" value="<?php the_value('event-title'); ?>" placeholder="Titre">
                    </div>
                    <div class="small-6 columns" id="form-trad-wrapper">
                        <input type="text" name="date-event" value="<?php the_value('date-event'); ?>" class="datepicker" placeholder="Date de l'événement">
                    </div>
                    <div class="small-1 columns" id="form-trad-wrapper">
                        <input type="number" name="event-hour" value="<?php the_value('event-hour'); ?>" placeholder="Heure">
                    </div>
                    <div class="small-1 columns text-center">
                        &nbsp;h&nbsp;
                    </div>
                    <div class="small-1 columns end">
                        <input type="number" name="event-min" value="<?php the_value('event-min'); ?>" placeholder="Minute">
                    </div>
                </div>
                <div class="row">
                    <div class="small-6 columns" id="form-trad-wrapper">
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