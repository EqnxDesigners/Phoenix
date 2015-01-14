<!-- CONTENT -->
<div class="content-wrap content-accueil">

  <?php include_once dirname(__DIR__). '/includes/slideshow.inc.php'; ?>

  <div class="row inscrSeminaire whide-row" id="descriptionSeminaire">

    <!--
        <div class="row content-sem" data-equalizer>
            <div class="small-12 medium-9 columns content" data-equalizer-watch>
                <h1>Séminaire d'information IS-Academia</h1>
                <h2>EVENT 1503</h2>
                <p>Notre séminaire se tiendra le 12 mars 2014, dans nos locaux situés au PSE de 9h30 à 12h00.</p>
            </div>
            <div class="small-12 medium-3 columns link" data-equalizer-watch>
                <a href="#" alt="S'inscrire" id="show-form">S'inscrire</a>
            </div>
        </div>
-->
    <?php display_form_inscr_semin(); ?>
    <div class="row content-sem-inscr" data-equalizer>
      <form>
        <div class="small-12 medium-9 columns content" data-equalizer-watch>
          <h1>Inscription au séminaire EVENT 1503</h1>
          <input type="hidden" value="EVENT 1406" name="event"/>
          <input type="hidden" value="12 mai 2015, 09h00" name="eventDate"/>
          <input type="hidden" value="Salle Neptune, Innovation Park EPFL (bât. IPE-C), Route cantonale, CH-1015 Lausanne" name="eventPlace"/>
          <div class="small-12 medium-6 columns">
            <input type="text" name="nom" placeholder="Nom"/>
          </div>
          <div class="small-12 medium-6 columns">
            <input type="text" name="prenom" placeholder="Prénom"/>
          </div>
          <div class="small-12 column">
            <input type="text" name="email" placeholder="e-mail"/>
          </div>
        </div>
        <div class="small-12 medium-3 columns link" data-equalizer-watch>
          <div class="small-6 medium-12 columns no-padding">
            <input type="button" id="seminaireForm" name="seminaireForm" value="Envoyer" />
          </div>
          <div class="small-6 medium-12 columns no-padding">
              <a href="#" alt="S'inscrire" id="close-form">Annuler</a>
          </div>
        </div>
      </form>

    </div>
    <div class="row content-sem-inscr-valid">
      <div class="small-12 columns content">
        <h3>Inscription envoyée</h3>
        <p>Vous allez recevoir un email de confirmation de votre inscription au séminaire.</p>
      </div>
    </div>
    <div class="row content-sem-inscr-load">
      <div class="small-12 columns content">
        <h3>Envoi en cours</h3>
        <div id="ewnet-network" class="spinner">
          <div class="bounce1"></div>
          <div class="bounce2"></div>
          <div class="bounce3"></div>
        </div>
      </div>
    </div>
  </div>

  <div id="newsEqnx" class="row">
    <?php the_news(); ?>
  </div>

</div>
<!-- END CONTENT -->