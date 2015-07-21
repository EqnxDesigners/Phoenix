<?php

//Show all errors and warnings
ini_set('display_errors', 'On');
error_reporting(E_ALL);

//Load the autoloader
if(file_exists('autoload.php')) {
    require_once('autoload.php');
    print('<pre>Fichier autoload.php trouvé</pre>');
}

//Load the configuration file
if(!function_exists('json_decode')) {
    throw new Exception('<p>We could not find json_decode. json_decode is found in php 5.2 and up, but not found on many linux systems due to licensing conflicts. If you are running ubuntu try "sudo apt-get install php5-json".</p>');
}
else {
    $config = json_decode(file_get_contents('config.json'), true);
    print('<pre>Configuration chargée...</pre>');
    var_dump($config);
}

if(empty($config['client_id']) || empty($config['client_secret']) || empty($config['access_token'])) {
    throw new Exception('<p>We could not locate your client id or client secret in "' . __DIR__ . '/config.json". Please create one, and reference config.json.example</p>');
}
else {
    $lib = new \Vimeo\Vimeo($config['client_id'], $config['client_secret'], $config['access_token']);
    print('<pre>Librairie instancée avec succès...</pre>');
    var_dump($lib);
}

//----- Requêtes ------------------------------------------
//$req = $lib->request('/tags/public/videos', array('sort' => 'created_time', 'direction' => 'asc'));
$req = $lib->request('/me/albums/3413792/videos', array('sort' => 'alphabetical', 'direction' => 'asc'));

echo '<pre>';
foreach($req['body']['data'] as $k => $video) {
    echo $video['name'].'<br>';
//    echo $video['embed']['html'].'<br>';
}
echo '</pre>';

//echo "<p><h1>Requête</h1><pre>";
//var_dump($req);
//echo "</pre></p>";