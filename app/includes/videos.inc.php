<?php

//Show all errors and warnings
ini_set('display_errors', 'On');
error_reporting(E_ALL);

//Load the autoloader
if(file_exists('vimeo/autoload.php')) {
    require_once('vimeo/autoload.php');
}

//Load the configuration file
if(!function_exists('json_decode')) {
    throw new Exception('<p>We could not find json_decode. json_decode is found in php 5.2 and up, but not found on many linux systems due to licensing conflicts. If you are running ubuntu try "sudo apt-get install php5-json".</p>');
}
else {
    $config = json_decode(file_get_contents('vimeo/config.json'), true);
}

if(empty($config['client_id']) || empty($config['client_secret']) || empty($config['access_token'])) {
    throw new Exception('<p>We could not locate your client id or client secret in "' . __DIR__ . '/config.json". Please create one, and reference config.json.example</p>');
}
else {
    $lib = new \Vimeo\Vimeo($config['client_id'], $config['client_secret'], $config['access_token']);
}

//----- Requêtes ------------------------------------------
$req = $lib->request('/me/albums/3413792/videos', array('sort' => 'date', 'direction' => 'desc'));
?>

<section class="row wide-row page-title">
    <h1><?php getTexte('videos', 'page_title'); ?></h1>
    <h2><?php getTexte('videos', 'page_sub-title'); ?></h2>
</section>

<section class="row sub-page sub-page-video">
    <div class="small-12 columns">
        <h2><?php echo $req['body']['data']['0']['name']; ?><br /><small><?php echo $req['body']['data']['0']['description']; ?></small></h2>
        <div class="flex-video widescreen vimeo">
            <?php $req['body']['data']['0']['embed']['color'] = '00ff00'; ?>
            <?php vimeo_player($req['body']['data']['0']); ?>
        </div>
        <div class="row">
            <div class="small-12 columns text-right">
                <?php vimeo_tags($req['body']['data']['0']['tags']); ?>
            </div>
        </div>
    </div>

    <div class="small-12 columns">
        <ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-3">
            <?php
                foreach($req['body']['data'] as $k => $video) {
                    if($k > 0) {
                        echo '<li>';
                            echo '<div class="vimeo-wraper">';
                                echo '<h3>'.$video['name'].'</h3>';
                                echo'<div class="flex-video widescreen vimeo small-vids">';
                                    vimeo_player($video);
                                echo '</div>';
                                echo '<div class="row lst-tags">';
                                    echo '<div class="small-12 columns text-right no-gutter">';
                                        echo vimeo_tags($video['tags']);
                                    echo '</div>';
                                echo '</div>';
                                echo '<div class="row vid-descr">';
                                    echo '<div class="small-12 columns text-left no-gutter">';
                                        echo $video['description'];
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</li>';
                    }
                }
            ?>
        </ul>
    </div>
</section>
