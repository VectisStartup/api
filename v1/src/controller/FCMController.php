<?php

require_once (__DIR__."/../model/dao/FCMDao.php");
require_once (__DIR__."/../helpers/GeralHelper.php");

use Slim\Http\Request;
use Slim\Http\Response;

class FCMController{
    private $fcmDao;
    private $request;
    private $response;
    private $args;

    public function __construct(Request $request, Response $response, array $args) {
        $this->fcmDao = new FCMDao();
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
    }

    public function sendToClienteById(){
        
        $json = $this->request->getParsedBody();
        $idCliente = $this->args['id'];
        $data = $json['data'];
        $notification = $json['notification'];

        if( $data != null && $notification != null){

            $tokenCliente = $this->fcmDao->getClienteTokenById($idCliente)[0];

            if($tokenCliente != null){

                $message = json_encode(array( "data" => $data, "notification" => $notification, "to" => $tokenCliente) );
                
                sendToFCM($message);

            }else{
                return $this->response->withStatus(204);
            }

        }else{
            return $this->response->withStatus(400);
        }

    }

    public function sendToClienteByToken(){
        
        $json = $this->request->getParsedBody();
        $tokenCliente = $this->args['token'];
        $data = $json['data'];
        $notification = $json['notification'];

        if( $data != null && $notification != null){

            $message = array( "data" => $data, "notification" => $notification, "to" => $tokenCliente);
            $this->sendToFCM($message);
                
        }else{
            return $this->response->withStatus(400);
        }

    }

    public function sendToLojaById(){
        
        $json = $this->request->getParsedBody();
        $idLoja = $this->args['id'];
        $data = $json['data'];
        $notification = $json['notification'];

        if( $data != null && $notification != null){

            $tokenLoja = $this->fcmDao->getLojaTokenById($idLoja)[0];

            if($tokenLoja != null){

                $message = json_encode(array( "data" => $data, "notification" => $notification, "to" => $tokenLoja) );
                sendToFCM($message);

            }else{
                return $this->response->withStatus(204);
            }

        }else{
            return $this->response->withStatus(400);
        }

    }

    public function sendToLojaByToken(){
        
        $json = $this->request->getParsedBody();
        $tokenLoja = $this->args['token'];
        $data = $json['data'];
        $notification = $json['notification'];

        if( $data != null && $notification != null){

            $message = json_encode(array( "data" => $data, "notification" => $notification, "to" => $tokenLoja) );
            sendToFCM($message);
                
        }else{
            return $this->response->withStatus(400);
        }

    }

    function sendToFCM($message){

         //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = "AAAAkD0TT_o:APA91bF62KQ6maJg3vbphEeI1c4R9T5qDplCdXKd3rsxuXSomj1m4BOM-1iRDWaCvIpHCasHgl5D9ctNq-6cuNu_HmOkjUAtrN2sL21_50_dVUv5oLmBs1N_9iR5M679H8K7ecAdHl-Q";
                
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );

        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }

        curl_close($ch);

        $resultado = json_decode($result);

        if($resultado['success'] >= 1){
            return $response->withStatus(200);
        }else{
            return $response->withStatus(100);
        }

    }
 
}    
    

?>