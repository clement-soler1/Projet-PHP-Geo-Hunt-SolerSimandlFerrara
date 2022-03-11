<?php

    require_once File::build_path(array("model","ModelHunts.php"));
    
class ControllerHunt {

    public static function create() {
        $hunt = new ModelHunts(-1,$_REQUEST['hunt_title'],$_REQUEST['privacy'],$_REQUEST['lat'],$_REQUEST['lon'],"");
        var_dump($hunt);
        $hunt->save();
    }

    public static function addhunt() {
        $controller='hunt';
        $view='createhunt';
        $pagetitle='GeoHunt - piste';
        require File::build_path(array("view","view.php"));
    }

    public static function read() {
        $controller='hunt';
        $view='huntview';
        $pagetitle='piste';
        require File::build_path(array("view","view.php"));
    }


}
?>