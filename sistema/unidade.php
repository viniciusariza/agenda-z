<?php
require_once '../dao/UnidadeDAO.php';
include_once '_msg.php';

$dao = new UnidadeDAO();
$cod = '';
$nome = '';
$ativa = 1;
$estado = '';

if (isset($_POST['btnSalvar'])) {
    $cod = $_POST['cod'];
    $nome = $_POST['nome'];
    $ativa = isset($_POST['ativa']) ? '1' : '0';

    if ($cod == '') {
        $ret = $dao->InserirUnidade($nome, $ativa);
    } else {
        $ret = $dao->AlterarUnidade($cod, $nome, $ativa);
    }
    $cod = '';
    $nome = '';
    $ativa = 1;
    $estado = '';
} else if (isset($_GET['cod']) && isset($_GET['nome']) && isset($_GET['ativa'])) {
    $cod = $_GET['cod'];
    $nome = $_GET['nome'];
    $ativa = $_GET['ativa'];
    $estado = 'a';
} else if (isset($_GET['excluir']) && isset($_GET['cod'])) {
    $cod = $_GET['cod'];
    $ret = $dao->ExcluirUnidade($cod);
}
$unidades = $dao->ConsultarUnidade();
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
                                    <form method="post" action="unidade.php">
                                        <input type="hidden" name="cod" value="<?= $estado == 'a' ? $cod : '' ?>" />
                                        <div class="form-group">
                                            <label>Nome da unidade</label>
                                            <input type="text" maxlength="100" class="form-control" id="nome" name="nome" placeholder="Digite aqui..." value="<?= $nome ?>">
                                        </div>
                                        <div class="form-check form-check-flat form-check-primary">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" id="ativa" name="ativa" <?= $ativa == '1' ? 'checked' : '' ?>>Unidade ativa</label>
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
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nome da unidade cadastrada</th>
                                                <th>A unidade está ativa?</th>
                                                <th>Execute uma ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i = 0; $i < count($unidades); $i++) { ?>
                                                <tr>
                                                    <td><?= $unidades[$i]['nome_unidade'] ?></td>
                                                    <td><?= $unidades[$i]['ativa_unidade'] == 1 ? 'Sim' : 'Não' ?></td>
                                                    <td>
                                                        <a href="unidade.php?cod=<?= $unidades[$i]['id_unidade'] ?>&nome=<?= $unidades[$i]['nome_unidade'] ?>&ativa=<?= $unidades[$i]['ativa_unidade'] ?>" class="btn btn-inverse-primary btn-sm">Alterar</a>
                                                        <a href="unidade.php?excluir=true&cod=<?= $unidades[$i]['id_unidade'] ?>" class="btn btn-inverse-danger btn-sm">Excluir</a>
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