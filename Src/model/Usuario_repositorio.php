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
 * ║  │ @description: It contains all the functions of the "Usuario" class                                          │  ║
 * ║  │ @class: Usuario_repositorio                                                                                 │  ║
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

require_once "Recursos/conexao_model.php";

use function Recursos\conexao_declaracao;

require_once "Recursos/conexao.php";

use PDO;


class Usuario_repositorio
{

    public function cadastro($Usuario)
    {
        $declaracao = " 
        Insert into [Usuario]
            ( [nome], [nomeSobrenome] , [email] , [senha], [cpf], [dataNascimento], [telefone], [trocarsenha] , [idNivelDeAcesso] , [idUnidade] ) 
        Values
            ('{$Usuario->getNome()}' , '{$Usuario->getNomeSobrenome()}',  '{$Usuario->getEmail()}' , HASHBYTES ('sha1','{$Usuario->getSenha()}') , '{$Usuario->getCpf()}' , '{$Usuario->getDataNascimento()}' ,  
            '{$Usuario->getTelefone()}' , '{$Usuario->getTrocaSenha()}' 
            , '{$Usuario->getNivelDeAcesso()->getId()}' , '{$Usuario->getUnidade()->getId()}'   )";

        conexao_declaracao($declaracao);
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select motivo from [Usuario] where id =  ...                                                         │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultar_CPF($cpf)
    {
        $declaracao = "
        Select
            cpf
        from
            [Usuario]
        Where
            cpf = '{$cpf}'
            and status = 1
        ;";

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
    * │  @return Select ...                                                                                           │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function ValidarEmail($email)
    {
        $declaracao = "Select email from Usuario where status = 1 ";

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);
        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if ($row['email'] == $email) {
                return true;
            }
        }
        return false;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...                                                                                           │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function listar()
    {
        $declaracao = "Select
        /*  Usuario  */
		u.id as idUsuario, u.cpf as cpfUsuario, u.nome as nomeUsuario,u.nomeSobrenome as nome_SobrenomeUsuario,
		u.dataNascimento as dataNascimentoUsuario, u.email as emailUsuario, u.telefone as telefoneUsuario, 
		u.status as statusUsuario, u.created as dataCriacaoUsuario , u.updated as dataAtualizacaoUsuario , u.description as descricaoUsuario, 

        /* NIVELDEACESSO    */
        n.id as idNivelDeAcesso, n.nome as nomeNivelDeAcesso, n.descricao as descricaoNivelDeAcesso, n.status as statusNivelDeAcesso, n.created as dataCriacaoNivelDeAcesso, 
        n.updated as DataAtualizacaoNivelDeAcesso, n.description as descricaoNivelDeAcesso,
    
        /* UNIDADE */
        uni.id as idUnidade, uni.nome as nomeUnidade, uni.descricao as descricaoUnidade, uni.status as statusUnidade, uni.created as dataCriacaoUnidade,
        uni.updated as dataAtualizacaoUnidade, uni.description as descriptionUnidade

        from 
            Usuario as u inner join [NivelDeAcesso] as n on u.idNivelDeAcesso = n.id
            inner join [Unidade] as uni on u.idUnidade = uni.id
        Where 
            u.status = 1 ";

        //echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaUsuario = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Usuario = new Usuario();

            $Usuario->setId($row['idUsuario']);
            $Usuario->setCpf($row['cpfUsuario']);
            $Usuario->setNome($row['nomeUsuario']);
            $Usuario->setNomeSobrenome($row['nome_SobrenomeUsuario']);
            $Usuario->setDataNascimento($row['dataNascimentoUsuario']->format("Y-m-d"));
            $Usuario->setEmail($row['emailUsuario']);
            $Usuario->setTelefone($row['telefoneUsuario']);
            $Usuario->setStatus($row['statusUsuario']);
            $Usuario->setCreated($row['dataCriacaoUsuario']->format("Y-m-d"));
            //$Usuario->setUpdated($row['dataAtualizacaoUsuario']->format("Y-m-d"));
            $Usuario->setDescription($row['descricaoUsuario']);


            //NivelDeAcesso
            $Usuario->getNivelDeAcesso()->setId($row['idNivelDeAcesso']);
            $Usuario->getNivelDeAcesso()->setNome($row['nomeNivelDeAcesso']);
            $Usuario->getNivelDeAcesso()->setStatus($row['statusNivelDeAcesso']);
            $Usuario->getNivelDeAcesso()->setCreated($row['dataCriacaoNivelDeAcesso']->format("Y-m-d"));
            //$Usuario->getNivelDeAcesso()->setUpdated($row['dataAtualizacaoNivelDeAcesso']->format("Y-m-d"));
            $Usuario->getNivelDeAcesso()->setDescription($row['descricaoNivelDeAcesso']);

            //Unidade
            $Usuario->getUnidade()->setId($row['idUnidade']);
            $Usuario->getUnidade()->setNome($row['nomeUnidade']);
            $Usuario->getUnidade()->setDescricao($row['descricaoUnidade']);
            $Usuario->getUnidade()->setStatus($row['statusUnidade']);
            $Usuario->getUnidade()->setCreated($row['dataCriacaoUnidade']->format("Y-m-d"));
            //$Usuario->getUnidade()->setUpdated($row['dataAtualizacaoUnidade']->format("Y-m-d"));
            $Usuario->getUnidade()->setDescription($row['descriptionUnidade']);

            $listaUsuario[] = $Usuario;
        }
        return $listaUsuario;
    }


    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...  where id                                                                                 │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consulta_Email($email)
    {
        try {

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // valid address
                // echo "E-mail correto";
                //Meu servidor: "desktop-f2g3ks7\sqlexpress"
                //Servidor do Senac: SQLSERVER

                $servername = "SQLSERVER";
                $dbname = "TermoAceite";
                $username = "tiagolopes";
                $pwd = "gti2022";
                try {
                    $pdo = new PDO("sqlsrv:server=$servername ; Database=$dbname", "$username", "$pwd");
                    // echo "Conectado com sucesso!";
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (Exception $e) {
                    die(print_r($e->getMessage()));
                }


                $stmt = $pdo->prepare("Select * from Usuario Where status = 1 and email = :email  ");
                $stmt->execute(array(
                    ':email' => $email
                ));

                if ($stmt->rowCount() == 0) {
                    // echo "A consulta retornou vazio.";
                    return false;
                } else {
                    // echo "A consulta retornou resultados.";

                    
                while($linha = $stmt->fetch(\PDO::FETCH_ASSOC)){
                    $Usuario = new Usuario();

                    $Usuario->setId($linha['id']); 
                    $Usuario->setNome($linha['nome']); 
                    $Usuario->setNomeSobrenome($linha['nomeSobrenome']); 
                    $Usuario->setEmail($linha['email']);         

                   }

                   return $Usuario;



                }

            } else {
                // invalid address
                //    echo "E-mail inválido!";
                return false;
            }
        } catch (PDOException $err) {
            echo $err->getMessage();
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
        /*  Usuario  */
		u.id as idUsuario, u.cpf as cpfUsuario, u.nome as nomeUsuario,u.nomeSobrenome as nome_SobrenomeUsuario,
		u.dataNascimento as dataNascimentoUsuario, u.email as emailUsuario, u.telefone as telefoneUsuario, u.trocarSenha as trocarSenhaUsuario,
		u.status as statusUsuario, u.created as dataCriacaoUsuario , u.updated as dataAtualizacaoUsuario , u.description as descricaoUsuario, 

        /* NIVELDEACESSO    */
        n.id as idNivelDeAcesso, n.nome as nomeNivelDeAcesso, n.descricao as descricaoNivelDeAcesso, n.status as statusNivelDeAcesso, n.created as dataCriacaoNivelDeAcesso, 
        n.updated as DataAtualizacaoNivelDeAcesso, n.description as descricaoNivelDeAcesso,
    
        /* UNIDADE */
        uni.id as idUnidade, uni.nome as nomeUnidade, uni.descricao as descricaoUnidade, uni.status as statusUnidade, uni.created as dataCriacaoUnidade,
        uni.updated as dataAtualizacaoUnidade, uni.description as descriptionUnidade

        from 
            Usuario as u inner join [NivelDeAcesso] as n on u.idNivelDeAcesso = n.id
            inner join [Unidade] as uni on u.idUnidade = uni.id
        Where u.id = '{$id}' ";

        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $Usuario = new Usuario();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            $Usuario->setId($row['idUsuario']);
            $Usuario->setCpf($row['cpfUsuario']);
            $Usuario->setNome($row['nomeUsuario']);
            $Usuario->setNomeSobrenome($row['nome_SobrenomeUsuario']);
            $Usuario->setTrocaSenha($row['trocarSenhaUsuario']);
            $Usuario->setDataNascimento($row['dataNascimentoUsuario']->format("Y-m-d"));
            $Usuario->setEmail($row['emailUsuario']);
            $Usuario->setTelefone($row['telefoneUsuario']);
            $Usuario->setStatus($row['statusUsuario']);
            $Usuario->setCreated($row['dataCriacaoUsuario']->format("Y-m-d"));
            //$Usuario->setUpdated($row['dataAtualizacaoUsuario']->format("Y-m-d"));
            $Usuario->setDescription($row['descricaoUsuario']);

            //NivelDeAcesso
            $Usuario->getNivelDeAcesso()->setId($row['idNivelDeAcesso']);
            $Usuario->getNivelDeAcesso()->setNome($row['nomeNivelDeAcesso']);
            $Usuario->getNivelDeAcesso()->setStatus($row['statusNivelDeAcesso']);
            $Usuario->getNivelDeAcesso()->setCreated($row['dataCriacaoNivelDeAcesso']->format("Y-m-d"));
            //$Usuario->getNivelDeAcesso()->setUpdated($row['dataAtualizacaoNivelDeAcesso']->format("Y-m-d"));
            $Usuario->getNivelDeAcesso()->setDescription($row['descricaoNivelDeAcesso']);

            //Unidade
            $Usuario->getUnidade()->setId($row['idUnidade']);
            $Usuario->getUnidade()->setNome($row['nomeUnidade']);
            $Usuario->getUnidade()->setDescricao($row['descricaoUnidade']);
            $Usuario->getUnidade()->setStatus($row['statusUnidade']);
            $Usuario->getUnidade()->setCreated($row['dataCriacaoUnidade']->format("Y-m-d"));
            //$Usuario->getUnidade()->setUpdated($row['dataAtualizacaoUnidade']->format("Y-m-d"));
            $Usuario->getUnidade()->setDescription($row['descriptionUnidade']);
        }

        //var_dump($Usuario);

        return $Usuario;
    }


    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select email_institucional, senha Where...                                                           |
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function Login($email, $senha)
    {
        try {

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // valid address
                // echo "E-mail correto";
                //Meu servidor: "desktop-f2g3ks7\sqlexpress"
                //Servidor do Senac: SQLSERVER

                $servername = "SQLSERVER";
                $dbname = "TermoAceite";
                $username = "tiagolopes";
                $pwd = "gti2022";
                try {
                    $pdo = new PDO("sqlsrv:server=$servername ; Database=$dbname", "$username", "$pwd");
                    // echo "Conectado com sucesso!";
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (Exception $e) {
                    die(print_r($e->getMessage()));
                }


                $prepare = $pdo->prepare("Select email, senha from Usuario Where status = 1 and senha = HASHBYTES('sha1', :senha) and email = :email  ");
                $prepare->bindParam(":senha", $senha);
                $prepare->bindParam(":email", $email);
                $result = $prepare->execute();

                if ($result) {
                    // echo "Consulta com sucesso!";
                } else {
                    // echo "Falha na consulta";
                }

                if ($result) {
                    return true;
                }

                return false;
            } else {
                // invalid address
                //    echo "E-mail inválido!";
            }
        } catch (PDOException $err) {
            echo $err->getMessage();
        }
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select nome_Sobrenome...                                                                             │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consulta_nomeSobrenome($email, $senha)
    {
        $declaracao = "
        Select
        /*  Usuario  */
		u.id as idUsuario, u.cpf as cpfUsuario, u.nome as nomeUsuario,u.nomeSobrenome as nome_SobrenomeUsuario,
		u.dataNascimento as dataNascimentoUsuario, u.email as emailUsuario, u.telefone as telefoneUsuario, 
		u.status as statusUsuario, u.created as dataCriacaoUsuario , u.updated as dataAtualizacaoUsuario , u.description as descricaoUsuario, 

        /* NIVELDEACESSO    */
        n.id as idNivelDeAcesso, n.nome as nomeNivelDeAcesso, n.descricao as descricaoNivelDeAcesso, n.status as statusNivelDeAcesso, n.created as dataCriacaoNivelDeAcesso, 
        n.updated as DataAtualizacaoNivelDeAcesso, n.description as descricaoNivelDeAcesso,
    
        /* UNIDADE */
        uni.id as idUnidade, uni.nome as nomeUnidade, uni.descricao as descricaoUnidade, uni.status as statusUnidade, uni.created as dataCriacaoUnidade,
        uni.updated as dataAtualizacaoUnidade, uni.description as descriptionUnidade

        from 
            Usuario as u inner join [NivelDeAcesso] as n on u.idNivelDeAcesso = n.id
            inner join [Unidade] as uni on u.idUnidade = uni.id
        Where
            u.senha = HASHBYTES('sha1', '{$senha}') and   u.email = '{$email}'  ";

        //echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);


        $Usuario = new Usuario();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            $Usuario->setId($row['idUsuario']);
            $Usuario->setCpf($row['cpfUsuario']);
            $Usuario->setNome($row['nomeUsuario']);
            $Usuario->setNomeSobrenome($row['nome_SobrenomeUsuario']);
            $Usuario->setDataNascimento($row['dataNascimentoUsuario']->format("Y-m-d"));
            $Usuario->setEmail($row['emailUsuario']);
            $Usuario->setTelefone($row['telefoneUsuario']);
            $Usuario->setStatus($row['statusUsuario']);
            $Usuario->setCreated($row['dataCriacaoUsuario']->format("Y-m-d"));
            //$Usuario->setUpdated($row['dataAtualizacaoUsuario']->format("Y-m-d"));
            $Usuario->setDescription($row['descricaoUsuario']);

            //NivelDeAcesso
            $Usuario->getNivelDeAcesso()->setId($row['idNivelDeAcesso']);
            $Usuario->getNivelDeAcesso()->setNome($row['nomeNivelDeAcesso']);
            $Usuario->getNivelDeAcesso()->setStatus($row['statusNivelDeAcesso']);
            $Usuario->getNivelDeAcesso()->setCreated($row['dataCriacaoNivelDeAcesso']->format("Y-m-d"));
            //$Usuario->getNivelDeAcesso()->setUpdated($row['dataAtualizacaoNivelDeAcesso']->format("Y-m-d"));
            $Usuario->getNivelDeAcesso()->setDescription($row['descricaoNivelDeAcesso']);

            //Unidade
            $Usuario->getUnidade()->setId($row['idUnidade']);
            $Usuario->getUnidade()->setNome($row['nomeUnidade']);
            $Usuario->getUnidade()->setDescricao($row['descricaoUnidade']);
            $Usuario->getUnidade()->setStatus($row['statusUnidade']);
            $Usuario->getUnidade()->setCreated($row['dataCriacaoUnidade']->format("Y-m-d"));
            //$Usuario->getUnidade()->setUpdated($row['dataAtualizacaoUnidade']->format("Y-m-d"));
            $Usuario->getUnidade()->setDescription($row['descriptionUnidade']);
        }
        return $Usuario;
    }


    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select nome_Sobrenome...                                                                             │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function login_deuSucesso($email, $senha)
    {
        $declaracao = "
        Select
        /*  Usuario  */
		u.id as idUsuario, u.cpf as cpfUsuario, u.nome as nomeUsuario,u.nomeSobrenome as nome_SobrenomeUsuario,
		u.dataNascimento as dataNascimentoUsuario, u.email as emailUsuario, u.telefone as telefoneUsuario, 
		u.status as statusUsuario, u.created as dataCriacaoUsuario , u.updated as dataAtualizacaoUsuario , u.description as descricaoUsuario, 

        /* NIVELDEACESSO    */
        n.id as idNivelDeAcesso, n.nome as nomeNivelDeAcesso, n.descricao as descricaoNivelDeAcesso, n.status as statusNivelDeAcesso, n.created as dataCriacaoNivelDeAcesso, 
        n.updated as DataAtualizacaoNivelDeAcesso, n.description as descricaoNivelDeAcesso,
    
        /* UNIDADE */
        uni.id as idUnidade, uni.nome as nomeUnidade, uni.descricao as descricaoUnidade, uni.status as statusUnidade, uni.created as dataCriacaoUnidade,
        uni.updated as dataAtualizacaoUnidade, uni.description as descriptionUnidade

        from 
            Usuario as u inner join [NivelDeAcesso] as n on u.idNivelDeAcesso = n.id
            inner join [Unidade] as uni on u.idUnidade = uni.id
        Where
            u.senha = HASHBYTES('sha1', '{$senha}') and   u.email = '{$email}'  ";

        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);


