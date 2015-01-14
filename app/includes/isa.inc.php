<!-- CONTENT -->
<div class="content-wrap">
    <div class="row bloc-title isa white wide-row">
        <div class="small-12 columns">
            <h1><?php echo $_SESSION['trad']['isa']['page_title']; ?></h1>
        </div>
        <div class="small-12 columns">
            <h2><?php echo $_SESSION['trad']['isa']['page_sub-title']; ?></h2>
        </div>
    </div>

    <div class="row bloc-description gris hide-s">
        <div class="small-12 columns">
            <h1><?php echo $_SESSION['trad']['isa']['txt1_title']; ?></h1>
        </div>
        <div class="small-12 columns">
            <?php 
                foreach($_SESSION['trad']['isa']['txt1_para'] as $k => $paragraphe) {
                    writeParagraphe($paragraphe, 'isa', 'txt1_li');
                }
            ?>
        </div>
    </div>

    <div class="row bloc-infos blanc">
        <div class="row">
            <div class="small-12 columns">
                <h1><?php echo $_SESSION['trad']['isa']['isa_bref_title']; ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="small-12 medium-4 large-4 columns info">
                <div class="row">
                    <div class="small-6 medium-12 columns">
                        <img src="img/info-01.png" alt="Multi-écoles & multi-langues" />
                    </div>
                    <div class="small-6 medium-12 columns">
                        <h2><?php echo $_SESSION['trad']['isa']['isa_bref1_title']; ?></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 columns">
                        <p><?php echo $_SESSION['trad']['isa']['isa_bref1_txt']; ?></p>
                    </div>
                </div>
            </div>

            <div class="small-12 medium-4 large-4 columns info">
                <div class="row">
                    <div class="small-6 medium-12 columns">
                        <img src="img/info-02.png" alt="Multi-interfaces" />
                    </div>
                    <div class="small-6 medium-12 columns">
                        <h2><?php echo $_SESSION['trad']['isa']['isa_bref2_title']; ?></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 columns">
                        <p><?php echo $_SESSION['trad']['isa']['isa_bref2_txt']; ?></p>
                    </div>
                </div>
            </div>

            <div class="small-12 medium-4 large-4 columns info">
                <div class="row">
                    <div class="small-6 medium-12 columns">
                        <img src="img/info-03.png" alt="entièrement paramétrable" />
                    </div>
                    <div class="small-6 medium-12 columns">
                        <h2><?php echo $_SESSION['trad']['isa']['isa_bref3_title']; ?></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 columns">
                        <p><?php echo $_SESSION['trad']['isa']['isa_bref3_txt']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="small-12 medium-6 large-6 columns info">
                <div class="row">
                    <div class="small-6 medium-12 columns">
                        <img src="img/info-04.png" alt="Compatible avec les systèmes d'information" />
                    </div>
                    <div class="small-6 medium-12 columns">
                        <h2><?php echo $_SESSION['trad']['isa']['isa_bref4_title']; ?></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 columns">
                        <p><?php echo $_SESSION['trad']['isa']['isa_bref4_txt']; ?></p>
                    </div>
                </div>
            </div>

            <div class="small-12 medium-6 large-6 columns info">
                <div class="row">
                    <div class="small-6 medium-12 columns">
                        <img src="img/info-05.png" alt="à votre image" />
                    </div>
                    <div class="small-6 medium-12 columns">
                        <h2><?php echo $_SESSION['trad']['isa']['isa_bref5_title']; ?></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 columns">
                        <p><?php echo $_SESSION['trad']['isa']['isa_bref5_txt']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row bloc-mini-infos noir">
        <div class="small-12 columns">
            <h1><?php echo $_SESSION['trad']['isa']['txt2_title']; ?></h1>
        </div>
        <div class="small-12 columns">
            <ul>
                <li>
                    <img src="img/chrome-ico.png" alt="Chrome" />
                    <span class="hide-s">Google Chrome</span>
                </li>
                <li>
                    <img src="img/firefox-ico.png" alt="firefox" />
                    <span class="hide-s">Firefox</span>
                </li>
                <li>
                    <img src="img/safari-ico.png" alt="Safari" />
                    <span class="hide-s">Safari</span>
                </li>
                <li>
                    <img src="img/opera-ico.png" alt="Opera" />
                    <span class="hide-s">Opera</span>
                </li>
                <li>
                    <img src="img/Ie-ico.png" alt="Opera" />
                    <span class="hide-s">Internet Explorer</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="row bloc-description gris hide-s">
        <div class="small-12 columns">
            <h1><?php echo $_SESSION['trad']['isa']['txt3_title']; ?></h1>
        </div>
        <div class="small-12 columns">
            <?php 
                foreach($_SESSION['trad']['isa']['txt3_para'] as $k => $paragraphe) {
                    writeParagraphe($paragraphe, 'isa', 'txt3_li');
                }
            ?>
        </div>
    </div>
    <div class="row bloc-diapo blanc">
        <div class="small-12 columns medium-6 image hide-s">
            <img src="img/biblio.jpg" alt="Utilisateurs d'is-academia" />
        </div>
        <div class="small-12 columns medium-6 diapo">
            <h1><?php echo $_SESSION['trad']['isa']['txt4_title']; ?></h1>
            <div class="slick-eqnx-diapo row">
                <div>
                    <img src="img/logos_clients/logo_ehl.jpg" alt="Ecole hôtelière de Lausanne" />
                    <h3>Ecole Hôtelière de Lausanne</h3>
                </div>
                <div>
                    <img src="img/logos_clients/Logo-unine.png" alt="Université de Neuchâtel" />
                    <h3>Université de Neuchâtel</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->