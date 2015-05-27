<section class="row" id="index-news">
    <div class="small-12 columns">
        <h3><?php getTexte('home-news', 'title'); ?></h3>
    </div>

    <div id="newsEqnx" class="row deux-cols" data-equalizer>
        <?php the_last_news(); ?>
        <div class="small-12 columns text-center more-info show-for-small-only">
            <a href="<?php echo buildUrl('news'); ?>" title="page news">
                <?php getTexte('home-news', 'more-btn'); ?>&nbsp;<span class="icon icon-shape-fleche-droite"></span>
            </a>
        </div>
    </div>

    <div class="small-12 columns text-center more-info hide-for-small-only">
        <a href="<?php echo buildUrl('news'); ?>" title="page news">
            <?php getTexte('home-news', 'more-btn'); ?>&nbsp;<span class="icon icon-shape-fleche-droite"></span>
        </a>
    </div>
    <hr/>
</section>