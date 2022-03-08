<?php
require_once (File::build_path(array('model', 'Model.php')));

class ModelAccess extends Model{

    private $hunt_id;
    private $user_id;
    protected static $object = "Access";
    protected static $attributs = array ('hunt_id','user_id');
    protected static $searchKeys = array ('hunt_id');


    function getHunt_Id() {
        return $this->hunt_id;
    }

    function getUser_Id() {
        return $this->user_id;
    }

    // un constructeur
    public function __construct($hunt_id = NULL, $user_id = NULL) {
        if (!is_null($hunt_id) && !is_null($user_id)) {
            $this->hunt_id = $hunt_id;
            $this->user_id = $user_id;
        }
    }
}
?>