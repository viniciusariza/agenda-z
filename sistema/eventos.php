<?php

require_once '../dao/AgendaDAO.php';
require_once '../dao/UnidadeDAO.php';

$unidade = UnidadeDAO::UnidadeAtual();
$daoAgenda = new AgendaDAO();
$agendamentos = $daoAgenda->ConsultarAgenda(UtilDAO::CodigoLogado(), $unidade);

if (count($agendamentos) > 0) {
    for ($i = 0; $i < count($agendamentos); $i++) {
        $eventos[] = array(
            'id' => $agendamentos[$i]['id_agenda'],
            'title' => $agendamentos[$i]['nome_paciente'],
            'color' => $agendamentos[$i]['cor_agenda'],
            'start' => $agendamentos[$i]['inicio_agenda'],
            'end' => $agendamentos[$i]['fim_agenda'],
            'unidade' => $agendamentos[$i]['nome_unidade'],
            'descricao' => $agendamentos[$i]['descricao_agenda'],
        );
    }
}
echo json_encode($eventos);