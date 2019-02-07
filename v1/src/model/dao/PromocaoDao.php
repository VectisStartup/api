<?php
/**
 * Created by PhpStorm.
 * User: Paulino-Pc
 * Date: 18/08/2018
 * Time: 14:40
 */

require_once (__DIR__."/../ConexaoBD.php");


class PromocaoDao
{
    private $database;
    private $produto;

    public function __construct()
    {
        $conexao = new ConexaoBD();
        $this->database = $conexao->database;

    }

    //GET
    function pegarPromocao($id){
        $resultado = $this->database->select("promocao","*",
            [
                'id' => $id
            ]);

        return $resultado;
    }
    //GET
    function pegarTodasAsPromocoes(){
        $resultado = $this->database->select("promocao","*");
        return $resultado;
    }
    //GET
    function pegarTodasAsPromocoesDaLoja($idLoja){
        $resultado = $this->database->select("promocao","*", ["idLoja" => $idLoja]);
        return $resultado;
    }
    //POST
    function criarPromocao($json)
    {
        //inserir
        $insert = $this->database->insert("promocao",
            [
                "idProduto" =>$json['idProduto'],
                "idLoja" => $json['idLoja'],
                "preco" =>$json['preco'],
                "DataTermino" =>$json['DataTermino']
            ]);

        return $insert;
    }
    //POST
    function actualizarPromocao($id, $json)
    {
        //inserir
        $resultado = $this->database->update("promocao",
            [
                "preco" =>$json['preco'],
                "DataTermino" =>$json['DataTermino']
            ],
            [
                "id"=>$id,
            ]);

        return $resultado;
    }
    //DELETE
    function apagarPromocao($id)
    {
        $resultado = $this->database->delete("promocao",
            [
                'id' => $id
            ]);
        
        return $resultado;
    }
}
