<?php
require_once '../dao/UnidadeDAO.php';
require_once '../dao/PacienteDAO.php';

$daoUnidade = new UnidadeDAO();
$daoPaciente = new PacienteDAO();

$unidade = '';
UnidadeDAO::CriarSessaoUnidade($unidade);

if (isset($_POST['btnAtualizar'])) {
    $unidade = $_POST['unidadeselect'];
    UnidadeDAO::CriarSessaoUnidade($unidade);
}

$unidades = $daoUnidade->ConsultarUnidadeAtiva();
$pacientes = $daoPaciente->ConsultarPacienteAtivoUnidade(UnidadeDAO::UnidadeAtual());
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
                    <form method="post" action="agenda.php">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-sm-11">
                                    <select class="form-control form-control-sm" name="unidadeselect" id="unidadeselect">
                                        <option value="">Selecione uma unidade</option>
                                        <?php for ($i = 0; $i < count($unidades); $i++) { ?>
                                            <option value="<?= $unidades[$i]['id_unidade'] ?>" <?= UnidadeDAO::UnidadeAtual() == $unidades[$i]['id_unidade'] ? 'selected' : '' ?>><?= $unidades[$i]['nome_unidade'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <button type="subimit" class=" btn-inverse-primary btn-rounded btn-icon" name="btnAtualizar" onclick="BuscarAgenda()">
                                        <i class="mdi mdi-autorenew"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div id="agenda_c" class="card-body">
                                <div id="calendar"></div>
                                <div class="modal fade" id="visualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Detalhes do atendimento</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="visevent">
                                                    <dl class="row">
                                                        <dt class="col-sm-3">Unidade</dt>
                                                        <dd class="col-sm-9" id="unidade"></dd>

                                                        <dt class="col-sm-3">Nome do paciente</dt>
                                                        <dd class="col-sm-9" id="title"></dd>

                                                        <dt class="col-sm-3">Início do atendimento</dt>
                                                        <dd class="col-sm-9" id="start"></dd>

                                                        <dt class="col-sm-3">Fim do atendimento</dt>
                                                        <dd class="col-sm-9" id="end"></dd>

                                                        <dt class="col-sm-3">Descrição</dt>
                                                        <dd class="col-sm-9" id="descricao"></dd>
                                                    </dl>
                                                    <button name="btnEditar" class="btn btn-gradient-primary mr-2 btn-canc-vis">Editar</button>
                                                    <a href="" id="apagar_evento" class="btn btn-gradient-danger mr-2">Excluir</a>
                                                </div>
                                                <div class="formedit">
                                                    <span id="msg-edit"></span>
                                                    <form id="editevent" method="POST" enctype="multipart/form-data">
                                                        <input type="hidden" name="id" id="id">
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Nome do paciente</label>
                                                            <div class="col-sm-9">
                                                                <input readonly="readonly" type="text" name="title" class="form-control" id="title">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Cor</label>
                                                            <div class="col-sm-9">
                                                                <select name="color" class="form-control" id="color">
                                                                    <option style="color:#AD9AC7;" value="#AD9AC7">Roxo</option>
                                                                    <option style="color:#0071c5;" value="#0071c5">Azul Escuro</option>
                                                                    <option style="color:#40E0D0;" value="#40E0D0">Azul Claro</option>
                                                                    <option style="color:#FFD700;" value="#FFD700">Amarelo</option>
                                                                    <option style="color:#FF4500;" value="#FF4500">Laranja</option>
                                                                    <option style="color:#228B22;" value="#228B22">Verde</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Início do atendimento</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="start" class="form-control" id="start" onkeypress="DataHora(event, this)">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Fim do atendimento</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="end" class="form-control" id="end" onkeypress="DataHora(event, this)">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Descrição</label>
                                                            <div class="col-sm-9">
                                                                <textarea limit="2000" name="descricao" class="form-control" id="descricao"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-sm-12">
                                                                <button type="submit" name="CadEvent" id="CadEvent" value="CadEvent" class="btn btn-gradient-primary mr-2">Salvar</button>
                                                                <button type="button" class="btn btn-light mr-2 btn-canc-edit">Cancelar</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Cadastrar atendimento</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="addevent" method="POST" enctype="multipart/form-data">
                                                <input hidden="hidden" id="unidade" name="unidade">
                                                <div class="modal-body">
                                                    <span id="msg-cad"></span>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Nome do paciente</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control form-control-sm" name="paciente" id="paciente">
                                                                <option value="">Selecione</option>
                                                                <?php for ($i = 0; $i < count($pacientes); $i++) { ?>
                                                                    <option value="<?= $pacientes[$i]['id_paciente'] ?>"><?= $pacientes[$i]['nome_paciente'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <a href="paciente.php">
                                                            <button type="button" class="btn btn-inverse-primary btn-rounded btn-icon">
                                                                <i class="mdi mdi-account-plus"></i>
                                                            </button>
                                                        </a>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Cor</label>
                                                        <div class="col-sm-9">
                                                            <select name="color" class="form-control" id="color">
                                                                <option style="color:#AD9AC7;" value="#AD9AC7">Roxo</option>
                                                                <option style="color:#0071c5;" value="#0071c5">Azul Escuro</option>
                                                                <option style="color:#40E0D0;" value="#40E0D0">Azul Claro</option>
                                                                <option style="color:#FFD700;" value="#FFD700">Amarelo</option>
                                                                <option style="color:#FF4500;" value="#FF4500">Laranja</option>
                                                                <option style="color:#228B22;" value="#228B22">Verde</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Início do atendimento</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="start" class="form-control" id="start" onkeypress="DataHora(event, this)">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Fim do atendimento</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="end" class="form-control" id="end" onkeypress="DataHora(event, this)">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Descrição</label>
                                                        <div class="col-sm-9">
                                                            <textarea limit="2000" name="descricao" class="form-control" id="descricao"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-9">
                                                            <input type="submit" name="CadEvent" id="CadEvent" value="Cadastrar" class="btn btn-gradient-primary mr-2">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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