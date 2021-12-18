<?php

require_once 'UtilDAO.php';
require_once 'Conexao.php';

class UsuarioDAO extends Conexao {

    public function ValidarLogin($email, $senha) {
        if (trim($email) == '' || trim($senha) == '') {
            return 0;
        }
        $conexao = parent::retornaConexao();
        $comando = 'select id_usuario from tb_usuario where login_usuario = ? and senha_usuario = ? and ativo_usuario = 1';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, $email);
        $sql->bindValue(2, $senha);
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        $user = $sql->fetchAll();

        if (count($user) == 0) {
            return -3;
        } else {
            UtilDAO::CriarSessao($user[0]['id_usuario']);
            header('location:agenda.php');
        }
    }
}
