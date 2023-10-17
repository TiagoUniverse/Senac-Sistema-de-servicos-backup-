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
 * ║  │ @description: It contains all the functions of the "Colaborador " class                                     │  ║
 * ║  │ @class: Colaborador_repositorio                                                                             │  ║
 * ║  │ @dir: src/model                                                                                             │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 21/12/22                                                                                             │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 * ║                                                     UPGRADES                                                      ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 1. @date: 20/01/23                                                                                          │  ║
 * ║  │    @description: Update the colaborador' schedhule and time                                                 │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 2. @date: 08/06/23                                                                                          │  ║
 * ║  │    @description: Fixing the format of date in the function 'Cadastro', data de nascimento                   │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║                                                                                                                   ║
 * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
 */

namespace model;

//08/06/23 = Correção na formatação na data de nascimento no cadastro
use DateTime;


use function Recursos\conexao_declaracao;

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Recursos\\conexao_model.php";

class Colaborador_repositorio
{
    /**
     * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
     * ║                                                    METHODS                                                    ║
     * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
     *
     * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
     * │  @return INSERT INTO [Colaborador  ]                                                                          │
     * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
     */
    public function cadastro($Colaborador)
    {
        // Data corrigida 08/09/23
        $dataNascimentoFormatada = $Colaborador->getDataNascimento();

        $declaracao =  "  Insert into [Colaborador]
        ( [nome], [cpf] , [dataNascimento] , [email_pessoal] , [motivo_solicitacao] , [telefone] , [chapa] , [funcao] , [gerencia] , [setor] , [ramal] , [rua]
        , [numero_endereco] , [bairro] , [horarioTrabalho] , [observacao] , [idUnidade] , status)
    
        Values    
        ('{$Colaborador->getNome()}' , '{$Colaborador->getCpf()}' , '$dataNascimentoFormatada' , '{$Colaborador->getEmail_pessoal()}' ,  '{$Colaborador->getMotivo_solicitacao()}' ,
        '{$Colaborador->getTelefone()}' , '{$Colaborador->getChapa()}' , '{$Colaborador->getFuncao()}' , '{$Colaborador->getGerencia()}' , '{$Colaborador->getSetor()}' , '{$Colaborador->getRamal()}' ,
        '{$Colaborador->getRua()}' , '{$Colaborador->getNumero_endereco()}' , '{$Colaborador->getBairro()}' , '{$Colaborador->getHorarioTrabalho()}' ,
        '{$Colaborador->getObservacao()}' , '{$Colaborador->getUnidade()->getId()}' ,  '{$Colaborador->getStatus()}' ); ";

        //  echo $declaracao;

        conexao_declaracao($declaracao);
    }


