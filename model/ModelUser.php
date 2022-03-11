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
    protected static $object = "User";
    protected static $attributs = array ('user_id','username','email','password','join_date','profile_pic','description','admin','token');
    protected static $searchKeys = array ('email');

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
    
    public function __construct($user_id = NULL, $username = NULL, $email = NULL, $password = NULL, $join_date = NULL, $profile_pic = NULL, $description = NULL, $admin = NULL, $token = NULL)
    {
        if (!is_null($user_id) && !is_null($username) && !is_null($email) && !is_null($password) && !is_null($join_date) && !is_null($profile_pic) && !is_null($description) && !is_null($admin) && !is_null($token))
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
        }
    }

    public static function getAvailableId()
    {
        $query = "SELECT getAvailableUser_ID() AS id;";
        $req = Model::$pdo->prepare($query);

        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
        return intval($result["id"]);

    }

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
            "id" => $this->id,
            "username" => $this->username,
            "email" => $this->email,
            "password" => $this->password,
            "join_date" => $this->join_date,
            "profile_pic" => $this->profile_pic,
            "description" => $this->description,
            "admin" => 1,
            "token" => $this->token,
        );
        $this->update($newAtt);
    }

    public function afficher() {

        echo '<div class="user">';
        if ($this->admin) {
            echo '<i class="material-icons iconUtility admin">font_download</i>';
        } else {
            echo '<i style="visibility: hidden;" class="material-icons iconUtility admin">font_download</i>';
        }

        echo '<p class="logUser">'. htmlspecialchars($this->username) .'</p>';
        echo '<p class="logUser">('. htmlspecialchars($this->email) .')</p>';
        echo '<i class="material-icons iconUtility icoUpt" onclick=\'updateUser("'. htmlspecialchars($this->user_id) .'")\'>create</i>';
        echo '<i class="material-icons iconUtility icoDlt" onclick=\'deleteUser("'. htmlspecialchars($this->user_id) .'")\'>delete</i>';
        echo '<i class="material-icons iconUtility icoSetAdmin" onclick=\'setUserAdmin  ("'. htmlspecialchars($this->user_id) .'")\'>font_download</i>';
        echo '</div>';
    }
}
?>
