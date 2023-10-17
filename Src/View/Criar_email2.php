<?php

/*
* ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
* ║                                                Senac - Aceite                                                     ║
* ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
* ║  │ NOTA: Todas as informações contidas neste documento são propriedade do SENAC PERNAMBUCO e seus fornecedores,│  ║
* ║  │ caso existam. Os conceitos intelectuais e técnicos contidos são propriedade do SENAC PERNAMBUCO e seus      │  ║
* ║  │ fornecedores e podem estar cobertos pelas patentes nacionais, e estão protegidas por segredo comercial ou   │  ║
* ║  │ lei de direitos autorais. Divulgação desta informação ou reprodução deste material é estritamente proibido, │  ║
* ║  │ a menos que seja obtida permissão prévia por escrito do SENAC PERNAMBUCO.                                   │  ║
* ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
* ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
* ║  │ @description: Result from the creation of an 'institucional e-mail' of an new 'Colaborador' (user)          │  ║
* ║  │ @class: Criar_email2                                                                      		               │  ║
* ║  │ @dir: Html Website/                                                                                         │  ║
* ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
* ║  │ @date: 16/11/22                                                                                             │  ║
* ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
* ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
* ║                                                     UPGRADES                                                      ║
* ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
* ║  │ 1. @date: 04/01/23                                                                                          │  ║
* ║  │    @description: Adicionando a timeline                                                                     │  ║
* ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
* ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
* ║  │ 2. @date: 23/01/23                                                                                          │  ║
* ║  │    @description: Adicionando dois emails disponíveis para enviar ao colaborador                             │  ║
* ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
* ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
* ║  │ 3. @date: 23/02/23                                                                                          │  ║
* ║  │    @description: Registrando os e-mails enviados                                                            │  ║
* ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
* ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
* ║  │ 4. @date: 31/05/23                                                                                          │  ║
* ║  │    @description: Caso o colaborador seja PROFESSOR, o sistema envia um E-MAIL para GTI Sistemas             │  ║
* ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
* ║                                                                                                                   ║
* ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
*/

require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";
require_once "Recursos/ValidaNivelDeAcesso.php";
ta_conectado();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Variables                                                                      │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/
$email_institucional = $_POST['email_institucional'] ?? $_GET['email_institucional'];
$emailPessoal_colaborador = $_POST['emailPessoal_colaborador'] ?? $_GET['emailPessoal_colaborador'];
$nome_colaborador = $_POST['nome_colaborador'] ?? $_GET['nome_colaborador'];
$cpf_Colaborador = $_POST['cpf_Colaborador'] ?? $_GET['cpf_Colaborador'];
$idColaborador = $_POST['idColaborador'];
$senhaPadrao = $_POST['senhaPadrao'] ?? $_GET['senhaPadrao'];

$tipoDeEmail = $_POST['exampleRadios'];

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Criacao de emails's section                                                    │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Criacao_email.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Criacao_email_repositorio.php";

use model\Criacao_email;
use model\Criacao_email_repositorio;

$Criacao_email = new Criacao_email();
$Criacao_email_repositorio = new Criacao_email_repositorio();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Colaborador's section                                                          │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador_repositorio.php";

use model\Colaborador;
use model\Colaborador_repositorio;

$Colaborador = new Colaborador();
$Colaborador_repositorio = new Colaborador_repositorio();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Timeline's section                                                             │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Timeline.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Timeline_repositorio.php";

use model\Timeline;
use model\Timeline_repositorio;

$Timeline = new Timeline();
$Timeline_repositorio = new Timeline_repositorio();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Usuario's section                                                              │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Usuario.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Usuario_repositorio.php";

use model\Usuario_repositorio;
use model\Usuario;

$Usuario = new Usuario();
$Usuario_repositorio = new Usuario_repositorio();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Emails's section                                                               │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/
require_once "../Email/enviarEmail.php";

use function Email\consulta_AtualizacaoSig;
use function Email\consulta_InformacoesColaborador_apenasEmail;
use function Email\consulta_InformacoesColaborador_contaRedeEmail;

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Envio_Emails 's section                                                        │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Envio_emails_repositorio.php";

use model\Envio_emails_repositorio;

$Envio_emails_repositorio = new Envio_emails_repositorio();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Validation                                                                     │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

$idStatusTimeline = $Timeline_repositorio->consultar_idStatusTimeline($idColaborador);

//Validação se o colaborador já possui o id de status 2. Ou seja, este colaborador já recebeu o e-mail institucional 
//e está numa etapa mais avançada
if (in_array(3, $idStatusTimeline)) {
  $possui_email = true;
} else {
  $possui_email = false;
}

//Cor inicial da mensagem. Caso o sistema cadastre o novo e-mail institucional, a cor da mensagem muda para verde
$cor_mensagem = "vermelha";

