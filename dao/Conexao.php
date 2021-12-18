<?php

// Configurações do site
define('HOST', 'localhost'); //IP
define('USER', 'root'); //usuario
define('PASS', ''); //Senha
define('DB', 'agendaz'); //Banco

class Conexao {

    /** @var PDO */
    private static $Connect;

    private static function Conectar() {
        try {

            //Verifica se a conexão não existe
            if (self::$Connect == null):

                $dsn = 'mysql:host=' . HOST . ';dbname=' . DB;
                self::$Connect = new PDO($dsn, USER, PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
            endif;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        //Seta os atributos para que seja retornado as excessões do banco
        self::$Connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return self::$Connect;
    }

    public function retornaConexao() {
        return self::Conectar();
    }

}