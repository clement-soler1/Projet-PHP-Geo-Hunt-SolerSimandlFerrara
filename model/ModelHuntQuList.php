<?php
require_once (File::build_path(array('huntqulist', 'HuntQuList.php')));

class ModelHuntQuList extends Model{

    private $qu_id;
    private $hunt_id;
    private $qu_num;
    protected static $object = "HuntQuList";
    protected static $attributs = array ('qu_id','hunt_id','$qu_num');
    protected static $searchKeys = array ('huntQuList');


    function getqu_id() {
        return $this->qu_id;
    }

    function gethunt_id() {
        return $this->hunt_id;
    }

    function getqu_num() {
        return $this->qu_num;
    }

    // un constructeur
    public function __construct($qu_id = NULL, $hunt_id = NULL, $qu_num = NULL) {
        if (!is_null($qu_id) && !is_null($hunt_id)) {
            $this->qu_id = $qu_id;
            $this->hunt_id = $hunt_id;
            $this->qu_num = $qu_num;
        }
    }

}




?>
