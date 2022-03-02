<?php 

    require_once File::build_path(array("model","ModelUser.php"));

class ControllerUser {

    //Action / appel de vue
    public static function login() {
        $controller='user';
        $view='login';
        $pagetitle='NoCheat - Connexion';
        require File::build_path(array("view","view.php"));  //"redirige" vers la vue
    }
    
    public static function validate() {
        $login = $_GET["login"];
        $nonce = $_GET["nonce"];
        
        ModelUser::validateUser($login, $nonce);
        
        //dans controller ou user
        $param['login'] = $login;
        $usr = ModelUser::select($param);
        $_SESSION['user']= $usr;
        $_SESSION['isAdmin'] = $usr->isAdmin();
        $_SESSION['login'] = $usr->getLogin();
        ControllerJeu::readAll();
    }
    
    public static function created() {
        $user = new ModelUser($_POST['login'],$_POST['email'],Security::chiffrer($_POST['pwd']),$_POST['dob'],$_POST['ville'],$_POST['cp'],
                $_POST['adr'],$_POST['pays'],Security::generateRandomHex(),false);
        
        $p["login"] = $_POST['login'];
        $userVerif = ModelUser::select($p);
        
        if (is_null($userVerif)) {        
        
            $user->save();

            $mail = '<h1>NoCheat - Activation du compte</h1></br></br><p>pour activer votre compte, cliquez sur le lien suivant:</p>'.
                    '<a href="http://webinfo.iutmontp.univ-montp2.fr/~solerc/NoCheat/index.php?controller=user&action=validate&login='. 
                    $user->getLogin() . '&nonce='. $user->getNonce() .'">Activer !</a>';

            $mail = wordwrap($mail, 70, "\r\n");
            mail($user->getEmail(), 'NoCheat - Activation', $mail);

            ControllerJeu::readAll();
        } else {
            $dataBack = $_POST;
            ControllerUser::showLoginError("inscription","Un utilisateur possedant ce login existe déja !",$dataBack);
        }
    }
    
    public static function connect() {
        $login = $_REQUEST['login'];
        $pwd = $_REQUEST['pwd'];
        
        $param['login'] = $login;
        $user = ModelUser::select($param);
        
        if (!is_null($user)) {
        
            $truePwd = $user->verifyPwd($pwd);
            $verified = $user->isVerified();

            if ($truePwd) {
                
                if ($verified) {                
                    $_SESSION['user']= $user;
                    $_SESSION['isAdmin'] = $user->isAdmin();
                    $_SESSION['login'] = $user->getLogin();
                    ControllerJeu::readAll();
                } else {
                    $dataBack['login'] = $login;
                    ControllerUser::showLoginError("connexion","Ce compte n'est pas vérifié, consultez vos email !",$dataBack);
                }
            } else {
                $dataBack['login'] = $login;
                ControllerUser::showLoginError("connexion","Mod de passe ou login incorrect",$dataBack);
            }
        } else {
            $dataBack['login'] = $login;
            ControllerUser::showLoginError("connexion","Mod de passe ou login incorrect",$dataBack);
        }
    }
    
    public static function showLoginError($type,$message,$data) {
        $dataBack = $data;
        $errType = $type;
        $errMessage = $message;
        $controller='user';
        $view='login';
        $pagetitle='NoCheat - Connexion';
        require File::build_path(array("view","view.php"));  //"redirige" vers la vue
    }
    
    public static function readAll() {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
            $tab_usr = ModelUser::selectAll();
            $controller='user';
            $view='readAll';
            $pagetitle='NoCheat - Users';
            require File::build_path(array("view","view.php"));  //"redirige" vers la vue
        } else {
            ControllerJeu::showError();
        }
    }
    
    public static function disconnect() {
        
        //destruction de la session
        session_unset(); 
        session_destroy();
        setcookie(session_name(),'',time()-1);
        
        ControllerJeu::readAll();
    }
    
    public static function delete() {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
            $params['login'] = $_REQUEST['login'];
            $usr = ModelUser::select($params);

            $usr->delete();

            ControllerUser::readAll();
        } else {
            ControllerJeu::showError();
        }
    }
    
    public static function setAdmin() {
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
            $params['login'] = $_REQUEST['login'];
            $usr = ModelUser::select($params);

            $usr->setAdmin();

            ControllerUser::readAll();
        } else {
            ControllerJeu::showError();
        }
    }

    public static function read() {
        if (isset($_REQUEST['login'])) {
            $params['login'] = $_REQUEST['login'];
        }else
        {
            $params['login'] = $_SESSION['login'];
        }


        $usr = ModelUser::select($params);

        if ((isset($_SESSION['admin']) && $_SESSION['admin']) || (isset($_SESSION['login']) && $_SESSION['login'] == $params['login'])) {

            $controller='user';
            $view='read';
            $pagetitle='NoCheat - Mon Compte';
            require File::build_path(array("view","view.php"));

        } else {
            ControllerJeu::showError();
        }
    }

    public static function update()
    {

        if (isset($_REQUEST['login'])) {
            $params['login'] = $_REQUEST['login'];
        }else
        {
        $params['login'] = $_SESSION['login'];
        }

        if ((isset($_SESSION['admin']) && $_SESSION['admin']) || (isset($_SESSION['login']) && $_SESSION['login'] == $params['login'])) {

            $usr = ModelUser::select($params);
            $controller='user';
            $view='update';
            $pagetitle='NoCheat - Mon Compte';
            require File::build_path(array("view","view.php"));

        } else {
            ControllerJeu::showError();
        }



    }

    public static function updated() {
        $params['login'] = $_REQUEST['login'];
        $usr = ModelUser::select($params);

        $params = $_REQUEST;
        $usr->update($params);

        ControllerUser::read();

    }

    public static function deleteMy() {
        if ((isset($_SESSION['admin']) && $_SESSION['admin']) || (isset($_SESSION['login']) && isset($_REQUEST['login']) && $_SESSION['login'] == $_REQUEST['login'])) {
            $params['login'] = $_REQUEST['login'];

            $usr = ModelUser::select($params);

            ControllerUser::disconnect();

            $usr->delete();
        }
        else {
            ControllerJeu::showError();
        }
    }

}

?>