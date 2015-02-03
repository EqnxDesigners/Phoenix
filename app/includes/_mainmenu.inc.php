<!-- MENU -->
<!--
<div data-magellan-expedition="fixed">
    <dl class="sub-nav">
        <dd><a target="#">Accueil</a></dd>
        <dd><a target="#">IS-Academia</a></dd>
        <dd><a target="#">News</a></dd>
        <dd><a target="#">Equinoxe</a></dd>
        <dd><a target="#">Contact</a></dd>
    </dl>
</div>
-->

<!--<nav>-->
<!--    <ul>-->
<!--        <li><a href="#" ><span class="icon icon-shape-planete"></span></a></li>-->
<!--        <li><a href="#">Accueil</a></li>-->
<!--        <li><a href="#">IS-Academia</a></li>-->
<!--        <li><a href="#">News</a></li>-->
<!--        <li><a href="#">Equinoxe</a></li>-->
<!--        <li target="index-footer"><a href="#">Contact</a></li>-->
<!--    </ul>-->
<!--</nav>-->

<nav id="mobile-nav" class="show-for-small-only">
    <div class="row row-block">
<!--        <div class="small-3 columns contact-menu"><img src="img/contact.png" alt="Contact" id="contact-btn" /></div>-->
        <div class="small-3 columns contact-menu"><span class="icon icon-shape-paperplane" id="contact-btn"></span></div>
        <div class="small-6 columns logo"><img src="img/eqnx-logo-s.png" alt="Equinoxe MIS Development" /></div>
<!--        <div class="small-3 columns langues-menu"><img src="img/langues.png" alt="Langues" id="langues-btn-mobile"/></div>-->
        <div class="small-3 columns langues-menu"><span class="icon icon-shape-planete" id="langues-btn-mobile"></span></div>
    </div>
</nav>

<nav id="desktop-nav" class="show-for-medium-up">
    <div class="row row-block">
        <div class="small-9 columns menu-items">
            <ul>
<!--                <li><img src="img/langues.png" alt="Langues" id="langues-btn"/></li>-->
                <li><span class="icon icon-shape-planete" id="langues-btn"></span></li>
                <li><a href="#">Accueil</a></li>
                <li><a href="#">IS-Academia</a></li>
                <li><a href="#">News</a></li>
                <li><a href="#">Equinoxe</a></li>
                <li target="index-footer"><a href="#">Contact</a></li>
            </ul>
        </div>
        <div class="small-3 columns logo"><img src="img/eqnx-logo-l.png" alt="Equinoxe MIS Development" /></div>
    </div>
</nav>

<div id="langues">
    <ul>
        <li><a href="">FR</a></li>
        <li><a href="">EN</a></li>
        <li><a href="">IT</a></li>
        <li><a href="">DE</a></li>
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
    </div>
</div>


<!--
<div class="vertical-container menu-wrap">
    <div class="header-vertical-container">
        <a id="close-button" class="close-button">Close Menu</a>
        <ul class="menu-langues">
            <li><a href="<?php echo getCurrentUrl('fr'); ?>">FR</a>
            </li>
            <li><a href="<?php echo getCurrentUrl('de'); ?>">DE</a>
            </li>
            <li><a href="<?php echo getCurrentUrl('it'); ?>">IT</a>
            </li>
            <li><a href="<?php echo getCurrentUrl('en'); ?>">EN</a>
            </li>
        </ul>
    </div>
    <nav>
        <ul class="nav-items main-nav activeNav">
            <li>
                <a href="<?php echo buildUrl('news'); ?>"><?php echo $_SESSION['trad']['mainmenu']['label_news']; ?></a>
            </li>
            <li>
                <a href="<?php echo buildUrl('isa'); ?>"><?php echo $_SESSION['trad']['mainmenu']['label_is-academia']; ?></a>
            </li>
            <li class="hide-s">
                <a href="<?php echo buildUrl('support'); ?>"><?php echo $_SESSION['trad']['mainmenu']['label_support']; ?></a>
            </li>
            <li class="hide">
                <a href="<?php echo buildUrl('videos'); ?>"><?php echo $_SESSION['trad']['mainmenu']['label_videos']; ?></a>
            </li>
            <li>
                <a href="<?php echo buildUrl('qui'); ?>"><?php echo $_SESSION['trad']['mainmenu']['label_qui']; ?></a>
            </li>
            <li>
                <a href="<?php echo buildUrl('contact'); ?>"><?php echo $_SESSION['trad']['mainmenu']['label_contact']; ?></a>
            </li>
            <li>
                <a href="<?php echo buildUrl('jobs'); ?>"><?php echo $_SESSION['trad']['mainmenu']['label_jobs']; ?></a>
            </li>
            <li class="hide">
                <a href="<?php echo buildUrl('download'); ?>"><?php echo $_SESSION['trad']['mainmenu']['label_telechargement']; ?></a>
            </li>
        </ul>
    </nav>
    <div class="footer-vertical-container">
        <div class="icon icon-shape-localisation icon-param-size-xxs icon-param-color-white"></div>
        <p class="adress">
            Equinoxe MIS Development
            <br/>Innovation Park EPFL (bât. IPE-C)
            <br/>Route Cantonale
            <br/>CH-1015 Lausanne
        </p>
        <div class="icon icon-param-size-xxs icon-param-color-white icon-shape-telephone"></div>
        <p class="phone">
            +41 21 693 89 38
        </p>
        <div class="icon icon-param-size-xxs icon-param-color-white icon-shape-paperplane"></div>
        <p class="mail">
            info@eqnx.ch
        </p>
    </div>
</div>
-->
<!-- END MENU -->