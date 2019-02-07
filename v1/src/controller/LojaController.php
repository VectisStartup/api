<?php

require_once (__DIR__."/../model/dao/LojaDao.php");
require_once (__DIR__."/../helpers/GeralHelper.php");

use Slim\Http\Request;
use Slim\Http\Response;

class LojaController{
    private $lojaDao;
    private $request;
    private $response;
    private $args;

    public function __construct(Request $request, Response $response, array $args) {
        $this->lojaDao = new LojaDao();
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
    }    

    public function getClientes(){
        $queryParams = $this->request->getQueryParams();

        if ( $this->hasFiltersLogin($queryParams) ) {
            $resultado = $this->lojaDao->getLojaQueryLogin($queryParams);
            return resultObject($resultado, $this->response);
            
        }elseif( $this->hasFiltersCategoria($queryParams) ){
            $resultado = $this->lojaDao->getLojaQueryCategoria($queryParams);
            return resultArray($resultado, $this->response);

        }elseif( $this->hasFiltersLocation($queryParams) ){
            $resultado = $this->lojaDao->getLojaQueryLocation($queryParams);
            return resultArray($resultado, $this->response);

        }else {
            $resultado = $this->lojaDao->pegarTodasAsLojas();
            return resultArray($resultado, $this->response);
        }

    }

    function hasFiltersLogin($queryParams){
        if ( $queryParams != null ) {
            
            if ( $queryParams['email'] != null && $queryParams['senha'] != null )
                return true;
            else
                return false;
        }else {
            return false;
        }
        
        return false;
    }

    function hasFiltersLocation($queryParams){
        if ( $queryParams != null ) {
            
            if ( $queryParams['latitude'] != null && $queryParams['longitude'] != null 
                 && $queryParams['distancia'] != null && $queryParams['page'] != null
                 && $queryParams['pageSize'] != null )
                return true;
            else
                return false;
        }else {
            return false;
        }
        
        return true;
    }

    function hasFiltersCategoria($queryParams){
        if ( $queryParams != null ) {
            
            if ( $queryParams['latitude'] != null && $queryParams['longitude'] != null 
                 && $queryParams['distancia'] != null && $queryParams['categoria'] != null
                 && $queryParams['page'] != null && $queryParams['pageSize'] != null)
                return true;
            else
                return false;
        }else {
            return false;
        }

        return false;
    }


 
}    
    

?>