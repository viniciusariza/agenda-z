<?php

session_start();
require_once '../dao/AgendaDAO.php';

$daoAgenda = new AgendaDAO();

$cod = $_GET['id'];

if (!empty($cod)) {
    $ret = $daoAgenda->ExcluirEvento($cod);

    if ($ret) {
        $_SESSION['msg'] = '<div class="alert alert-primary" role="alert">O evento foi apagado com sucesso!</div>';
        header("Location: agenda.php");
    } else {
        $_SESSION['msg'] = '<div class="alert alert-primary" role="alert">Erro: O evento não foi apagado com sucesso!</div>';
        header("Location: agenda.php");
    }
} else {
    $_SESSION['msg'] = '<div class="alert alert-primary" role="alert">Erro: O evento não foi apagado com sucesso!</div>';
    header("Location: agenda.php");
}