        if (sqlsrv_has_rows($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt)) {
                //   echo "row:<br>"; var_dump($row); echo "<br><br>";
                return true;
            }
        } else {
            // echo "<br/>No Results were found."; 
            return false;
        }
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ... Where Nome                                                                                │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function listarUsuario($nome, $cpf, $email, $idNivelDeAcesso)
    {
        /*
        * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
        * │ Validação                                                                                                     │
        * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
        */

        $Condicao_query = "";

        for ($contador = 1; $contador <= 4; $contador++) {
            if ($contador == 1) {
                if ($nome !== "") {
                    $Condicao_query = " u.nome LIKE '%{$nome}%'";
                }
            } else if ($contador == 2) {
                if ($cpf !== "") {
                    if ($nome !== "") {
                        $Condicao_query = $Condicao_query . " and ";
                    }

                    $Condicao_query = $Condicao_query . " u.cpf = '{$cpf}' ";
                }
            } else if ($contador == 3) {
                if ($email !== "") {
                    if ($cpf !== "" || $nome !== "") {
                        $Condicao_query = $Condicao_query . " and ";
                    }

                    $Condicao_query = $Condicao_query . " u.email = '{$email}'  ";
                }
            } else if ($contador == 4) {
                if ($cpf !== "" || $nome !== "" || $email !== "") {
                    $Condicao_query = $Condicao_query . " or ";
                }

                $Condicao_query = $Condicao_query . " u.idNivelDeAcesso = '{$idNivelDeAcesso}' ";
            }
        }

        //echo $Condicao_query;


        $declaracao = "Select
        /*  Usuario  */
		u.id as idUsuario, u.cpf as cpfUsuario, u.nome as nomeUsuario,u.nomeSobrenome as nome_SobrenomeUsuario,
		u.dataNascimento as dataNascimentoUsuario, u.email as emailUsuario, u.telefone as telefoneUsuario, 
		u.status as statusUsuario, u.created as dataCriacaoUsuario , u.updated as dataAtualizacaoUsuario , u.description as descricaoUsuario, u.idNivelDeAcesso, u.idUnidade,

		/* NIVELDEACESSO    */
        n.id as idNivelDeAcesso, n.nome as nomeNivelDeAcesso, n.descricao as descricaoNivelDeAcesso, n.status as statusNivelDeAcesso, n.created as dataCriacaoNivelDeAcesso, 
        n.updated as DataAtualizacaoNivelDeAcesso, n.description as descricaoNivelDeAcesso,
		
		/* UNIDADE */
        uni.id as idUnidade, uni.nome as nomeUnidade, uni.descricao as descricaoUnidade, uni.status as statusUnidade, uni.created as dataCriacaoUnidade,
        uni.updated as dataAtualizacaoUnidade, uni.description as descriptionUnidade
		
		
		from 
			Usuario as u inner join NivelDeAcesso as n on u.idNivelDeAcesso = n.id
			inner join Unidade as uni on u.idUnidade = uni.id

        Where
			u.status = 1 and " . $Condicao_query . ";";


        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaUsuario = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Usuario = new Usuario();

            $Usuario->setId($row['idUsuario']);
            $Usuario->setCpf($row['cpfUsuario']);
            $Usuario->setNome($row['nomeUsuario']);
            $Usuario->setNomeSobrenome($row['nome_SobrenomeUsuario']);
            $Usuario->setDataNascimento($row['dataNascimentoUsuario']->format("Y-m-d"));
            $Usuario->setEmail($row['emailUsuario']);
            $Usuario->setTelefone($row['telefoneUsuario']);
            $Usuario->setStatus($row['statusUsuario']);
            $Usuario->setCreated($row['dataCriacaoUsuario']->format("Y-m-d"));
            //$Usuario->setUpdated($row['dataAtualizacaoUsuario']->format("Y-m-d"));
            $Usuario->setDescription($row['descricaoUsuario']);


            //NivelDeAcesso
            $Usuario->getNivelDeAcesso()->setId($row['idNivelDeAcesso']);
            $Usuario->getNivelDeAcesso()->setNome($row['nomeNivelDeAcesso']);
            $Usuario->getNivelDeAcesso()->setStatus($row['statusNivelDeAcesso']);
            $Usuario->getNivelDeAcesso()->setCreated($row['dataCriacaoNivelDeAcesso']->format("Y-m-d"));
            //$Usuario->getNivelDeAcesso()->setUpdated($row['dataAtualizacaoNivelDeAcesso']->format("Y-m-d"));
            $Usuario->getNivelDeAcesso()->setDescription($row['descricaoNivelDeAcesso']);

            //Unidade
            $Usuario->getUnidade()->setId($row['idUnidade']);
            $Usuario->getUnidade()->setNome($row['nomeUnidade']);
            $Usuario->getUnidade()->setDescricao($row['descricaoUnidade']);
            $Usuario->getUnidade()->setStatus($row['statusUnidade']);
            $Usuario->getUnidade()->setCreated($row['dataCriacaoUnidade']->format("Y-m-d"));
            //$Usuario->getUnidade()->setUpdated($row['dataAtualizacaoUnidade']->format("Y-m-d"));
            $Usuario->getUnidade()->setDescription($row['descriptionUnidade']);

            $listaUsuario[] = $Usuario;
        }
        return $listaUsuario;
    }


    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Update [Usuario]                                                                                     │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function alterar($Usuario)
    {
        $declaracao = "
        Update [Usuario] SET  
            [nome] = '{$Usuario->getNome()}' , [nomeSobrenome] = '{$Usuario->getNomeSobrenome()}' , 
            [dataNascimento] = '{$Usuario->getDataNascimento()}' , [email] = '{$Usuario->getEmail()}' , 
            [telefone] = '{$Usuario->getTelefone()}' , [updated] =  GETDATE()
        Where 
		    Id = '{$Usuario->getId()}' 
        ";

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" => $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        //print_r($declaracao);

        if ($stmt == false) {
            return false;
        } else {
            return true;
        }
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...  where id and status = 1                                                                  │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultaIdEStatus($id)
    {
        $declaracao = "Select
        /*  Usuario  */
		u.id as idUsuario, u.cpf as cpfUsuario, u.nome as nomeUsuario,u.nomeSobrenome as nome_SobrenomeUsuario,
		u.dataNascimento as dataNascimentoUsuario, u.email as emailUsuario, u.telefone as telefoneUsuario, u.trocarSenha as trocarSenhaUsuario, 
		u.status as statusUsuario, u.created as dataCriacaoUsuario , u.updated as dataAtualizacaoUsuario , u.description as descricaoUsuario, 

        /* NIVELDEACESSO    */
        n.id as idNivelDeAcesso, n.nome as nomeNivelDeAcesso, n.descricao as descricaoNivelDeAcesso, n.status as statusNivelDeAcesso, n.created as dataCriacaoNivelDeAcesso, 
        n.updated as DataAtualizacaoNivelDeAcesso, n.description as descricaoNivelDeAcesso,
    
        /* UNIDADE */
        uni.id as idUnidade, uni.nome as nomeUnidade, uni.descricao as descricaoUnidade, uni.status as statusUnidade, uni.created as dataCriacaoUnidade,
        uni.updated as dataAtualizacaoUnidade, uni.description as descriptionUnidade

        from 
            Usuario as u inner join [NivelDeAcesso] as n on u.idNivelDeAcesso = n.id
            inner join [Unidade] as uni on u.idUnidade = uni.id
        Where u.id = '{$id}' and u.status = 1 ";

        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $Usuario = new Usuario();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            $Usuario->setId($row['idUsuario']);
            $Usuario->setCpf($row['cpfUsuario']);
            $Usuario->setNome($row['nomeUsuario']);
            $Usuario->setTrocaSenha($row['trocarSenhaUsuario']);
            $Usuario->setNomeSobrenome($row['nome_SobrenomeUsuario']);
            $Usuario->setDataNascimento($row['dataNascimentoUsuario']->format("Y-m-d"));
            $Usuario->setEmail($row['emailUsuario']);
            $Usuario->setTelefone($row['telefoneUsuario']);
            $Usuario->setStatus($row['statusUsuario']);
            $Usuario->setCreated($row['dataCriacaoUsuario']->format("Y-m-d"));
            //$Usuario->setUpdated($row['dataAtualizacaoUsuario']->format("Y-m-d"));
            $Usuario->setDescription($row['descricaoUsuario']);

            //NivelDeAcesso
            $Usuario->getNivelDeAcesso()->setId($row['idNivelDeAcesso']);
            $Usuario->getNivelDeAcesso()->setNome($row['nomeNivelDeAcesso']);
            $Usuario->getNivelDeAcesso()->setStatus($row['statusNivelDeAcesso']);
            $Usuario->getNivelDeAcesso()->setCreated($row['dataCriacaoNivelDeAcesso']->format("Y-m-d"));
            //$Usuario->getNivelDeAcesso()->setUpdated($row['dataAtualizacaoNivelDeAcesso']->format("Y-m-d"));
            $Usuario->getNivelDeAcesso()->setDescription($row['descricaoNivelDeAcesso']);

            //Unidade
            $Usuario->getUnidade()->setId($row['idUnidade']);
            $Usuario->getUnidade()->setNome($row['nomeUnidade']);
            $Usuario->getUnidade()->setDescricao($row['descricaoUnidade']);
            $Usuario->getUnidade()->setStatus($row['statusUnidade']);
            $Usuario->getUnidade()->setCreated($row['dataCriacaoUnidade']->format("Y-m-d"));
            //$Usuario->getUnidade()->setUpdated($row['dataAtualizacaoUnidade']->format("Y-m-d"));
            $Usuario->getUnidade()->setDescription($row['descriptionUnidade']);
        }
        return $Usuario;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Update [Usuario] set status = 0                                                                      │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function deletar($Usuario)
    {
        $declaracao = "Update [Usuario] SET status = 0 , updated = GETDATE() Where id = '{$Usuario->getId()}' ";
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
    * │  @return Update [Usuario]                                                                                     │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function ativar_trocarSenha($id)
    {
        $declaracao = "
        Update
            [Usuario]
        Set
            [trocarSenha] = 1  ,
            [updated] = GETDATE()
        Where 
            id = '{$id}'
            and status = 1; ";

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
    * │  @return Select trocaSenha from [Usuario] where id =  ...                                                     │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function consultar_StatusAlterarSenha($codigo)
    {
        $declaracao = "
        Select
            trocarSenha
        from
            [Usuario]
        Where
            id = '{$codigo}'
            and status = 1
        ;";

        //echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $retorno = "";
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            $retorno = ($row['trocarSenha']);
        }
        return $retorno;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Update [Usuario]                                                                                     │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function desativar_trocarSenha($id)
    {
        $declaracao = "
        Update
            [Usuario]
        Set
            [trocarSenha] = 0  ,
            [updated] = GETDATE()
        Where 
            id = '{$id}'
            and status = 1; ";

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
    * │  @return Update [Usuario]                                                                                     │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function alterarSenha($senha, $id)
    {
        $declaracao = "
        Update
            [Usuario]
        Set
            [senha] = HASHBYTES ('sha1','{$senha}')  ,
            [updated] = GETDATE()
        Where 
            id = '{$id}'
            and status = 1; ";

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" => $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        } else {
            return true;
        }
    }
}
