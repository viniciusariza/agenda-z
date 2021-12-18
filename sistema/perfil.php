<?php
require_once '../dao/PerfilDAO.php';
include_once '_msg.php';

$daoPerfil = new PerfilDAO();
$perfil = $daoPerfil->ConsultarPerfil();

$nome = $perfil[0]['nome_usuario'];
$login = $perfil[0]['login_usuario'];
$senha = $perfil[0]['senha_usuario'];

if (isset($_POST['btnSalvar'])) {
    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $ret = $daoPerfil->AlterarPerfil($nome, $login, $senha);
}
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
                                    <form method="post" action="perfil.php" class="forms-sample">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" maxlength="100" class="form-control" id="nome" name="nome" placeholder="Digite aqui..." value="<?= $nome ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Usuário</label>
                                            <input type="email" class="form-control" id="login" name="login" placeholder="Digite aqui..." value="<?= $login ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Senha</label>
                                            <input type="password" maxlength="20" class="form-control" id="senha" name="senha" placeholder="Digite aqui..." value="<?= $senha ?>">
                                        </div>
                                        <br>
                                        <button name="btnSalvar" class="btn btn-gradient-primary mr-2">Salvar</button>
                                        <button class="btn btn-light mr-2">Cacelar</button>
                                    </form>
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