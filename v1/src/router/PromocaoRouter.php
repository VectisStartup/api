<?php

require_once __DIR__ . "/../model/dao/PromocaoDao.php";

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

//Listar todas as  promocoes
$app->get('/promocoes', function (Request $request, Response $response, array $args) {
    $promocaoDao = new PromocaoDao();

    $resultado = $promocaoDao->pegarTodasAsPromocoes();

    if ($resultado == null) {
        return $response->withStatus(204)->write("Ainda não existem promocoes.");
    }

    return $response->withJson($resultado, 200);
});
//Listar todas as  promocoes da loja
$app->get('/lojas/{id:[0-9]+}/promocoes', function (Request $request, Response $response, array $args) {
    $promocaoDao = new PromocaoDao();
    $idLloja = $args['id'];
    $resultado = $promocaoDao->pegarTodasAsPromocoesDaLoja($idLloja);

    if ($resultado == null) {
        return $response->withStatus(204)->write("Ainda não existem promocoes.");
    }

    return $response->withJson($resultado, 200);
});
//Listar Promocao...
$app->get('/promocoes/{id:[0-9]+}', function (Request $request, Response $response, array $args) {
    $promocaoDao = new PromocaoDao();
    $id = $args['id'];
    $resultado = $promocaoDao->pegarPromocao($id);
    if ($resultado == null) {
        return $response->withStatus(204)->write("Promocao não encontrada.");
    }
    return $response->withJson($resultado[0], 200);
});
/*
//Listar produtos com nome...
$app->get('/promocoes/{nome}', function (Request $request, Response $response, array $args) {
    $promocaoDao = new PromocaoDao();
    $nome = $args['nome'];
    $resultado = $promocaoDao->pegarProdutosPeloNome($nome);
    if ($resultado == null) {
        return $response->withStatus(204)->write("De momento não existem produtos com este nome.");
    }

    return $response->withHeader('Content-type', 'application/json')
        ->write(json_encode($resultado, JSON_UNESCAPED_SLASHES));
});*/
//Criar Promocao
$app->post('/lojas/{id:[0-9]+}/promocoes', function (Request $request, Response $response, array $args)
{
    $jsonInArray = $request->getParsedBody();
    if ($jsonInArray)
    {
        $jsonInArray['idLoja'] = $args['id'];
        $promocaoDao = new PromocaoDao();

        $resultado = $promocaoDao->criarPromocao($jsonInArray);

        if($resultado->rowCount() > 0){
            return $response->withStatus(200)->write('Promocao criada.');
        }else{
            return $response->withStatus(400)->write('Erro ao criar a promocao.');
        }

    }else{
        return $response->withStatus(500)->write('Um erro desconhecido ocorreu ao criar a promocao.');
    }
});
//Actualizar promocao
$app->put('/promocoes/{id:[0-9]+}', function (Request $request, Response $response, array $args)
{
    $jsonInArray = $request->getParsedBody();
    if($jsonInArray != null)
    {
        $promocaoDao = new PromocaoDao();
        $id = $args['id'];
        $resultado = $promocaoDao->actualizarPromocao($id,$jsonInArray);

        if($resultado->rowCount() > 0){
            return $response->withStatus(201)->write('Promocao actualizado.');
        }else{
            return $response->withStatus(400)->write('Erro ao actualizar a promocao.');
        }

    }else{
        return $response->withStatus(500)->write('Um erro desconhecido ocorreu ao actualizar a promocao.');
    }
});
