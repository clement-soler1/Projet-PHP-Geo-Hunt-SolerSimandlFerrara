<?php

    require_once File::build_path(array("config","Conf.php"));
    
class Model {

    public static $pdo;
    
    public static function Init() {
        $hostname = Conf::getHostname();
        $database_name = Conf::getDatabase();
        $login = Conf::getLogin();
        $password = Conf::getPassword();
        
        try{
            // Connexion à la base de données            
            // Le dernier argument sert à ce que toutes les chaines de caractères 
            // en entrée et sortie de MySql soit dans le codage UTF-8
            self::$pdo = new PDO("mysql:host=$hostname;dbname=$database_name", $login, $password,
                                 array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

            // On active le mode d'affichage des erreurs, et le lancement d'exception en cas d'erreur
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            if (Conf::getDebug()) {
              echo $e->getMessage(); // affiche un message d'erreur
            } else {
              echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }
    
    public static function selectAll() {
        
        $table_name = static::$object;
      
        $rep = Model::$pdo->query('SELECT * FROM '.ucfirst($table_name));
        $rep->setFetchMode(PDO::FETCH_CLASS, 'Model'.ucfirst($table_name));
        $tab = $rep->fetchAll();

        return $tab;
  }
  
    public function save() {
        
        $table_name = static::$object;
        
        $lsAttributs = static::$attributs;
        
        $listAttributs = "(". join(",",$lsAttributs).")";
        $listTag = "(:tag_". join(",:tag_",$lsAttributs).")";
        
        $sql = "INSERT INTO ".ucfirst($table_name) ." ". $listAttributs ." VALUES " . $listTag;
        
        $req_prep = Model::$pdo->prepare($sql);
        
        $values = array();
        
        
        foreach ($lsAttributs as $val) {
            $fn_name = 'get'.ucfirst($val);
            
            $values[":tag_".$val] = $this->$fn_name();
            
        }
        
        $req_prep->execute($values);
    }
    
    public function delete() {
        $table_name = static::$object;
        
        $lsAttributs = static::$attributs;
        
        $sql = "DELETE FROM ".ucfirst($table_name) ." WHERE";
        
        $nbAtt = count($lsAttributs);
        $ct = 0;
        
        foreach ($lsAttributs as $att) {
            $ct = $ct + 1;
            $tagAtt = ":tag_".$att;
            $sql = $sql." ".$att."=".$tagAtt;
            if ($ct < $nbAtt) {
                $sql = $sql." AND";
            }   
        }
        
        $sql = $sql.";";
        
        $req_prep = Model::$pdo->prepare($sql);
        
        $values = array();
        
        
        foreach ($lsAttributs as $val) {
            $fn_name = 'get'.ucfirst($val);
            
            $values[":tag_".$val] = $this->$fn_name();  
            
        }
        
        $req_prep->execute($values);
    }
    
    public static function select($params) {
        $table_name = static::$object;       
        $searchKey = static::$searchKeys;
        
        $sql = "SELECT * FROM ".ucfirst($table_name) ." WHERE";
        
        $nbAtt = count($searchKey);
        $ct = 0;
        
        foreach ($searchKey as $atb) {
            $ct = $ct + 1;
            $tagAtb = ":tag_".$atb;
            $sql = $sql." ".$atb."=".$tagAtb;
            if ($ct < $nbAtt) {
                $sql = $sql." AND";
            }
        }
        
        $sql = $sql.";"; 
        $req_prep = Model::$pdo->prepare($sql);
        $values = array();

        foreach ($searchKey as $atb) {
            $values[":tag_".$atb] = $params[$atb];
        }
        
        $req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'Model'.ucfirst($table_name));
        $obj = $req_prep->fetchAll();
        
        if (sizeof($obj) == 0) {
            return null;
        }

        return $obj[0];
        
    }
    
    public function update($newAtt) {
        $table_name = static::$object;
        
        $lsAttributs = static::$attributs;
        
        $sql = "UPDATE ".ucfirst($table_name) ." SET";
        
        $nbAtt = count($lsAttributs);
        $ct = 0;
        
        foreach ($lsAttributs as $att) {
            $ct = $ct + 1;
            $tagAtt = ":tag1_".$att;
            $sql = $sql." ".$att."=".$tagAtt;
            if ($ct < $nbAtt) {
                $sql = $sql.", ";
            }   
        }
        
        $sql = $sql." WHERE";
        
        $ct2 = 0;
        
        foreach ($lsAttributs as $att) {
            $ct2 = $ct2 + 1;
            $tagAtt = ":tag2_".$att;
            $sql = $sql." ".$att."=".$tagAtt;
            if ($ct2 < $nbAtt) {
                $sql = $sql." AND ";
            }   
        }
        
        $sql = $sql.";";
        $req_prep = Model::$pdo->prepare($sql);
        $values = array();
        
        foreach ($lsAttributs as $atb) {
            $values[":tag1_".$atb] = $newAtt[$atb];
        }
        
        foreach ($lsAttributs as $val) {
            $fn_name = 'get'.ucfirst($val);
            
            $values[":tag2_".$val] = $this->$fn_name();  
            
        }
        
        $req_prep->execute($values);
        
        
    }

    public static function getSearchKeys() {
        return static::$searchKeys;
    }


    public static function getAvailableId()
    {
        $id = rand(1, 99999);
        $table_name = static::$object;
        $searchKey = static::$searchKeys;

        $sql = 'SELECT * FROM '.ucfirst($table_name) .' WHERE';
        $nbAtt = count($searchKey);
        $ct = 0;

        foreach ($searchKey as $atb) {
            $ct = $ct + 1;
            $tagAtb = ":tag_".$atb;
            $sql = $sql." ".$atb."=".$tagAtb;
            if ($ct < $nbAtt) {
                $sql = $sql." AND";
            }
        }

        $sql = $sql.";";
        $req_prep = Model::$pdo->prepare($sql);
        $values = array();

        foreach ($searchKey as $atb) {
            $values[":tag_".$atb] = $id;
        }

        $req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'Model'.ucfirst($table_name));
        $obj = $req_prep->fetchAll();

        if (sizeof($obj) == 0) {
            return $id;
        } else {
            return static::getAvailableId();
        }
    }

    public function toArrayObject() {
        $json_array = array();

        $lsAttributs = static::$attributs;


        foreach ($lsAttributs as $val) {
            $fn_name = 'get'.ucfirst($val);

            $json_array[$val] = $this->$fn_name();

        }

        return $json_array;

    }
      
}
  


Model::Init();

?>