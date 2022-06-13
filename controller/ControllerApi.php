<?php

require_once File::build_path(array("model","ModelApi.php"));
require_once File::build_path(array("model","ModelUser.php"));

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
}

?>