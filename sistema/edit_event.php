<?php

session_start();
require_once '../dao/AgendaDAO.php';

$daoAgenda = new AgendaDAO();

$cod = $_POST['id'];
$cor = $_POST['color'];
$inicio = $_POST['start'];
$fim = $_POST['end'];
$descricao = $_POST['descricao'];

$data_start = str_replace('/', '-', $inicio);
$data_start_conv = date("Y-m-d H:i:s", strtotime($data_start));

$data_end = str_replace('/', '-', $fim);
$data_end_conv = date("Y-m-d H:i:s", strtotime($data_end));

$ret = $daoAgenda->AlterarEvento($cod, $cor, $data_start_conv, $data_end_conv, $descricao);

if ($ret == 1) {
    $retorna = ['sit' => true, 'msg' => '<div class="alert alert-primary" role="alert">Evento salvo com sucesso!</div>'];
    $_SESSION['msg'] = '<div class="alert alert-primary" role="alert">Evento salvo com sucesso!</div>';
} else if ($ret == 0) {
    $retorna = ['sit' => false, 'msg' => '<div class="alert alert-primary" role="alert">Atenção: Preencha os campos obrigatórios!</div>'];
} else {
    $retorna = ['sit' => false, 'msg' => '<div class="alert alert-primary" role="alert">Erro: Não foi possível editar o evento!</div>'];
}

header('Content-Type: application/json');
echo json_encode($retorna);
