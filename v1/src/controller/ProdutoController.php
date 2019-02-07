<?php

require_once (__DIR__."/../model/dao/ProdutoDao.php");
require_once (__DIR__."/../helpers/GeralHelper.php");

use Slim\Http\Request;
use Slim\Http\Response;

class ProdutoController{
    private $produtoDao;
    private $request;
    private $response;
    private $args;

    public function __construct(Request $request, Response $response, array $args) {
        $this->produtoDao = new ProdutoDao();
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
    }    

    public function getProdutos(){
        $queryParams = $this->request->getQueryParams();

        if ( $this->hasFiltersName($queryParams) ) {
            $resultado = $this->produtoDao->getProdutoQueryName($queryParams);
            return resultArray($resultado, $this->response);
            
        }elseif( $this->hasFiltersCategoria($queryParams) ){
            $resultado = $this->produtoDao->getLojaQueryCategoria($queryParams);
            return resultArray($resultado, $this->response);

        }else {
            $resultado = $this->produtoDao->pegarTodasAsLojas();
            return resultArray($resultado, $this->response);
        }

    }
    //Hungria

    function hasFiltersName($queryParams){
        if ( $queryParams != null ) {
            
            if ( $queryParams['latitude'] != null && $queryParams['longitude'] != null 
                 && $queryParams['distancia'] != null && $queryParams['page'] != null
                 && $queryParams['pageSize'] != null && $queryParams['nome'] != null)
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