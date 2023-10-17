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
 * ║  │ @description: It contains all the functions of the "NivelDeAcesso" class                                    │  ║
 * ║  │ @class: NivelDeAcesso_repositorio                                                                           │  ║
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

class NivelDeAcesso_repositorio
{
    /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║                                                    METHODS                                                    ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @return INSERT INTO [NivelDeAcesso]                                                                          │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    public function cadastro($NivelDeAcesso)
    {
        $declaracao =  " INSERT INTO [NivelDeAcesso]
        ( [nome] , [descricao] ) 
        VALUES 
        ('{$NivelDeAcesso->getNome()}' , '{$NivelDeAcesso->getDescricao()}' ); ";

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
    * │  @return Select ...  where id                                                                                 │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultaId($id)
    {
        $declaracao = "Select
        /* NIVELDEACESSO    */
        n.id as idNivelDeAcesso, n.nome as nomeNivelDeAcesso, n.descricao as descricao_NivelDeAcesso, n.status as statusNivelDeAcesso, 
        n.created as dataCriacaoNivelDeAcesso, n.updated as DataAtualizacaoNivelDeAcesso, n.description as descricaoNivelDeAcesso
    
        from
        NivelDeAcesso as n
        Where n.id = '{$id}' ";

        //echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $NivelDeAcesso = new NivelDeAcesso();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            //NIVELDEACESSO
            $NivelDeAcesso->setId($row['idNivelDeAcesso']);
            $NivelDeAcesso->setNome($row['nomeNivelDeAcesso']);
            $NivelDeAcesso->setDescricao($row['descricao_NivelDeAcesso']);
            $NivelDeAcesso->setStatus($row['statusNivelDeAcesso']);
            $NivelDeAcesso->setCreated($row['dataCriacaoNivelDeAcesso']->format("Y-m-d"));
            //$NivelDeAcesso->setUpdated($row['dataAtualizacaoNivelDeAcesso']->format("Y-m-d"));
            $NivelDeAcesso->setDescription($row['descricaoNivelDeAcesso']);

        }
        return $NivelDeAcesso;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...  where id and status = 1                                                                  |
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultaIdEStatus($id)
    {
        $declaracao = "Select
        /* NIVELDEACESSO    */
        n.id as idNivelDeAcesso, n.nome as nomeNivelDeAcesso, n.descricao as descricao_NivelDeAcesso, n.status as statusNivelDeAcesso,
         n.created as dataCriacaoNivelDeAcesso, n.updated as DataAtualizacaoNivelDeAcesso, n.description as descricaoNivelDeAcesso
    
        from
        NivelDeAcesso as n
        Where n.id = '{$id}' and n.status = 1 ";

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $NivelDeAcesso = new NivelDeAcesso();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            //NIVELDEACESSO
            $NivelDeAcesso->setId($row['idNivelDeAcesso']);
            $NivelDeAcesso->setNome($row['nomeNivelDeAcesso']);
            $NivelDeAcesso->setDescricao($row['descricao_NivelDeAcesso']);
            $NivelDeAcesso->setStatus($row['statusNivelDeAcesso']);
            $NivelDeAcesso->setCreated($row['dataCriacaoNivelDeAcesso']->format("Y-m-d"));
            //$NivelDeAcesso->setUpdated($row['dataAtualizacaoNivelDeAcesso']->format("Y-m-d"));
            $NivelDeAcesso->setDescription($row['descricaoNivelDeAcesso']);

        }
        return $NivelDeAcesso;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Update [NivelDeAcesso]                                                                               │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function alterar($NivelDeAcesso)
    { 
        $declaracao = "
        Update
        [NivelDeAcesso]
        Set
        [nome] = '{$NivelDeAcesso->getNome()}'  , [descricao] = '{$NivelDeAcesso->getDescricao()}'
        ,  [updated] =  GETDATE() , [status] = '{$NivelDeAcesso->getStatus()}'
        Where id = '{$NivelDeAcesso->getId()}' ; ";

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
    * │  @return Update [NivelDeAcesso] set status = 0                                                                │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function deletar($NivelDeAcesso)
    {
        $declaracao = "Update [NivelDeAcesso] SET status = 0 , updated = GETDATE() Where id = '{$NivelDeAcesso->getId()}' ";
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
    * │  @return Select ...                                                                                           │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function listar()
    {
        $declaracao = "Select
        /* NIVELDEACESSO    */
        n.id as idNivelDeAcesso, n.nome as nomeNivelDeAcesso, n.descricao as descricao_NivelDeAcesso, n.status as statusNivelDeAcesso,
        n.created as dataCriacaoNivelDeAcesso, n.updated as DataAtualizacaoNivelDeAcesso, n.description as descricaoNivelDeAcesso
    
        from
        NivelDeAcesso as n 
        Where status = 1";

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaNivelDeAcesso = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $NivelDeAcesso = new NivelDeAcesso();

             //NIVELDEACESSO
            $NivelDeAcesso->setId($row['idNivelDeAcesso']);
            $NivelDeAcesso->setNome($row['nomeNivelDeAcesso']);
            $NivelDeAcesso->setDescricao($row['descricao_NivelDeAcesso']);
            $NivelDeAcesso->setStatus($row['statusNivelDeAcesso']);
            $NivelDeAcesso->setCreated($row['dataCriacaoNivelDeAcesso']->format("Y-m-d"));
            //$NivelDeAcesso->setUpdated($row['dataAtualizacaoNivelDeAcesso']->format("Y-m-d"));
            $NivelDeAcesso->setDescription($row['descricaoNivelDeAcesso']);

            $listaNivelDeAcesso[] = $NivelDeAcesso;
        }
        return $listaNivelDeAcesso;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ... Where status = 1                                                                          │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function listarEStatus()
    {
        $declaracao = "Select
        /* NIVELDEACESSO    */
        n.id as idNivelDeAcesso, n.nome as nomeNivelDeAcesso, n.descricao as descricao_NivelDeAcesso, n.status as statusNivelDeAcesso, 
        n.created as dataCriacaoNivelDeAcesso, n.updated as DataAtualizacaoNivelDeAcesso, n.description as descricaoNivelDeAcesso
    
        from
        NivelDeAcesso as n
        Where n.status = 1 ";

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaNivelDeAcesso = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $NivelDeAcesso = new NivelDeAcesso();

             //NIVELDEACESSO
            $NivelDeAcesso->setId($row['idNivelDeAcesso']);
            $NivelDeAcesso->setNome($row['nomeNivelDeAcesso']);
            $NivelDeAcesso->setDescricao($row['descricao_NivelDeAcesso']);
            $NivelDeAcesso->setStatus($row['statusNivelDeAcesso']);
            $NivelDeAcesso->setCreated($row['dataCriacaoNivelDeAcesso']->format("Y-m-d"));
            //$NivelDeAcesso->setUpdated($row['dataAtualizacaoNivelDeAcesso']->format("Y-m-d"));
            $NivelDeAcesso->setDescription($row['descricaoNivelDeAcesso']);

            $listaNivelDeAcesso[] = $NivelDeAcesso;
        }
        return $listaNivelDeAcesso;
    }


    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ... Where status = 1 and id = ...                                                             |
    * |  Description: Se o id do novo usuário for igual a o de um colaborador, seu 'processoStatus' tem valor de 1    │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function verificarColaborador($id)
    {
        $declaracao = "Select * from NivelDeAcesso where status = 1 and id = '{$id}' ";

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaNivelDeAcesso = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $NivelDeAcesso = new NivelDeAcesso();

             //NIVELDEACESSO
            if ($row['nome'] == "Colaborador"){
                return true;
            }
            
        }
        return false;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...  Where nome                                                                               │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function listarNivelDeAcesso($nome)
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

        $declaracao = "Select
        /* NIVELDEACESSO    */
        n.id as idNivelDeAcesso, n.nome as nomeNivelDeAcesso, n.descricao as descricao_NivelDeAcesso, n.status as statusNivelDeAcesso, 
        n.created as dataCriacaoNivelDeAcesso, n.updated as DataAtualizacaoNivelDeAcesso, n.description as descricaoNivelDeAcesso
    
        from
        NivelDeAcesso as n 
        Where
        " . $Condicao_query . " and status = 1";

        //echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaNivelDeAcesso = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $NivelDeAcesso = new NivelDeAcesso();

             //NIVELDEACESSO
            $NivelDeAcesso->setId($row['idNivelDeAcesso']);
            $NivelDeAcesso->setNome($row['nomeNivelDeAcesso']);
            $NivelDeAcesso->setDescricao($row['descricao_NivelDeAcesso']);
            $NivelDeAcesso->setStatus($row['statusNivelDeAcesso']);
            $NivelDeAcesso->setCreated($row['dataCriacaoNivelDeAcesso']->format("Y-m-d"));
            //$NivelDeAcesso->setUpdated($row['dataAtualizacaoNivelDeAcesso']->format("Y-m-d"));
            $NivelDeAcesso->setDescription($row['descricaoNivelDeAcesso']);

            $listaNivelDeAcesso[] = $NivelDeAcesso;
        }
        return $listaNivelDeAcesso;
    }

    

}
