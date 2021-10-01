<?php

session_start();

require_once("../app/init.php");

$web_file = str_replace("index.php","",$_SERVER['SCRIPT_NAME']);
$root = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$web_file;
$assets = $root."assets/";
$file = $root."uploads/";

define('ROOT',$root);
define('ASSETS',$assets);
define('FILE',$file);


$app = new App();