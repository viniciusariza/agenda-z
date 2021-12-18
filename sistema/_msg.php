<?php

function ExibirMsg($ret)
{
    switch ($ret) {
        case -3:

            echo '<div class="alert alert-primary">
                    Acesso negado
                </div>';

            break;
        case -2:

            echo '<div class="alert alert-primary">
                    Não foi possível excluir o registro, pois o mesmo está em uso
                </div>';

            break;
        case -1:

            echo '<div class="alert alert-primary">
                    Ocorreu um erro na operação! Tente mais tarde
                </div>';

            break;

        case 0:

            echo '<div class="alert alert-primary">
                    Preencha o(s) campo(s) obrigatório(s)
                </div>';

            break;

        case 1:

            echo '<div class="alert alert-primary">
                    Ação realizada com sucesso
                </div>';

            break;
    }
}
