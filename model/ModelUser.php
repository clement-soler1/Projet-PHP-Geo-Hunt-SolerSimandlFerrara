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
    protected static $object = "User";
    protected static $attributs = array ('user_id','username','email','password','join_date','profile_pic','description','admin');
    protected static $searchKeys = array ('username');

    function getUserId() {
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

    function getJoinDate() {
        return $this->join_date;
    }

    public function getProfilePic()
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
    
    public function __construct($user_id = NULL, $username = NULL, $email = NULL, $password = NULL, $join_date = NULL, $profile_pic = NULL, $description = NULL, $admin = NULL)
    {
        if (!is_null($user_id) && !is_null($username) && !is_null($email) && !is_null($password) && !is_null($join_date) && !is_null($profile_pic) && !is_null($description) && !is_null($admin))
        {
            $this->user_id = $user_id;
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->join_date = $join_date;
            $this->profile_pic = $profile_pic;
            $this->description = $description;
            $this->admin = $admin;
        }
    }
}
?>
