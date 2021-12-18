<?php

require_once 'UtilDAO.php';
require_once 'Conexao.php';

class PerfilDAO extends Conexao
{
    public function ConsultarPerfil()
    {

        $conexao = parent::retornaConexao();
        $comando = 'select id_usuario, nome_usuario, login_usuario, senha_usuario, ativo_usuario from tb_usuario where id_usuario = ?';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, UtilDAO::CodigoLogado());
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function AlterarPerfil($nome, $login, $senha)
    {

        if (trim($nome) == '' || trim($login) == '' || trim($senha) == '') {
            return 0;
        }

        $conexao = parent::retornaConexao();
        $comando = 'update tb_usuario set nome_usuario = ?, login_usuario = ?, senha_usuario = ? where id_usuario = ?';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, $nome);
        $sql->bindValue(2, $login);
        $sql->bindValue(3, $senha);
        $sql->bindValue(4, UtilDAO::CodigoLogado());

        try {
            $sql->execute();
            return 1;
        } catch (Exception $ex) {
            return -3;
        }
    }
}
