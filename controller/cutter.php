<?php

/* A check pour mettre ce fonctionnement dans le htacces
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ /index.php?path=$1 [NC,L,QSA]
 */

//$DIR_PATH = "C:/xampp/htdocs/dev/cnam/Projet-PHP-SolerSimandlFerrara/";
$DIR_PATH = getcwd() . "/../";
require_once  $DIR_PATH.'lib/File.php';

require_once File::build_path(array("controller","ControllerUser.php"));
require_once File::build_path(array("controller","ControllerHunt.php"));
require_once File::build_path(array("controller","ControllerQuestion.php"));
require_once File::build_path(array("controller","ControllerGlobal.php"));

//here searching if it's MVC model
//$DIR_PATH_ON_SERVER = "/dev/cnam/Projet-PHP-SolerSimandlFerrara/";
$DIR_PATH_ON_SERVER = File::$localPath . "/";

$url = $_SERVER['REQUEST_URI'];
$left_url = substr($url,strlen($DIR_PATH_ON_SERVER));

$mvc_args = explode("/",$left_url);

//routing
$controller = "global";
if (isset($mvc_args[0])) {
    $controller = $mvc_args[0];
}

$controller_class = "Controller".ucfirst($controller);

if (!class_exists($controller_class)) {
    $controller_class = "ControllerGlobal";
    $controller = "global";
}

$tabAction = get_class_methods($controller_class);

$action = "read";
if (count($mvc_args) > 1 || $controller_class == "ControllerGlobal") {
    //recherche d'une action dans la suite de l'url
    $action_idx = 0;
    if ($controller_class == "ControllerGlobal") {
        $action_idx = -1;
    }
    $action_found = false;
    $p_action = "";
    do {
        $action_idx++;
        $p_action = $mvc_args[$action_idx];

        if (in_array($p_action, $tabAction)) {
            $action_found = true;
            $action = $p_action;
        }

    } while ($action_idx+1 < count($mvc_args) && !$action_found);
}

if (!in_array($action, $tabAction)) {
    //si l'action n'existe pas, print error
    $controller_class = "ControllerGlobal";//basic controlleur a changer
    $action = "error";//basic error a changer
}

//args don't work for a global (because no existance in BDD/model
if ($controller_class != "ControllerGlobal") {
    $args = array_slice($mvc_args,1,$action_idx-1);
    //labelisation des args selon la searchkey en priorite puis arg_x
    $idx = 0;
    $model_class = "Model".ucfirst($controller);
    $skey = $model_class::getSearchKeys();



    for($i = 0; $i < count($args); $i++) {
        $p_name = "args_".$i;
        if ($i < count($skey)) {
            $p_name = $skey[$i];
        }
        $_REQUEST[$p_name] = $args[$i];
    }
}



$controller_class::$action();


?>
