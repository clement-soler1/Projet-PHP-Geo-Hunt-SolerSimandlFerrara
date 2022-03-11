<?php

class ControllerGlobal
{
    public static function error() {
        $controller='global';
        $view='error';
        $pagetitle='GeoHunt - Error 404';
        require File::build_path(array("view","view.php"));
    }
}

?>