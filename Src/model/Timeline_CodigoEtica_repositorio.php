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
 * ║  │ @description: It contains all the functions of the "Timeline_CodigoEtica" class                             │  ║
 * ║  │ @class: Timeline_CodigoEtica_repositorio                                                                    │  ║
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

class Timeline_CodigoEtica_repositorio
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
    public function registrar_timeline($descricao, $idUsuario, $idCodigoEtica_colaborador, $idStatusTimeline_CodigoEtica)
    {
        $declaracao =  " Insert into Timeline_CodigoEtica (descricao, idUsuario, idCodigoEtica_Colaborador, idStatusTimeline_CodigoEtica)
        Values   ('{$descricao}', '{$idUsuario}' , '$idCodigoEtica_colaborador' , '{$idStatusTimeline_CodigoEtica}' )   ";

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
    * │  @return Select motivo from [Usuario] where id =  ...                                                         │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultar_idStatusTimeline($id_colaborador)
    {
        $declaracao = "
        Select
            idStatusTimeline_CodigoEtica
        from
            Timeline_CodigoEtica
        Where
            idCodigoEtica_Colaborador = '{$id_colaborador}'
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

            $retorno = ($row['idStatusTimeline_CodigoEtica']);

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
            *
        from
            Timeline_CodigoEtica 
        Where
            idStatusTimeline_CodigoEtica = '{$idStatusTimeline}' and idCodigoEtica_Colaborador = '{$idColaborador}'
        ;";

        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

         $Timeline = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            $idTimeline = $row['id'];
            $descricao = $row['descricao'];
            $created = $row['created']->format('d/m/Y - H:i:s');
            $idUsuario = $row['idUsuario'];
            $idCodigoEtica_colaborador = $row['idCodigoEtica_Colaborador'];
            $idStatusTimeline_CodigoEtica = $row['idStatusTimeline_CodigoEtica'];

            $Timeline = array($idTimeline, $descricao, $created, $idUsuario, $idCodigoEtica_colaborador, $idStatusTimeline_CodigoEtica);

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
        "Select
            *
        from
            Timeline_CodigoEtica 
        Where
            idCodigoEtica_Colaborador ='{$id_colaborador}'
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

            $idTimeline = $row['id'];
            $descricao = $row['descricao'];
            $created = $row['created']->format("d/m/Y - H:i:s");
            $idUsuario = $row['idUsuario'];
            $idCodigoEtica_colaborador = $row['idCodigoEtica_Colaborador'];
            $idStatusTimeline_CodigoEtica = $row['idStatusTimeline_CodigoEtica'];

            $listaTimeline[] = array($idTimeline, $descricao, $created, $idUsuario, $idCodigoEtica_colaborador, $idStatusTimeline_CodigoEtica);
        }
        return $listaTimeline;
    }

          /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select motivo from [Usuario] where id =  ...                                                         │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultar_ID_RH($id_colaborador)
    {
        $declaracao = " Select idUsuario from Timeline_CodigoEtica where idCodigoEtica_Colaborador = '{$id_colaborador}' and idStatusTimeline_CodigoEtica = 1 ";
        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            return $row['idUsuario'];
        }
        return false;
    }



}
