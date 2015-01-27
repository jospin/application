<?php
spl_autoload_register(function ($class) {
    echo $class ;
    require_once(__DIR__ . '/' . str_replace('\\', '/', $class . '.php'));
});
?>