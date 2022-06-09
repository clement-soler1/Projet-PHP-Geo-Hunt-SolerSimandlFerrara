<?php 

    require_once File::build_path(array("model","ModelUser.php"));

class ControllerUser {

    //Action / appel de vue
    public static function login() {
        $controller='user';
        $view='login';
        $pagetitle='Geo-Hunt - Log In';
        require File::build_path(array("view","view.php"));  //"redirige" vers la vue
    }

    public static function signup() {
        $controller='user';
        $view='signup';
        $pagetitle='Geo-Hunt - Sign Up';
        require File::build_path(array("view","view.php"));  //"redirige" vers la vue
    }

    public static function create() {

        $token = Security::generateRandomHex();
        $idu = ModelUser::getAvailableId();
        $user = new ModelUser($idu,$_POST['username'],$_POST['email'],Security::chiffrer($_POST['password']),date("Y-m-d"),"","",false,$token,1);

        $user->save();

        $url = 'http://' . $_SERVER['HTTP_HOST'] . File::$localPath . '/';

        $mail = '<h1>Geo-Hunt - Activation du compte</h1></br></br><p>pour activer votre compte, cliquez sur le lien suivant:</p>'.
            '<a href="'. $url .'?controller=user&action=validate&usr='.
            $user->getUsername() . '&token='. $user->getToken() .'">Activer !</a>';

        $mail = wordwrap($mail, 70, "\r\n");
        mail($user->getEmail(), 'Geo-Hunt - Activation', $mail);

        //echo pour valider en local car pa de smtp
        echo $url .'?controller=user&action=validate&usr='. $user->getUsername() . '&token='. $user->getToken();

    }

    public static function read() {
        $controller = 'user';
        $view = 'profile';
        $pagetitle = 'Geo-Hunt - Mon Profil';
        $usr = ModelUser::select($_REQUEST);
        if ($usr === null) {
            echo "This User doesn't exist";
            //TO DO : create an error user doesn't exist
        } else {
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }
    }

    public static function validate() {
        $username = $_REQUEST['usr'];
        $token = $_REQUEST['token'];

        ModelUser::validateUser($username, $token);


        $controller='user';
        $view='verified';
        $pagetitle='Geo-Hunt - Verified';
        require File::build_path(array("view","view.php"));  //"redirige" vers la vue
    }

    public static function connect() {
        $login = $_REQUEST['email'];
        $pwd = $_REQUEST['password'];

        //$param['email'] = $login;
        //$user = ModelUser::select($param);
        $user = ModelUser::getUserByMail($login);

        if (!is_null($user)) {

            $truePwd = $user->verifyPwd($pwd);
            $verified = $user->isVerified();

            if ($truePwd) {

                if ($verified) {
                    $_SESSION['user']= $user;
                    $_SESSION['isAdmin'] = $user->isAdmin();
                    $_SESSION['login'] = $user->getUsername();
                    //redirection sur le profil de l'utilisateur
                    header("LOCATION: ". File::fileDirection("/user/".$user->getUser_id()."/read"));
                } else {
                    $dataBack['email'] = $login;
                    ControllerUser::showLoginError("activation","Ce compte n'est pas vérifié, consultez vos email !",$dataBack);
                }
            } else {
                $dataBack['email'] = $login;
                ControllerUser::showLoginError("pwd","Mod de passe incorrect",$dataBack);
            }
        } else {
            $dataBack['email'] = $login;
            ControllerUser::showLoginError("mail","Email incorrect",$dataBack);
        }
    }

    public static function showLoginError($type,$message,$data) {
        $dataBack = $data;
        $errType = $type;
        $errMessage = $message;
        $controller='user';
        $view='login';
        $pagetitle='Geo-Hunt - Log In';
        require File::build_path(array("view","view.php"));  //"redirige" vers la v
    }

    public static function readAll() {
        if (/*isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']*/ true) {
            $tab_usr = ModelUser::selectAll();
            $controller='user';
            $view='readAll';
            $pagetitle='Geo-hunt - Users';
            require File::build_path(array("view","view.php"));  //"redirige" vers la vue
        } else {
            //showError
        }
    }

    public static function delete() {
        session_start();
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
            $params['user_id'] = intval($_REQUEST['user_id']);
            $usr = ModelUser::select($params);

            $usr->delete();

            //ControllerUser::readAll();
            header("LOCATION: ". File::fileDirection("/user/readAll"));
        } else {
            ControllerGlobal::error();
        }
    }

    public static function setAdmin() {
        session_start();
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
            $params['user_id'] = intval($_REQUEST['user_id']);
            $usr = ModelUser::select($params);

            $usr->setAdmin();

            //ControllerUser::readAll();
            header("LOCATION: ". File::fileDirection("/user/readAll"));
        } else {
            ControllerGlobal::error();
        }
    }

    public static function disconnect() {
        session_start();

        //destruction de la session
        session_unset();
        session_destroy();
        setcookie(session_name(),'',time()-1);

        header("LOCATION: ". File::fileDirection("/"));
    }

    /*
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
    }*/

}

?>