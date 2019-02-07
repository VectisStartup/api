<?php
/**
 * Created by PhpStorm.
 * User: candido
 * Date: 18/08/2018
 * Time: 14:40
 */

require_once (__DIR__."/../ConexaoBD.php");


class ProdutoDao
{
    private $database;

    public function __construct()
    {
        $conexao = new ConexaoBD();
        $this->database = $conexao->database;

    }

    function getProdutoQueryName($queryParams){
        $offset = ($queryParams['page']-1)*$queryParams['pageSize'];
        $calculos = "(6371*acos(cos(radians(".$queryParams["latitude"]."))*cos(radians(loja.latitude))*cos(radians(loja.longitude) - radians(".$queryParams['longitude']."))+sin(radians(".$queryParams["latitude"]."))*sin(radians(loja.latitude))))";
        $sql = "SELECT produto.id,produto.nome,produto.descricao,produto.imagem,produto.idLoja,produto.preco,produto.tempoDePreparo,loja.nome as loja,loja.endereco,".$calculos." AS distancia FROM produto INNER JOIN loja ON produto.idLoja = loja.id WHERE produto.nome Like '".$queryParams['nome']."%' HAVING distancia <= ".$queryParams['distancia']." ORDER BY distancia DESC LIMIT ".$offset.",".$queryParams['pageSize'];

        $resultado = $this->database->query($sql)->fetchAll();

        $resultAfter = array();

        for ($i = 0; $i < sizeof($resultado); $i++){
            $resultAfter[$i]['id'] = $resultado[$i]['id'];
            $resultAfter[$i]['nome'] = $resultado[$i]['nome'];
            $resultAfter[$i]['descricao'] = $resultado[$i]['descricao'];
            $resultAfter[$i]['imagem'] = $resultado[$i]['imagem'];
            $resultAfter[$i]['idLoja'] = $resultado[$i]['idLoja'];
            $resultAfter[$i]['preco'] = $resultado[$i]['preco'];
            $resultAfter[$i]['tempoDePreparo'] = $resultado[$i]['tempoDePreparo'];
            $resultAfter[$i]['loja'] = $resultado[$i]['loja'];
            $resultAfter[$i]['endereco'] = $resultado[$i]['endereco'];
            $resultAfter[$i]['distancia'] =  round($resultado[$i]['distancia'], 3) ;
        }

        $rows = sizeof($resultAfter);

        if ($resultAfter != null) {

            if ( $rows < $queryParams['pageSize'] ) {
                return array('page' => $queryParams['page'],'listProduto' => $resultAfter, 'hasMore' => 'false' );
            }else{
                return array('page' => $queryParams['page'],'listProduto' => $resultAfter, 'hasMore' => 'true' );
            }
        }else{
            return null;
        }
    }

    function getProdutoQueryCategoria($queryParams){
        $offset = ($queryParams['page']-1)*$queryParams['pageSize'];
        $calculos = "(6371*acos(cos(radians(".$queryParams["latitude"]."))*cos(radians(latitude))*cos(radians(longitude) - radians(".$queryParams['longitude']."))+sin(radians(".$queryParams["latitude"]."))*sin(radians(latitude))))";
        $sql = "SELECT id,nome,logotipo,telefone,entrada,saida,fcmToken,latitude,longitude,endereco,categoria,online,".$calculos." AS distancia FROM loja WHERE categoria = '".$queryParams['categoria']."' HAVING distancia <= ".$queryParams['distancia'] ." ORDER BY distancia LIMIT ".$offset.",".$queryParams['pageSize'];

        $resultado = $this->database->query($sql)->fetchAll();

        $resultAfter = array();

        for ($i = 0; $i < sizeof($resultado); $i++){
            $resultAfter[$i]['id'] = $resultado[$i]['id'];
            $resultAfter[$i]['nome'] = $resultado[$i]['nome'];
            $resultAfter[$i]['logotipo'] = $resultado[$i]['logotipo'];
            $resultAfter[$i]['telefone'] = $resultado[$i]['telefone'];
            $resultAfter[$i]['entrada'] = $resultado[$i]['entrada'];
            $resultAfter[$i]['saida'] = $resultado[$i]['saida'];
            $resultAfter[$i]['fcmToken'] = $resultado[$i]['fcmToken'];
            $resultAfter[$i]['latitude'] = $resultado[$i]['latitude'];
            $resultAfter[$i]['longitude'] = $resultado[$i]['longitude'];
            $resultAfter[$i]['endereco'] = $resultado[$i]['endereco'];
            $resultAfter[$i]['categoria'] = $resultado[$i]['categoria'];
            $resultAfter[$i]['online'] = $resultado[$i]['online'];
            $resultAfter[$i]['distancia'] =  round($resultado[$i]['distancia'], 3) ;
        }
    }
        
