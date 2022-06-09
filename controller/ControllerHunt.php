<?php

    require_once File::build_path(array("model","ModelHunts.php"));
    require_once File::build_path(array("model","ModelAttempts.php"));
    require_once File::build_path(array("model","ModelUser.php"));
    
class ControllerHunt {

    public static function create() {

        $usr = unserialize($_SESSION["user"]);
        var_dump($usr);
        $idh = ModelHunts::getAvailableId();
        $hunt = new ModelHunts($idh,$_POST['hunt_title'],isset($_POST['privacy']),$_POST['lat'],$_POST['lon'],$usr->getUser_id());

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
        $p_a = ModelAttempts::getPreviousAttemptsOfHuntByUser(1,5);
        require File::build_path(array("view","view.php"));
    }


}
?>