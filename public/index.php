<?php

/**
* File is very important for skeleton of the application
* I use redirect_url cause it call parameters witch may or may not exist.
*/

$redirect_url = explode('/',$_SERVER['REDIRECT_URL']);
// Passa para a classe Load que ira tratar o M�dulo/Controller/Action e os par�metros
echo '<pre>';
print_r($_SERVER);