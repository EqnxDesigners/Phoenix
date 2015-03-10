<!DOCTYPE html>
<html>

    <head>
        <!-- BASE URL -->
        <base href="<?php echo BASE_URL; ?>" />

        <meta charset="utf-8">
        <title><?php echo PAGE_TITLE; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0" />

        <!-- Favicon-->
        <link rel="icon" type="image/png" href="img/favicon.png" />

        <!-- Styles CSS-->
        <link rel="stylesheet" type="text/css" href="css/main.min.css" />

        <!-- jquery-->
        <script type="text/javascript" src="js/main.min.js" charset="utf-8"></script>

        <!-- Google fonts -->
        <link href='http://fonts.googleapis.com/css?family=Lato:300,700,900' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,700italic,400italic' rel='stylesheet' type='text/css'>

        <!-- Google Maps -->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6oN_q0aaOgyZ9AV3h4GvdncqAp_wjcpI"></script>

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