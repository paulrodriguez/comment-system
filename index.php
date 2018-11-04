<?php
// for use with php server. if extension is an asset, then do not process controll and other files
$extensions = array("jpg", "jpeg", "gif", "css","js");

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$ext = pathinfo($path, PATHINFO_EXTENSION);
$url = explode('/',$_SERVER['REQUEST_URI']);
if (in_array($ext, $extensions) && $url[1]=='assets') {
    // let the server handle the request as-is
    return false;
}

require getcwd().DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'Globals.php';

// load configuration files
require APP_ROOT.DS.'configs'.DS.'Db.php';

// load model files
require APP_ROOT.DS.'models'.DS.'DbConn.php';
require APP_ROOT.DS.'models'.DS.'Comment.php';
require APP_ROOT.DS.'models'.DS.'Block.php';

// load controller files
require APP_ROOT.DS.'controllers'.DS.'BaseController.php';
require APP_ROOT.DS.'controllers'.DS.'IndexController.php';


$controller = new \Controller\IndexController();
$controller->run();
