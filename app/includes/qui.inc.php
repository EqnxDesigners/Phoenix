<!-- CONTENT -->
<div class="content-wrap">
    <div class="row bloc-title about white wide-row">
        <div class="small-12 columns">
            <h1><?php echo $_SESSION['trad']['qui']['page_title']; ?></h1>
        </div>
        <div class="small-12 columns">
            <h2><?php echo $_SESSION['trad']['qui']['page_sub-title']; ?></h2>
        </div>
    </div>

    <div class="row bloc-description gris hide-s">
        <div class="small-12 columns">
            <h1><?php echo $_SESSION['trad']['qui']['txt1_title']; ?></h1>
        </div>
        <div class="small-12 columns">
            <?php 
                foreach($_SESSION['trad']['qui']['txt1_para'] as $k => $paragraphe) {
                    writeParagraphe($paragraphe, 'qui', 'txt1_li');
                }
            ?>
        </div>
    </div>

    <div class="row bloc-description blanc">
        <div class="small-12 columns">
            <h1><?php echo $_SESSION['trad']['qui']['txt2_title']; ?></h1>
        </div>
        <div class="row">
            <div class="small-12 medium-4 large-4 columns fiche-equipe">
                <h1><span class="nom">Plug</span> Sven</h1>
                <h2>Associé / Partner</h2>
                <p><a href="mailto:sp@eqnx.ch">sp@eqnx.ch</a>
                </p>
            </div>
            <div class="small-12 medium-4 large-4 columns fiche-equipe">
                <h1><span class="nom">Rod</span> Serge</h1>
                <h2>Associé / Partner</h2>
                <p><a href="mailto:sp@eqnx.ch">sr@eqnx.ch</a>
                </p>
            </div>
            <div class="small-12 medium-4 large-4 columns fiche-equipe">
                <h1><span class="nom">Bandeira-Duarte</span> Teresa</h1>
                <h2>Secrétaire de direction</h2>
                <p><a href="mailto:sp@eqnx.ch">tbd@eqnx.ch</a>
                </p>
            </div>
        </div>
    </div>

</div>
<!-- END CONTENT -->