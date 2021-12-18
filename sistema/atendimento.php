<?php
require_once '../dao/PacienteDAO.php';
include_once '_msg.php';

$dao = new PacienteDAO();

if (isset($_GET['cod']) && isset($_GET['nome']) && isset($_GET['cad'])) {
    $cod = $_GET['cod'];
    $nome = $_GET['nome'];
    $cad = $_GET['cad'];
}

$agendas = $dao->ConsultarAgendaPaciente($cod);
$pacientes = $dao->ConsultarPaciente();
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php
include_once '_head.php';
?>

<body>
    <div class="container-scroller">
        <?php
        include_once '_topo.php';
        ?>
        <div class="container-fluid page-body-wrapper">
            <?php
            include_once '_menu.php';
            ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Dados do paciente</h4>
                                    <?php
                                    if (isset($ret)) {
                                        ExibirMsg($ret);
                                    }
                                    ?>
                                    <br>
                                    <div class="form-group">
                                        <label>Nome do paciente</label>
                                        <input disabled="disabled" type="text" maxlength="100" class="form-control" id="nome" name="nome" placeholder="Digite aqui..." value="<?= $nome ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>CAD</label>
                                        <input disabled="disabled" type="tel" maxlength="100" class="form-control" id="cad" name="cad" placeholder="Digite aqui..." value="<?= $cad ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card" style="overflow: auto; height: auto">
                                <div class="card-body">
                                    <h4>Consultar atendimentos</h4>
                                    <br>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Início do atendimento</th>
                                                <th>Fim do atendimento</th>
                                                <th>Descrição do atendimento</th>
                                                <th>Execute uma ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i = 0; $i < count($agendas); $i++) { ?>
                                                <tr>
                                                    <td><?= $agendas[$i]['inicio_agenda'] ?></td>
                                                    <td><?= $agendas[$i]['fim_agenda'] ?></td>
                                                    <td class="td"><?= $agendas[$i]['descricao_agenda'] ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-inverse-primary btn-sm">Detalhar</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                include_once '_rodape.php';
                ?>
            </div>
        </div>
    </div>
</body>

</html>