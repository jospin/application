<?php
namespace Lib\Mvc;

/**
* Classe que monta um exceptions customizada
* A ideia final é chamar a view do exception para carregar o erro.
* @author Lucien Jospin <lucien.carbonare@gmail.com>
* @since 2015-01-27
* @copyright 2015
* @version 1.0
*/
class ExceptionLoad extends \Exception{

    /**
    * Método que gera o retorno da Exception customizada
    * @author Lucien Jospin <lucien.carbonare@gmail.com>
    * @return string
    */
    public function __toString()
    {
        $html = '<h1>Erro ao carregar a página</h1>';
        $html .= '<p>' . $this->getMessage() . '<p>';
        return $html;
    }
}