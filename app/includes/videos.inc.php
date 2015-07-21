<?php

//Show all errors and warnings
ini_set('display_errors', 'On');
error_reporting(E_ALL);

//Load the autoloader
if(file_exists('vimeo/autoload.php')) {
    require_once('vimeo/autoload.php');
    print('<pre>Fichier autoload.php trouvé</pre>');
}

//Load the configuration file
if(!function_exists('json_decode')) {
    throw new Exception('<p>We could not find json_decode. json_decode is found in php 5.2 and up, but not found on many linux systems due to licensing conflicts. If you are running ubuntu try "sudo apt-get install php5-json".</p>');
}
else {
    $config = json_decode(file_get_contents('vimeo/config.json'), true);
    print('<pre>Configuration chargée...</pre>');
//    var_dump($config);
}

if(empty($config['client_id']) || empty($config['client_secret']) || empty($config['access_token'])) {
    throw new Exception('<p>We could not locate your client id or client secret in "' . __DIR__ . '/config.json". Please create one, and reference config.json.example</p>');
}
else {
    $lib = new \Vimeo\Vimeo($config['client_id'], $config['client_secret'], $config['access_token']);
    print('<pre>Librairie instancée avec succès...</pre>');
//    var_dump($lib);
}

//----- Requêtes ------------------------------------------
//$req = $lib->request('/tags/public/videos', array('sort' => 'created_time', 'direction' => 'asc'));
$req = $lib->request('/me/albums/3413792/videos', array('sort' => 'alphabetical', 'direction' => 'asc'));

//echo '<pre>';
//foreach($req['body']['data'] as $k => $video) {
//    echo $video['name'].'<br>';
//    echo $video['embed']['html'].'<br>';
//}
//echo '</pre>';

//echo "<p><h1>Requête</h1><pre>";
//var_dump($req);
//echo "</pre></p>";
?>

<section class="row wide-row page-title">
    <h1><?php getTexte('videos', 'page_title'); ?></h1>
</section>

<section class="row sub-page">
    <h3>Dernière vidéos</h3>
    <div class="small-12 medium-7 columns">
        <div class="flex-video widescreen vimeo">
<!--            <iframe allowfullscreen="" mozallowfullscreen="" webkitallowfullscreen="" src="http://player.vimeo.com/video/60122989?title=0&byline=0&portrait=0&color=dd243e" frameborder="0" height="240px" width="400px"></iframe>-->
            <?php
            foreach($req['body']['data'] as $k => $video) {
                echo $video['name'].'<br>';
                //echo $video['embed']['html'].'<br>';
            }
            ?>
        </div>
    </div>

    <div class="small-12 medium-5 columns">
        <span class="date">21 Octobre 2014</span>
        <h3>Titre de la vidéo</h3>
        <p>Description de la vidéo</p>
    </div>
    <div class="small-12 columns">
        <p><a class="link" title="video">Videos</a>
        </p>
    </div>
    <hr/>
</section>




<!-- CONTENT -->
<!--
<div class="content-wrap">

    <div class="row bloc-title videos white wide-row">
        <div class="small-12 columns">
            <h1>Vidéos</h1>
        </div>
    </div>

    <div class="row bloc-description main-video gris">
        <div class="small-12 medium-7 columns">
            <div class="flex-video widescreen vimeo">
                <iframe allowfullscreen="" mozallowfullscreen="" webkitallowfullscreen="" src="http://player.vimeo.com/video/60122989?title=0&byline=0&portrait=0&color=dd243e" frameborder="0" height="240px" width="400px"></iframe>
            </div>
        </div>

        <div class="small-12 medium-5 columns">
            <span class="date">21 Octobre 2014</span>
            <h3>Titre de la vidéo</h3>
            <p>Description de la vidéo</p>
        </div>
        <div class="small-12 columns">
            <p><a class="link" title="video">Videos</a>
            </p>
        </div>
    </div>

    <div class="row bloc-description blanc videos-items">
        <div class="small-12 medium-4 columns video-item">
            <div class="flex-video widescreen vimeo">
                <iframe src="http://player.vimeo.com/video/9253882?title=0&byline=0&portrait=0&color=dd243e" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="0" height="136" width="213"></iframe>
            </div>
            <h3>Titre de la vidéo</h3>
            <span class="date">21 Octobre 2014</span>
        </div>
        <div class="small-12 medium-4 columns video-item">
            <div class="flex-video widescreen vimeo">
                <iframe src="http://player.vimeo.com/video/46511270?title=0&byline=0&portrait=0&color=dd243e" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="0" height="136" width="213"></iframe>
            </div>
            <h3>Titre de la vidéo</h3>
            <span class="date">21 Octobre 2014</span>
        </div>
        <div class="small-12 medium-4 columns video-item">
            <div class="flex-video widescreen vimeo">
                <iframe src="http://player.vimeo.com/video/19489506?title=0&byline=0&portrait=0&color=dd243e" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="0" height="136" width="213"></iframe>
            </div>
            <h3>Titre de la vidéo</h3>
            <span class="date">21 Octobre 2014</span>
        </div>
    </div>

</div>
-->
<!-- END CONTENT -->