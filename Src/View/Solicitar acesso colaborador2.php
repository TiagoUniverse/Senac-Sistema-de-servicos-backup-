<?php
/*
 * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
 * ║                                                    Senac - Aceite                                                 ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ NOTA: Todas as informações contidas neste documento são propriedade do SENAC PERNAMBUCO e seus fornecedores,│  ║
 * ║  │ caso existam. Os conceitos intelectuais e técnicos contidos são propriedade do SENAC PERNAMBUCO e seus      │  ║
 * ║  │ fornecedores e podem estar cobertos pelas patentes nacionais, e estão protegidas por segredo comercial ou   │  ║
 * ║  │ lei de direitos autorais. Divulgação desta informação ou reprodução deste material é estritamente proibido, │  ║
 * ║  │ a menos que seja obtida permissão prévia por escrito do SENAC PERNAMBUCO.                                   │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ @description: Result from the registry                                                                      |  ║
 * ║  │ @class: Solicitacao-acesso_tela-inicial                                                                     │  ║
 * ║  │ @dir: Src/ View                                                                                             │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 14/11/22                                                                                             │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 * ║                                                     UPGRADES                                                      ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 1. @date: 20/01/23                                                                                          │  ║
 * ║  │    @description: Update the time of the 'Colaborador'                                                       │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 2. @date: 13/02/23                                                                                          │  ║
 * ║  │    @description: Update the 'HorarioTrabalho' of the Colaborador                                            │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 3. @date: 17/02/23                                                                                          │  ║
 * ║  │    @description: Added the 'Emails_enviado'                                                                 │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║                                                                                                                   ║
 * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
 */

require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";
require_once "Recursos/ValidaNivelDeAcesso.php";
ta_conectado();

//Variables
$nomeCompleto = $_POST['nomeCompleto'] ?? $_GET['nomeCompleto'];
$cpf = $_POST['cpf'] ?? $_GET['cpf'];
$dataNascimento = $_POST['dataNascimento'] ?? $_GET['dataNascimento'];
$email_pessoal = $_POST['email_pessoal'] ?? $_GET['email_pessoal'];
$telefone = $_POST['telefone'] ?? $_GET['telefone'];
$funcao = $_POST['funcao'] ?? $_GET['funcao'];
$gerencia = $_POST['gerencia'] ?? $_GET['gerencia'];
$setor = $_POST['setor'] ?? $_GET['setor'];
$rua = $_POST['rua'] ?? $_GET['rua'];
$numero_Endereco = $_POST['numero_Endereco'] ?? $_GET['numero_Endereco'];
$bairro = $_POST['bairro'] ?? $_GET['bairro'];
$observacao = $_POST['observacao'] ?? $_GET['observacao'];
$HorarioTrabalho = $_POST['horarioTrabalho'];


$idUnidade = $_POST['idUnidade'] ?? $_GET['idUnidade'];

$data_totvs = $_POST['data_totvs'] ?? $_GET['data_totvs'];

if (isset($_POST['ramal']) == false) {
  $ramal = null;
} else {
  $ramal = $_POST['ramal'] ?? $_GET['ramal'];
}

if (isset($_POST['motivoEscolha']) == false) {
  $motivoEscolha = null;
} else {
  $motivoEscolha = $_POST['motivoEscolha'] ?? $_GET['motivoEscolha'];
}

if (isset($_POST['matricula']) == false) {
  $matricula = null;
} else {
  $matricula = $_POST['matricula'] ?? $_GET['matricula'];
}

//Colaborador's section
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador_repositorio.php";

use model\Colaborador;
use model\Colaborador_repositorio;

$Colaborador_repositorio = new Colaborador_repositorio();

//Timeline's section
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Timeline.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Timeline_repositorio.php";

use model\Timeline;
use model\Timeline_repositorio;

//Email's section
require_once "..//Email//enviarEmail.php";
use function Email\Email_AceiteTermos;
use function Email\consulta_AceiteTermos;


/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Envio_Emails 's section                                                        │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Envio_emails_repositorio.php";
Use model\Envio_emails_repositorio;

$Envio_emails_repositorio = new Envio_emails_repositorio();


/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Validation                                                                     │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

if ($data_totvs == "true") {
  //Formato de data vindo do TOTVS
  $dataValidacao = explode('/', $dataNascimento);
  $ano = $dataValidacao[2];
  $mes = $dataValidacao[1];
  $dia = $dataValidacao[0];
} else {
  //Formato do input data
  $dataValidacao = explode('-', $dataNascimento);
  $ano = $dataValidacao[0];
  $mes = $dataValidacao[1];
  $dia = $dataValidacao[2];
}

// Criar a variável de data no formato Y-M-D
$dataNascimentoFormatada = $ano . '-' . $mes . '-' . $dia;

$validacao = 0;

