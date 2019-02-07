<?php

require_once (__DIR__ . "/../model/dao/LojaDao.php");
require_once (__DIR__."/../controller/LojaController.php");

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

//Listar todas as lojas
$app->get('/lojas', function (Request $request, Response $response, array $args) {

    /*$lojaController = new LojaController($request, $response, $args);
    return $lojaController->getClientes();*/

    return "Ola mundo";

});
//Listar loja...
/*$app->get('/lojas/{id:[0-9]+}', function (Request $request, Response $response, array $args) {
    $loja = new LojaDao();
    $id = $args['id'];
    $resultado = $loja->pegarLojaPeloId($id);
    if ($resultado == null) {
        return $response->withStatus(204)->write("Esta loja não existe.");
    }

    return $response->withJson($resultado[0], 200);
});
//Listar lojas com categoria...
$app->get('/lojas/{categria:[a-zA-Z0-9]+}', function (Request $request, Response $response, array $args) {
    $loja = new LojaDao();
    $categoria = $args['categria'];
    $resultado = $loja->pegarTodasAsLojasComACategoria($categoria);
    if ($resultado == null) {
        return $response->withStatus(204)->write("De momento não existem lojas com esta categoria.");
    }

    return $response->withJson($resultado, 200);
});
//Criar loja
$app->post('/lojas', function (Request $request, Response $response, array $args)
{
    $jsonInArray = $request->getParsedBody();
    if($jsonInArray != null)
    {
        $lojaDao = new LojaDao();
        $resultado = $lojaDao->criarLoja($jsonInArray);

        if($resultado->rowCount() > 0){
            return $response->withStatus(201)->write('Parabéns! você criou a sua loja');
        }else{
            return $response->withStatus(400)->write('Não foi possível criar a loja. Por favor, verifique se todos os campos estão correctos.');
        }

    }else{
        return $response->withStatus(400)->write('Um erro desconhecido ocorreu ao criar a loja.');
    }
});
//Actualizar loja com id
$app->post('/lojas/{id:[0-9]+}/logos', function (Request $request, Response $response, array $args)
{
    $jsonInArray = $_FILES['logo'];
    if($jsonInArray != null)
    {
        $lojaDao = new LojaDao();
        $id = $args['id'];
        $resultado = $lojaDao->actualizarLogoDaLoja($id,$jsonInArray);
        if($resultado->rowCount() > 0){
            return $response->withStatus(200)->write('logo actualizado.');
        }else{
            return $response->withStatus(400)->write('Não foi possivel actualizar o logo.');
        }

    }else{
        return $response->withStatus(400)->write('Um erro desconhecido ocorreu ao actualizar o logo.');
    }
});
//Actualizar loja com id
$app->put('/lojas/{id:[0-9]+}', function (Request $request, Response $response, array $args)
{
    $jsonInArray = $request->getParsedBody();
    if($jsonInArray != null)
    {
        $lojaDao = new LojaDao();
        $id = $args['id'];
        $resultado = $lojaDao->actualizarLoja($id,$jsonInArray);

        if($resultado->rowCount() > 0){
            return $response->withStatus(200)->write('loja actualizada com sucesso.');
        }else{
            return $response->withStatus(400)->write('Não foi possivel actualizar a loja.');
        }

    }else{
        return $response->withStatus(400)->write('Um erro desconhecido ocorreu ao actualizar a loja.');
    }
});

//Actualizar loja com id
$app->put('/lojas/{id:[0-9]+}/accao/activo/trocar', function (Request $request, Response $response, array $args)
{
    $jsonInArray = $request->getParsedBody();
    if($jsonInArray != null)
    {
        $lojaDao = new LojaDao();
        $id = $args['id'];
        $resultado = $lojaDao->estadoDeActividade($id,$jsonInArray);

        if($resultado->rowCount() > 0){
            return $response->withStatus(200)->write('chat actualizado');
        }else{
            return $response->withStatus(400)->write('Não foi possivel actualizar a loja.');
        }

    }else{
        return $response->withStatus(400)->write('Um erro desconhecido ocorreu ao actualizar a loja.');
    }
});
*/