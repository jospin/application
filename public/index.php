<?php
require_once dirname(__DIR__) . '/autload.php';
require_once dirname(__DIR__) . '/config/etc.php';

use Lib\Mvc as Mvc;
use Lib\Conf as Conf;

Conf\Load::getInstance()->setGlobalConf($config['global']);
try{
    Mvc\Load::getApp();
} catch(Mvc\ExceptionLoad $e) {
    echo $e;
    die();
}

print_r(Mvc\Load::getMethod());
print_r(Mvc\Load::getModule());
print_r(Mvc\Load::getController());
print_r(Mvc\Load::getAction());
die();
