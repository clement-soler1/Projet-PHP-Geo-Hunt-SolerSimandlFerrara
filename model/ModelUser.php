<?php 
    require_once (File::build_path(array('model', 'Model.php')));

class ModelUser extends Model{
    
    private $login;
    private $email;
    private $password;
    private $dateNaissance;
    private $ville;
    private $codePostal;
    private $adresse;
    private $pays;
    private $nonce;
    private $admin;
    protected static $object = "User";
    protected static $attributs = array ('login','email','password','dateNaissance','ville','codePostal','adresse','pays','nonce','admin');
    protected static $searchKeys = array ('login');
    
    function getLogin() {
        return $this->login;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getDateNaissance() {
        return $this->dateNaissance;
    }

    function getVille() {
        return $this->ville;
    }

    function getCodePostal() {
        return $this->codePostal;
    }

    function getAdresse() {
        return $this->adresse;
    }

    function getPays() {
        return $this->pays;
    }

    function getNonce() {
        return $this->nonce;
    }
    
    function getAdmin() {
        return $this->admin;
    }

    
    // un constructeur
    public function __construct($login = NULL, $email = NULL,
        $pwd = NULL, $dob = NULL,$ville = NULL , $cp = NULL, $adr = NULL, $pays = NULL, $nonce = NULL, $admin = NULL) {
        if (!is_null($login) && !is_null($email) && !is_null($pwd)
                   && !is_null($dob) && !is_null($ville) && !is_null($cp) && !is_null($adr) && !is_null($pays) && !is_null($nonce) && !is_null($admin)) {
            $this->login = $login;
            $this->email = $email;
            $this->password = $pwd;
            $this->dateNaissance = $dob;
            $this->ville = $ville;
            $this->codePostal = $cp;
            $this->adresse = $adr;
            $this->pays = $pays;
            $this->nonce = $nonce;
            $this->admin = $admin;
        }
    }
    
    public function verifyPwd($pwd) {
        return ($this->password == Security::chiffrer($pwd));
    }
    
    public function isVerified() {
        return ($this->nonce == "verified");
        
    }
    
    public function setAdmin() {
        $newAtt = array (
            "login" => $this->login,
            "email" => $this->email,
            "password" => $this->password,
            "dateNaissance" => $this->dateNaissance,
            "ville" => $this->ville,
            "codePostal" => $this->codePostal,
            "adresse" => $this->adresse,
            "pays" => $this->pays,
            "nonce" => $this->nonce,
            "admin" => 1
        );
        $this->update($newAtt);
    }
    
    
}




?>
