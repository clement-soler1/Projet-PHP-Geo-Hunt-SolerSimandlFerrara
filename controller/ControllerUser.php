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

        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION["user"])) {

            $me = unserialize($_SESSION["user"]);
            if ($me->getUser_id() === $_REQUEST["user_id"] || $_SESSION["isAdmin"]) {
                $usr = ModelUser::select($_REQUEST);
                if ($usr === null) {
                    echo "This User doesn't exist";
                    //TO DO : create an error user doesn't exist
                } else {
                    require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
                }
            } else {
                ControllerGlobal::accesForbidden();
            }
        } else {
            ControllerGlobal::accesForbidden();
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
                    $_SESSION['user']= serialize($user);
                    $_SESSION['isAdmin'] = $user->isAdmin();
                    $_SESSION['login'] = $user->getUsername();

                    $team = $user->getTeam();
                    $_SESSION["asTeam"] = !(is_null($team));
                    $_SESSION['team'] = serialize($team);

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
        if (!isset($_SESSION)) {
            session_start();
        }
        $me = unserialize($_SESSION["user"]);
        if ($me->getUser_id() === $_REQUEST["user_id"] || (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'])) {
            $params['user_id'] = intval($_REQUEST['user_id']);
            $usr = ModelUser::select($params);

            $usr->delete();

            //ControllerUser::readAll();
            header("LOCATION: ". File::fileDirection("/user/readAll"));
        } else {
            ControllerGlobal::accesForbidden();
        }
    }

    public static function setAdmin() {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
            $params['user_id'] = intval($_REQUEST['user_id']);
            $usr = ModelUser::select($params);

            $usr->setAdmin();

            //ControllerUser::readAll();
            header("LOCATION: ". File::fileDirection("/user/readAll"));
        } else {
            ControllerGlobal::accesForbidden();
        }
    }

    public static function disconnect() {
        if (!isset($_SESSION)) {
            session_start();
        }

        //destruction de la session
        session_unset();
        session_destroy();
        setcookie(session_name(),'',time()-1);

        header("LOCATION: ". File::fileDirection("/"));
    }

    public static function update()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $me = unserialize($_SESSION["user"]);

        if (isset($_REQUEST['user_id'])) {
            $params['user_id'] = $_REQUEST['user_id'];
        }else
        {
            $params['user_id'] = $me->getUser_id();
        }

        if ((isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) || $me->getUser_id() == $params['login']) {

            $usr = ModelUser::select($params);
            $controller='user';
            $view='update';
            $pagetitle='Geohunt - Mon Compte';
            require File::build_path(array("view","view.php"));

        } else {
            ControllerGlobal::accesForbidden();
        }



    }

    public static function updated() {
        $params['user_id'] = intval($_REQUEST['user_id']);
        $usr = ModelUser::select($params);

        $params = $_REQUEST;
        $usr->update($params);


        header("LOCATION: ". File::fileDirection("/user/".$params['user_id']."/read"));
    }

}

?>