<?php

    require_once File::build_path(array("model","ModelHunts.php"));
    require_once File::build_path(array("model","ModelAttempts.php"));
    require_once File::build_path(array("model","ModelUser.php"));
    
class ControllerHunts {

    public static function create() {
        session_start();
        var_dump($_POST);

        $usr = unserialize($_SESSION["user"]);
        //var_dump($usr);
        $idh = ModelHunts::getAvailableId();
        $hunt = new ModelHunts($idh,$_POST['hunt_title'],isset($_POST['privacy']),$_POST['lat'],$_POST['lon'],$usr->getUser_id());

        $hunt->save();
    }

    public static function addhunt() {
        $controller='hunts';
        $view='createhunt';
        $pagetitle='GeoHunt - creer piste';
        require File::build_path(array("view","view.php"));
    }

    public static function read() {
        $controller='hunts';
        $view='huntview';
        $pagetitle='piste';
        require File::build_path(array("view","view.php"));
    }

    public static function readAll() {
        $my_hunts = ModelHunts::selectAll();
        $controller='hunts';
        $view='readAll';
        $pagetitle='Geo-hunt - mes pistes';
        require File::build_path(array("view","view.php"));
    }

    public static function showHighscore() {
        $controller='hunts';
        $view='showHighscore';
        $pagetitle='piste';
        $scores = ModelAttempts::getAttemptsOfHunt(1);
        $p_a = ModelAttempts::getPreviousAttemptsOfHuntByUser(1,5);
        require File::build_path(array("view","view.php"));
    }


}
?>