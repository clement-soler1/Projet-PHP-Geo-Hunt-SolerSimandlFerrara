<?php

    require_once File::build_path(array("model","ModelHunts.php"));
    require_once File::build_path(array("model","ModelAttempts.php"));
    require_once File::build_path(array("model","ModelUser.php"));
    
class ControllerHunts {

    public static function create() {
        if (!isset($_SESSION)) {
            session_start();
        }

        $usr = unserialize($_SESSION["user"]);
        $idh = ModelHunts::getAvailableId();
        $hunt = new ModelHunts($idh,$_POST['hunt_title'],isset($_POST['privacy']),$_POST['lat'],$_POST['lon'],$usr->getUser_id());

        $hunt->save();

        header("LOCATION: ". File::fileDirection("/hunts/".$idh."/addQuestions"));
    }

    public static function addhunt() {
        $controller='hunts';
        $view='createhunt';
        $pagetitle='GeoHunt - creer piste';
        $use_mapbox = true;
        require File::build_path(array("view","view.php"));
    }

    public static function read() {
        $controller='hunts';
        $view='huntview';
        $pagetitle='piste';
        require File::build_path(array("view","view.php"));
    }

    public static function readAll() {
        if (!isset($_SESSION)) {
            session_start();
        }
        $usr = unserialize($_SESSION["user"]);
        $my_hunts = ModelHunts::selectAll();
        $controller='hunts';
        $view='readAll';
        $pagetitle='Geo-hunt - mes pistes';
        $use_mapbox = true;
        require File::build_path(array("view","view.php"));
    }

    public static function showHighscore() {
        $controller='hunts';
        $view='showHighscore';
        $pagetitle='piste';
        $hunt = ModelHunts::select($_REQUEST);
        $id = $hunt->getHunt_Id();
        $scores = ModelAttempts::getAttemptsOfHunt($id);
        $p_a = ModelAttempts::getPreviousAttemptsOfHuntByUser(1,5);
        require File::build_path(array("view","view.php"));
    }

    public static function addQuestions() {
        $questions = ModelHunts::getUserQuestions();
        $hunt = ModelHunts::select($_REQUEST);
        $usr = unserialize($_SESSION["user"]);
        $controller='hunts';
        $view='addQu';
        $pagetitle='ajout de question';
        require File::build_path(array("view","view.php"));
    }

    public static function getQuestions() {
        $controller='hunts';
        $results = ModelHunts::getUserQuestions();
        //var_dump($results);
    }

    public static function createlist() {
        $hunt = ModelHunts::select($_REQUEST);
        $hunt->addQuestion($_REQUEST["qu_id"],$_REQUEST["number"]);
    }

    public static function play() {
        $hunt = ModelHunts::select($_REQUEST);
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['currentAttempt'])){
            //next question
            $attempt = unserialize($_SESSION['currentAttempt']);
            $results = $hunt->getQuestion($attempt->getNextQuestionId());
        } else {
            //generate attempt
            $ida = ModelAttempts::getAvailableId();
            $usr = unserialize($_SESSION["user"]);
            $score = 0;
            $attempt_time = date("H:i:s");
            $attempt_date = date("Y-m-d");
            $win = false;

            $attempt = new ModelAttempts($ida,$hunt->getHunt_Id(),$usr->getUser_id(),$attempt_time,$attempt_date,$score,$win);
            $_SESSION['currentAttempt'] = serialize($attempt);
            $results = $hunt->getQuestion(0);
        }

        $controller='hunts';
        $view='play';
        $pagetitle= $hunt->getHunt_Title();
        $use_mapbox = true;
        require File::build_path(array("view","view.php"));
    }

    public static function playNext() {
        $hunt = ModelHunts::select($_REQUEST);
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['currentAttempt'])){
            $attempt = unserialize($_SESSION['currentAttempt']);
            $attempt->addPoints();
            $_SESSION['currentAttempt'] = serialize($attempt);

            $nbq = $hunt->getNbQuestions();
            if ($nbq == $attempt->getNextQuestionId()) {
                //win
                $hid = $hunt -> getHunt_Id();
                $usr = unserialize($_SESSION["user"]);
                $uid = $usr -> getUser_id();
                $attempt->finish($hid,$uid);
                header("LOCATION: ". File::fileDirection("/hunts/".$hunt->getHunt_Id()."/victory"));
            } else {
                //next question
                header("LOCATION: ". File::fileDirection("/hunts/".$hunt->getHunt_Id()."/play"));
            }
        } else {

        }
    }

    public static function test() {
        $hunt = ModelHunts::select($_REQUEST);
        echo $hunt->getRankAverage();
        echo '<br>';
        echo $hunt->getMyRank();

        $hunt->setMyRank(1);
    }

    public static function victory() {
        $hunt = ModelHunts::select($_REQUEST);
        $controller='hunts';
        $view='victory';
        $pagetitle='GeoHunt - victoire';
        require File::build_path(array("view","view.php"));
    }
}
?>