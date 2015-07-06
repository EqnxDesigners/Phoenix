<section class="row" id="index-events">
    <div class="small-12 columns hide-for-small-only">
        <h3><?php getTexte('home-events', 'title'); ?></h3>
    </div>
    <div class="small-12 columns show-for-small-only">
        <h3><?php getTexte('home-events', 'title'); ?></h3>
    </div>
    <div class="row events-tab">

        <div class="medium-4 columns hide-for-small-only">
            <?php the_event_tabs(); ?>
        </div>

        <div class="small-12 medium-8 columns">
            <?php the_event_details(); ?>
        </div>

    </div>
    <hr/>
</section>