<?php
require_once '../dao/UtilDAO.php';
require_once '../dao/UsuarioDAO.php';
include_once '_msg.php';

$email = '';
$senha = '';

if (isset($_POST['btnLogar'])) {
    $email = $_POST['login'];
    $senha = $_POST['senha'];

    $dao = new UsuarioDAO();
    $ret = $dao->ValidarLogin($email, $senha);
}
?>﻿

<!DOCTYPE html>
<html lang="pt-br">
<?php
include_once '_head.php';
?>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <?php
                        if (isset($ret)) {
                            ExibirMsg($ret);
                        }
                        ?>
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo">
                                <img src="assets/images/logo.svg">
                            </div>
                            <h4>Olá! vamos começar</h4>
                            <h6 class="font-weight-light">Faça login para continuar</h6>
                            <form method="post" action="login.php" class="pt-3">
                                <div class="form-group">
                                    <input type="email" maxlength="100" class="form-control form-control-lg" id="login" name="login" placeholder="Usuário">
                                </div>
                                <div class="form-group">
                                    <input type="password" maxlength="20" class="form-control form-control-lg" id="senha" name="senha" placeholder="Senha">
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" name="btnLogar">ENTRAR</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>