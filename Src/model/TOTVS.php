<?php

/**
 * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
 * ║                                                   Senac - Aceite                                                  ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ NOTA: Todas as informações contidas neste documento são propriedade do SENAC PERNAMBUCO e seus fornecedores,│  ║
 * ║  │ caso existam. Os conceitos  electuais e técnicos contidos são propriedade do SENAC PERNAMBUCO e seus      │  ║
 * ║  │ fornecedores e podem estar cobertos pelas patentes nacionais, e estão protegidas por segredo comercial ou   │  ║
 * ║  │ lei de direitos autorais. Divulgação desta informação ou reprodução deste material é estritamente proibido, │  ║
 * ║  │ a menos que seja obtida permissão prévia por escrito do SENAC PERNAMBUCO.                                   │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ @description: TOTVS is the database from the secretary with all the new workers                             │  ║
 * ║  │ @class: TOTVS                                                                                               │  ║
 * ║  │ @dir: src/model                                                                                             │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 01/12/22                                                                                             │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 * ║                                                     UPGRADES                                                      ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 1. @date:                                                                                                   │  ║
 * ║  │    @description:                                                                                            │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║                                                                                                                   ║
 * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
 */

namespace model;

class TOTVS
{
  /*╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗   
/** ║                                                    Atributes                                                  ║ */
 // ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ It's the number of registration of the User                                                                   |
     * │ @access private                                                                                               │
     * │ @var                                                                                                     │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    private   $chapa;

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ Cpf from the employee.                                                                                        |
     * │ @access private                                                                                               │
     * │ @var                                                                                                     │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    private   $cpf;

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ Full name and all last names of the employee.                                                                 |
     * │ @access private                                                                                               │
     * │ @var                                                                                                     │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    private   $nome;

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ Employee's designated role.                                                                                   |
     * │ @access private                                                                                               │
     * │ @var                                                                                                     │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    private   $cargo;

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ Employee's date of birth                                                                                      |
     * │ @access private                                                                                               │
     * │ @var                                                                                                     │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    private   $dataNascimento;

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ E-mail for personal use of the new employee that will be used to contact.                                     |
     * │ @access private                                                                                               │
     * │ @var                                                                                                     │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    private   $email;

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ Employee contact phone number.                                                                                |
     * │ @access private                                                                                               │
     * │ @var                                                                                                     │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    private   $telefone;

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ A boolean type (1 or 0) generated in the database to say if the register is avaliable on the system           │
     * │ @access private                                                                                               │
     * │ @var                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    private   $situacao;

        /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ Unity from the worker                                                                                         │
     * │ @access private                                                                                               │
     * │ @var                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    private   $Unidade;

        /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ employee hours                                                                                                │
     * │ @access private                                                                                               │
     * │ @var                                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    private   $Horario;



    public function __construct()
    {
        
    }

    /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║                                                    METHODS                                                    ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     */

  /*╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗   
/** ║                                                    GET METHODS                                                ║ */
 // ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝

    /* ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │ @return                                                                                                     │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */  
    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @return                                                                                                 │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function getChapa()
    {
        return $this-> chapa;
    }

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @return                                                                                                 │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function getCpf()
    {
        return $this-> cpf;
    }

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @return                                                                                                 │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function getNome()
    {
        return $this-> nome;
    }

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @return                                                                                                 │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function getCargo()
    {
        return $this-> cargo;
    }

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @return                                                                                                 │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function getDataNascimento()
    {
        return $this-> dataNascimento;
    }

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @return                                                                                                 │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function getEmail()
    {
        return $this-> email;
    }

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @return                                                                                                 │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function getTelefone()
    {
        return $this-> telefone;
    }

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @return                                                                                                 │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function getSituacao()
    {
        return $this-> situacao;
    }

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @return                                                                                                 │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function getUnidade()
    {
        return $this-> Unidade;
    }

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @return                                                                                                 │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function getHorario()
    {
        return $this-> Horario;
    }


  /*╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗   
/** ║                                                    SET METHODS                                                ║ */
 // ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @param     $chapa                                                                                       │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function setChapa(  $chapa) : void
    {
        $this-> chapa = $chapa;
    }

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @param     $cpf                                                                                         │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function setCpf(  $cpf) : void
    {
        $this-> cpf = $cpf;
    }


    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @param     $nome                                                                                        │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function setNome(  $nome) : void
    {
        $this-> nome = $nome;
    }

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @param     $cargo                                                                                       │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function setCargo(  $cargo) : void
    {
        $this-> cargo = $cargo;
    }

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @param     $dataNascimento                                                                              │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function setDataNascimento(  $dataNascimento) : void
    {
        $this-> dataNascimento = $dataNascimento;
    }

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @param     $email                                                                                       │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function setEmail(  $email) : void
    {
        $this-> email = $email;
    }

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @param     $telefone                                                                                    │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function setTelefone(  $telefone) : void
    {
        $this-> telefone = $telefone;
    }

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @param     $situacao                                                                                    │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function setSituacao(  $situacao) : void
    {
        $this-> situacao = $situacao;
    }

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @param     $unidade                                                                                     │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function setUnidade(  $unidade) : void
    {
        $this-> Unidade = $unidade;
    }

    /**
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @param     $Horario                                                                                     │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */ 
    public function setHorario(  $Horario) : void
    {
        $this-> Horario = $Horario;
    }


}
