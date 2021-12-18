<?php

require_once 'UtilDAO.php';
require_once 'Conexao.php';

class UnidadeDAO extends Conexao {

    public function InserirUnidade($nome, $ativa) {

        if (trim($nome) == '') {
            return 0;
        }

        $conexao = parent::retornaConexao();
        $comando = 'insert into tb_unidade (nome_unidade, ativa_unidade, id_usuario) values(?,?,?)';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, $nome);
        $sql->bindValue(2, $ativa);
        $sql->bindValue(3, UtilDAO::CodigoLogado());

        try {
            $sql->execute();
            return 1;
        } catch (Exception $ex) {
            return -1;
        }
    }

    public function ConsultarUnidade() {

        $conexao = parent::retornaConexao();
        $comando = 'select id_unidade, nome_unidade, ativa_unidade from tb_unidade where id_usuario = ? order by nome_unidade';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, UtilDAO::CodigoLogado());
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function ConsultarUnidadeAtiva() {

        $conexao = parent::retornaConexao();
        $comando = 'select id_unidade, nome_unidade, ativa_unidade from tb_unidade where id_usuario = ? and ativa_unidade = 1 order by nome_unidade';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, UtilDAO::CodigoLogado());
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function AlterarUnidade($cod, $nome, $ativa) {

        if (trim($nome) == '') {
            return 0;
        }

        $conexao = parent::retornaConexao();
        $comando = 'update tb_unidade set nome_unidade = ?, ativa_unidade = ? where id_unidade = ?';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, $nome);
        $sql->bindValue(2, $ativa);
        $sql->bindValue(3, $cod);

        try {
            $sql->execute();
            return 1;
        } catch (Exception $ex) {
            return -1;
        }
    }

    public function ExcluirUnidade($cod) {

        $conexao = parent::retornaConexao();
        $comando = 'delete from tb_unidade where id_unidade = ?';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, $cod);
        try {
            $sql->execute();
            return 1;
        } catch (Exception $ex) {
            return -2;
        }
    }

    private static function IniciarSessao() {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public static function CriarSessaoUnidade($codUnidade) {
        self::IniciarSessao();
        $_SESSION['unidade'] = $codUnidade;
    }

    public static function UnidadeAtual() {
        self::IniciarSessao();
        return $_SESSION['unidade'];
    }

}