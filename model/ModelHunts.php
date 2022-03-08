<?php
require_once (File::build_path(array('hunt', 'Hunt.php')));

class ModelHunts extends Model{

    private $hunt_id;
    private $hunt_title;
    private $privacy;
    private $lat;
    private $long;
    private $user_id;
    protected static $object = "Hunt";
    protected static $attributs = array ('hunt_id','hunt_title','privacy','lat','long','user_id');

    function getHunt_id() {
        return $this->hunt_id;
    }

    function getHunt_title() {
        return $this->hunt_title;
    }

    function getPrivacy() {
        return $this->privacy;
    }

    function getLat() {
        return $this->lat;
    }

    function getLong() {
        return $this->long;
    }

    function getUser_id() {
        return $this->user_id;
    }

    // un constructeur
    public function __construct($hunt_id = NULL, $hunt_title = NULL,
                                $privacy = NULL,$lat = NULL , $long = NULL, $user_id = NULL) {
        if (!is_null($hunt_id) && !is_null($hunt_title)
            && !is_null($privacy) && !is_null($lat) && !is_null($long) && !is_null($user_id)) {
            $this->hunt_id = $hunt_id;
            $this->hunt_title = $hunt_title;
            $this->privacy = $privacy;
            $this->lat = $lat;
            $this->long = $long;
            $this->user_id = $user_id;
        }
    }
}




?>
