<!DOCTYPE html>
<html lang="<?php echo $_SESSION['current']['lang']; ?>">

<head>
    <!-- BASE URL -->
    <base href="<?php echo BASE_URL; ?>" />

    <meta charset="utf-8">
    <title>
        <?php the_title(); ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0" />
    <meta name="description" lang="<?php echo $_SESSION['current']['lang']; ?>" content="<?php echo $_SESSION['current']['meta_description']; ?>" />
    <meta name="keywords" lang="<?php echo $_SESSION['current']['lang']; ?>" content="is-academia,gestion,academique,medical,management,application,design,webdesigne,epfl" />
    <meta http-equiv="content-language" content="fr, en, de, it">
    <meta name="identifier-url" content="http://www.equinoxemis.ch/">
    <meta name="google-site-verification" content="LSylobbt-Ro1Sjlu06vKRJOMQmll4PRsaUyUisJDjOg" />

    <link rel="canonical" href="http://www.equinoxemis.ch" />
    <link rel="icon" type="image/png" href="img/favicon.png" />

    <link rel="stylesheet" type="text/css" href="css/foundation.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/flickity/flickity.css" />
    <link rel="stylesheet" type="text/css" href="css/animate.css" />
    <link rel="stylesheet" type="text/css" href="assets/sweetAlert/sweet-alert.css" />
    <link rel="stylesheet" type="text/css" href="css/styles.css" />

    <!-- Police d icone -->
    <link rel="stylesheet" href="assets/icoEqnx/styles/icoEqnx-styles.css" type="text/css">
    <link rel="stylesheet" href="assets/icoEqnx/styles/icoEqnx.css">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,700,900' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,700italic,400italic' rel='stylesheet' type='text/css'>

</head>

<body>