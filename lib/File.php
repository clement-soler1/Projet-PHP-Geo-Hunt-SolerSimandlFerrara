<?php

class File {


    public static function build_path($path_array) {
        $DS = DIRECTORY_SEPARATOR;
        $ROOT_FOLDER = __DIR__ . $DS . "..";
        return $ROOT_FOLDER. $DS . join($DS, $path_array);
    }

    public static function cssFilePath($css_file) {
        $DS = DIRECTORY_SEPARATOR;
        //$ROOT_FOLDER = __DIR__ . $DS . "..";
        $ROOT_FOLDER = 'http://' . $_SERVER['HTTP_HOST'] . '/dev/cnam/Projet-PHP-SolerSimandlFerrara' . '/assets';
        return $ROOT_FOLDER . $DS . "css" . $DS . $css_file;
    }

    public static function assetsFilePath($assets_file) {
        $DS = DIRECTORY_SEPARATOR;
        //$ROOT_FOLDER = __DIR__ . $DS . "..";
        $ROOT_FOLDER = 'http://' . $_SERVER['HTTP_HOST'] . '/dev/cnam/Projet-PHP-SolerSimandlFerrara' . '/assets';
        return $ROOT_FOLDER. $DS . $assets_file;
    }

}
?>

