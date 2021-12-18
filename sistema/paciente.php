<?php
require_once '../dao/PacienteDAO.php';
require_once '../dao/UnidadeDAO.php';
include_once '_msg.php';

$dao = new PacienteDAO();
$daoUnidade = new UnidadeDAO();

$cod = '';
$nome = '';
$cad = '';
$unidade = '';
$ativa = 1;
$estado = '';

if (isset($_POST['btnSalvar'])) {
    $cod = $_POST['cod'];
    $nome = $_POST['nome'];
    $cad = $_POST['cad'];
    $unidade = $_POST['unidade'];
    $ativa = isset($_POST['ativa']) ? '1' : '0';

    if ($cod == '') {
        $ret = $dao->InserirPaciente($nome, $cad, $ativa, $unidade);
    } else {
        $ret = $dao->AlterarPaciente($cod, $nome, $cad, $ativa, $unidade);
    }
    $cod = '';
    $nome = '';
    $cad = '';
    $unidade = '';
    $ativa = 1;
    $estado = '';
} else if (isset($_GET['cod']) && isset($_GET['nome']) && isset($_GET['ativa']) && isset($_GET['cad']) && isset($_GET['unidade'])) {
    $cod = $_GET['cod'];
    $nome = $_GET['nome'];
    $cad = $_GET['cad'];
    $unidade = $_GET['unidade'];
    $ativa = $_GET['ativa'];
    $estado = 'a';
} else if (isset($_GET['excluir']) && isset($_GET['cod'])) {
    $cod = $_GET['cod'];
    $ret = $dao->ExcluirPaciente($cod);
}
$unidades = $daoUnidade->ConsultarUnidade();
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
                                    <h4 class="card-title">Gerenciar</h4>
                                    <?php
                                    if (isset($ret)) {
                                        ExibirMsg($ret);
                                    }
                                    ?>
                                    <br>
                                    <form method="post" action="paciente.php">
                                        <input type="hidden" name="cod" value="<?= $estado == 'a' ? $cod : '' ?>" />
                                        <div class="form-group">
                                            <label>Nome da unidade</label>
                                            <select class="form-control form-control-sm" name="unidade" id="unidade">
                                                <option value="">Selecione uma opção</option>
                                                <?php for ($i = 0; $i < count($unidades); $i++) { ?>
                                                    <option value="<?= $unidades[$i]['id_unidade'] ?>" <?= $unidade == $unidades[$i]['id_unidade'] ? 'selected' : '' ?>><?= $unidades[$i]['nome_unidade'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Nome do paciente</label>
                                            <input type="text" maxlength="100" class="form-control" id="nome" name="nome" placeholder="Digite aqui..." value="<?= $nome ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>CAD</label>
                                            <input type="tel" maxlength="100" class="form-control" id="cad" name="cad" placeholder="Digite aqui..." value="<?= $cad ?>">
                                        </div>
                                        <div class="form-check form-check-flat form-check-primary">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" id="ativa" name="ativa" <?= $ativa == '1' ? 'checked' : '' ?>>Paciente ativo</label>
                                        </div>
                                        <br>
                                        <button name="btnSalvar" class="btn btn-gradient-primary mr-2"><?= $estado == 'a' ? 'Salvar' : 'Cadastrar'; ?></button>
                                        <button class="btn btn-light mr-2">Cancelar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card" style="overflow: auto; height: auto">
                                <div class="card-body">
                                    <h4 class="card-title">Consultar</h4>
                                    <br>
                                    <table class="table table-hover" style="overflow: auto; height: auto">
                                        <thead>
                                            <tr>
                                                <th>Nome da unidade</th>
                                                <th>Nome do paciente</th>
                                                <th>CAD</th>
                                                <th>O paciente está ativo?</th>
                                                <th>Execute uma ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i = 0; $i < count($pacientes); $i++) { ?>
                                                <tr>
                                                    <td><?= $pacientes[$i]['nome_unidade'] ?></td>
                                                    <td><?= $pacientes[$i]['nome_paciente'] ?></td>
                                                    <td><?= $pacientes[$i]['cad_paciente'] ?></td>
                                                    <td><?= $pacientes[$i]['ativo_paciente'] == 1 ? 'Sim' : 'Não' ?></td>
                                                    <td>
                                                        <a href="atendimento.php?cod=<?= $pacientes[$i]['id_paciente'] ?>&nome=<?= $pacientes[$i]['nome_paciente'] ?>&cad=<?= $pacientes[$i]['cad_paciente'] ?>" class="btn btn-inverse-dark btn-sm">Abrir</a>
                                                        <a href="paciente.php?cod=<?= $pacientes[$i]['id_paciente'] ?>&nome=<?= $pacientes[$i]['nome_paciente'] ?>&cad=<?= $pacientes[$i]['cad_paciente'] ?>&unidade=<?= $pacientes[$i]['id_unidade'] ?>&ativa=<?= $pacientes[$i]['ativo_paciente'] ?>" class="btn btn-inverse-primary btn-sm">Alterar</a>
                                                        <a href="paciente.php?excluir=true&cod=<?= $pacientes[$i]['id_paciente'] ?>" class="btn btn-inverse-danger btn-sm">Excluir</a>
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