if ($nomeCompleto == "") {
  $mensagem = "Preencha o nome completo";
} else if (strlen($nomeCompleto) > 200) {
  $mensagem = "Quantidade de caracteres maiores que 200. Por favor, preencha novamente";
} else if ($cpf == null) {
  $mensagem = "Preencha o CPF";
} else if (strlen($cpf) < 11) {
  $mensagem = "Digite o CPF completo";
} else if ($Colaborador_repositorio->consultar_CPF($cpf) != null) {
  $mensagem = "Já existe um colaborador cadastrado com este CPF. Por favor, verifique o seu CPF";
} else if (checkdate($mes, $dia, $ano) == false) {
  $mensagem = "Data de nascimento inválida. Por favor, digite novamente";
} else if ($email_pessoal == "") {
  $mensagem = "Preencha o email pessoal";
} else if (filter_var($email_pessoal, FILTER_VALIDATE_EMAIL) == false) {
  $mensagem = "E-mail pessoal cadastrado incorretamente. Por favor, preencha novamente";
  // } else if ($Colaborador_repositorio->ValidaEmailPessoal($email_pessoal)) {
  //   $mensagem = "E-mail pessoal já está cadastrado no sistema. Por favor, preencha novamente";
} else if ($telefone == "") {
  $mensagem = "Preencha o telefone de contato";
} else if (strlen($telefone) > 12) {
  $mensagem = "Quantidade incorreta do telefone. Por favor, digite 11 números de telefone de acordo com o exemplo: 81988889999";
} else if ($matricula != null && $Colaborador_repositorio->ValidaChapa($matricula)) {
  $mensagem = "Essa matrícula já está cadastrada no sistema. Por favor, preencha novamente";
} else if ($funcao == "") {
  $mensagem = "Preencha a função";
} else if (str_word_count($funcao) > 200) {
  $mensagem = "Função com mais de 200 caracteres. Por favor, tente novamente";
} else if ($gerencia == "") {
  $mensagem = "Preencha a função";
} else if (str_word_count($gerencia) > 200) {
  $mensagem = "Função com mais de 200 caracteres. Por favor, tente novamente";
} else if ($setor == "") {
  $mensagem = "Preencha a função";
} else if (str_word_count($setor) > 200) {
  $mensagem = "Função com mais de 200 caracteres. Por favor, tente novamente";
} else if ($ramal != null && str_word_count($ramal) > 5) {
  $mensagem = "Ramal com mais de 5 digitos. Por favor, preencha novamente";
} else if ($rua == "") {
  $mensagem = "Preencha o nome da rua";
} else if ($numero_Endereco == "") {
  $mensagem = "Preencha o número da rua";
} else if ($bairro == "") {
  $mensagem = "Preencha o bairro da rua";
} else if ($HorarioTrabalho == "") {
  $mensagem = "Preencha o horário de trabalho do colaborador";
} else if ($idUnidade == "") {
  $mensagem = "Selecione uma unidade";
} else if ($motivoEscolha == null) {
  $mensagem = "Digite um motivo de escolha para este colaborador";
} else {

  $mensagem = "Cadastro realizado com sucesso!";
  $validacao = 1;

  //Colaborador registry
  $Colaborador = new Colaborador();

  $Colaborador->setNome($nomeCompleto);
  $Colaborador->setCpf($cpf);
  $Colaborador->setDataNascimento($dataNascimentoFormatada);
  $Colaborador->setEmail_pessoal($email_pessoal);
  $Colaborador->setTelefone($telefone);
  $Colaborador->setFuncao($funcao);
  $Colaborador->setGerencia($gerencia);
  $Colaborador->setSetor($setor);
  $Colaborador->setRua($rua);
  $Colaborador->setNumero_Endereco($numero_Endereco);
  $Colaborador->setBairro($bairro);
  $Colaborador->setObservacao($observacao);
  $Colaborador->setStatus(1);

  $Colaborador->setHorarioTrabalho($HorarioTrabalho);


  $Colaborador->getUnidade()->setId($idUnidade);

  if ($ramal != null) {
    $Colaborador->setRamal($ramal);
  } else {
    $Colaborador->setRamal("");
  }

  if ($motivoEscolha != null) {
    $Colaborador->setMotivo_Solicitacao($motivoEscolha);
  } else {
    $Colaborador->setMotivo_Solicitacao("");
  }

  if ($matricula != null) {
    $Colaborador->setChapa($matricula);
  } else {
    $Colaborador->setChapa("");
  }

  $Colaborador_repositorio->cadastro($Colaborador);


  //Consulta do colaborador que acabou de ser cadastrado
  $Colaborador = $Colaborador_repositorio->consultaByCPF($cpf);


    /**
   * Cadastro de Id criptografado do colaborador
   * Funcionamento: Este ID será utilizado quando o Suporte GTI for cliclar no e-mail, para que o sistema valide pelo id com criptografia.
   * Data: 13/02/23
   */
  $Colaborador_repositorio->atualizar_IdCriptografado($cpf , hash('sha1' , $Colaborador->getId())  );


  //Timeline registry
  $Timeline = new Timeline();
  $Timeline_repositorio = new Timeline_repositorio();

  $Timeline->setNome("Foi solicitado a criação do e-mail para o colaborador " . $nomeCompleto);
  $Timeline->setId_funcionario($_SESSION['idUser']);
  $Timeline->getColaborador()->setId($Colaborador->getId());

  $Timeline_repositorio->registrar_solicitacaoRH($Timeline);


  /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
  * │                                Envio_Emails 's section                                                        │
  * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
  */

  $consultaEmail = consulta_AceiteTermos($Colaborador->getId() , $Colaborador->getNome()) ;

  $email_destinatario = $email_pessoal;
  $de = "naoresponda@pe.senac.br";
  $para = $email_destinatario;
  $cc = "";
  $assunto = $consultaEmail[0];
  $conteudo = str_replace("'", "''", $consultaEmail[1]);


  $Envio_emails_repositorio->cadastro(
    $de
  , $para 
  , $cc
  , $assunto
  , $conteudo
  , $Colaborador->getId()    );

}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Solicitação de novo colaborador</title>
  <link href="../../Assets/Icons/android-chrome-192x192.png" rel="icon" type="image/png">
  <link rel="apple-touch-icon" sizes="180x180" href="../../Assets/Icons/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../../Assets/Icons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../../Assets/Icons/favicon-16x16.png">

  <link rel="mask-icon" href="../../Assets/Icons/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

  <!--Boostrap link-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <!-- CSS -->
  <link rel="stylesheet" href="../../Assets/Css/components/Header.css" />
  <link rel="stylesheet" href="../../Assets/Css/components/body.css" />
  <link rel="stylesheet" href="../../Assets/Css/components/navbar.css" />
  <link rel="stylesheet" href="../../Assets/Css/components/content.css" />
  <link rel="stylesheet" href="../../Assets/Css/components/SideBar.css" />
  <link rel="stylesheet" href="../../Assets/Css/components/footer.css" />
  <link rel="stylesheet" href="../../Assets/Css/components/filter.css" />
  <meta name="description" content="Sistema de termo de aceite" />
  <meta name="keywords" content="sistema" />
  <meta name="theme-color" content="#ffffff" />
  <link rel="apple-touch-icon" href="/assets/icons/apple-touch-icon.png">
  <link rel="manifest" href="/Termo-de-compromisso/manifest.json">

