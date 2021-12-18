<?php

session_start();
require_once '../dao/AgendaDAO.php';
require_once '../dao/UnidadeDAO.php';

$daoAgenda = new AgendaDAO();

$unidade = UnidadeDAO::UnidadeAtual();
$paciente = $_POST['paciente'];
$cor = $_POST['color'];
$inicio = $_POST['start'];
$fim = $_POST['end'];
$descricao = $_POST['descricao'];

$data_start = str_replace('/', '-', $inicio);
$data_start_conv = date("Y-m-d H:i:s", strtotime($data_start));

$data_end = str_replace('/', '-', $fim);
$data_end_conv = date("Y-m-d H:i:s", strtotime($data_end));

$ret = $daoAgenda->InserirEvento($paciente, $cor, $data_start_conv, $data_end_conv, $descricao, $unidade);

if ($ret == 1) {
    $retorna = ['sit' => true, 'msg' => '<div class="alert alert-primary" role="alert">Evento cadastrado com sucesso!</div>'];
    $_SESSION['msg'] = '<div class="alert alert-primary" role="alert">Evento cadastrado com sucesso!</div>';
} else if ($ret == 0) {
    $retorna = ['sit' => false, 'msg' => '<div class="alert alert-primary" role="alert">Atenção: Preencha os campos obrigatórios!</div>'];
} else {
    $retorna = ['sit' => false, 'msg' => '<div class="alert alert-primary" role="alert">Erro: Não foi possível cadastrar o evento! Selecione uma unidade ou tentemais tarde</div>'];
}

header('Content-Type: application/json');
echo json_encode($retorna);
