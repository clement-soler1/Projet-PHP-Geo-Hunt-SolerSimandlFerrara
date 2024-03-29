<?php
//require_once File::build_path(array("lib","File.php"));
//require_once File::build_path(array("controller","ControllerJeu.php"));
require_once File::build_path(array("controller","ControllerUser.php"));
require_once File::build_path(array("controller","ControllerHunts.php"));
require_once File::build_path(array("controller","ControllerQuestions.php"));
require_once File::build_path(array("controller","ControllerGlobal.php"));
require_once File::build_path(array("controller","ControllerTeams.php"));
require_once File::build_path(array("controller","ControllerApi.php"));


if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
} else {
    if ( isset($_SESSION['user'])) {
        $action = "landing";
    } else {
        $action = "landing";
    }
}

if (isset($_REQUEST['controller'])) {
    $controller = $_REQUEST['controller'];
} else {
    $controller = 'global';//basic controlleur a changer
}

$controller_class = "Controller".ucfirst($controller);

if(class_exists($controller_class)) {
    $tabAction = get_class_methods($controller_class);
    if (!in_array($action, $tabAction)) {
        //si l'action n'existe pas, print error
        $controller_class = "ControllerGlobal";//basic controlleur a changer
        $action = "error";//basic error a changer
    }

    $controller_class::$action();
} else {
    ControllerGlobal::error();
    //basic error (404 : controller doesn't exist)
}
 
?>
