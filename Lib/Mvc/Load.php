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

    public $_methods = array(
        'flow',
        );
    /**
    * Atributo para determinar o tipo de atuação que a controller atuará
    * @var string
    */
    public $_http;

    /**
    * Atributo para determinar o Módulo que será chamado
    * @var string
    */
    private $_module;

    /**
    * Atributo para determinar o Controller que será chamado
    * @var string
    */
    private $_controller;

    /**
    * Atributo para determinar a Action chamada
    * @var string
    */
    private $_action;

    /**
    * Atributo para determinar os parâmetros do request
    * @var string
    */
    private $_request;

    static public function getApp(array $request)
    {
        Load::_setHttp($request[1]);
    }

    static function _setHttp($method)
    {

        if (is_array(strtolower($method), self::$_methods)) {
            self::$_http = $method;
        } else {
            Throw New Exception('Erro no Método');
        }
    }

}