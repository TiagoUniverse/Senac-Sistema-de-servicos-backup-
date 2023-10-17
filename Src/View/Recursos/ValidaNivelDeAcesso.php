<?php

// Lista dos níveis de acesso
//id = 1 - Administrador
//id = 4 - RH
//id = 6 - Colaborador
//id = 7 - Suporte GTI



function ta_conectado()
{
    if ($_SESSION['connected'] !== '1') {
        header('Location: login.php');
    }
}


function valida_acesso($NivelAcesso_disponivel)
{
    foreach ($NivelAcesso_disponivel as $valor) {
        if ($_SESSION['acessLevel'] == $valor) {
            return true;
        }
    }

    //return false;
    header('Location: Acesso negado.php');
}



function exibe_botao($NivelAcesso_disponivel)
{
    foreach ($NivelAcesso_disponivel as $valor) {
        if ($_SESSION['acessLevel'] == $valor) {
            return true;
        }
    }

    return false;
}


function redirecionando_suporteGTI()
{
    if ($_SESSION['acessLevel'] == 7) {
        //Se a variável existe
        if (isset($_SESSION['criar_email']) == true) {
            if ($_SESSION['criar_email'] == 'PENDENTE') {
                header('Location: Criar_email.php?id=' . $_SESSION['idColaborador']);
            }
        }
    }
}
