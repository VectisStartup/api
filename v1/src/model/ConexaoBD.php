<?php
/**
 * Created by PhpStorm.
 * User: candido
 * Date: 16/08/2018
 * Time: 23:06
 */

require_once (__DIR__."/Medoo.php");


class ConexaoBD
{

    public $database;

    //remove esse comentario quando for para testar no servidor
    //E comenta igualzinho o outro bloco de codigo
    //Nunca se esquece, never forget
    public function __construct()
    {
        $this->database = new \Medoo\Medoo([
            'database_type' => 'mysql',
            'database_name' => 'lnYToa7J9Y',
            'server' => 'remotemysql.com',
            'username' => 'lnYToa7J9Y',
            'password' => 'z1DplIjphX',
            'charset' => 'utf8']);
    }


    //Esse bloco aqui é para comentar, antes de enviar para o servidor
    /*public function __construct()
    {
        $this->database = new \Medoo\Medoo([
            'database_type' => 'mysql',
            'database_name' => 'vectisfood',
            'server' => 'localhost',
            'username' => 'candido',
            'password' => '12345',
            'charset' => 'utf8']);
    }*/

}
