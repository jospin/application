<?php
namespace Lib\Mvc;
use Lib\Conf as Conf;

/**
* Classe que determina qual controller, de qual modulo chamar pelos parâmetros passados na URL
* Utiliza-se dos dados passados na REDIRECT_URL
* @author Lucien Jospin <lucien.carbonare@gmail.com>
* @since 2015-01-26
* @copyright 2015
* @version 1.0
*/
class Load {

    private static $_methods = array(
        'flow',
        'form',
        'iso'
        );
    /**
    * Atributo para determinar o tipo de atuação que a controller atuará
    * @var string
    */
    public static $_method;

    /**
    * Atributo que monta as pastas de parâmetros
    * @var string
    */
    private static $_url = null;

    /**
    * Atributo para determinar o Módulo que será chamado
    * @var string
    */
    public static $_module;

    /**
    * Atributo para determinar o Controller que será chamado
    * @var string
    */
    public static $_controller;

    /**
    * Atributo para determinar a Action chamada
    * @var string
    */
    public static $_action;

    /**
    * Atributo para determinar os parâmetros do request
    * @var string
    */
    public static $_request;

    /**
    * Atributo para determinar o arquivo do controller
    * @var string
    */
    private static $_fileControler;

    /**
    * Atributo para determinar a aplicação chamada
    * @var string
    */
    private static $_enviroment;

    /**
    * Atributo para receber a configuração
    * @var stdClass
    */
    private static $_mvcDefault;

    private static $call = array('method','module','controller','action');

    /**
    * Método da classe load que monta qual controlle e action será acessada,
    * e qual o método de resposta utilizado
    * @author Lucien Jospin <lucien.carbonare@gmail.com>
    * @access public
    * @return boolean
    */
    public static function getApp()
    {
        if (self::$_url === null) {
            Load::_getUrlList();
        }

        self::$_mvcDefault = Conf\Load::getInstance()->getMvc();

        // No looping caso tenhamos uma exception tentar buscar se não pode ser parâmetros de passagem antes de lançar a exceptio
        // Pois pode ser que o módulo seja o default.
        $i = 0;
        for($i = 0; $i <count(self::$_url); $i++) {
            Load::_factory(self::$_url[$i]);
        }
    }

    public static function getMethod()
    {
        if (empty(self::$_method) && isset(self::$_mvcDefault->methoddefault)) {
            self::$_method =  self::$_mvcDefault->methoddefault;
        }
        return self::$_method;
    }

    public static function getModule()
    {
        if (empty(self::$_module) && isset(self::$_mvcDefault->moduledefault)) {
            self::$_module =  self::$_mvcDefault->moduledefault;
        }
        return self::$_module;
    }

    public static function getController()
    {
        if (empty(self::$_controller) && isset(self::$_mvcDefault->controllerdefault)) {
            self::$_controller =  self::$_mvcDefault->controllerdefault;
        }
        return self::$_controller;
    }

    public static function getAction()
    {
        if (empty(self::$_action) && isset(self::$_mvcDefault->actiondefault)) {
            self::$_action =  self::$_mvcDefault->actiondefault;
        }
        return self::$_action;
    }

    private static function _factory($value)
    {
        $val = self::$call[0];
        $method = '_set' . ucfirst($val);
        if (Load::{$method}($value)) {
            array_shift(self::$call);
            return true;
        }
    }

    /**
    * Método que monta a lista de URL que esta sendo passada além da de acesso a aplicação
    * @author Lucien Jospin <lucien.carbonare@gmail.com>
    * @return array
    * @access private
    */
    private static function _getUrlList()
    {
        global $_SERVER;

        // Primeiro traz todos as pastas abaixo do index.php
        $startUrl = strlen( $_SERVER["DOCUMENT_ROOT"] ) -1 ;
        $excludeUrl = substr( $_SERVER["SCRIPT_FILENAME"], $startUrl, -11 );

        // a variável$request possui toda a string da URL após o domínio.
        $request = $_SERVER['REQUEST_URI'];

        // Agora retira toda as pastas abaixo da pasta raiz
        $request = substr( $request, strlen( $excludeUrl ) );


        // Explode a URL para pegar retirar tudo após o ?
        $urlTmp = explode("?", $request);
        $request = $urlTmp[ 0 ];

        // Explo a URL para pegar cada uma das partes da URL
        $urlExplodida = explode("/", $request);

        $retorna = array();

        for($a = 0; $a <= count($urlExplodida); $a ++)
        {
            if(isset($urlExplodida[$a]) AND $urlExplodida[$a] != "")
            {
                array_push($retorna, $urlExplodida[$a]);
            }
        }
        self::$_url = $retorna;
    }

