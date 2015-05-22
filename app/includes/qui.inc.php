<section class="row wide-row page-title">
    <h1><?php getTexte('qui', 'page_title'); ?></h1>
</section>

<?php displayAlertJob(); ?>

<section class="row sub-page">
    <h3><?php getTexte('qui', 'txt1_title'); ?></h3>
    <div class="row">
        <?php getMultiLineTexte('qui', 'txt1_para', 'text-justify'); ?>
    </div>
    <hr/>
</section>

<section class="row sub-page">
    <h3><?php getTexte('qui', 'domaine_title'); ?></h3>
    <div class="small-12 medium-4 columns text-center eqnx-sectors">
        <div class="small-12 columns wow bounceIn animated" data-wow-delay="0.1s">
            <img src="img/eqnx-acad.png" alt="Monde académique">
        </div>
        <div class="small-12 columns">
            <h4><?php getTexte('qui', 'txt2_title'); ?></h4>
        </div>
        <div class="small-12 columns">
            <?php getMultiLineTexte('qui', 'txt2_para', 'text-center'); ?>
        </div>
    </div>
    <div class="small-12 medium-4 columns text-center eqnx-sectors">
        <div class="small-12 columns wow bounceIn animated" data-wow-delay="0.5s">
            <img src="img/eqnx-health.png" alt="Domaine de la santé">
        </div>
        <div class="small-12 columns">
            <h4><?php getTexte('qui', 'txt3_title'); ?></h4>
        </div>
        <div class="small-12 columns">
            <?php getMultiLineTexte('qui', 'txt3_para', 'text-center'); ?>
        </div>
    </div>
    <div class="small-12 medium-4 columns text-center eqnx-sectors">
        <div class="small-12 columns wow bounceIn animated" data-wow-delay="0.3s">
            <img src="img/eqnx-design.png" alt="Design">
        </div>
        <div class="small-12 columns">
            <h4><?php getTexte('qui', 'txt4_title'); ?></h4>
        </div>
        <div class="small-12 columns">
            <?php getMultiLineTexte('qui', 'txt4_para', 'text-center'); ?>
        </div>
    </div>
</section>