    public function listar()
    {
        $declaracao = "
        Select
            /*  Colaborador */
            c.id as idColaborador, c.cpf as cpfColaborador, c.nome as nomeColaborador, c.dataNascimento as dataNascimentoColaborador, c.email_pessoal as email_pessoalColaborador, c.email_institucional as email_institucionalColaborador,
            c.motivo_solicitacao as motivo_solicitacaoColaborador, c.telefone as telefoneColaborador, c.chapa as chapaColaborador, c.funcao as funcaoColaborador, c.gerencia as gerenciaColaborador,
            c.setor as setorColaborador, c.ramal as ramalColaborador, c.rua as ruaColaborador, c.numero_endereco as numero_enderecoColaborador, c.bairro as bairroColaborador, 
            c.observacao as observacaoColaborador, c.status as statusColaborador,
            c.created as dataCriacaoColaborador, c.updated as dataAtualizacaoColaborador, c.description as descricaoColaborador, c.idUnidade as idUnidade_Usuario, 

            /* UNIDADE */
            uni.id as idUnidade, uni.nome as nomeUnidade, uni.descricao as descricaoUnidade, uni.status as statusUnidade, uni.created as dataCriacaoUnidade,
            uni.updated as dataAtualizacaoUnidade, uni.description as descriptionUnidade

        from 
            Colaborador as c inner join Unidade as uni on c.idUnidade = uni.id
        where
            c.status = 1 ";

        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaColaborador = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Colaborador = new Colaborador();

            $Colaborador->setId($row['idColaborador']);
            $Colaborador->setCpf($row['cpfColaborador']);
            $Colaborador->setNome($row['nomeColaborador']);
            $Colaborador->setDataNascimento($row['dataNascimentoColaborador']->format("Y-m-d"));
            $Colaborador->setEmail_pessoal($row['email_pessoalColaborador']);
            $Colaborador->setEmail_institucional($row['email_institucionalColaborador']);
            $Colaborador->setMotivo_Solicitacao($row['motivo_solicitacaoColaborador']);
            $Colaborador->setTelefone($row['telefoneColaborador']);
            $Colaborador->setChapa($row['chapaColaborador']);
            $Colaborador->setFuncao($row['funcaoColaborador']);
            $Colaborador->setGerencia($row['gerenciaColaborador']);
            $Colaborador->setSetor($row['setorColaborador']);
            $Colaborador->setRamal($row['ramalColaborador']);
            $Colaborador->setRua($row['ruaColaborador']);
            $Colaborador->setNumero_endereco($row['numero_enderecoColaborador']);
            $Colaborador->setBairro($row['bairroColaborador']);
            $Colaborador->setObservacao($row['observacaoColaborador']);
            $Colaborador->setStatus($row['statusColaborador']);
            $Colaborador->setCreated($row['dataCriacaoColaborador']->format("Y-m-d"));
            //$Colaborador->setUpdated($row['dataAtualizacaoColaborador']->format("Y-m-d"));
            $Colaborador->setDescription($row['descricaoColaborador']);

            //Unidade
            $Colaborador->getUnidade()->setId($row['idUnidade']);
            $Colaborador->getUnidade()->setNome($row['nomeUnidade']);
            $Colaborador->getUnidade()->setDescricao($row['descricaoUnidade']);
            $Colaborador->getUnidade()->setStatus($row['statusUnidade']);
            $Colaborador->getUnidade()->setCreated($row['dataCriacaoUnidade']->format("Y-m-d"));
            //$Colaborador->getUnidade()->setUpdated($row['dataAtualizacaoUnidade']->format("Y-m-d"));
            $Colaborador->getUnidade()->setDescription($row['descriptionUnidade']);

            $listaColaborador[] = $Colaborador;
        }
        return $listaColaborador;
    }

    /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │                                Listagem de Solicitações dos colaboradores                                     |
    * │ Descrição: As funções abaixos irão auxiliar na listagem de colaboradores na solicitação do RH (28/06/23)      |
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */

    // 1ª: Listar todos os ids de colaboradores disponíveis
    // Esta função vai trazer todos os colaboradores cadastrados no sistema para depois filtrarmos quais são os que
    // estão com o processo em andamento e quais já acabaram.
    public function listar_IdColaboradores()
    {
        $declaracao = "
        Select
            id
        From
            Colaborador
        Where status = 1 ";

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $ids_Colaborador = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            $ids_Colaborador[] = $row['id'];
        }
        return $ids_Colaborador;
    }

    // 2ª: Retornar uma lista com apenas o id dos colaboradores que estão com o processo em andamento
    // Agora que já listamos todos os colaboradores, vamos retornar apenas os que estão com o processo em andamneto
    public function listar_Colaboradores_Andamento(array $ids_Colaborador)
    {
        $idColaboradores_Andamento = array();
        $Timeline_repositorio = new Timeline_repositorio();

        foreach ($ids_Colaborador as $id) {
            $idStatusTimeline =  $Timeline_repositorio->consultar_idStatusTimeline($id);

            $idAtual = max($idStatusTimeline);

            if ($idAtual != 3) {
                $idColaboradores_Andamento[] = $id;
            }
        }

        return $idColaboradores_Andamento;
    }


    // Esta consulta vai listar todos os colaboradores que estão com o processo em andamento e os colaboradores do TOTVS
    // que foram contratados recentementes e virão como sugestão para o R.H. Essa consulta pode ser complexa e vou separá-la em
    // várias funções.  Data: 28/06/23
    public function listagem_SolicitacaoColaborador()
    {
        $Colaborador_repositorio = new Colaborador_repositorio();
        $id_colaborador = $Colaborador_repositorio->listar_IdColaboradores();

        $idColaboradores_Andamento = $Colaborador_repositorio->listar_Colaboradores_Andamento($id_colaborador);

        $condicao = "";

        for ($contador = 0; $contador < count($idColaboradores_Andamento); $contador++) {
            if ($contador == 0) {
                $condicao .= "colab.id ='" . $idColaboradores_Andamento[$contador] . "' ";
            } else {
                $condicao .= "OR colab.id ='" . $idColaboradores_Andamento[$contador] . "' ";
            }
        }

        $TOTVS_repositorio = new TOTVS_repositorio();

        $listaTotvs = $TOTVS_repositorio->listarTodosTOTVS_SolicitacaoRH();

        // var_dump($listaTotvs);

        $Colaborador_repositorio = new Colaborador_repositorio();
        foreach ($listaTotvs as $totvs) {
            $retorno = $Colaborador_repositorio->consultar_CPF($totvs[2]);

            // //Se retorna nada, é porque ele não encontrou o CPF no sistema
            if ($retorno == null && $retorno == false) {
                // echo "Este colaborador não foi cadastrado";
                $envio = array('0', $totvs[1], $totvs[2]);
                $resultadoTotvs[] = $envio;
            }
        }

        $declaracao = "
        Select
            *
        From
            Colaborador as colab
        Where 
        $condicao ";

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaColaborador = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $id = $row['id'];
            $nome = $row['nome'];
            $cpf = $row['cpf'];

            $listaColaborador[] = array($id, $nome, $cpf);
        }

        // Vamos unir o array dos colaboradores em processo e a consulta do TOTVS
        $resultado_Listagem = array_merge($listaColaborador, $resultadoTotvs);

        // var_dump($resultado_Listagem);


        return $resultado_Listagem;
    }

    // Esta consulta busca por um colaborador que está com o processo em andamento e que 
    //atende aos parametros de busca. Data: 28/06/23
    public function verificar_Colaborador_Filtro(int $idColaborador_Andamento, $nome, $cpf, $email)
    {

        $Condicao_query = "";
        for ($contador = 1; $contador <= 3; $contador++) {
            if ($contador == 1) {
                if ($nome !== "") {
                    $Condicao_query = " c.nome LIKE '%{$nome}%'";
                }
            } else if ($contador == 2) {
                if ($cpf !== "") {
                    if ($nome !== "") {
                        $Condicao_query = $Condicao_query . " and ";
                    }

                    $Condicao_query = $Condicao_query . " c.cpf = '{$cpf}' ";
                }
            } else if ($contador == 3) {
                if ($email !== "") {
                    if ($cpf !== "" || $nome !== "") {
                        $Condicao_query = $Condicao_query . " and ";
                    }

                    $Condicao_query = $Condicao_query . " c.email_pessoal = '{$email}' or c.email_institucional = '{$email}'  ";
                }
            }
        }

        $declaracao = "
        Select
            c.id, c.nome, c.cpf, c.email_pessoal, c.email_institucional
        From
            Colaborador as c
        Where 
        status = 1 and id = '$idColaborador_Andamento' and $Condicao_query  ";

        // echo $declaracao;
        // echo "<br>";
        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            return $row['id'];
        }
        return false;
    }

    // A consulta abaixo é para listar o resultado do filtro do RH, exibindo os resultados encontrados do
    // TOTVS e da lista de colaboradores cadastrados. Data: 12/07/23
    public function listagemFILTRO_SolicitacaoColaborador(array $listaColaborador, array $listaTOTVS, $apenasColaborador)
    {
        $resultado = array();
        /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
        * │                                Colaborador                                                                    |
        * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
        */
        // 1ª passo: Listar todos os ids dos colaboradores
        $Colaborador_repositorio = new Colaborador_repositorio();
        $id_colaborador = $Colaborador_repositorio->listar_IdColaboradores();

        // 2ª passo: Verificar quais dos colaboradores estão em andamento com o seu processo
        $idColaboradores_Andamento = $Colaborador_repositorio->listar_Colaboradores_Andamento($id_colaborador);

        foreach ($listaColaborador as $Colaborador) {
            if (in_array($Colaborador->getId(), $idColaboradores_Andamento)) {
                $envio = array($Colaborador->getId(), $Colaborador->getNome(), $Colaborador->getCpf());
                $resultado[] = $envio;
            }
        }

        /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
        * │                                TOTVS                                                                          |
        * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
        */

        if (!empty($listaTOTVS)  && $apenasColaborador == null) {
            // var_dump($listaTOTVS);
            $Colaborador_repositorio = new Colaborador_repositorio();
            foreach ($listaTOTVS as $totvs) {
                $retorno = $Colaborador_repositorio->consultar_CPF($totvs->getCpf());

                // //Se retorna nada, é porque ele não encontrou o CPF no sistema
                if ($retorno == null && $retorno == false) {
                    // echo "Este colaborador não foi cadastrado";
                    $envio = array('0', $totvs->getNome(), $totvs->getCpf());
                    $resultado[] = $envio;
                }
            }
        }
        return $resultado;
    }


    public function listar_ColaboradoresFinalizados()
    {
        $declaracao = "
        Select
            /*  Colaborador */
            c.id as idColaborador, c.cpf as cpfColaborador, c.nome as nomeColaborador, c.dataNascimento as dataNascimentoColaborador, c.email_pessoal as email_pessoalColaborador, c.email_institucional as email_institucionalColaborador,
            c.motivo_solicitacao as motivo_solicitacaoColaborador, c.telefone as telefoneColaborador, c.chapa as chapaColaborador, c.funcao as funcaoColaborador, c.gerencia as gerenciaColaborador,
            c.setor as setorColaborador, c.ramal as ramalColaborador, c.rua as ruaColaborador, c.numero_endereco as numero_enderecoColaborador, c.bairro as bairroColaborador, 
            c.observacao as observacaoColaborador, c.status as statusColaborador,
            c.created as dataCriacaoColaborador, c.updated as dataAtualizacaoColaborador, c.description as descricaoColaborador, c.idUnidade as idUnidade_Usuario,

            /* UNIDADE */
            uni.id as idUnidade, uni.nome as nomeUnidade, uni.descricao as descricaoUnidade, uni.status as statusUnidade, uni.created as dataCriacaoUnidade,
            uni.updated as dataAtualizacaoUnidade, uni.description as descriptionUnidade,

			/* TIMELINE */
			ti.id as idTimeline, ti.nome as nomeTimeline, ti.id_funcionario as id_funcionarioTimeline, ti.created as dataCriacaoTimeline, ti.idColaborador as idColaborador_Timeline,
        ti.idStatusTimeline as idStatusTimeline_Timeline

        from Colaborador as c inner join Unidade as uni on c.idUnidade = uni.id
			inner join timeline as ti on ti.idColaborador = c.id
        where
            c.status = 1 and ti.idStatusTimeline = 3 ";

        // echo $declaracao;


        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaColaborador = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Colaborador = new Colaborador();

            $Colaborador->setId($row['idColaborador']);
            $Colaborador->setCpf($row['cpfColaborador']);
            $Colaborador->setNome($row['nomeColaborador']);
            $Colaborador->setDataNascimento($row['dataNascimentoColaborador']->format("Y-m-d"));
            $Colaborador->setEmail_pessoal($row['email_pessoalColaborador']);
            $Colaborador->setEmail_institucional($row['email_institucionalColaborador']);
            $Colaborador->setMotivo_Solicitacao($row['motivo_solicitacaoColaborador']);
            $Colaborador->setTelefone($row['telefoneColaborador']);
            $Colaborador->setChapa($row['chapaColaborador']);
            $Colaborador->setFuncao($row['funcaoColaborador']);
            $Colaborador->setGerencia($row['gerenciaColaborador']);
            $Colaborador->setSetor($row['setorColaborador']);
            $Colaborador->setRamal($row['ramalColaborador']);
            $Colaborador->setRua($row['ruaColaborador']);
            $Colaborador->setNumero_endereco($row['numero_enderecoColaborador']);
            $Colaborador->setBairro($row['bairroColaborador']);
            $Colaborador->setObservacao($row['observacaoColaborador']);
            $Colaborador->setStatus($row['statusColaborador']);
            $Colaborador->setCreated($row['dataCriacaoColaborador']->format("Y-m-d"));
            //$Colaborador->setUpdated($row['dataAtualizacaoColaborador']->format("Y-m-d"));
            $Colaborador->setDescription($row['descricaoColaborador']);

            //Unidade
            $Colaborador->getUnidade()->setId($row['idUnidade']);
            $Colaborador->getUnidade()->setNome($row['nomeUnidade']);
            $Colaborador->getUnidade()->setDescricao($row['descricaoUnidade']);
            $Colaborador->getUnidade()->setStatus($row['statusUnidade']);
            $Colaborador->getUnidade()->setCreated($row['dataCriacaoUnidade']->format("Y-m-d"));
            //$Colaborador->getUnidade()->setUpdated($row['dataAtualizacaoUnidade']->format("Y-m-d"));
            $Colaborador->getUnidade()->setDescription($row['descriptionUnidade']);

            $listaColaborador[] = $Colaborador;
        }
        return $listaColaborador;
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
            [Colaborador]
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
    * │  @return Select ...                                                                                           │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function ValidaEmailPessoal($email_pessoal)
    {
        $declaracao = "Select email_pessoal from Colaborador where status = 1 ";

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);
        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if ($row['email_pessoal'] == $email_pessoal) {
                return true;
            }
        }
        return false;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select chapa                                                                                         │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function ValidaChapa($chapa)
    {
        $declaracao = "Select chapa from Usuario Where status = 1 ";

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);
        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if ($row['chapa'] == $chapa) {
                return true;
            }
        }
        return false;
    }


    public function consultarById($id)
    {
        $declaracao = "
        Select
            /*  Colaborador */
            c.id as idColaborador, c.cpf as cpfColaborador, c.nome as nomeColaborador, c.dataNascimento as dataNascimentoColaborador, c.email_pessoal as email_pessoalColaborador, c.email_institucional as email_institucionalColaborador,
            c.motivo_solicitacao as motivo_solicitacaoColaborador, c.telefone as telefoneColaborador, c.chapa as chapaColaborador, c.funcao as funcaoColaborador, c.gerencia as gerenciaColaborador,
            c.setor as setorColaborador, c.ramal as ramalColaborador, c.rua as ruaColaborador, c.numero_endereco as numero_enderecoColaborador, c.bairro as bairroColaborador, 
            c.observacao as observacaoColaborador, c.status as statusColaborador, c.horarioTrabalho , c.created as dataCriacaoColaborador, c.updated as dataAtualizacaoColaborador,
            c.description as descricaoColaborador, c.idUnidade as idUnidade_Usuario,

            /* UNIDADE */
            uni.id as idUnidade, uni.nome as nomeUnidade, uni.descricao as descricaoUnidade, uni.status as statusUnidade, uni.created as dataCriacaoUnidade,
            uni.updated as dataAtualizacaoUnidade, uni.description as descriptionUnidade

        from 
            Colaborador as c inner join Unidade as uni on c.idUnidade = uni.id
        where
            c.status = 1 and c.id = '{$id}' ";

        //    echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }


        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Colaborador = new Colaborador();

            $Colaborador->setId($row['idColaborador']);
            $Colaborador->setCpf($row['cpfColaborador']);
            $Colaborador->setNome($row['nomeColaborador']);
            $Colaborador->setDataNascimento($row['dataNascimentoColaborador']->format("Y-m-d"));
            $Colaborador->setEmail_pessoal($row['email_pessoalColaborador']);
            $Colaborador->setEmail_institucional($row['email_institucionalColaborador']);
            $Colaborador->setMotivo_Solicitacao($row['motivo_solicitacaoColaborador']);
            $Colaborador->setTelefone($row['telefoneColaborador']);
            $Colaborador->setChapa($row['chapaColaborador']);
            $Colaborador->setFuncao($row['funcaoColaborador']);
            $Colaborador->setGerencia($row['gerenciaColaborador']);
            $Colaborador->setSetor($row['setorColaborador']);
            $Colaborador->setRamal($row['ramalColaborador']);
            $Colaborador->setRua($row['ruaColaborador']);
            $Colaborador->setNumero_endereco($row['numero_enderecoColaborador']);
            $Colaborador->setBairro($row['bairroColaborador']);
            $Colaborador->setHorarioTrabalho($row['horarioTrabalho']);
            $Colaborador->setObservacao($row['observacaoColaborador']);
            $Colaborador->setStatus($row['statusColaborador']);
            $Colaborador->setCreated($row['dataCriacaoColaborador']->format("Y-m-d"));
            //$Colaborador->setUpdated($row['dataAtualizacaoColaborador']->format("Y-m-d"));
            $Colaborador->setDescription($row['descricaoColaborador']);

            //Unidade
            $Colaborador->getUnidade()->setId($row['idUnidade']);
            $Colaborador->getUnidade()->setNome($row['nomeUnidade']);
            $Colaborador->getUnidade()->setDescricao($row['descricaoUnidade']);
            $Colaborador->getUnidade()->setStatus($row['statusUnidade']);
            $Colaborador->getUnidade()->setCreated($row['dataCriacaoUnidade']->format("Y-m-d"));
            //$Colaborador->getUnidade()->setUpdated($row['dataAtualizacaoUnidade']->format("Y-m-d"));
            $Colaborador->getUnidade()->setDescription($row['descriptionUnidade']);
        }
        return $Colaborador;
    }


    public function consultarByIdCriptografado($id_criptografado)
    {
        $declaracao = "
        Select
            /*  Colaborador */
            c.id as idColaborador, c.cpf as cpfColaborador, c.nome as nomeColaborador, c.dataNascimento as dataNascimentoColaborador, c.email_pessoal as email_pessoalColaborador, c.email_institucional as email_institucionalColaborador,
            c.motivo_solicitacao as motivo_solicitacaoColaborador, c.telefone as telefoneColaborador, c.chapa as chapaColaborador, c.funcao as funcaoColaborador, c.gerencia as gerenciaColaborador,
            c.setor as setorColaborador, c.ramal as ramalColaborador, c.rua as ruaColaborador, c.numero_endereco as numero_enderecoColaborador, c.bairro as bairroColaborador, 
            c.observacao as observacaoColaborador, c.status as statusColaborador, c.horarioTrabalho , c.created as dataCriacaoColaborador, c.updated as dataAtualizacaoColaborador,
            c.description as descricaoColaborador, c.idUnidade as idUnidade_Usuario,

            /* UNIDADE */
            uni.id as idUnidade, uni.nome as nomeUnidade, uni.descricao as descricaoUnidade, uni.status as statusUnidade, uni.created as dataCriacaoUnidade,
            uni.updated as dataAtualizacaoUnidade, uni.description as descriptionUnidade

        from 
            Colaborador as c inner join Unidade as uni on c.idUnidade = uni.id
        where
            c.status = 1 and c.id_criptografado = '{$id_criptografado}' ";

        //    echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }


        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Colaborador = new Colaborador();

            $Colaborador->setId($row['idColaborador']);
            $Colaborador->setCpf($row['cpfColaborador']);
            $Colaborador->setNome($row['nomeColaborador']);
            $Colaborador->setDataNascimento($row['dataNascimentoColaborador']->format("Y-m-d"));
            $Colaborador->setEmail_pessoal($row['email_pessoalColaborador']);
            $Colaborador->setEmail_institucional($row['email_institucionalColaborador']);
            $Colaborador->setMotivo_Solicitacao($row['motivo_solicitacaoColaborador']);
            $Colaborador->setTelefone($row['telefoneColaborador']);
            $Colaborador->setChapa($row['chapaColaborador']);
            $Colaborador->setFuncao($row['funcaoColaborador']);
            $Colaborador->setGerencia($row['gerenciaColaborador']);
            $Colaborador->setSetor($row['setorColaborador']);
            $Colaborador->setRamal($row['ramalColaborador']);
            $Colaborador->setRua($row['ruaColaborador']);
            $Colaborador->setNumero_endereco($row['numero_enderecoColaborador']);
            $Colaborador->setBairro($row['bairroColaborador']);
            $Colaborador->setHorarioTrabalho($row['horarioTrabalho']);
            $Colaborador->setObservacao($row['observacaoColaborador']);
            $Colaborador->setStatus($row['statusColaborador']);
            $Colaborador->setCreated($row['dataCriacaoColaborador']->format("Y-m-d"));
            //$Colaborador->setUpdated($row['dataAtualizacaoColaborador']->format("Y-m-d"));
            $Colaborador->setDescription($row['descricaoColaborador']);

            //Unidade
            $Colaborador->getUnidade()->setId($row['idUnidade']);
            $Colaborador->getUnidade()->setNome($row['nomeUnidade']);
            $Colaborador->getUnidade()->setDescricao($row['descricaoUnidade']);
            $Colaborador->getUnidade()->setStatus($row['statusUnidade']);
            $Colaborador->getUnidade()->setCreated($row['dataCriacaoUnidade']->format("Y-m-d"));
            //$Colaborador->getUnidade()->setUpdated($row['dataAtualizacaoUnidade']->format("Y-m-d"));
            $Colaborador->getUnidade()->setDescription($row['descriptionUnidade']);
        }
        return $Colaborador;
    }

    public function consultaByCPF($cpf)
    {
        $declaracao = "
        Select
        /*  Colaborador */
        c.id as idColaborador, c.cpf as cpfColaborador, c.nome as nomeColaborador, c.dataNascimento as dataNascimentoColaborador, c.email_pessoal as email_pessoalColaborador, c.email_institucional as email_institucionalColaborador,
        c.motivo_solicitacao as motivo_solicitacaoColaborador, c.telefone as telefoneColaborador, c.chapa as chapaColaborador, c.funcao as funcaoColaborador, c.gerencia as gerenciaColaborador,
        c.setor as setorColaborador, c.ramal as ramalColaborador, c.rua as ruaColaborador, c.numero_endereco as numero_enderecoColaborador, c.bairro as bairroColaborador, 
        c.observacao as observacaoColaborador, c.status as statusColaborador, c.horarioTrabalho,
        c.created as dataCriacaoColaborador, c.updated as dataAtualizacaoColaborador, c.description as descricaoColaborador, c.idUnidade as idUnidade_Usuario,

        /* UNIDADE */
        uni.id as idUnidade, uni.nome as nomeUnidade, uni.descricao as descricaoUnidade, uni.status as statusUnidade, uni.created as dataCriacaoUnidade,
        uni.updated as dataAtualizacaoUnidade, uni.description as descriptionUnidade

    from 
        Colaborador as c inner join Unidade as uni on c.idUnidade = uni.id
        where
            c.status = 1 and c.cpf = '{$cpf}' ";


        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Colaborador = new Colaborador();

            $Colaborador->setId($row['idColaborador']);
            $Colaborador->setCpf($row['cpfColaborador']);
            $Colaborador->setNome($row['nomeColaborador']);
            $Colaborador->setDataNascimento($row['dataNascimentoColaborador']->format("Y-m-d"));
            $Colaborador->setEmail_pessoal($row['email_pessoalColaborador']);
            $Colaborador->setEmail_institucional($row['email_institucionalColaborador']);
            $Colaborador->setMotivo_Solicitacao($row['motivo_solicitacaoColaborador']);
            $Colaborador->setTelefone($row['telefoneColaborador']);
            $Colaborador->setChapa($row['chapaColaborador']);
            $Colaborador->setFuncao($row['funcaoColaborador']);
            $Colaborador->setGerencia($row['gerenciaColaborador']);
            $Colaborador->setSetor($row['setorColaborador']);
            $Colaborador->setRamal($row['ramalColaborador']);
            $Colaborador->setRua($row['ruaColaborador']);
            $Colaborador->setNumero_endereco($row['numero_enderecoColaborador']);
            $Colaborador->setBairro($row['bairroColaborador']);
            $Colaborador->setHorarioTrabalho($row['horarioTrabalho']);
            $Colaborador->setObservacao($row['observacaoColaborador']);
            $Colaborador->setStatus($row['statusColaborador']);
            $Colaborador->setCreated($row['dataCriacaoColaborador']->format("Y-m-d"));
            //$Colaborador->setUpdated($row['dataAtualizacaoColaborador']->format("Y-m-d"));
            $Colaborador->setDescription($row['descricaoColaborador']);

            //Unidade
            $Colaborador->getUnidade()->setId($row['idUnidade']);
            $Colaborador->getUnidade()->setNome($row['nomeUnidade']);
            $Colaborador->getUnidade()->setDescricao($row['descricaoUnidade']);
            $Colaborador->getUnidade()->setStatus($row['statusUnidade']);
            $Colaborador->getUnidade()->setCreated($row['dataCriacaoUnidade']->format("Y-m-d"));
            //$Colaborador->getUnidade()->setUpdated($row['dataAtualizacaoUnidade']->format("Y-m-d"));
            $Colaborador->getUnidade()->setDescription($row['descriptionUnidade']);
        }
        if (isset($Colaborador)) {
            return $Colaborador;
        } else {
            return null;
        }
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Update [Usuario]                                                                                     │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function alterar_motivo($motivo_solicitacao, $id)
    {
        $declaracao = "
        Update
            [Colaborador]
        Set
            [motivo_solicitacao] = '{$motivo_solicitacao}'  ,
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
    * │  @return Update [Usuario]                                                                                     |
    * |  Date: 13/03/23                                                                                               │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function alterar_solicitacao(
        $motivo_solicitacao,
        $email_Pessoal,
        $telefone,
        $matricula,
        $funcao,
        $gerencia,
        $setor,
        $ramal,
        $rua,
        $numero_endereco,
        $bairro,
        $horarioTrabalho,
        $observacao,
        $idUnidade,
        $id
    ) {
        $declaracao = "
        Update
            [Colaborador]
        Set
            [motivo_solicitacao] = '{$motivo_solicitacao}'  ,
            [email_Pessoal] = '{$email_Pessoal}'  ,
            [telefone] = '{$telefone}'  ,
            [chapa] = '{$matricula}'  ,
            [funcao] = '{$funcao}'  ,
            [gerencia] = '{$gerencia}'  ,
            [setor] = '{$setor}'  ,
            [ramal] = '{$ramal}'  ,
            [rua] = '{$rua}'  ,
            [numero_endereco] = '{$numero_endereco}'  ,
            [bairro] = '{$bairro}'  ,
            [horarioTrabalho] = '{$horarioTrabalho}'  ,
            [observacao] = '{$observacao}'  ,
            [idUnidade] = '{$idUnidade}'  ,
            [updated] = GETDATE()
        Where 
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
                    $Condicao_query = " c.nome LIKE '%{$nome}%'";
                }
            } else if ($contador == 2) {
                if ($cpf !== "") {
                    if ($nome !== "") {
                        $Condicao_query = $Condicao_query . " and ";
                    }

                    $Condicao_query = $Condicao_query . " c.cpf = '{$cpf}' ";
                }
            } else if ($contador == 3) {
                if ($email !== "") {
                    if ($cpf !== "" || $nome !== "") {
                        $Condicao_query = $Condicao_query . " and ";
                    }

                    $Condicao_query = $Condicao_query . " c.email_pessoal = '{$email}' or c.email_institucional = '{$email}'  ";
                }
            }
        }

        //echo $Condicao_query;


        $declaracao = "Select
        /*  Colaborador */
        c.id as idColaborador, c.cpf as cpfColaborador, c.nome as nomeColaborador, c.dataNascimento as dataNascimentoColaborador, c.email_pessoal as email_pessoalColaborador, c.email_institucional as email_institucionalColaborador,
        c.motivo_solicitacao as motivo_solicitacaoColaborador, c.telefone as telefoneColaborador, c.chapa as chapaColaborador, c.funcao as funcaoColaborador, c.gerencia as gerenciaColaborador,
        c.setor as setorColaborador, c.ramal as ramalColaborador, c.rua as ruaColaborador, c.numero_endereco as numero_enderecoColaborador, c.bairro as bairroColaborador, 
         c.observacao as observacaoColaborador, c.status as statusColaborador,
        c.created as dataCriacaoColaborador, c.updated as dataAtualizacaoColaborador, c.description as descricaoColaborador, c.idUnidade as idUnidade_Usuario,

        /* UNIDADE */
        uni.id as idUnidade, uni.nome as nomeUnidade, uni.descricao as descricaoUnidade, uni.status as statusUnidade, uni.created as dataCriacaoUnidade,
        uni.updated as dataAtualizacaoUnidade, uni.description as descriptionUnidade

        from   
            Colaborador as c inner join Unidade as uni on c.idUnidade = uni.id
        where
        c.status = 1 and " . $Condicao_query . " ; ";


        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaColaborador = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Colaborador = new Colaborador();

            $Colaborador->setId($row['idColaborador']);
            $Colaborador->setCpf($row['cpfColaborador']);
            $Colaborador->setNome($row['nomeColaborador']);
            $Colaborador->setDataNascimento($row['dataNascimentoColaborador']->format("Y-m-d"));
            $Colaborador->setEmail_pessoal($row['email_pessoalColaborador']);
            $Colaborador->setEmail_institucional($row['email_institucionalColaborador']);
            $Colaborador->setMotivo_Solicitacao($row['motivo_solicitacaoColaborador']);
            $Colaborador->setTelefone($row['telefoneColaborador']);
            $Colaborador->setChapa($row['chapaColaborador']);
            $Colaborador->setFuncao($row['funcaoColaborador']);
            $Colaborador->setGerencia($row['gerenciaColaborador']);
            $Colaborador->setSetor($row['setorColaborador']);
            $Colaborador->setRamal($row['ramalColaborador']);
            $Colaborador->setRua($row['ruaColaborador']);
            $Colaborador->setNumero_endereco($row['numero_enderecoColaborador']);
            $Colaborador->setBairro($row['bairroColaborador']);
            $Colaborador->setObservacao($row['observacaoColaborador']);
            $Colaborador->setStatus($row['statusColaborador']);
            $Colaborador->setCreated($row['dataCriacaoColaborador']->format("Y-m-d"));
            //$Colaborador->setUpdated($row['dataAtualizacaoColaborador']->format("Y-m-d"));
            $Colaborador->setDescription($row['descricaoColaborador']);

            //Unidade
            $Colaborador->getUnidade()->setId($row['idUnidade']);
            $Colaborador->getUnidade()->setNome($row['nomeUnidade']);
            $Colaborador->getUnidade()->setDescricao($row['descricaoUnidade']);
            $Colaborador->getUnidade()->setStatus($row['statusUnidade']);
            $Colaborador->getUnidade()->setCreated($row['dataCriacaoUnidade']->format("Y-m-d"));
            //$Colaborador->getUnidade()->setUpdated($row['dataAtualizacaoUnidade']->format("Y-m-d"));
            $Colaborador->getUnidade()->setDescription($row['descriptionUnidade']);

            $listaColaborador[] = $Colaborador;
        }
        return $listaColaborador;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...                                                                                           │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function listarTodos_CriacaoEmail()
    {
        $declaracao = "Select
        /*  Colaborador */
                c.id as idColaborador, c.id_criptografado as id_criptografadoColaborador ,  c.cpf as cpfColaborador, c.nome as nomeColaborador, c.dataNascimento as dataNascimentoColaborador, c.email_pessoal as email_pessoalColaborador, c.email_institucional as email_institucionalColaborador,
                c.motivo_solicitacao as motivo_solicitacaoColaborador, c.telefone as telefoneColaborador, c.chapa as chapaColaborador, c.funcao as funcaoColaborador, c.gerencia as gerenciaColaborador,
                c.setor as setorColaborador, c.ramal as ramalColaborador, c.rua as ruaColaborador, c.numero_endereco as numero_enderecoColaborador, c.bairro as bairroColaborador, 
                 c.observacao as observacaoColaborador, c.status as statusColaborador,
                c.created as dataCriacaoColaborador, c.updated as dataAtualizacaoColaborador, c.description as descricaoColaborador, c.idUnidade as idUnidade_Usuario,
        
                /* TimeLine */
                ti.id as idTimeline, ti.nome as nomeTimeline, ti.id_funcionario as id_funcionarioTimeline, ti.created as dataCriacaoTimeline, ti.idColaborador as idColaborador_Timeline,
                ti.idStatusTimeline as idStatusTimeline_Timeline
        
            from 
                Colaborador as c inner join Timeline as ti on ti.idColaborador = c.id
            where
                ti.idStatusTimeline = 2 and status = 1 ";

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaColaborador = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Colaborador = new Colaborador();

            $Colaborador->setId($row['idColaborador']);
            $Colaborador->setId_criptografado($row['id_criptografadoColaborador']);
            $Colaborador->setCpf($row['cpfColaborador']);
            $Colaborador->setNome($row['nomeColaborador']);
            $Colaborador->setDataNascimento($row['dataNascimentoColaborador']->format("Y-m-d"));
            $Colaborador->setEmail_pessoal($row['email_pessoalColaborador']);
            $Colaborador->setEmail_institucional($row['email_institucionalColaborador']);
            $Colaborador->setMotivo_Solicitacao($row['motivo_solicitacaoColaborador']);
            $Colaborador->setTelefone($row['telefoneColaborador']);
            $Colaborador->setChapa($row['chapaColaborador']);
            $Colaborador->setFuncao($row['funcaoColaborador']);
            $Colaborador->setGerencia($row['gerenciaColaborador']);
            $Colaborador->setSetor($row['setorColaborador']);
            $Colaborador->setRamal($row['ramalColaborador']);
            $Colaborador->setRua($row['ruaColaborador']);
            $Colaborador->setNumero_endereco($row['numero_enderecoColaborador']);
            $Colaborador->setBairro($row['bairroColaborador']);
            $Colaborador->setObservacao($row['observacaoColaborador']);
            $Colaborador->setStatus($row['statusColaborador']);
            $Colaborador->setCreated($row['dataCriacaoColaborador']->format("Y-m-d"));
            //$Colaborador->setUpdated($row['dataAtualizacaoColaborador']->format("Y-m-d"));
            $Colaborador->setDescription($row['descricaoColaborador']);


            $listaColaborador[] = $Colaborador;
        }
        return $listaColaborador;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Select ...                                                                                           │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function listarColaborador_criacaoEmail($nome, $cpf, $email)
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
                    $Condicao_query = " c.nome LIKE '%{$nome}%'";
                }
            } else if ($contador == 2) {
                if ($cpf !== "") {
                    if ($nome !== "") {
                        $Condicao_query = $Condicao_query . " and ";
                    }

                    $Condicao_query = $Condicao_query . " c.cpf = '{$cpf}' ";
                }
            } else if ($contador == 3) {
                if ($email !== "") {
                    if ($cpf !== "" || $nome !== "") {
                        $Condicao_query = $Condicao_query . " and ";
                    }

                    $Condicao_query = $Condicao_query . " c.email_pessoal = '{$email}' or c.email_institucional = '{$email}'  ";
                }
            }
        }

        //echo $Condicao_query;


        $declaracao = "Select
        /*  Colaborador */
                c.id as idColaborador, c.cpf as cpfColaborador, c.nome as nomeColaborador, c.dataNascimento as dataNascimentoColaborador, c.email_pessoal as email_pessoalColaborador, c.email_institucional as email_institucionalColaborador,
                c.motivo_solicitacao as motivo_solicitacaoColaborador, c.telefone as telefoneColaborador, c.chapa as chapaColaborador, c.funcao as funcaoColaborador, c.gerencia as gerenciaColaborador,
                c.setor as setorColaborador, c.ramal as ramalColaborador, c.rua as ruaColaborador, c.numero_endereco as numero_enderecoColaborador, c.bairro as bairroColaborador, 
                c.observacao as observacaoColaborador, c.status as statusColaborador,
                c.created as dataCriacaoColaborador, c.updated as dataAtualizacaoColaborador, c.description as descricaoColaborador, c.idUnidade as idUnidade_Usuario,
        
                /* TimeLine */
                ti.id as idTimeline, ti.nome as nomeTimeline, ti.id_funcionario as id_funcionarioTimeline, ti.created as dataCriacaoTimeline, ti.idColaborador as idColaborador_Timeline,
                ti.idStatusTimeline as idStatusTimeline_Timeline
        
            from 
                Colaborador as c inner join Timeline as ti on ti.idColaborador = c.id
            where
                ti.idStatusTimeline = 2 and c.status = 1 and " . $Condicao_query;


        // echo $declaracao;

        $conexao = array("Database" => $_SESSION['DB_NAME'], "CharacterSet" => "UTF-8", "UID" =>  $_SESSION['DB_USER'], "PWD" => $_SESSION['DB_PASSWORD']);
        $link = sqlsrv_connect($_SESSION['SERVER'], $conexao);

        $stmt = sqlsrv_query($link, $declaracao);

        if ($stmt == false) {
            return false;
        }

        $listaColaborador = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Colaborador = new Colaborador();

            $Colaborador->setId($row['idColaborador']);
            $Colaborador->setCpf($row['cpfColaborador']);
            $Colaborador->setNome($row['nomeColaborador']);
            $Colaborador->setDataNascimento($row['dataNascimentoColaborador']->format("Y-m-d"));
            $Colaborador->setEmail_pessoal($row['email_pessoalColaborador']);
            $Colaborador->setEmail_institucional($row['email_institucionalColaborador']);
            $Colaborador->setMotivo_Solicitacao($row['motivo_solicitacaoColaborador']);
            $Colaborador->setTelefone($row['telefoneColaborador']);
            $Colaborador->setChapa($row['chapaColaborador']);
            $Colaborador->setFuncao($row['funcaoColaborador']);
            $Colaborador->setGerencia($row['gerenciaColaborador']);
            $Colaborador->setSetor($row['setorColaborador']);
            $Colaborador->setRamal($row['ramalColaborador']);
            $Colaborador->setRua($row['ruaColaborador']);
            $Colaborador->setNumero_endereco($row['numero_enderecoColaborador']);
            $Colaborador->setBairro($row['bairroColaborador']);
            $Colaborador->setObservacao($row['observacaoColaborador']);
            $Colaborador->setStatus($row['statusColaborador']);
            $Colaborador->setCreated($row['dataCriacaoColaborador']->format("Y-m-d"));
            //$Colaborador->setUpdated($row['dataAtualizacaoColaborador']->format("Y-m-d"));
            $Colaborador->setDescription($row['descricaoColaborador']);

            $listaColaborador[] = $Colaborador;
        }

        return $listaColaborador;
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Update [Colaborador] set email_institucional...                                                      │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function atualizar_emailInstitucional($Colaborador)
    {
        $declaracao = "
        Update 
            [Colaborador] 
        SET  
            [email_institucional] = '{$Colaborador->getEmail_institucional()}' ,  
            [updated] =  GETDATE()
        Where Id = '{$Colaborador->getId()}' ";

        conexao_declaracao($declaracao);
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
            [Colaborador] 
        SET  
            [id_criptografado] = '{$id_criptografado}'
        Where cpf = '{$cpf}' ";

        // echo $declaracao;

        conexao_declaracao($declaracao);
    }

    /*
    * ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │  @return Update [Colaborador]                                                                                 │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function alterar_dataAceiteTermo($Colaborador)
    {
        $declaracao = "
        Update
            [Colaborador]
        Set
            [dataAceiteTermo] = GETDATE()  ,
            [updated] = GETDATE()
        Where 
            id = '{$Colaborador->getId()}'
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
    * │  @return Select chapa                                                                                         │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */
    public function excluir_Colaborador($id)
    {
        $declaracao = "
        Update
            [Colaborador] 
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
}