    /**
    * Método que seta o método após validação
    * @author Lucien Jospin <lucien.carbonare@gmail.com>
    * @param string $method
    * @return boolean
    * @access private
    */
    private static function _setMethod($method)
    {

        if (in_array(strtolower($method), self::$_methods)) {
            self::$_method = $method;
        } else {
            if (!empty(self::$_mvcDefault->method)) {
                self::$_method = $method;
                return true;
            }
            throw new ExceptionLoad('Método chamado não existe');
        }
        return true;
    }

    /**
    * Método que seta o módulo após validação
    * @author Lucien Jospin <lucien.carbonare@gmail.com>
    * @param string $module
    * @return boolean
    * @access private
    */
    private static function _setModule($module)
    {
        if (is_string($module)) {
            try{
                Load::_validaModule($module);
                self::$_module = $module;
            } catch(ExceptionLoad $e) {
                echo $e;
            }
        } else {
            throw new ExceptionLoad('Parâmetro passado como módulo não existe');
        }
    }

    /**
    * Método que valida se o Módulo existe
    * @author Lucien Jospin <lucien.carbonare@gmail.com>
    * @param string $module
    * @return boolean
    * @access private
    */
    private static function _validaModule($module)
    {
        $modulePath = dirname(__DIR__) . '/module/' . $module;
        if (!is_dir($modulePath)) {
            throw new ExceptionLoad('Módulo não existe nesta aplicação');
        }
    }

    /**
    * Método que seta o controller após validação
    * @author Lucien Jospin <lucien.carbonare@gmail.com>
    * @param string $controller
    * @return boolean
    * @access private
    */
    private static function _setController($controller)
    {
        if (is_string($controller)) {
            try{
                Load::_validaController($controller);
                self::$_controller = $controller;
            } catch(ExceptionLoad $e) {
                echo $e;
            }
        } else {
            throw new ExceptionLoad('Parâmetro passado como controller não existe');
        }
        return true;
    }

    /**
    * Método que valida se o Controller existe
    * @author Lucien Jospin <lucien.carbonare@gmail.com>
    * @param string $controller
    * @return boolean
    * @access private
    */
    private static function _validaController($controller)
    {
        self::$_fileControler = dirname(__DIR__)
                            . '/'
                            . self::$_module
                            . '/' . $controller . '.php';
        if (!is_file(self::$_fileControler)) {
            throw new ExceptionLoad('Controller inexistente nesta aplicação');
        }
        return true;
    }

    /**
    * Método que seta a action caso exista
    * @author Lucien Jospin <lucien.carbonare@gmail.com>
    * @param string $action
    * @return boolean
    * @access private
    */
    private static function _setAction($action)
    {
        if (is_string($action)) {
            try{
                Load::_validaAction($action);
                self::$_action = $action;
            } catch(ExceptionLoad $e) {
                echo $e;
            }
        } else {
            throw new ExceptionLoad('Parâmetro passado como action não existe');
        }
        return true;
    }

    /**
    * Método que valida se a action existe
    * @author Lucien Jospin <lucien.carbonare@gmail.com>
    * @param string $action
    * @return boolean
    * @access private
    */
    private static function _validaAction($action)
    {

        if (!is_file(self::$_fileControler)) {
            throw new ExceptionLoad('Action inexistente no Controller: ' . self::$_controller);
        }
        return true;

    }

}