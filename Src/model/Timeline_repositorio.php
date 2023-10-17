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
 * ║  │ @description: It contains all the functions of the "Timeline" class                                         │  ║
 * ║  │ @class: Timeline_repositorio                                                                                │  ║
 * ║  │ @dir: src/model                                                                                             │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 02/01/23                                                                                             │  ║
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

class Timeline_repositorio
{
    /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║                                                    METHODS                                                    ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @return INSERT INTO [Timeline]                                                                               │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    public function registrar_solicitacaoRH($Timeline)
    {
        $declaracao =  " Insert INTO [Timeline]
        ( [nome] , [id_funcionario] , [idColaborador] , [idStatusTimeline] ) 
        VALUES 
        ('{$Timeline->getNome()}' , '{$Timeline->getId_funcionario()}' , '{$Timeline->getColaborador()->getId()}' , '1'  ); ";

        //echo $declaracao;
        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);
        if (sqlsrv_query($link, $declaracao) == false) {
            return false;
        } else {
            return true;
        }
    }

    // public function registrar_AceiteColaborador($Timeline)
    public function registrar_AceiteColaborador($Timeline)
    {
        $declaracao =  " Insert INTO [Timeline]
        ( [nome] , [id_funcionario] , [idColaborador] , [idStatusTimeline] ) 
        VALUES 
        ('{$Timeline->getNome()}' , '{$Timeline->getId_funcionario()}' , '{$Timeline->getColaborador()->getId()}' , '2'  ); ";

        //echo $declaracao;
        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);
        if (sqlsrv_query($link, $declaracao) == false) {
            return false;
        } else {
            return true;
        }
    }

    public function registrar_criacaoEmail($Timeline)
    {
        $declaracao =  " Insert INTO [Timeline]
        ( [nome] , [id_funcionario] , [idColaborador] , [idStatusTimeline] ) 
        VALUES 
        ('{$Timeline->getNome()}' , '{$Timeline->getId_funcionario()}' , '{$Timeline->getColaborador()->getId()}' , '3'  ); ";

        //echo $declaracao;
        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);
        if (sqlsrv_query($link, $declaracao) == false) {
            return false;
        } else {
            return true;
        }
    }

    public function registrarEvento($Timeline)
    {
        $declaracao =  " Insert INTO [Timeline]
        ( [nome] , [id_funcionario] , [idColaborador] , [idStatusTimeline] ) 
        VALUES 
        ('{$Timeline->getNome()}' , '{$Timeline->getId_funcionario()}' , '{$Timeline->getColaborador()->getId()}' , '{$Timeline->getStatusTimeline()->getId()}'  ); ";

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
    * │  @return Select ...  where idColaborador                                                                      │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultaById($id)
    {
        $declaracao = "select
        ti.id as idTimeline, ti.nome as nomeTimeline, ti.id_funcionario as id_funcionarioTimeline, ti.created as dataCriacaoTimeline, ti.idColaborador as idColaborador_Timeline,
        ti.idStatusTimeline as idStatusTimeline_Timeline
        from
            Timeline as ti
        Where
        id =  '{$id}' ";

        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);
        $stmt = sqlsrv_query($link, $declaracao);


        if ($stmt == false) {
            return false;
        }

        $Timeline = new Timeline();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Timeline->setId($row['idTimeline']);
            $Timeline->setNome($row['nomeTimeline']);
            $Timeline->setId_funcionario($row['id_funcionarioTimeline']);
            $Timeline->setCreated($row['dataCriacaoTimeline']->format("d/m/Y - H:i:s"));
            $Timeline->getColaborador()->setId($row['idColaborador_Timeline']);
            $Timeline->getStatusTimeline()->setId($row['idStatusTimeline_Timeline']);
        }
        return $Timeline;
    }



      /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...  where idColaborador                                                                      │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultaByColaboradorID($idColaborador)
    {
        $declaracao = "select
        ti.id as idTimeline, ti.nome as nomeTimeline, ti.id_funcionario as id_funcionarioTimeline, ti.created as dataCriacaoTimeline, ti.idColaborador as idColaborador_Timeline,
        ti.idStatusTimeline as idStatusTimeline_Timeline
        from
            Timeline as ti
        Where
        idColaborador =  '{$idColaborador}' ";

        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);
        $stmt = sqlsrv_query($link, $declaracao);


        if ($stmt == false) {
            return false;
        }

        $Timeline = new Timeline();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Timeline->setId($row['idTimeline']);
            $Timeline->setNome($row['nomeTimeline']);
            $Timeline->setId_funcionario($row['id_funcionarioTimeline']);
            $Timeline->setCreated($row['dataCriacaoTimeline']->format("Y-m-d"));
            $Timeline->getColaborador()->setId($row['idColaborador_Timeline']);
            $Timeline->getStatusTimeline()->setId($row['idStatusTimeline_Timeline']);
        }
        return $Timeline;
    }

          /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...  where idColaborador                                                                      │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultarEmailRH($idColaborador)
    {
        $declaracao = "select
        ti.id as idTimeline, ti.nome as nomeTimeline, ti.id_funcionario as id_funcionarioTimeline, ti.created as dataCriacaoTimeline, ti.idColaborador as idColaborador_Timeline,
        ti.idStatusTimeline as idStatusTimeline_Timeline
        from
            Timeline as ti
        Where
        idColaborador =  '{$idColaborador}' and idStatusTimeline = 1  ";

        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);
        $stmt = sqlsrv_query($link, $declaracao);


        if ($stmt == false) {
            return false;
        }

        $Timeline = new Timeline();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Timeline->setId($row['idTimeline']);
            $Timeline->setNome($row['nomeTimeline']);
            $Timeline->setId_funcionario($row['id_funcionarioTimeline']);
            $Timeline->setCreated($row['dataCriacaoTimeline']->format("Y-m-d"));
            $Timeline->getColaborador()->setId($row['idColaborador_Timeline']);
            $Timeline->getStatusTimeline()->setId($row['idStatusTimeline_Timeline']);
        }
        return $Timeline;
    }



        /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select motivo from [Usuario] where id =  ...                                                         │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultar_idStatusTimeline($id_colaborador)
    {
        $declaracao = "
        Select
            idStatusTimeline
        from
            [Timeline]
        Where
            idColaborador = '{$id_colaborador}'
        ;";

        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $retorno = "";
        $listaIdStatusTimeline = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            $retorno = ($row['idStatusTimeline']);

            $listaIdStatusTimeline[] = $retorno;
        }
        return $listaIdStatusTimeline;
    }

    
        /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select motivo from [Usuario] where id =  ...                                                         │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultaBy_IdStatusTimeline($idStatusTimeline , $idColaborador)
    {
        $declaracao = "
        Select
            ti.id as idTimeline, ti.nome as nomeTimeline, ti.id_funcionario as id_funcionarioTimeline, ti.created as dataCriacaoTimeline, ti.idColaborador as idColaborador_Timeline,
            ti.idStatusTimeline as idStatusTimeline_Timeline
        from
            [Timeline] as ti
        Where
            idStatusTimeline = '{$idStatusTimeline}' and idColaborador = '{$idColaborador}'
        ;";

        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

         $Timeline = new Timeline();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            $Timeline->setId($row['idTimeline']);
            $Timeline->setNome($row['nomeTimeline']);
            $Timeline->setId_funcionario($row['id_funcionarioTimeline']);
            $Timeline->setCreated($row['dataCriacaoTimeline']->format("d/m/Y - H:i:s"));
            $Timeline->getColaborador()->setId($row['idColaborador_Timeline']);
            $Timeline->getStatusTimeline()->setId($row['idStatusTimeline_Timeline']);
        }
        return $Timeline;
    }


            /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select motivo from [Usuario] where id =  ...                                                         │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function listarTimeline($id_colaborador)
    {
        $declaracao = 
        "select
        ti.id as idTimeline, ti.nome as nomeTimeline, ti.id_funcionario as id_funcionarioTimeline, ti.created as dataCriacaoTimeline, ti.idColaborador as idColaborador_Timeline,
        ti.idStatusTimeline as idStatusTimeline_Timeline
        from
            Timeline as ti
        Where
        idColaborador =  '{$id_colaborador}'
        ;";

        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaTimeline = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Timeline = new Timeline();

            $Timeline->setId($row['idTimeline']);
            $Timeline->setNome($row['nomeTimeline']);
            $Timeline->setId_funcionario($row['id_funcionarioTimeline']);
            $Timeline->setCreated($row['dataCriacaoTimeline']->format("d/m/Y - H:i:s"));
            $Timeline->getColaborador()->setId($row['idColaborador_Timeline']);
            $Timeline->getStatusTimeline()->setId($row['idStatusTimeline_Timeline']);

            $listaTimeline[] = $Timeline;
        }
        return $listaTimeline;
    }


    
   


}
