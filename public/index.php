<?php

require_once dirname(__DIR__) . '/autload.php';
use Lib\Mvc as Mvc;
//$redirect_url = explode('/',$_SERVER['REDIRECT_URL']);
try{
    $load = Mvc\Load::getApp();
} catch(Mvc\ExceptionLoad $e) {
    echo $e;
    die();
}
// Passa para a classe Load que ira tratar o Módulo/Controller/Action e os parâmetros
//echo '<pre>';
//print_r($_SERVER);