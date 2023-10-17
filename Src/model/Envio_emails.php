<?php

/**
 * Classe: Envio_emails
 * Objetivo: Registrar e controlar o envio de e-mails de um respectivo colaborador
 * Data: 28/02/23
 */

namespace model;

require_once   $_SESSION['URL_SYSTEM'] . "\\src\\model\\Colaborador.php";
use model\Colaborador;

class Envio_emails
{


    private   $id;

    private   $de;

    private   $para;

    private   $cc;

    private   $assunto;

    private   $conteudo;

    private   $data_envio;

    private   $status_enviado;

    private   $data_cadastroEmail;


    private  $Colaborador;


    public function __construct()
    {
        $this-> Colaborador = new Colaborador(); 
    }


    public function getId()
    {
        return $this->id;
    }

    public function getDe()
    {
        return $this->de;
    }

    public function getPara()
    {
        return $this->para;
    }

    public function getCc()
    {
        return $this->cc;
    }

    public function getAssunto()
    {
        return $this->assunto;
    }

    public function getConteudo()
    {
        return $this->conteudo;
    }

    public function getData_envio()
    {
        return $this->data_envio;
    }

    public function getStatus_enviado()
    {
        return $this->status_enviado;
    }

    public function getData_cadastroEmail()
    {
        return $this->data_cadastroEmail;
    }

    public function getColaborador()
    {
        return $this->Colaborador;
    }



    public function setId(  $id): void
    {
        $this->id = $id;
    }

    public function setDe(  $de) : void
    {
        $this->de = $de;
    }

    public function setPara(  $para) : void
    {
        $this->para = $para;
    }

    public function setCC(  $cc) : void
    {
        $this->cc = $cc;
    }

    public function setAssunto(  $assunto) : void
    {
        $this->assunto = $assunto;
    }

    public function setConteudo(  $conteudo) : void
    {
        $this->conteudo = $conteudo;
    }

    public function setData_envio(  $data_envio) : void
    {
        $this->data_envio = $data_envio;
    }

    public function setStatus_enviado(  $status_enviado) : void
    {
        $this->status_enviado = $status_enviado;
    }

    public function setData_cadastroEmail(  $data_cadastroEmail) : void
    {
        $this->data_cadastroEmail = $data_cadastroEmail;
    }

    public function setColaborador($Colaborador) : void
    {
        $this->Colaborador = $Colaborador;
    }
}
