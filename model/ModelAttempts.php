<?php
require_once (File::build_path(array('model', 'Model.php')));

class ModelAttempts extends Model{

    private $attempt_id;
    private $hunt_id;
    private $user_id;
    private $attempt_time;
    private $attempt_date;
    private $score;
    private $win;
    protected static $object = "Attempts";
    protected static $attributs = array ('attempt_id','hunt_id','user_id','attempt_time','attempt_date','score','win');
    protected static $searchKeys = array ('attempt_id');

    public function getAttemptId()
    {
        return $this->attempt_id;
    }
    
    public function getAttemptTime()
    {
        return $this->attempt_time;
    }

    public function getAttemptDate()
    {
        return $this->attempt_date;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function getWin()
    {
        return $this->win;
    }

    public function __construct($attempt_id=null, $hunt_id=null, $user_id=null, $attempt_time=null, $attempt_date=null, $score=null, $win=null)
    {
        if(!is_null($attempt_id) && !is_null($attempt_time) && !is_null($attempt_date) && !is_null($score) && !is_null($win))
        {
            $this->attempt_id = $attempt_id;
            $this->attempt_time = $attempt_time;
            $this->attempt_date = $attempt_date;
            $this->score = $score;
            $this->win = $win;
        }
    }

    public static function getAttemptsOfHunt($hunt_id) {

        $table_name = static::$object;
        //$searchKey = static::$searchKeys;



        $sql = "SELECT * FROM ".ucfirst($table_name) ." WHERE hunt_id=1 ORDER BY score DESC, attempt_time ASC";

        /*$nbAtt = count($searchKey);
        $ct = 0;

        foreach ($searchKey as $atb) {
            $ct = $ct + 1;
            $tagAtb = ":tag_".$atb;
            $sql = $sql." ".$atb."=".$tagAtb;
            if ($ct < $nbAtt) {
                $sql = $sql." AND";
            }
        }*/

        $sql = $sql.";";
        $req_prep = Model::$pdo->prepare($sql);
        $values = array();

        /*foreach ($searchKey as $atb) {
            $values[":tag_".$atb] = $params[$atb];
        }*/
        //$values[":tag_hid"] = $hunt_id;


        $req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'Model'.ucfirst($table_name));
        $obj = $req_prep->fetchAll();


        if (sizeof($obj) == 0) {
            return null;
        }

        return $obj;


    }

    public function displayAttempt() {
        //visuel to do
    }
}
?>
