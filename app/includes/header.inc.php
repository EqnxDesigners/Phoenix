<!-- HEADER -->
<header class="row wide-row">
    <div class="small-12 columns" id="main-navigation">

        <nav id="mobile-nav" class="show-for-small-only">
            <div class="row row-block">
                <div class="small-3 columns contact-menu"><span class="icon icon-shape-paperplane" id="contact-btn"></span></div>
                <div class="small-6 columns logo"><img src="img/eqnx-logo-s.png" alt="Equinoxe MIS Development" /></div>
                <div class="small-3 columns langues-menu"><span class="icon icon-shape-planete" id="langues-btn-mobile"></span></div>
            </div>
        </nav>

        <nav id="desktop-nav" class="show-for-medium-up">
            <div class="row row-block">
                <div class="small-9 columns menu-items">
                    <ul>
                        <li><span class="icon icon-shape-planete" id="langues-btn"></span></li>
                        <li><a href="#"><?php getTexte('mainmenu', 'label_accueil'); ?></a></li>
                        <li><a href="<?php echo buildUrl('isacademia'); ?>"><?php getTexte('mainmenu', 'label_is-academia'); ?></a></li>
                        <li><a href="<?php echo buildUrl('news'); ?>"><?php getTexte('mainmenu', 'label_news'); ?></a></li>
                        <li><a href="<?php echo buildUrl('equinoxe'); ?>"><?php getTexte('mainmenu', 'label_qui'); ?></a></li>
                        <li target="index-footer"><?php getTexte('mainmenu', 'label_contact'); ?></li>
                    </ul>
                </div>
                <div class="small-3 columns logo"><img src="img/eqnx-logo-l.png" alt="Equinoxe MIS Development" /></div>
            </div>
        </nav>

        <div id="langues">
            <ul>
                <li><a href="<?php echo getCurrentUrl('fr'); ?>">FR</a></li>
                <li><a href="<?php echo getCurrentUrl('en'); ?>">EN</a></li>
                <li><a href="<?php echo getCurrentUrl('it'); ?>">IT</a></li>
                <li><a href="<?php echo getCurrentUrl('de'); ?>">DE</a></li>
            </ul>
        </div>

        <div id="contact-panel" class="show-for-small-only">
            <div class="row">
                <div class="small-10 columns">
                    <h1>Nous contacter</h1>
                </div>
                <div class="small-2 columns close-item">
                    <img src="img/arrow-left.png" alt="X" id="close-contact-panel" />
                </div>
                
                <div class="small-12 medium-6 columns">
                    <div class="row coord-info">
                        <div class="small-1 columns">
                            <span class="icon icon-shape-localisation icon-param-color-white wow bounce" data-wow-delay="0.5s"></span>
                        </div>
                        <div class="small-11 columns">
                            Equinoxe MIS Development<br>
                            InnovationPark EPFL (bât. IPE-C)<br>
                            Route Cantonale<br>
                            CH-1015 Lausanne
                        </div>
                    </div>
                    <div class="row coord-info">
                        <div class="small-1 columns">
                            <span class="icon icon-shape-paperplane icon-param-color-white wow bounce" data-wow-delay="0.75s"></span>
                        </div>
                        <div class="small-11 columns">
                            <a href="mailto:info@eqnx.ch">info@eqnx.ch</a>
                        </div>
                    </div>
                    <div class="row coord-info">
                        <div class="small-1 columns">
                            <span class="icon icon-shape-telephone icon-param-color-white wow bounce" data-wow-delay="1s"></span>
                        </div>
                        <div class="small-11 columns">
                            <a href="tel:+41 21 693 89 38">+41 21 693 89 38</a>
                        </div>
                    </div>
                </div>

                <!-- formulaire conact mobile -->
                <div class="small-12 medium-6 columns show-for-small-only">
                    <form>
                        <div class="small-12 columns">
                            <div class="group">
                                <input type="text" name="nom" form-code="contact-mobile"/>
                                <label>Nom prénom</label>
                            </div>
                        </div>
                        <div class="small-12 columns">
                            <div class="group">
                                <input type="email" name="email" form-code="contact-mobile"/>
                                <label>E-mail</label>
                            </div>
                        </div>
                        <div class="small-12 columns">
                            <textarea name="message" cols="30" rows="8" placeholder="Message" form-code="contact-mobile"></textarea>
                        </div>
                        <div class="small-12 columns text-right">
                            <input type="button" value="Envoyer" class="button send-form" form-code="contact-mobile"/>
                            <span class="send-spinner" style="display:none;">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div> 
                            </span>
                        </div>
                    </form>
                </div>                

            </div>
            <div class="row">
                <div class="row wide-row" id="google-map-mobile"></div>
            </div>
        </div>
    </div>

</header>
<!-- END HEADER -->