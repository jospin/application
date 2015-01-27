<?php
require_once dirname(__DIR__) . '/autload.php';
use Lib\Mvc as Mvc;
/**
* File is very important for skeleton of the application
* I use redirect_url cause it call parameters witch may or may not exist.
*/
echo '<pre>';
$redirect_url = array();
if (isset($_SERVER['REDIRECT_URL'])) {
    $redirect_url = explode('/',$_SERVER['REDIRECT_URL']);
}
//$redirect_url = explode('/',$_SERVER['REDIRECT_URL']);
try{
    $load = Mvc\Load::getApp($redirect_url);
} catch(Mvc\ExceptionLoad $e) {
    echo $e;
    die();
}
// Passa para a classe Load que ira tratar o Módulo/Controller/Action e os parâmetros
//echo '<pre>';
//print_r($_SERVER);