<?php
require_once (File::build_path(array('model', 'Model.php')));

class ModelHunts extends Model{

    private $hunt_id;
    private $hunt_title;
    private $privacy;
    private $lat;
    private $lon;
    private $user_id;
    protected static $object = "Hunts";
    protected static $attributs = array ('hunt_id','hunt_title','privacy','lat','lon','user_id');
    protected static $searchKeys = array ('hunt_id');


    function getHunt_Id() {
        return $this->hunt_id;
    }

    function getHunt_Title() {
        return $this->hunt_title;
    }

    function getPrivacy() {
        return $this->privacy;
    }

    function getLat() {
        return $this->lat;
    }

    function getLon() {
        return $this->lon;
    }

    function getUser_id() {
        return $this->user_id;
    }

    // un constructeur
    public function __construct($hunt_id = NULL, $hunt_title = NULL,
                                $privacy = NULL,$lat = NULL , $lon = NULL, $user_id = NULL) {
        if (!is_null($hunt_id) && !is_null($hunt_title)
            && !is_null($privacy) && !is_null($lat) && !is_null($lon) && !is_null($user_id)) {
            $this->hunt_id = $hunt_id;
            $this->hunt_title = $hunt_title;
            $this->privacy = $privacy;
            $this->lat = $lat;
            $this->lon = $lon;
            $this->user_id = $user_id;
        }
    }

    public static function getUserQuestions(){
        session_start();
        $usr = unserialize($_SESSION["user"]);

        $sql = "SELECT * FROM Questions WHERE user_id=:tag_id;";

        $req_prep = Model::$pdo->prepare($sql);
        $values = array();

        $values[":tag_id"] = $usr->getUser_id();

        $req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelQuestions');
        $obj = $req_prep->fetchAll();

        if (sizeof($obj) == 0) {
            return null;
        }

        return $obj;
    }

    public function addQuestion($quId,$quNum){
        try {
            $sql = "INSERT INTO Hunt_qu_list(qu_id, hunt_id, qu_num) VALUES (:tag_qu,:tag_hunt,:tag_num)";
            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                "tag_qu" => $quId,
                "tag_hunt" => $this->hunt_id,
                "tag_num" => $quNum,
            );
            $req_prep->execute($values);

        } catch(PDOException $e) {
            echo $e->getMessage(); // affiche un message d'erreur
        }
    }

    /*public static function getAvailableId()
    {
        $query = "SELECT getAvailableHunt_ID() AS id;";
        $req = Model::$pdo->prepare($query);

        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
        return intval($result["id"]);

    }*/

    public function getQuestion($number) {

        $sql = "SELECT Q.* FROM Questions Q JOIN Hunt_qu_list H ON Q.qu_id=H.qu_id WHERE H.hunt_id=:tag_hid AND H.qu_num=:tag_qnum;";

        $req_prep = Model::$pdo->prepare($sql);
        $values = array();

        $values[":tag_hid"] = $this->hunt_id;
        $values[":tag_qnum"] = $number;

        $req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelQuestions');
        $obj = $req_prep->fetchAll();

        if (sizeof($obj) == 0) {
            return null;
        }

        return $obj;

    }

    public function getNbQuestions() {

        $sql = "SELECT Q.* FROM Questions Q JOIN Hunt_qu_list H ON Q.qu_id=H.qu_id WHERE H.hunt_id=:tag_hid;";

        $req_prep = Model::$pdo->prepare($sql);
        $values = array();

        $values[":tag_hid"] = $this->hunt_id;

        $req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelQuestions');
        $obj = $req_prep->fetchAll();

        if (sizeof($obj) == 0) {
            return 0;
        }

        return count($obj);
    }


    public function getRankAverage() {
        $sql = "SELECT AVG(rank) FROM Hunt_rank WHERE hunt_id=:tag_hunt;";

        $req_prep = Model::$pdo->prepare($sql);
        $values = array();

        $values[":tag_hunt"] = $this->hunt_id;

        $req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_ASSOC);
        $obj = $req_prep->fetchAll();

        if (sizeof($obj) == 0) {
            return null;
        }

        //retourne null si aucun rank
        return $obj[0]["AVG(rank)"];
    }

    public function getMyRank() {
        $sql = "SELECT rank FROM Hunt_rank WHERE hunt_id=:tag_hunt AND user_id=:tag_user;";

        $req_prep = Model::$pdo->prepare($sql);
        $values = array();

        if (!isset($_SESSION)) {
            session_start();
        }
        $usr = unserialize($_SESSION["user"]);

        $values[":tag_hunt"] = $this->hunt_id;
        $values[":tag_user"] = $usr->getUser_id();

        $req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_ASSOC);
        $obj = $req_prep->fetchAll();

        if (sizeof($obj) == 0) {
            return null;
        }

        //retourne null si aucun rank
        return $obj[0]["rank"];
    }

    public function setMyRank($rank)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $usr = unserialize($_SESSION["user"]);

        $sql = "INSERT INTO Hunt_rank(hunt_id, user_id, rank) VALUES (:tag_hunt,:tag_usr,:tag_rank)";

        if (!is_null($this->getMyrank())) {
            //security if rank already made, request is an update
            $sql = "UPDATE Hunt_rank SET rank=:tag_rank WHERE hunt_id=:tag_hunt AND user_id=:tag_usr;";
        }

        try {
            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                "tag_hunt" => $this->hunt_id,
                "tag_rank" => $rank,
                "tag_usr" => $usr->getUser_id(),
            );
            $req_prep->execute($values);

        } catch (PDOException $e) {
            echo $e->getMessage(); // affiche un message d'erreur
        }
    }
}
?>