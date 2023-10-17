<?php

/**
 * Classe: Envio_emails_repositorio
 * Objetivo: Repositorio do envio_emails
 * Data: 28/02/23
 */

namespace model;

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Recursos\\conexao_model.php";
use function Recursos\conexao_declaracao;

class Envio_emails_repositorio
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
    public function cadastro($de , $para, $cc, $assunto, $conteudo , $ColaboradorId )
    {

        $declaracao =  "  Insert INTO [Envio_emails] (de , para, cc , assunto, conteudo  , data_cadastroEmail , idColaborador)
        Values
        ('{$de}' , '{$para}' , '{$cc}' , '{$assunto}' ,   '{$conteudo}'  , GETDATE() ,   '{$ColaboradorId}' ); ";

        // echo $declaracao;

        conexao_declaracao($declaracao);
    }
}
