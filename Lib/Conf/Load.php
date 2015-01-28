<?php
namespace Lib\Conf;

/**
* Classe que Pega os dados de configuração e trata dentro de um objeto
* @author Lucien Jospin <lucien.carbonare@gmail.com>
* @since 2015-01-27
* @copyright 2015
* @version 1.0
*/
class Load{

    /**
    * Atributo do Singleton
    * @var Lib\Conf\Load
    */
    private static $_instance;

    /**
    * Atributo statico para a configuração do MVC
    * @var stdClass
    */
    private static $_mvc;

    private function __construct(){}

    /**
    * Método getInstance para garantir o singletoon
    * @author Lucien Jospin <lucien.carbonare@gmail.com>
    * @access public
    * @return Lib\Conf\Load
    */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new Load();
        }
        return self::$_instance;
    }

    /**
    * Método para pegar o conf do MVC
    * @author Lucien Jospin <lucien.carbonare@gmail.com>
    * @access public
    * @return stdClass
    */
    public function setGlobalConf(array $config)
    {
        if (isset($config['mvc'])) {
            self::$_mvc = (object) $config['mvc'];
        }
    }

    public function getMvc()
    {
        return self::$_mvc;
    }

}