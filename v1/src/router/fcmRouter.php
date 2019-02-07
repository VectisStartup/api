<?php

require_once (__DIR__."/../controller/FCMController.php");

/*
 *   @Company: Vectis
 *   @Author: Cândido M.J.Fernandes Malavoloneque
 *   @Description: API clientes
*/

use Slim\Http\Request;
use Slim\Http\Response;


$app->post('/pushmessage/cliente/{id:[0-9]+}', function (Request $request, Response $response, array $args) {
    
    $fcmController = new FCMController($request, $response, $args);
    return $fcmController->sendToClienteById();

});

$app->post('/pushmessage/cliente/{token}', function (Request $request, Response $response, array $args) {
        
    $fcmController = new FCMController($request, $response, $args);
    return $fcmController->sendToClienteByToken();

});

$app->post('/pushmessage/loja/{id:[0-9]+}', function (Request $request, Response $response, array $args) {
    $fcmController = new FCMController($request, $response, $args);
    return $fcmController->sendToClienteById();

});

$app->post('/pushmessage/loja/{token}', function (Request $request, Response $response, array $args) {
    $fcmController = new FCMController($request, $response, $args);
    return $fcmController->sendToClienteByToken();

});

/*$app->post('/pushmessage/cliente/{id:[0-9]+}', function (Request $request, Response $response, array $args) {
    $clientePedidosController = new ClientePedidosController($request, $response, $args);
    return $clientePedidosController->getClientePedidos();

});

$app->post('/pushmessage/loja', function (Request $request, Response $response, array $args) {
    $clientePedidosController = new ClientePedidosController($request, $response, $args);
    return $clientePedidosController->getClientePedidos();

});

$app->post('/pushmessage/loja/{id:[0-9]+}', function (Request $request, Response $response, array $args) {
    $clientePedidosController = new ClientePedidosController($request, $response, $args);
    return $clientePedidosController->getClientePedidos();

});*/

?>