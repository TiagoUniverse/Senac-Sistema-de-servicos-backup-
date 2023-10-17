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
 * ║  │ @description: It contains all the functions of the "Unidade" class                                          │  ║
 * ║  │ @class: Unidade_repositorio                                                                                 │  ║
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

class Unidade_repositorio
{
    /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║                                                    METHODS                                                    ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @return INSERT INTO [Unidade]                                                                                │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    public function cadastro($Unidade)
    {
        $declaracao =  "Insert into [Unidade] ([nome] , [descricao]) values ('{$Unidade->getNome()}' , '{$Unidade->getDescricao()}' ) ";

        //echo $declaracao;
        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);
        if (sqlsrv_query($link, $declaracao) == false) {
            return false;
        } else {
            return true;
        }
    }


    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Update [Unidade]                                                                                     │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function alterar($Unidade)
    {
        $declaracao = "Update [Unidade] SET  [nome] = '{$Unidade->getNome()}' , [descricao] = '{$Unidade->getDescricao()}' , [updated] =  GETDATE() , [status] = '{$Unidade->getStatus()}'
        Where Id = '{$Unidade->getId()}' ";
        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" => $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        //echo $declaracao;

        if ($stmt == false) {
            return false;
        } else {
            return true;
        }
    }


    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Update [Unidade] set status = 0                                                                      │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */    
    public function deletar($Unidade)
    {
        $declaracao = "Update [Unidade] SET status = 0 , updated = GETDATE() Where id = '{$Unidade->getId()}' ";
        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" => $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        } else {
            return true;
        }
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...  where id                                                                                 │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultaId($id)
    {
        $declaracao = "Select * from Unidade where [id] = '{$id}' ";
        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);
        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $Unidade = new Unidade();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Unidade->setId($row['id']);
            $Unidade->setNome($row['nome']);
            $Unidade->setDescricao($row['descricao']);
            $Unidade->setStatus($row['status']);
            $Unidade->setCreated($row['created']->format("Y-m-d"));
            //$Unidade->setUpdated($row['updated']->format("Y-m-d"));
            $Unidade->setDescription($row['description']);
        }
        return $Unidade;
    }

        /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...  where id                                                                                 │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultaByNome($nome)
    {
        $declaracao = "Select * from Unidade where [nome] = '{$nome}' ";
        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);
        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $Unidade = new Unidade();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Unidade->setId($row['id']);
            $Unidade->setNome($row['nome']);
            $Unidade->setDescricao($row['descricao']);
            $Unidade->setStatus($row['status']);
            $Unidade->setCreated($row['created']->format("Y-m-d"));
            //$Unidade->setUpdated($row['updated']->format("Y-m-d"));
            $Unidade->setDescription($row['description']);
        }
        return $Unidade;
    }


    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...  where id and status = 1                                                                  │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultaIdEStatus($id)
    {
        $declaracao = "Select * from Unidade where [id] = '{$id}' and status = 1 ";
        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);
        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $Unidade = new Unidade();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Unidade->setId($row['id']);
            $Unidade->setNome($row['nome']);
            $Unidade->setDescricao($row['descricao']);
            $Unidade->setStatus($row['status']);
            $Unidade->setCreated($row['created']->format("Y-m-d"));
            //$Unidade->setUpdated($row['updated']->format("Y-m-d"));
            $Unidade->setDescription($row['description']);
        }
        return $Unidade;
    }


    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...                                                                                           │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function listar()
    {
        $declaracao = "Select * from [Unidade] Where status = 1 ";
        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);
        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaUnidade = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Unidade = new Unidade();

            $Unidade->setId($row['id']);
            $Unidade->setNome($row['nome']);
            $Unidade->setDescricao($row['descricao']);
            $Unidade->setStatus($row['status']);
            $Unidade->setCreated($row['created']->format("Y-m-d"));
            //$Unidade->setUpdated($row['updated']->format("Y-m-d"));
            $Unidade->setDescription($row["description"]);

            $listaUnidade[] = $Unidade;
        }
        return $listaUnidade;
    }

     /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...    where nome                                                                             │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function listarUnidade($nome)
    {

        /*
        * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
        * │ Validação                                                                                                     │
        * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
        */
        $Condicao_query = "";

        for ($contador = 1; $contador <= 1; $contador++) {
            if ($contador == 1) {
                if ($nome !== "") {
                    $Condicao_query = " nome LIKE '%{$nome}%'";
                }
            } 
        }

        //  echo $Condicao_query;


        $declaracao = "Select * from [Unidade] 
        Where
        " . $Condicao_query . "and status = 1";
        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);
        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        //echo $declaracao;

        $listaUnidade = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Unidade = new Unidade();

            $Unidade->setId($row['id']);
            $Unidade->setNome($row['nome']);
            $Unidade->setDescricao($row['descricao']);
            $Unidade->setStatus($row['status']);
            $Unidade->setCreated($row['created']->format("Y-m-d"));
            //$Unidade->setUpdated($row['updated']->format("Y-m-d"));
            $Unidade->setDescription($row["description"]);

            $listaUnidade[] = $Unidade;
        }
        return $listaUnidade;
    }
}
