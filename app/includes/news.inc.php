<section class="row wide-row page-title">
    <div class="show-for-small-only back-mobile">
        <a href="http://www.equinoxemis.ch/" target="_self">
            <span class="icon icon-shape-arrow-left icon-param-color-white"></span>
        </a>
    </div>
    <h1><?php getTexte('news', 'page_title'); ?></h1>
</section>
<section class="row sub-page hide-for-small-only">
    <div class="small-12 columns">
        <div id="news-masonry" class="deux-cols">
            <?php (isset($_GET['pagination']) ? the_news($_GET['pagination']) : the_news(1)); ?>
        </div>
    </div>
</section>
<section class="row sub-page hide-for-small-only">
    <div class="small-12 columns text-center">
        <?php (isset($_GET['pagination']) ? news_pagination($_GET['pagination']) : news_pagination(1)); ?>
    </div>
</section>

<section class="row show-for-small-only">
    <div class="small-12 columns">
        <div id="news-mobile" class="une-cols">
            <?php the_news_mobile(); ?>
        </div>
    </div>
</section>