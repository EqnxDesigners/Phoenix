<?php the_top_menu(); ?>

<section class="row">
<div class="col-lg-2 menu-main no-gutter">
<?php the_main_menu($_GET['module']); ?>
</div>
<div class="col-lg-10">
    <?php echo $_GET['module']; ?>
</div>
</section>

