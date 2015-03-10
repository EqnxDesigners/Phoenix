<section class="row wide-row page-title">
    <h1><?php getTexte('news', 'page_title'); ?></h1>
</section>
<section class="row sub-page">
    <div class="small-12 columns">
        <div id="news-masonry" class="deux-cols">
            <?php (isset($_GET['pagination']) ? the_news($_GET['pagination']) : the_news(1)); ?>
        </div>
    </div>
</section>
<section class="row sub-page">
    <div class="small-12 columns text-center">
        <?php (isset($_GET['pagination']) ? news_pagination($_GET['pagination']) : news_pagination(1)); ?>
    </div>
</section>