    //GET
    function pegarProdutoPeloId($id){
        $resultado = $this->database->select("produto","*",
            [
                'id' => $id
            ]);

        return $resultado;
    }

    //GET
    function getLojaProdutoPeloId($idLoja, $id){
        $resultado = $this->database->select("produto","*",
            [
                'id' => $id,
                'idLoja' => $idLoja,
            ]);

        return $resultado;
    }

    //GET
    function pegarTodosProdutos(){
        $resultado = $this->database->select("produto","*");
        return $resultado;
    }

    //GET
    function pegarProdutosDaLoja($idLoja){
        $resultado = $this->database->select("produto","*", ['idLoja'=>$idLoja]);
        return $resultado;
    }

    //GET
    function getLojaProdutosPeloNome($idLoja, $nome){
        $resultado = $this->database->select("produto","*", 
        [
            'nome[~]'=>$nome."_",
            'idLoja'=>$idLoja
        ]);
        return $resultado;
    }

    //GET
    function pegarProdutosPeloNome($nome){
        $resultado = $this->database->select("produto","*", ['nome[~]'=>$nome."_"]);
        return $resultado;
    }

    //POST
    function criarProduto($json){

        //inserir
        $insert = $this->database->insert("produto",
            [
                "nome" =>$json['nome'],
                "descricao" =>$json['descricao'],
                "imagem" =>$json['imagem'],
                "idLoja" =>$json['idLoja'],
                "preco" =>$json['preco'],
                "tempoDePreparo" =>$json['tempoDePreparo'],
                "criacao" =>$json['criacao']
            ]);

        return $insert;
    }

    //POST
    function actualizarProduto($id, $json){
        //inserir
        $resultado = $this->database->update("produto",
            [
                "nome" =>$json['nome'],
                "descricao" =>$json['descricao'],
                "imagem" =>$json['imagem'],
                "idLoja" =>$json['idLoja'],
                "preco" =>$json['preco'],
                "tempoDePreparo" =>$json['tempoDePreparo'],
                "criacao" =>$json['criacao']
            ],
            [
                "id"=>$id,
            ]);

        return $resultado;
    }

    //POST
    function actualizarImagemDoProduto($id, $imagem){
        $img = uploadedImage($imagem, 'produto');
        $resultado = $this->database->update("produto",
            [
                "imagem"=> $img
            ],
            [
                "id"=>$id,
            ]);

        return $resultado;
    }

    //DELETE
    function apagarProduto($id){
        /*$resultado = $this->database->delete("loja",
            [
                'id' => $id
            ]);
        */
        return "E melhor por um campo oculto";//$resultado;
    }

    //POST
    function postLojaProduto($idLoja, $json){

        $insert = $this->database->insert("produto",
            [
                "idLoja" => $idLoja,
                "nome" =>$json['nome'],
                "descricao" =>$json['descricao'],
                "imagem" =>$json['imagem'],
                "preco" =>$json['preco'],
                "tempoDePreparo" =>$json['tempoDePreparo'],
                "criacao" =>$json['criacao']
            ]);

        return $insert;
    }

    //PUT
    function putLojaProduto($id, $idLoja, $json){
        $resultado = $this->database->update("produto",
            [
                "nome" =>$json['nome'],
                "descricao" =>$json['descricao'],
                "imagem" =>$json['imagem'],
                "preco" =>$json['preco'],
                "tempoDePreparo" =>$json['tempoDePreparo']
            ],
            [
                "id" => $id,
                "idLoja" => $idLoja
            ]);

        return $resultado;
    }
    
    //DELETE
    function deleteLojaProduto($id, $idLoja){
        $resultado = $this->database->delete("produto",
            [
                "id" => $id,
                "idLoja" => $idLoja
            ]);
        return $resultado;
    }
}

