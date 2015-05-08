<!DOCTYPE html>
<html>

<head>
    <!-- BASE URL -->
    <base href="<?php echo BASE_URL; ?>" />

    <meta charset="utf-8">
    <title>
        <?php echo PAGE_TITLE; ?>&nbsp;|&nbsp;<?php echo $_SESSION['current']['page_title']; ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0" />
    <meta name="description" content="<?php echo $_SESSION['current']['meta_description']; ?>" />

    <link rel="icon" type="image/png" href="img/favicon.png" />

    <link rel="stylesheet" type="text/css" href="css/foundation.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/flickity/flickity.css" />
    <link rel="stylesheet" type="text/css" href="css/animate.css" />
    <link rel="stylesheet" type="text/css" href="assets/sweetAlert/sweet-alert.css" />
    <link rel="stylesheet" type="text/css" href="css/styles.css" />

    <!-- jquery-->
    <script type="text/javascript" src="js/jquery-1.11.1.min.js" charset="utf-8"></script>

    <!-- assets -->
    <script type="text/javascript" src="assets/foundation/foundation.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="assets/flickity/flickity.pkgd.js" charset="utf-8"></script>
    <script type="text/javascript" src="assets/masonry/jquery.masonry.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="assets/Wow/wow.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="assets/foundation/foundation.equalizer.js"></script>
    <script type="text/javascript" src="assets/mixItUp/jquery.mixitup.js"></script>
    <script type="text/javascript" src="assets/sweetAlert/sweet-alert.min.js"></script>
    <script type="text/javascript" src="assets/hammer/hammer.min.js"></script>

    <!-- JS equinoxe -->
    <script type="text/javascript" src="js/equinoxe.js" charset="utf-8"></script>

    <!-- JS mail -->
    <script type="text/javascript" src="js/eqnx_mail.js" charset="utf-8"></script>

    <!-- Police d icone -->
    <link rel="stylesheet" href="assets/icoEqnx/styles/icoEqnx-styles.css" type="text/css">
    <link rel="stylesheet" href="assets/icoEqnx/styles/icoEqnx.css">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,700,900' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,700italic,400italic' rel='stylesheet' type='text/css'>

    <!-- Google Maps -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?language=<?php echo $_SESSION['current']['lang']; ?>&key=AIzaSyA6oN_q0aaOgyZ9AV3h4GvdncqAp_wjcpI"></script>

    <!-- Google Analytics -->
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-58216966-1', 'auto');
        ga('send', 'pageview');
    </script>


</head>

<body>