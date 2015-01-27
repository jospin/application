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
