<?php
require_once (File::build_path(array('model', 'Model.php')));

class ModelAttempts extends Model{

    private $attempt_id;
    private $attempt_time;
    private $attempt_date;
    private $score;
    private $win;
    protected static $object = "Attempt";
    protected static $attributs = array ('attempt_id','attempt_time','attempt_date','score','win');
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

    public function __construct($attempt_id, $attempt_time, $attempt_date, $score, $win)
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
}
?>
