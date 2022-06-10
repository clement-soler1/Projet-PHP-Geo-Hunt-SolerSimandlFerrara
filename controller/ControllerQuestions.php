<?php

require_once File::build_path(array("model","ModelQuestions.php"));
require_once File::build_path(array("model","ModelUser.php"));

class ControllerQuestions {

    public static function create() {
        session_start();
        $usr = unserialize($_SESSION["user"]);
        $idh = ModelQuestions::getAvailableId();

        $qu = new ModelQuestions($idh,$_POST['qu_title'],$_POST['qu_text'],isset($_POST['privacy']),$_POST['lat'],$_POST['lon'],$usr->getUser_id());
        $qu->save();
    }

    public static function createquestion() {
        $controller='questions';
        $view='createquestion';
        $pagetitle='GeoHunt - questions';
        $use_mapbox = true;
        require File::build_path(array("view","view.php"));
    }
}
?>