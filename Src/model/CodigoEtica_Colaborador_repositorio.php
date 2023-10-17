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
 * ║  │ @description: It contains all the functions of the "CodigoEtica_Colaborador" class                          │  ║
 * ║  │ @class: CodigoEtica_Colaborador_repositorio                                                                 │  ║
 * ║  │ @dir: src/model                                                                                             │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 05/10/23                                                                                             │  ║
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

class CodigoEtica_Colaborador_repositorio
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
    public function cadastrar($nome, $cpf, $email, $telefone, $idUsuario)
    {
        $declaracao =  "Insert INTO CodigoEtica_Colaborador (nome, cpf, email, telefone, idUsuario) Values
        ('{$nome}', '{$cpf}', '{$email}' , '{$telefone}' , '{$idUsuario}');  ";

        // echo $declaracao;
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
    * │  @return Select * from CodigoEtica                                                                             │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function listagem_TodasRequisicoes()
    {
        $declaracao =  "Select * from CodigoEtica_Colaborador Where status = 1 ";

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $CodigoEtica_Colaborador = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $idCodigoEtica = $row['id'];
            $nome = $row['nome'];
            $email = $row['email'];
            $telefone = $row['telefone'];
            $status = $row['status'];
            $created = $row['created'];
            $updated = $row['updated'];
            $idUsuario = $row['idUsuario'];

            $CodigoEtica_Colaborador[] = array($idCodigoEtica, $nome, $email, $telefone, $status, $created, $updated, $idUsuario);
        }
        return $CodigoEtica_Colaborador;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select motivo from [Colaborador] where id =  ...                                                     │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultar_CPF($cpf)
    {
        $declaracao = "
        Select
            cpf
        from
            [CodigoEtica_Colaborador]
        Where
            cpf = '{$cpf}'
            and status = 1
        ;";

        // echo $declaracao;

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
    * │  @return Select * from ... where cpf = ''                                                                     │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultar_ByCPF($cpf)
    {
        $declaracao = "
        Select
            *
        from
            [CodigoEtica_Colaborador]
        Where
            cpf = '{$cpf}'
            and status = 1
        ;";

        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $retorno = "";
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $idCodigoEtica = $row['id'];
            $nome = $row['nome'];
            $email = $row['email'];
            $status = $row['status'];
            $telefone = $row['telefone'];
            $created = $row['created'];
            $updated = $row['updated'];
            $idUsuario = $row['idUsuario'];

            $CodigoEtica_Colaborador = array($idCodigoEtica, $nome, $email, $telefone, $status, $created, $updated, $idUsuario);

            return $CodigoEtica_Colaborador;
        }

        return $retorno;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select * from ... where id = ''                                                                     │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultar_ByID($id)
    {
        $declaracao = "
        Select
            *
        from
            [CodigoEtica_Colaborador]
        Where
            id = '{$id}'
            and status = 1
        ;";

        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $retorno = "";
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $idCodigoEtica = $row['id'];
            $nome = $row['nome'];
            $cpf = $row['cpf'];
            $email = $row['email'];
            $status = $row['status'];
            $telefone = $row['telefone'];
            $created = $row['created'];
            $updated = $row['updated'];
            $idUsuario = $row['idUsuario'];

            $CodigoEtica_Colaborador = array($idCodigoEtica, $nome, $cpf, $email, $telefone, $status, $created, $updated, $idUsuario);

            return $CodigoEtica_Colaborador;
        }

        return $retorno;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Update [Colaborador] set id_criptografado...                                                         │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function atualizar_IdCriptografado($cpf, $id_criptografado)
    {
        $declaracao = "
        Update 
            [CodigoEtica_Colaborador] 
        SET  
            [id_criptografia] = '{$id_criptografado}'
        Where cpf = '{$cpf}' ";

        conexao_declaracao($declaracao);
    }


    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Update [Usuario]                                                                                     |
    * |  Date: 13/03/23                                                                                               │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function alterar_solicitacao($email_Pessoal,$telefone, $id) {
        $declaracao = "
        Update CodigoEtica_Colaborador Set email = '{$email_Pessoal}' , telefone = '{$telefone}' where
            id = '{$id}'
            and status = 1; ";

        // echo $declaracao;

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
    * │  @return Update where                                                                                         │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function excluir_solicitacao($id)
    {
        $declaracao = "
        Update
            [CodigoEtica_Colaborador] 
        Set
            status = 0,
            updated = GETDATE() 
        Where id = '{$id}' ";

        

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
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
    * │  @return Update [CodigoEtica]                                                                                 │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function alterar_dataAceite($idColaborador)
    {
        $declaracao = "
        Update [CodigoEtica_Colaborador]
            SET dataAceite = GETDATE(),
                updated = GETDATE()
        Where
            id ='{$idColaborador}' and status = 1; ";

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
    * │  @return Update [CodigoEtica]                                                                                 │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function alterar_nomeArquivo($idColaborador, $nome_arquivo)
    {
        $declaracao = "
        Update [CodigoEtica_Colaborador]
            SET nome_arquivo = '{$nome_arquivo}',
                updated = GETDATE()
        Where
            id ='{$idColaborador}' and status = 1; ";

            // echo $declaracao;

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
    * │  @return Select * from ... where id = ''                                                                     │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultar_NomeArquivo($id)
    {
        $declaracao = "
        Select
            *
        from
            [CodigoEtica_Colaborador]
        Where
            id = '{$id}'
            and status = 1
        ;";

        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $retorno = "";
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            return $row['nome_arquivo'];
        }

        return false;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select * from ... where id = ''                                                                     │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultar_DataAceite($id)
    {
        $declaracao = "
        Select
            *
        from
            [CodigoEtica_Colaborador]
        Where
            id = '{$id}'
            and status = 1
        ;";

        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $retorno = "";
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            return $row['dataAceite']->format('d/m/Y - H:i:s');
        }

        return false;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ... Where idNivelDeAcesso = 6                                                                 │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function listarColaborador($nome, $cpf, $email)
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
                    $Condicao_query = "nome LIKE '%{$nome}%'";
                }
            } else if ($contador == 2) {
                if ($cpf !== "") {
                    if ($nome !== "") {
                        $Condicao_query = $Condicao_query . " and ";
                    }

                    $Condicao_query = $Condicao_query . " cpf = '{$cpf}' ";
                }
            } else if ($contador == 3) {
                if ($email !== "") {
                    if ($cpf !== "" || $nome !== "") {
                        $Condicao_query = $Condicao_query . " and ";
                    }

                    $Condicao_query = $Condicao_query . " email = '{$email}'  ";
                }
            }
        }

        //echo $Condicao_query;

        $declaracao = "Select * from CodigoEtica_Colaborador where
        status = 1 and " . $Condicao_query . " ; ";


        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaColaborador = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            $idCodigoEtica = $row['id'];
            $nome = $row['nome'];
            $cpf = $row['cpf'];
            $email = $row['email'];
            $status = $row['status'];
            $telefone = $row['telefone'];
            $created = $row['created'];
            $updated = $row['updated'];
            $idUsuario = $row['idUsuario'];

            $listaColaborador[] = array($idCodigoEtica, $nome, $cpf, $email, $telefone, $status, $created, $updated, $idUsuario);           

        }
        return $listaColaborador;
    }


    // // A consulta abaixo é para listar o resultado do filtro do RH, exibindo os resultados encontrados do
    // // TOTVS e da lista de colaboradores cadastrados. Data: 10/10/23 || Data original: 12/07/23
    // public function listagemFILTRO_SolicitacaoColaborador(array $listaColaborador)
    // {
    //     $resultado = array();
    //     /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    //     * │                                Colaborador                                                                    |
    //     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    //     */
    //     // 1ª passo: Listar todos os ids dos colaboradores
    //     $CodigoEtica_Colaborador_repositorio = new CodigoEtica_Colaborador_repositorio();
    //     $id_colaborador = $Colaborador_repositorio->listar_IdColaboradores();

    //     // 2ª passo: Verificar quais dos colaboradores estão em andamento com o seu processo
    //     $idColaboradores_Andamento = $Colaborador_repositorio->listar_Colaboradores_Andamento($id_colaborador);

    //     foreach ($listaColaborador as $Colaborador) {
    //         if (in_array($Colaborador->getId(), $idColaboradores_Andamento)) {
    //             $envio = array($Colaborador->getId(), $Colaborador->getNome(), $Colaborador->getCpf());
    //             $resultado[] = $envio;
    //         }
    //     }

    //     /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    //     * │                                TOTVS                                                                          |
    //     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    //     */

    //     if (!empty($listaTOTVS)  && $apenasColaborador == null) {
    //         // var_dump($listaTOTVS);
    //         $Colaborador_repositorio = new Colaborador_repositorio();
    //         foreach ($listaTOTVS as $totvs) {
    //             $retorno = $Colaborador_repositorio->consultar_CPF($totvs->getCpf());

    //             // //Se retorna nada, é porque ele não encontrou o CPF no sistema
    //             if ($retorno == null && $retorno == false) {
    //                 // echo "Este colaborador não foi cadastrado";
    //                 $envio = array('0', $totvs->getNome(), $totvs->getCpf());
    //                 $resultado[] = $envio;
    //             }
    //         }
    //     }
    //     return $resultado;
    // }

}
