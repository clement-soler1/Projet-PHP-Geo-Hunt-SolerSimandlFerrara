<?php
    session_start();

    $DIR_PATH = getcwd() . '/';

    require_once  $DIR_PATH.'lib/File.php';
    require_once File::build_path(array("lib","Security.php"));
    require File::build_path(array("controller","routeur.php"));
?>