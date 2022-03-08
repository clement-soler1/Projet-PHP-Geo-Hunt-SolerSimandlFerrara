<?php
require_once (File::build_path(array('teams', 'Teams.php')));

class ModelTeams extends Model{

    private $team_id;
    private $user_id;
    protected static $object = "Team";
    protected static $attributs = array ('team_id','user_id');
    protected static $searchKeys = array ('team');


    function getteam_id() {
        return $this->team_id;
    }

    function getuser_id() {
        return $this->user_id;
    }

    // un constructeur
    public function __construct($team_id = NULL, $user_id = NULL) {
        if (!is_null($team_id) && !is_null($user_id)) {
            $this->team_id = $team_id;
            $this->user_id = $user_id;
        }
    }

}




?>
