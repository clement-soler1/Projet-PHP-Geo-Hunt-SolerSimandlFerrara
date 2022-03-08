<?php
require_once (File::build_path(array('model', 'Model.php')));

class ModelHuntQuList extends Model{

    private $qu_id;
    private $hunt_id;
    private $qu_num;
    protected static $object = "HuntQuList";
    protected static $attributs = array ('qu_id','hunt_id','$qu_num');
    protected static $searchKeys = array ('hunt_id');


    function getQu_Id() {
        return $this->qu_id;
    }

    function getHunt_Id() {
        return $this->hunt_id;
    }

    function getQu_Num() {
        return $this->qu_num;
    }

    // un constructeur
    public function __construct($qu_id = NULL, $hunt_id = NULL, $qu_num = NULL) {
        if (!is_null($qu_id) && !is_null($hunt_id) && !is_null($qu_num)) {
            $this->qu_id = $qu_id;
            $this->hunt_id = $hunt_id;
            $this->qu_num = $qu_num;
        }
    }

}
?>