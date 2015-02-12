<section class="row" id="index-news">
    <div class="small-12 columns">
        <h3>Dernières news</h3>
    </div>

    <div id="newsEqnx" class="row" data-equalizer>
        <?php the_last_news(); ?>
    </div>

    <div class="small-12 columns text-center more-info hide-for-small-only">
        <a href="<?php echo buildUrl('news'); ?>">
            Toutes les news&nbsp;<span class="icon icon-shape-fleche-droite"></span>
        </a>
    </div>
    <hr/>
</section>