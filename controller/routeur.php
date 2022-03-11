<?php
//require_once File::build_path(array("lib","File.php"));
//require_once File::build_path(array("controller","ControllerJeu.php"));
require_once File::build_path(array("controller","ControllerUser.php"));

if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
} else {
    $action = "login";
}

if (isset($_REQUEST['controller'])) {
    $controller = $_REQUEST['controller'];
} else {
    $controller = 'user';//basic controlleur a changer
}

$controller_class = "Controller".ucfirst($controller);

if(class_exists($controller_class)) {
    $tabAction = get_class_methods($controller_class);
    if (!in_array($action, $tabAction)) {
        //si l'action n'existe pas, print error
        //basic error (404 : action doesn't exist)
        $controller_class = "ControllerJeu";//basic controlleur a changer
        $action = "showError";//basic error a changer
    } else {
        $controller_class::$action();
    }
} else {
    //ControllerJeu::showError();
    //basic error (404 : controller doesn't exist)
}
 
?>
