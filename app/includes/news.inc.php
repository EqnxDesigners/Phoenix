<section class="row wide-row page-title">
    <h1><?php getTexte('news', 'page_title'); ?></h1>
</section>
<section class="row sub-page">
    <div class="small-12 columns">
        <div id="news-masonry" class="deux-cols">
            <?php the_news(); ?>
        </div>
    </div>
</section>
<section class="row sub-page">
    <div class="small-12 columns text-center">
        <ul class="pag">
            <li class="fleche prev"><a href="#"><img src="img/fleche-bleue-prev.png" alt="prev" /></a></li>
            <li><a href="#">1</a></li>
            <li class="active"><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li class="fleche next"><a href="#"><img src="img/fleche-bleue-next.png" alt="prev" /></a></li>
        </ul>
    </div>
</section>