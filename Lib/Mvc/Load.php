<?php
namespace Lib\Mvc;

/**
* Classe que determina qual controller, de qual modulo chamar pelos parâmetros passados na URL
* Utiliza-se dos dados passados na REDIRECT_URL
* @author Lucien Jospin <lucien.carbonare@gmail.com>
* @since 2015-01-26
* @copyright 2015
* @version 1.0
*/
class Load{

    static private $_methods = array(
        'flow',
        );
    /**
    * Atributo para determinar o tipo de atuação que a controller atuará
    * @var string
    */
    static public $_method;

    /**
    * Atributo para determinar o Módulo que será chamado
    * @var string
    */
    static public $_module;

    /**
    * Atributo para determinar o Controller que será chamado
    * @var string
    */
    static public $_controller;

    /**
    * Atributo para determinar a Action chamada
    * @var string
    */
    static public $_action;

    /**
    * Atributo para determinar os parâmetros do request
    * @var string
    */
    static public $_request;

    static public function getApp(array $request)
    {
        Load::_setMethod($request[1]);
        if (isset($request[2])) {
            Load::_setModule($request[2]);
        }
    }

    static private function _setMethod($method)
    {

        if (in_array(strtolower($method), self::$_methods)) {
            self::$_method = $method;
        } else {
            throw new ExceptionLoad('Método chamado não existe');
        }
    }

    static private function _setModule($module)
    {
        if (is_string($module)) {
            try{
                Load::validaModule($module);
                self::$_module = $module;
            } catch(ExceptionLoad $e) {
                echo $e;
            }
        } else {
            throw new ExceptionLoad('Parâmetro passado como módulo não existe');
        }
    }

    static private function validaModule($module)
    {
        $modulePath = dirname(__DIR__) . '/module/' . $module;
        if (!is_dir($modulePath)) {
            throw new ExceptionLoad('Módulo não existe nesta aplicação');
        }
    }

}