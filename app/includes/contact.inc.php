<div class="row">
    <div class="small-12 columns hide-for-small-only">
        <h3><?php getTexte('home-contact', 'title'); ?></h3>
    </div>
    <div class="small-12 medium-6 columns">
        <div class="row coord-info">
            <div class="small-1 columns">
                <span class="icon icon-shape-localisation icon-param-color-white wow bounce" data-wow-delay="0.5s"></span>
            </div>
            <div class="small-11 columns">
                Equinoxe MIS Development<br>
                EPFL Innovation Park (bât. EIP-C)<br>
                Route Cantonale<br>
                CH-1015 Lausanne
            </div>
        </div>
        <div class="row coord-info">
            <div class="small-1 columns">
                <span class="icon icon-shape-mail icon-param-color-white wow bounce" data-wow-delay="0.75s"></span>
            </div>
            <div class="small-11 columns">
                <a href="mailto:info@eqnx.ch" title="adresse email">info@eqnx.ch</a>
            </div>
        </div>
        <div class="row coord-info">
            <div class="small-1 columns">
                <span class="icon icon-shape-telephone icon-param-color-white wow bounce" data-wow-delay="1s"></span>
            </div>
            <div class="small-11 columns">
                <a href="tel:+41 21 693 89 38" title="numero telephone">+41 21 693 89 38</a>
            </div>
        </div>
	    <div class="row coord-info">
            <div class="small-1 columns">
                <span class="icon icon-shape-paperplane icon-param-color-white wow bounce" data-wow-delay="1.24s"></span>
            </div>
            <div class="small-11 columns">
                <a href="http://eepurl.com/bpqXZD" target="_blank"><?php getTexte('contact', 'newsletter_link'); ?>&nbsp;</a>
            </div>
        </div>
    </div>
    
    <!-- formulaire conact descktop + tablette -->
    <div class="small-12 medium-6 columns hide-for-small-only">
        <form>
            <div class="small-12 columns">
                <div class="group">
                    <input type="text" name="nom" form-code="contact-desktop" />
                    <label><?php getTexte('home-contact', 'label-name'); ?></label>
                </div>
            </div>
            <div class="small-12 columns">
                <div class="group">
                    <input type="email" name="email" form-code="contact-desktop" />
                    <label><?php getTexte('home-contact', 'label-email'); ?></label>
                </div>
            </div>
            <div class="small-12 columns">
                <textarea name="message" cols="30" rows="8" placeholder="<?php getTexte('home-contact', 'label-message'); ?>" form-code="contact-desktop"></textarea>
            </div>
            <div class="small-12 columns text-right">
                <input type="button" value="<?php getTexte('home-contact', 'form-btn'); ?>" class="button send-form" form-code="contact-desktop"/>
                <span class="send-spinner" style="display:none;">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div> 
                </span>
            </div>
        </form>
    </div>

</div>