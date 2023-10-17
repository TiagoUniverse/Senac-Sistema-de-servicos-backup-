<?php

/**
 * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
 * ║                                                   Senac - Aceite                                                  ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ NOTA: Todas as informações contidas neste documento são propriedade do SENAC PERNAMBUCO e seus fornecedores,│  ║
 * ║  │ caso existam. Os conceitos intelectuais e técnicos contidos são propriedade do SENAC PERNAMBUCO e seus      │  ║
 * ║  │ fornecedores e podem estar cobertos pelas patentes nacionais, e estão protegidas por segredo comercial ou   │  ║
 * ║  │ lei de direitos autorais. Divulgação desta informação ou reprodução deste material é estritamente proibido, │  ║
 * ║  │ a menos que seja obtida permissão prévia por escrito do SENAC PERNAMBUCO.                                   │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ @description: It contains all the functions of the "Criacao_email" class                                    │  ║
 * ║  │ @class: Criacao_email_repositorio                                                                           │  ║
 * ║  │ @dir: src/model                                                                                             │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 12/11/22                                                                                             │  ║
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

use function Recursos\conexao_declaracao;

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Recursos\\conexao_model.php";

class Criacao_email_repositorio
{
    /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║                                                    METHODS                                                    ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @return INSERT INTO [Criacao_email]                                                                          │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    public function cadastro($Criacao_email)
    {

        $declaracao =  "  INSERT INTO [Criacao_email]
        ( [nome_criador] , [nome_colaborador], [idUsuario]  , [idColaborador]) 
        VALUES 
        ('{$Criacao_email->getNome_criador()}' , '{$Criacao_email->getNome_colaborador()}' ,   '{$Criacao_email->getUsuario()->getId()}' ,  
        '{$Criacao_email->getColaborador()->getId()}' ); ";

        // echo $declaracao;

        conexao_declaracao($declaracao);
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Update [Criacao_email]                                                                               │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */


    public function alterar($Criacao_email)
    {

        $declaracao = "
        Update
            [Criacao_email]
        Set
            [nome_criador] = '{$Criacao_email->getNome_criador()}'
            ,  [updated] =  GETDATE()
            , [status] = '{$Criacao_email->getStatus()}'
        Where 
            id = '{$Criacao_email->getId()}' ; 
            
            ";

        conexao_declaracao($declaracao);
    }



    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Update [Criacao_email] set status = 0                                                                │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function deletar($Criacao_email)
    {
        $declaracao = "Update [Criacao_email] SET status = 0 , updated = GETDATE() Where id = '{$Criacao_email->getId()}' ";

        conexao_declaracao($declaracao);
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Update [Criacao_email] set status = 0                                                                │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function deletarByIdUsuario($idUsuario)
    {
        $declaracao = "
        Update 
            [Criacao_email] 
        SET 
            status = 0 , 
            updated = GETDATE() 
        Where 
            idUsuario = '{$idUsuario}' ";

        $declaracao;

        conexao_declaracao($declaracao);
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...  where id and status = 1                                                                  │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultaId($id)
    {
        $declaracao = "
        Select
			*
		from
			Criacao_email
		Where
			status = 1 
            and id = '{$id}' ";

        echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $Criacao_email = new Criacao_email();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            //Criacao_email
            $Criacao_email->setId($row['id']);
            $Criacao_email->setNome_criador($row['nome_criador']);
            $Criacao_email->setStatus($row['status']);
            $Criacao_email->setCreated($row['created']->format("Y-m-d"));
            //$Criacao_email->setUpdated($row['updated']->format("Y-m-d"));
            $Criacao_email->setDescription($row['description']);
        }
        return $Criacao_email;
    }


    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...  where idUsuario and status = 1                                                           │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultaIdUsuario($idUsuario)
    {
        $declaracao = "
        Select
			*
		from
			Criacao_email
		Where
			status = 1 
            and idUsuario = '{$idUsuario}' ";

        //echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        if (sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC) == null) {
            return false;
        } else {
            $Criacao_email = new Criacao_email();
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

                //Criacao_email
                $Criacao_email->setId($row['id']);
                $Criacao_email->setNome_criador($row['nome_criador']);
                $Criacao_email->setStatus($row['status']);
                $Criacao_email->setCreated($row['created']->format("Y-m-d"));
                //$Criacao_email->setUpdated($row['updated']->format("Y-m-d"));
                $Criacao_email->setDescription($row['description']);

                $Criacao_email->getUsuario()->setId($row['idUsuario']);
            }
            return $Criacao_email;
        }
    }




    public function listar()
    {
        $declaracao = "
        Select
			*
		from
			Criacao_email
		Where
			status = 1;";

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaCriacao_email = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Criacao_email = new Criacao_email();

            //Criacao_email
            $Criacao_email->setId($row['id']);
            $Criacao_email->setNome_criador($row['nome_criador']);
            $Criacao_email->setStatus($row['status']);
            $Criacao_email->setCreated($row['created']->format("Y-m-d"));
            //$Criacao_email->setUpdated($row['updated']->format("Y-m-d"));
            $Criacao_email->setDescription($row['description']);

            $listaCriacao_email[] = $Criacao_email;
        }
        return $listaCriacao_email;
    }
}
