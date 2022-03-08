<?php
require_once (File::build_path(array('access', 'Access.php')));

class ModelAccess extends Model{

    private $hunt_id;
    private $user_id;
    protected static $object = "Access";
    protected static $attributs = array ('hunt_id','user_id');

    function gethunt_id() {
        return $this->hunt_id;
    }

    function getuser_id() {
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
