<?php

require_once 'UtilDAO.php';
require_once 'Conexao.php';

class AgendaDAO extends Conexao {

    public function ConsultarAgenda($usuario, $unidade) {

        $conexao = parent::retornaConexao();
        $comando = 'select id_agenda, descricao_agenda, cor_agenda, inicio_agenda, fim_agenda, u.id_unidade, u.nome_unidade, nome_paciente, cad_paciente from tb_agenda a inner join tb_paciente p on p.id_paciente = a.id_paciente inner join tb_unidade u on u.id_unidade = a.id_unidade inner join tb_usuario us on us.id_usuario = u.id_usuario where us.id_usuario = ? and u.id_unidade = ?';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, $usuario);
        $sql->bindValue(2, $unidade);
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function InserirEvento($paciente, $cor, $inicio, $fim, $descricao, $unidade) {

        if ($paciente == '' || trim($inicio) == '' || trim($fim) == '') {
            return 0;
        }
        $conexao = parent::retornaConexao();
        $comando = 'insert into tb_agenda (id_paciente, cor_agenda, inicio_agenda, fim_agenda, descricao_agenda, id_unidade) values(?,?,?,?,?,?)';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, $paciente);
        $sql->bindValue(2, $cor);
        $sql->bindValue(3, $inicio);
        $sql->bindValue(4, $fim);
        $sql->bindValue(5, $descricao);
        $sql->bindValue(6, $unidade);
        try {
            $sql->execute();
            return 1;
        } catch (Exception $ex) {
            return -1;
        }
    }

    public function AlterarEvento($cod, $cor, $inicio, $fim, $descricao) {

        if ($cod == '' || trim($inicio) == '' || trim($fim) == '') {
            return 0;
        }
        $conexao = parent::retornaConexao();
        $comando = 'update tb_agenda set cor_agenda = ?, inicio_agenda = ?, fim_agenda = ?, descricao_agenda = ? where id_agenda = ?';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, $cor);
        $sql->bindValue(2, $inicio);
        $sql->bindValue(3, $fim);
        $sql->bindValue(4, $descricao);
        $sql->bindValue(5, $cod);
        try {
            $sql->execute();
            return 1;
        } catch (Exception $ex) {
            return -1;
        }
    }

    public function ExcluirEvento($cod) {

        $conexao = parent::retornaConexao();
        $comando = 'delete from tb_agenda where id_agenda = ?';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, $cod);
        try {
            $sql->execute();
            return 1;
        } catch (Exception $ex) {
            return -1;
        }
    }
}