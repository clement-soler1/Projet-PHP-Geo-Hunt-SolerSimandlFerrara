<?php
require_once File::build_path(array("model","ModelTeams.php"));

class ControllerTeams
{

    public static function create() {
        $controller='teams';
        $view='create';
        $pagetitle='GeoHunt - Créer une équipe';
        require File::build_path(array("view","view.php"));
    }

    public static function created() {
        //var_dump($_POST);
        if (session_status() != PHP_SESSION_ACTIVE ) {
            session_start();
        }

        $team = new ModelTeams(ModelTeams::getAvailableId(),$_POST["team_name"]);

        $team->save();
        $usr = unserialize($_SESSION["user"]);
        $team->addToTeam($usr->getUser_id(),1);
    }

    public static function readAll() {
        $controller='teams';
        $view='readAll';
        $pagetitle='GeoHunt - Equipes';

        $tab_team = ModelTeams::selectAll();

        require File::build_path(array("view","view.php"));
    }

    public static function read() {
        $controller = 'teams';
        $view = 'read';
        $pagetitle = 'Geo-Hunt - Mon équipe';
        $team = ModelTeams::select($_REQUEST);
        $members = $team->getMembers();
        if ($team === null) {
            echo "This Team doesn't exist";
            //TO DO : create an error user doesn't exist
        } else {
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }
    }

}

?>