<?php
require_once (File::build_path(array('model', 'Model.php')));

class ModelQuestions extends Model{

    private $qu_id;
    private $qu_title;
    private $qu_text;
    private $privacy;
    private $lat;
    private $lon;
    private $user_id;
    protected static $object = "Question";
    protected static $attributs = array ('qu_id','qu_title','qu_text','privacy','lat','lon','user_id');
    protected static $searchKeys = array ('qu_title');


    function getQu_Id() {
        return $this->qu_id;
    }

    function getQu_Title() {
        return $this->qu_title;
    }

    function getQu_Text() {
        return $this->qu_text;
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

    function getUser_Id() {
        return $this->user_id;
    }

    // un constructeur
    public function __construct($qu_id = NULL, $qu_title = NULL,
                                $qu_text = NULL, $privacy = NULL,$lat = NULL , $lon = NULL, $user_id = NULL) {
        if (!is_null($qu_id) && !is_null($qu_title) && !is_null($qu_text)
            && !is_null($privacy) && !is_null($lat) && !is_null($lon) && !is_null($user_id)) {
            $this->qu_id = $qu_id;
            $this->qu_title = $qu_title;
            $this->qu_text = $qu_text;
            $this->privacy = $privacy;
            $this->lat = $lat;
            $this->lon = $lon;
            $this->user_id = $user_id;
        }
    }
}




?>
