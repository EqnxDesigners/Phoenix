<!-- CONTENT -->
<div class="content-wrap">
  <div class="row bloc-title contact white wide-row">
    <div class="small-12 columns">
      <h1><?php echo $_SESSION['trad']['contact']['page_title']; ?></h1>
    </div>
  </div>

  <div class="row bloc-description bloc-contact">
    <div class="small-12 medium-4 columns">
      <div class="row">
        <div class="small-12 columns">
          <h3><?php echo $_SESSION['trad']['contact']['label_rub1']; ?></h3>
          <div class="icon icon-shape-localisation icon-param-size-xxs icon-param-color-red"></div>
          <p class="adress">
            Equinoxe MIS Development
            <br>Innovation Park EPFL (bât. IPE-C)
            <br>Route Cantonale
            <br>CH-1015 Lausanne
          </p>
          <div class="icon icon-param-size-xxs icon-param-color-red icon-shape-telephone"></div>
          <p class="phone">
            <a href="tel:+41216938938">+41 21 693 89 38</a>
          </p>
          <div class="icon icon-param-size-xxs icon-param-color-red icon-shape-paperplane"></div>
          <p class="mail">
            <a href="mailto:info@eqnx.ch">info@eqnx.ch</a>
          </p>
        </div>
      </div>
    </div>
    <div class="small-12 medium-8 columns">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10981.5149473631!2d6.562703163946086!3d46.52040684226511!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000%3A0x090b5a0440403b2c!2sEPFL+Innovation+Park!5e0!3m2!1sfr!2sch!4v1420471879040" width="100%" height="450" frameborder="0" style="border:0"></iframe>
    </div>
  </div>

  <div class="row bloc-description">
    <div class="row">
      <div class="small-12 columns">
        <h3><?php echo $_SESSION['trad']['contact']['label_rub2']; ?></h3>
      </div>
    </div>

    <form class="contact" id="form_contact">
      <div class="row">
        <div class="small-12 medium-6 columns">
          <input type="text" name="nom" placeholder="<?php echo $_SESSION['trad']['contact']['placeholder1']; ?>"/>
        </div>
        <div class="small-12 medium-6 columns">
          <input type="text" name="prenom" placeholder="<?php echo $_SESSION['trad']['contact']['placeholder2']; ?>"/>
        </div>
      </div>
      <div class="row">
        <div class="large-12 columns">
          <input type="text" name="email" placeholder="<?php echo $_SESSION['trad']['contact']['placeholder3']; ?>"/>
        </div>
      </div>
      <div class="row">
        <div class="large-12 columns">
          <textarea placeholder="<?php echo $_SESSION['trad']['contact']['placeholder4']; ?>" row="10" name="message"></textarea>
        </div>
      </div>
      <div class="row">
        <div class="large-12 columns">
          <input type="button" name="contactForm" id="contactForm" value="Envoyer" />
          <input type="button" disabled="true" id="sendingButton" value="Envoi en cours" />
        </div>
      </div>
    </form>
  </div>

</div>
<!-- END CONTENT -->