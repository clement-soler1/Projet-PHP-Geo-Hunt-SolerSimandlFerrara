<?php

require_once File::build_path(array("model","ModelApi.php"));
require_once File::build_path(array("model","ModelUser.php"));
require_once File::build_path(array("model","ModelHunts.php"));
require_once File::build_path(array("lib","Security.php"));


class ControllerApi
{
    public static function getAllUsers() {
        $usrs = ModelUser::selectAll();
        $obj_usr_forJson = array();

        foreach ($usrs as $u) {
            array_push($obj_usr_forJson,$u->toArrayObject());
        }

        echo json_encode($obj_usr_forJson);

    }

    /* POST request
     * { "user_email" : "test",
         "user_password" : "pwd",
         "hunt_id" : "500",
         "rank": "1.5"
        }
     */
    public static function rankHunt() {

        //recuperation de la requete
        $requestBody = json_decode(file_get_contents('php://input'),true);

        if (!(isset($requestBody["user_mail"]) && isset($requestBody["user_password"]) && isset($requestBody["hunt_id"]) && isset($requestBody["rank"]))) {
            echo "Error : wrong request arguments";
            http_response_code(400);
        } else {

            $usr = ModelUser::getUserByMail($requestBody["user_mail"]);

            if (!is_null($usr)) {

                if ($usr->verifyPwd($requestBody["user_password"])) {

                    $params["hunt_id"] = intval($requestBody["hunt_id"]);
                    $hunt = ModelHunts::select($params);

                    if (!is_null($hunt)) {
                        $hunt->setMyRank(doubleval($requestBody["rank"]));
                        http_response_code(200);
                    } else {
                        echo "Error : this hunt doesn't exist";
                        http_response_code(400);
                    }

                } else {
                    echo "Error : wrong password";
                    http_response_code(400);
                }

            } else {
                echo "Error : can't find the user";
                http_response_code(400);
            }
        }
    }
}

?>