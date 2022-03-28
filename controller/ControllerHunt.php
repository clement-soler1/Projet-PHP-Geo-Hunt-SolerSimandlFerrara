<?php

    require_once File::build_path(array("model","ModelHunts.php"));
    require_once File::build_path(array("model","ModelAttempts.php"));
    
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

    public static function showHighscore() {
        $controller='hunt';
        $view='showHighscore';
        $pagetitle='piste';
        $scores = ModelAttempts::getAttemptsOfHunt(1);
        require File::build_path(array("view","view.php"));
    }
}
?>