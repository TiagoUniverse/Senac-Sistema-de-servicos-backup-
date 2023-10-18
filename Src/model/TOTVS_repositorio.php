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
 * ║  │ @description: It contains all the functions of the "TOTVS" class                                            │  ║
 * ║  │ @class: TOTVS_repositorio                                                                                   │  ║
 * ║  │ @dir: src/model                                                                                             │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 18/10/23                                                                                             │  ║
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

class TOTVS_repositorio
{
    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select motivo from [TOTVS] where cpf =  ...                                                          │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function verificar_CPF($cpf)
    {
        $declaracao = "
        Select
            cpf
        from
            [TOTVS]
        Where
            cpf = '{$cpf}'
        ;";

        echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $retorno = "";
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            $retorno = ($row['cpf']);
        }
        return $retorno;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select motivo from [TOTVS] where cpf =  ...                                                          │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function unidade_existe($unidade)
    {
        $declaracao = "
        Select DISTINCT Unidade from TOTVS where UNIDADE = '{$unidade}' ;";

        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $retorno = "";
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            if ($unidade == $row['Unidade']) {
                return true;
            }
        }
        return false;
    }


    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...  where cpf                                                                                │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function ConsultaByCPF($cpf)
    {
        $declaracao = " Select * from TOTVS Where cpf = '{$cpf}' ";

        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }



        $TOTVS = new TOTVS();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            $TOTVS->setChapa($row['CHAPA']);
            $TOTVS->setCpf($row['CPF']);
            $TOTVS->setNome($row['NOME']);
            $TOTVS->setCargo($row['CARGO']);
            $TOTVS->setDataNascimento($row['DTNASCIMENTO']);
            $TOTVS->setEmail($row['EMAIL']);
            $TOTVS->setTelefone($row['TELEFONE']);
            $TOTVS->setSituacao($row['SITUACAO']);
            $TOTVS->setUnidade($row['UNIDADE']);
            $TOTVS->setHorario($row['HORARIO']);
        }
        return $TOTVS;
    }


    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...  where cpf                                                                                │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function Consultar_CadastroUsuario($cpf)
    {
        $declaracao = " Select * from TOTVS Where cpf = '{$cpf}'  ";

        echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }



        $TOTVS = new TOTVS();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            $TOTVS->setChapa($row['CHAPA']);
            $TOTVS->setCpf($row['CPF']);
            $TOTVS->setNome($row['NOME']);
            $TOTVS->setCargo($row['CARGO']);
            $TOTVS->setDataNascimento($row['DTNASCIMENTO']);
            $TOTVS->setEmail($row['EMAIL']);
            $TOTVS->setTelefone($row['TELEFONE']);
            $TOTVS->setSituacao($row['SITUACAO']);
            $TOTVS->setUnidade($row['UNIDADE']);
            $TOTVS->setHorario($row['HORARIO']);
        }
        return $TOTVS;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...  where cpf                                                                                │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function CPF_existe($cpf)
    {
        $declaracao = " Select * from TOTVS Where cpf = '{$cpf}' ";

        //echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if ($row['CPF'] == $cpf) {
                return true;
            }
        }
        return false;
    }


    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ... Where...                                                                                  │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function listarTodosTOTVS()
    {
        $declaracao = "SELECT 
        NOME , CPF, CHAPA, CARGO, DTNASCIMENTO, EMAIL, TELEFONE, SITUACAO,   YEAR(TRY_CONVERT(DATE, DATAADMISSAO, 103)) AS AnoAdmissao
     FROM 
        TOTVS
     WHERE 
        YEAR(TRY_CONVERT(DATE, DATAADMISSAO, 103)) = YEAR(GETDATE())
        AND MONTH(TRY_CONVERT(DATE, DATAADMISSAO, 103)) >= MONTH(GETDATE())
     ORDER BY DATAADMISSAO DESC      ";


        // echo $declaracao;
        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaTOTVS = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $TOTVS = new TOTVS();

            $TOTVS->setChapa($row['CHAPA']);
            $TOTVS->setCpf($row['CPF']);
            $TOTVS->setNome($row['NOME']);
            $TOTVS->setCargo($row['CARGO']);
            $TOTVS->setDataNascimento($row['DTNASCIMENTO']);
            $TOTVS->setEmail($row['EMAIL']);
            $TOTVS->setTelefone($row['TELEFONE']);
            $TOTVS->setSituacao($row['SITUACAO']);

            $listaTOTVS[] = $TOTVS;
        }
        return $listaTOTVS;
    }


    public function listarTodosTOTVS_SolicitacaoRH()
    {
        $declaracao = "SELECT 
        '0' as 'id', NOME , CPF
        FROM 
            TOTVS
        WHERE 
            YEAR(TRY_CONVERT(DATE, DATAADMISSAO, 103)) = YEAR(GETDATE())
            AND MONTH(TRY_CONVERT(DATE, DATAADMISSAO, 103)) >= MONTH(GETDATE())
        ORDER BY DATAADMISSAO DESC       ";


        // echo $declaracao;
        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaTOTVS = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $id = $row['id'];
            $nome = $row['NOME'];
            $cpf = $row['CPF'];

            $listaTOTVS[] = array($id, $nome, $cpf);
        }
        return $listaTOTVS;
    }

    // Esta consulta busca dentro das recomendações se o colaborador está nesta lista. Data:12/07/23
    public function listarPorFiltro_SolicitacaoRH($nome, $cpf, $email)
    {
        $Condicao_query = "";
        for ($contador = 1; $contador <= 3; $contador++) {
            if ($contador == 1) {
                if ($nome !== "") {
                    $Condicao_query = " NOME LIKE '%{$nome}%'";
                }
            } else if ($contador == 2) {
                if ($cpf !== "") {
                    if ($nome !== "") {
                        $Condicao_query = $Condicao_query . " and ";
                    }

                    $Condicao_query = $Condicao_query . " CPF = '{$cpf}' ";
                }
            } else if ($contador == 3) {
                if ($email !== "") {
                    if ($cpf !== "" || $nome !== "") {
                        $Condicao_query = $Condicao_query . " and ";
                    }

                    $Condicao_query = $Condicao_query . " EMAIL = '{$email}' OR EMAILPESSOAL = '{$email}'  ";
                }
            }
        }

        $declaracao = "SELECT 
        '0' as 'id', NOME , CPF
        FROM 
            TOTVS 
        WHERE 
            YEAR(TRY_CONVERT(DATE, DATAADMISSAO, 103)) = YEAR(GETDATE())
            AND MONTH(TRY_CONVERT(DATE, DATAADMISSAO, 103)) >= MONTH(GETDATE())
            AND $Condicao_query
        ORDER BY DATAADMISSAO DESC       ";

        echo $declaracao;
        
        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaTOTVS = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $id = $row['id'];
            $nome = $row['NOME'];
            $cpf = $row['CPF'];

            $listaTOTVS[] = array($id, $nome, $cpf);
        }
        return $listaTOTVS;
    }


    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ... Where idNivelDeAcesso = 6                                                                 │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function ListarTOTVS($nome, $cpf, $email)
    {
        /*
        * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
        * │ Validação                                                                                                     │
        * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
        */

        $Condicao_query = "";

        for ($contador = 1; $contador <= 3; $contador++) {
            if ($contador == 1) {
                if ($nome !== "") {
                    $Condicao_query = " nome LIKE '%{$nome}%'";
                }
            } else if ($contador == 2) {
                if ($cpf !== "") {
                    if ($nome !== "") {
                        $Condicao_query = $Condicao_query . " or ";
                    }

                    $Condicao_query = $Condicao_query . " cpf = '{$cpf}' ";
                }
            } else if ($contador == 3) {
                if ($email !== "") {
                    if ($cpf !== "" || $nome !== "") {
                        $Condicao_query = $Condicao_query . " or ";
                    }

                    $Condicao_query = $Condicao_query . " email = '{$email}'  ";
                }
            }
        }


        //echo $Condicao_query;


        $declaracao = "Select * from TOTVS 
        Where
            " . $Condicao_query . '
            and  YEAR(TRY_CONVERT(DATE, DATAADMISSAO, 103)) = YEAR(GETDATE())
            AND MONTH(TRY_CONVERT(DATE, DATAADMISSAO, 103)) >= MONTH(GETDATE())
         ORDER BY DATAADMISSAO DESC  ';


        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaTOTVS = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $TOTVS = new TOTVS();

            $TOTVS->setChapa($row['CHAPA']);
            $TOTVS->setCpf($row['CPF']);
            $TOTVS->setNome($row['NOME']);
            $TOTVS->setCargo($row['CARGO']);
            $TOTVS->setDataNascimento($row['DTNASCIMENTO']);
            $TOTVS->setEmail($row['EMAIL']);
            $TOTVS->setTelefone($row['TELEFONE']);
            $TOTVS->setSituacao($row['SITUACAO']);

            $listaTOTVS[] = $TOTVS;
        }
        return $listaTOTVS;
    }
}
