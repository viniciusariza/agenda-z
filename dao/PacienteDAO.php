<?php

require_once 'UtilDAO.php';
require_once 'Conexao.php';

class PacienteDAO extends Conexao
{

    public function InserirPaciente($nome, $cad, $ativo, $unidade)
    {

        if (trim($nome) == '' || $unidade == '') {
            return 0;
        }

        $conexao = parent::retornaConexao();
        $comando = 'insert into tb_paciente (nome_paciente, cad_paciente, ativo_paciente, id_unidade) values(?,?,?,?)';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, $nome);
        $sql->bindValue(2, $cad);
        $sql->bindValue(3, $ativo);
        $sql->bindValue(4, $unidade);
        try {
            $sql->execute();
            return 1;
        } catch (Exception $ex) {
            return -1;
        }
    }

    public function ConsultarPaciente()
    {

        $conexao = parent::retornaConexao();
        $comando = 'select id_paciente, nome_paciente, cad_paciente, ativo_paciente, nome_unidade, u.id_unidade from tb_paciente p inner join tb_unidade u on u.id_unidade = p.id_unidade inner join tb_usuario us on us.id_usuario = u.id_usuario where us.id_usuario = ? order by nome_unidade, nome_paciente';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, UtilDAO::CodigoLogado());
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function ConsultarPacienteAtivo()
    {

        $conexao = parent::retornaConexao();
        $comando = 'select id_paciente, nome_paciente, cad_paciente, ativo_paciente, nome_unidade, u.id_unidade from tb_paciente p inner join tb_unidade u on u.id_unidade = p.id_unidade inner join tb_usuario us on us.id_usuario = u.id_usuario where us.id_usuario = ? and ativo_paciente = 1 order by nome_unidade, nome_paciente';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, UtilDAO::CodigoLogado());
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();
        return $sql->fetchAll();
    }


    public function ConsultarPacienteAtivoUnidade($unidade)
    {

        $conexao = parent::retornaConexao();
        $comando = 'select id_paciente, nome_paciente, cad_paciente, ativo_paciente, nome_unidade, u.id_unidade from tb_paciente p inner join tb_unidade u on u.id_unidade = p.id_unidade inner join tb_usuario us on us.id_usuario = u.id_usuario where us.id_usuario = ? and ativo_paciente = 1 and u.id_unidade = ? order by nome_unidade, nome_paciente';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, UtilDAO::CodigoLogado());
        $sql->bindValue(2, $unidade);
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();
        return $sql->fetchAll();
    }


    public function ConsultarAgendaPaciente($paciente)
    {

        $conexao = parent::retornaConexao();
        $comando = 'select descricao_agenda, inicio_agenda, fim_agenda from tb_agenda a inner join tb_paciente p on p.id_paciente = a.id_paciente where a.id_paciente = ?';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, $paciente);
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function AlterarPaciente($cod, $nome, $cad, $ativo, $unidade)
    {

        if (trim($nome) == '' || $unidade == '') {
            return 0;
        }

        $conexao = parent::retornaConexao();
        $comando = 'update tb_paciente set nome_paciente = ?, cad_paciente = ?, ativo_paciente = ?, id_unidade = ? where id_paciente = ?';
        $sql = new PDOStatement();
        $sql = $conexao->prepare($comando);
        $sql->bindValue(1, $nome);
        $sql->bindValue(2, $cad);
        $sql->bindValue(3, $ativo);
        $sql->bindValue(4, $unidade);
        $sql->bindValue(5, $cod);

        try {
            $sql->execute();
            return 1;
        } catch (Exception $ex) {
            return -1;
        }
    }

    public function ExcluirPaciente($cod)
    {

        $conexao = parent::retornaConexao();
        $comando = 'delete from tb_paciente where id_paciente = ?';
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
}