<?php
require_once (File::build_path(array('model', 'Model.php')));

class ModelTeams extends Model{

    private $team_id;
    private $team_name;
    protected static $object = "Teams";
    protected static $attributs = array ('team_id','team_name');
    protected static $searchKeys = array ('team_id');


    function getTeam_Id() {
        return $this->team_id;
    }

    function getTeam_Name() {
        return $this->team_name;
    }

    // un constructeur
    public function __construct($team_id = NULL, $team_name = NULL) {
        if (!is_null($team_id) && !is_null($team_name)) {
            $this->team_id = $team_id;
            $this->team_name = $team_name;
        }
    }

    public static function getAvailableId()
    {
        $query = "SELECT getAvailableTeam_ID() AS id;";
        $req = Model::$pdo->prepare($query);

        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
        return intval($result["id"]);

    }

    public function addToTeam($user_id,$rank = 0) {
        try {
            $sql = "INSERT INTO teams_user(team_id, user_id, rank) VALUES (:tag_team,:tag_user,:tag_rank)";
            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                "tag_team" => $this->team_id,
                "tag_user" => $user_id,
                "tag_rank" => $rank,
            );
            $req_prep->execute($values);

        } catch(PDOException $e) {
            echo $e->getMessage(); // affiche un message d'erreur
        }
    }

    public function afficher() {
        echo '<div class="team" data-uid="'. htmlspecialchars($this->team_id) .'">';
        echo '<p class="iconUtilityTxt adminTxt">Username</p>';
        echo '<p class="logTeam">'.htmlspecialchars($this->team_name).'</p>';
        echo '<i class="material-icons iconUtility icoSetAdmin">group_add</i>';
        echo '<i class="material-icons iconUtility icoUpt">create</i>';
        echo '<i class="material-icons iconUtility icoDlt">delete</i>';
        echo '</div>';
    }


    public function getMembers() {


        //$sql = "SELECT * FROM User WHERE email=:tag_mail;";

        $sql = "SELECT * FROM User U JOIN Teams_user T ON U.user_id=T.user_id WHERE t.team_id=:tag_team;";

        $req_prep = Model::$pdo->prepare($sql);
        $values = array();

        $values[":tag_team"] = $this->team_id;

        $req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_ASSOC);
        $obj = $req_prep->fetchAll();

        if (sizeof($obj) == 0) {
            return null;
        }

        return $obj;

    }
}
?>