</head>

<body>

  <?php
  /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
  * │                                Permissão pra acessar esta tela                                                │
  * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
  */
  require_once "Recursos/Navegacao.php";

  //Niveis de acesso disponíveis para acessar a página atual
  $NivelAcesso_disponivel = array(
    1, 2
  );

  valida_acesso($NivelAcesso_disponivel);

  ?>

  <div class="row" style="background-color: white; height:19.3cm;">
    <section>
      <article class="card">
        <a href="Solicitacao-acesso_tela-inicial.php">Recomeçar</a>
        <div class="row g-0 text-center">
          <div class="col-6 col-md-4">
            <img src="../../Assets/Img/funcionarios.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
          </div>
          <div class="col-sm-6 col-md-8" id="content_inicio">
            <h2 class="content_inicioText">Solicitação de acesso de um novo colaborador</h2>
            <h4 class="content_inicioText"> Este formulário foi baseado no documento de "Criação de usuário e E-mail corporativo". A partir desta conclusão, a GTI vai prosseguir com o processo. </h4>
          </div>
        </div>
      </article>

      <article class="card content_inicioText">
        <h3>Resultado:</h3>
        <?php
        if ($validacao == 0) {
        ?>
          <div class="alert alert-danger" role="alert">
          <?php
        } else {
          ?>
            <div class="alert alert-success" role="alert">
            <?php
          }
            ?>
            <p class="h4 color_black"> <?php echo $mensagem; ?> </p>
            </div>

            <br>
            <div class="row g-0 text-center">
              <div class="col-sm-6 col-md-12">
                <h3 class="content_inicioText"> Retornar à tela inicial</h3>
                <a class="btn btn-info my-1" id="" href="Solicitacao-acesso_tela-inicial.php" role="button">Menu inicial</a>
              </div>
            </div>


      </article>

    </section>
  </div>

  <br>
  <footer>
    © Todos os Direitos Reservados - Senac, PE GTI 2023.
  </footer>

  <!--Bootstrap JavaScript-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

  <script>
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('/Termo-de-compromisso/sw.js', {
        scope: '/Termo-de-compromisso/'
      });
    }
  </script>

</body>

</html>