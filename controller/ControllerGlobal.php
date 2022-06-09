<?php
    require_once File::build_path(array("controller","ControllerUser.php"));

class ControllerGlobal
{
    public static function error() {
        $controller='global';
        $view='error';
        $pagetitle='GeoHunt - Error 404';
        require File::build_path(array("view","view.php"));
    }

    public static function login() {
        ControllerUser::login();
    }

    public static function landing() {
        $controller='global';
        $view='landing';
        $pagetitle='GeoHunt - Landing';
        require File::build_path(array("view","view.php"));
    }
}

?>