if ($email_institucional == null) {
  $mensagem =  "Por favor, preencha o e-mail institucional.";
} else if ($nome_colaborador == null) {
  $mensagem = "Por favor, informe o nome do colaborador";
} else if ($idColaborador == null) {
  $mensagem = "Erro em identificar o colaborador pelo seu código. Por favor, tente novamente.";
} else if ($possui_email == true) {
  $mensagem = "Este colaborador já teve o seu e-mail institucional criado.";
} else if ($senhaPadrao == null) {
  $mensagem = "Senha padrão vazia. Por favor, preencha este campo.";
} else {
  $mensagem = "Criação do e-mail institucional do colaborador com sucesso. Assim, o processo está finalizado.";
  $cor_mensagem = "verde";

  //Updating the informations
  //Colaborador
  $Colaborador->setEmail_institucional($email_institucional);
  $Colaborador->setId($idColaborador);
  $Colaborador_repositorio->atualizar_emailInstitucional($Colaborador);

  //Criacao_Email
  $Criacao_email->setNome_criador($_SESSION['nameComplete']);
  $Criacao_email->setNome_colaborador($nome_colaborador);
  $Criacao_email->getUsuario()->setId($_SESSION['idUser']);
  $Criacao_email->getColaborador()->setId($idColaborador);

  $Criacao_email_repositorio->cadastro($Criacao_email);

  //Timeline do colaborador
  if ($tipoDeEmail == "email_apenasEmail") {
    $Timeline->setNome("Apenas o e-mail institucional do Senac foi criado e registrado no sistema. Dessa forma, o processo está finalizado.");
  } else if ($tipoDeEmail == "email_contadeRede_Email") {
    $Timeline->setNome("O e-mail institucional e a conta de rede foram criados e registrados no sistema. Dessa forma, o processo está finalizado.");
  }

  $Timeline->setId_funcionario($_SESSION['idUser']);
  $Timeline->getColaborador()->setId($idColaborador);

  $Timeline_repositorio->registrar_criacaoEmail($Timeline);

  //Email para o Colaborador
  $email_destinatario = $emailPessoal_colaborador;
  $de = "naoresponda@pe.senac.br";
  $para = $email_destinatario;
  $cc = "";


  if ($tipoDeEmail == "email_apenasEmail") {
    // $mensagem = Email_InformacoesColaborador_apenasEmail($email_destinatario, $nome_colaborador, $email_institucional, $senhaPadrao);

    /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │                                Envio_Emails 's section                                                        |
    * | Descrição: Caso vá enviar o e-mail sem a conta de rede, no caso dos PROFESSORES/INSTRUTORES                   │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */

    // 1ª e-mail: para o colaborador informando que o processo está finalizado
    $consultaEmail = consulta_InformacoesColaborador_apenasEmail($nome_colaborador, $email_institucional, $senhaPadrao);

    $assunto = $consultaEmail[0];
    $conteudo = str_replace("'", "''", $consultaEmail[1]);


    $Envio_emails_repositorio->cadastro(
      $de,
      $para,
      $cc,
      $assunto,
      $conteudo,
      $idColaborador
    );

    // 2ª e-mail: para a GTI SISTEMAS solicitando atualização do registro do professor no SIG
    $consultaEmail = consulta_AtualizacaoSig($nome_colaborador, $email_institucional, $cpf_Colaborador);

    $email_destinatario = "gti-sistemas@pe.senac.br";
    $de = "naoresponda@pe.senac.br";
    $para = $email_destinatario;
    $cc = "";


    $assunto = $consultaEmail[0];
    $conteudo = str_replace("'", "''", $consultaEmail[1]);


    $Envio_emails_repositorio->cadastro(
      $de,
      $para,
      $cc,
      $assunto,
      $conteudo,
      $idColaborador
    );
  } else if ($tipoDeEmail == "email_contadeRede_Email") {
    // $mensagem = Email_InformacoesColaborador_contaRedeEmail($email_destinatario, $nome_colaborador, $email_institucional, $senhaPadrao);

    /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │                                Envio_Emails 's section                                                        |
    * | Descrição: Registro do e-mail com conta de rede                                                               │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */

    $consultaEmail =  consulta_InformacoesColaborador_contaRedeEmail($nome_colaborador, $email_institucional, $senhaPadrao);

    $assunto = $consultaEmail[0];
    $conteudo = str_replace("'", "''", $consultaEmail[1]);


    $Envio_emails_repositorio->cadastro(
      $de,
      $para,
      $cc,
      $assunto,
      $conteudo,
      $idColaborador
    );
  }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar email</title>
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
    1, 3
  );

  valida_acesso($NivelAcesso_disponivel);

  ?>

  <div class="row" style="background-color: white; height:19.3cm;">
    <section>
      <article class="card">
        <a href="Criacao-email_tela-inicial.php">Voltar</a>
        <div class="row g-0 text-center">
          <div class="col-6 col-md-4">
            <img src="../../Assets/Img/funcionarios.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
          </div>
          <div class="col-sm-6 col-md-8" id="content_inicio">
            <h2 class="content_inicioText">Criação do e-mail do colaborador</h2>
            <h5>Veja o resultado logo abaixo:</h5>
          </div>
        </div>
      </article>

      <article class="card content_inicioText">
        <?php
        if ($cor_mensagem == "vermelha") {
        ?>
          <div class="alert alert-danger" role="alert">
          <?php
        } else {
          ?>
            <div class="alert alert-success" role="alert">
            <?php
          }
            ?>
            <h5> <?php echo $mensagem; ?> </h5>
            </div>


            <div class="row g-0 text-center">
              <div class="col-sm-6 col-md-12">
                <h3 class="content_inicioText"> Retornar à tela inicial</h3>
                <a class="btn btn-info my-1" id="" href="Criacao-email_tela-inicial.php" role="button">Menu inicial</a>
              </div>
            </div>
      </article>



    </section>
  </div>


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