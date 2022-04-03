<?php
    session_start();

    $DIR_PATH = "C:/xampp/htdocs/dev/cnam/Projet-PHP-SolerSimandlFerrara/";
    
    require_once  $DIR_PATH.'lib/File.php';
    require_once File::build_path(array("lib","Security.php"));
    require File::build_path(array("controller","routeur.php"));
?>