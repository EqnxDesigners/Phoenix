<!-- CONTENT -->
<div class="content-wrap">
    <div class="row bloc-title support white wide-row">
        <div class="small-12 columns">
            <h1><?php echo $_SESSION['trad']['support']['page_title']; ?></h1>
        </div>
        <div class="small-12 columns">
            <h2><?php echo $_SESSION['trad']['support']['page_sub-title']; ?></h2>
        </div>
    </div>

    <div class="row bloc-description gris">
        <div class="small-12 columns">
            <h1><?php echo $_SESSION['trad']['support']['txt1_title']; ?></h1>
        </div>
        <div class="small-12 columns">
            <?php 
                foreach($_SESSION['trad']['support']['txt1_para'] as $k => $paragraphe) {
                    writeParagraphe($paragraphe, 'support', 'txt1_li');
                }
            ?>
        </div>
    </div>

    <div class="row bloc-description blanc">
        <div class="small-12 columns">
            <h1><?php echo $_SESSION['trad']['support']['txt2_title']; ?></h1>
        </div>
        <div class="small-12 columns">
            <?php 
                foreach($_SESSION['trad']['support']['txt2_para'] as $k => $paragraphe) {
                    writeParagraphe($paragraphe, 'support', 'txt2_li');
                }
            ?>
            <p>
                <a href="https://equinoxe1.epfl.ch/IS-Academia/Accueil" class="link" target="_blank">
                    <?php echo $_SESSION['trad']['support']['label_button1']; ?>
                </a>
            </p>

        </div>
    </div>


    <div class="row bloc-description gris">
        <div class="small-12 columns">
            <h1>Call-center</h1>
        </div>
        <div class="small-12 columns">
            <?php 
                foreach($_SESSION['trad']['support']['txt3_para'] as $k => $paragraphe) {
                    writeParagraphe($paragraphe, 'support', 'txt3_li');
                }
            ?>
            <p>
                <a href="https://equinoxe1.epfl.ch/support/Login.jsp" class="link" target="_blank">
                    <?php echo $_SESSION['trad']['support']['label_button2']; ?>
                </a>
            </p>
        </div>

    </div>
    <div class="row bloc-description">
        <div class="small-12 columns">
            <p class="notification">
                <?php echo $_SESSION['trad']['support']['notify1']; ?>
            </p>
        </div>
    </div>
</div>
<!-- END CONTENT -->