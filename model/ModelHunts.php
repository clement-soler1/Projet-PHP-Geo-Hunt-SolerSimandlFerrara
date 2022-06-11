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
    protected static $searchKeys = array ('hunt_title');


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

    /*public static function getAvailableId()
    {
        $query = "SELECT getAvailableHunt_ID() AS id;";
        $req = Model::$pdo->prepare($query);

        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
        return intval($result["id"]);

    }*/
}
?>