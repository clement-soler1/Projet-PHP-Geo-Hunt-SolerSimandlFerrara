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
        $use_mapbox = true;
        require File::build_path(array("view","view.php"));
    }

    public static function read() {
        $controller='hunts';
        $view='huntview';
        $pagetitle='piste';
        require File::build_path(array("view","view.php"));
    }

    public static function readAll() {
        session_start();
        $usr = unserialize($_SESSION["user"]);
        $my_hunts = ModelHunts::selectAll();
        $controller='hunts';
        $view='readAll';
        $pagetitle='Geo-hunt - mes pistes';
        $use_mapbox = true;
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

    public static function addQuestions() {
        $questions = ModelHunts::getUserQuestions();
        $usr = unserialize($_SESSION["user"]);
        $controller='hunts';
        $view='addQu';
        $pagetitle='ajout de question';
        require File::build_path(array("view","view.php"));
    }

    public static function getQuestions() {
        $controller='hunts';
        $results = ModelHunts::getUserQuestions();
        //var_dump($results);
    }

    public static function createlist() {
        var_dump($_POST);

        $hunt = new ModelHuntQuList($_POST['qu_id'],$_POST['hunt_id'],$_POST['qu_num']);

        $hunt->save();
    }
}
?>