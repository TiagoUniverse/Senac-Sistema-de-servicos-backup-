<?php

/**
 * Classe: Envio_emails_CodigoEtica_repositorio
 * Objetivo: Repositorio do envio_emails
 * Data: 06/10/23
 */

namespace model;

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Recursos\\conexao_model.php";
use function Recursos\conexao_declaracao;

class Envio_emails_CodigoEtica_repositorio
{

    /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║                                                    METHODS                                                    ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @return INSERT INTO [Emails_enviados]                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    public function cadastro($de , $para, $cc, $assunto, $conteudo , $idCodigoEtica_Colaborador )
    {

        $declaracao =  "  Insert INTO Envio_Emails_CodigoEtica (de , para, cc , assunto, conteudo  , data_cadastroEmail , idCodigoEtica_Colaborador)
        Values
        ('{$de}' , '{$para}' , '{$cc}' , '{$assunto}' ,   '{$conteudo}'  , GETDATE() ,   '{$idCodigoEtica_Colaborador}' ); ";

        // echo $declaracao;

        conexao_declaracao($declaracao);
    }
}
