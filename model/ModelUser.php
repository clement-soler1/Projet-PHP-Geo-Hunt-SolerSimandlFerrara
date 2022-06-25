<?php 
    require_once (File::build_path(array('model', 'Model.php')));

class ModelUser extends Model{
    
    private $user_id;
    private $username;
    private $email;
    private $password;
    private $join_date;
    private $profile_pic;
    private $description;
    private $admin;
    private $token;
    private $enabled;
    protected static $object = "User";
    protected static $attributs = array ('user_id','username','email','password','join_date','profile_pic','description','admin','token','enabled');
    protected static $searchKeys = array ('user_id');

    function getUser_id() {
        return $this->user_id;
    }

    function getUsername(){
        return $this->username;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getJoin_date() {
        return $this->join_date;
    }

    public function getProfile_pic()
    {
        return $this->profile_pic;
    }

    public function getDescription()
    {
        return $this->description;
    }

    function getAdmin() {
        return $this->admin;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getEnabled()
    {
        return $this->enabled;
    }
    
    public function __construct($user_id = NULL, $username = NULL, $email = NULL, $password = NULL, $join_date = NULL, $profile_pic = NULL, $description = NULL, $admin = NULL, $token = NULL, $enabled = NULL)
    {
        if (!is_null($user_id) && !is_null($username) && !is_null($email) && !is_null($password) && !is_null($join_date) && !is_null($profile_pic) && !is_null($description) && !is_null($admin) && !is_null($token) && !is_null($enabled))
        {
            $this->user_id = $user_id;
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->join_date = $join_date;
            $this->profile_pic = $profile_pic;
            $this->description = $description;
            $this->admin = $admin;
            $this->token = $token;
            $this->enabled = $enabled;
        }
    }

    /*public static function getAvailableId()
    {
        $query = "SELECT getAvailableUser_ID() AS id;";
        $req = Model::$pdo->prepare($query);

        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
        return intval($result["id"]);


    }*/

    public static function validateUser($username,$token) {

        try {
            $sql = "UPDATE User SET token='verified' WHERE username=:tag_username AND token=:tag_token;";
            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                "tag_username" => $username,
                "tag_token" => $token,
            );
            $req_prep->execute($values);

        } catch(PDOException $e) {
            echo $e->getMessage(); // affiche un message d'erreur
        }

    }

    public function verifyPwd($pwd) {
        return ($this->password == Security::chiffrer($pwd));
    }

    public function isVerified() {
        return ($this->token == "verified");
    }

    public function isAdmin() {
        return $this->admin;
    }

    public function setAdmin() {
        $newAtt = array (
            "user_id" => $this->user_id,
            "username" => $this->username,
            "email" => $this->email,
            "password" => $this->password,
            "join_date" => $this->join_date,
            "profile_pic" => $this->profile_pic,
            "description" => $this->description,
            "admin" => $this->admin,
            "token" => $this->token,
            "enabled" => $this->enabled
        );
        $this->update($newAtt);
    }

    public function afficher() {

        echo '<div class="user" data-uid="'. htmlspecialchars($this->user_id) .'">';
        if ($this->admin) {
            echo '<i class="material-icons iconUtility admin">font_download</i>';
        } else {
            echo '<i style="visibility: hidden;" class="material-icons iconUtility admin">font_download</i>';
        }
        //echo $this->user_id;

        echo '<p class="logUser">'. htmlspecialchars($this->username) .'</p>';
        echo '<p class="logUser">'. htmlspecialchars($this->email) .'</p>';
        echo '<i class="material-icons iconUtility icoUpt">create</i>';
        echo '<i class="material-icons iconUtility icoDlt">delete</i>';
        echo '<i class="material-icons iconUtility icoSetAdmin">font_download</i>';
        echo '</div>';
    }//File::fileDirection("/user/readAll")

    public static function getUserByMail($mail) {


        $sql = "SELECT * FROM User WHERE email=:tag_mail;";

        $req_prep = Model::$pdo->prepare($sql);
        $values = array();

        $values[":tag_mail"] = $mail;

        $req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUser');
        $obj = $req_prep->fetchAll();

        if (sizeof($obj) == 0) {
            return null;
        }

        return $obj[0];
    }

    public static function getUserById($id) {


        $sql = "SELECT * FROM User WHERE user_id=:tag_id;";

        $req_prep = Model::$pdo->prepare($sql);
        $values = array();

        $values[":tag_id"] = $id;

        $req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUser');
        $obj = $req_prep->fetchAll();

        if (sizeof($obj) == 0) {
            return null;
        }

        return $obj[0];
    }

    public function getTeam() {
        $sql = "SELECT T.* FROM Teams T JOIN Teams_user TU ON TU.team_id=T.team_id WHERE TU.user_id=:tag_user;";

        $req_prep = Model::$pdo->prepare($sql);
        $values = array();

        $values[":tag_user"] = $this->user_id;

        $req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelTeams');
        $obj = $req_prep->fetchAll();

        if (sizeof($obj) == 0) {
            return null;
        }

        return $obj[0];
    }
}
?>
