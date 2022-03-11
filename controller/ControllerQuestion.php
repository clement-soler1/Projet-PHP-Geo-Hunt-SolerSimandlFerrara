<?php

require_once File::build_path(array("model","ModelQuestions.php"));

class ControllerQuestion {

    public static function create() {
        $qu = new ModelHunts(-1,$_REQUEST['qu_title'],$_REQUEST['qu_text'],$_REQUEST['privacy'],$_REQUEST['lat'],$_REQUEST['lon'],"");
        var_dump($qu);
        $qu->save();
    }

    public static function createquestion() {
        $controller='questions';
        $view='createquestion';
        $pagetitle='GeoHunt - questions';
        require File::build_path(array("view","view.php"));
    }
}
?>