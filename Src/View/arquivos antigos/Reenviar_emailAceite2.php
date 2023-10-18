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
 * ║  │ @description: Result from the email                                                                         |  ║
 * ║  │ @class: Reenviar_emailAceite2                                                                               │  ║
 * ║  │ @dir: Src/ View                                                                                             │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 17/01/23                                                                                             │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 * ║                                                     UPGRADES                                                      ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 1. @date: 05/05/23                                                                                          │  ║
 * ║  │    @description: Reenvio do email cadastrado no banco de dados                                              │  ║
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

$idColaborador = $_POST['idColaborador'] ?? $_GET['idColaborador'];;


/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Colaborador 's section                                                         │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador_repositorio.php";

use model\Colaborador;
use model\Colaborador_repositorio;

$Colaborador_repositorio = new Colaborador_repositorio();

$Colaborador = $Colaborador_repositorio->consultarById($idColaborador);

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Email 's section                                                               │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

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

if ($idColaborador == "") {
  $mensagem = "Erro com o código identificador do usuário";
} else {
  /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    * │                                Email 's section                                                               │
    * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    */

  $consultaEmail = consulta_AceiteTermos($Colaborador->getId() , $Colaborador->getNome()) ;

  $email_destinatario = $Colaborador->getEmail_pessoal();
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


  $mensagem = "E-mail de aceite dos termos enviado com sucesso!";
  // $nome = $Colaborador->getNome();
  // $email_destinatario = $Colaborador->getEmail_pessoal();


  //  $retorno = Email_AceiteTermos($email_destinatario, $nome, $Colaborador->getId() , $nome);

  //  if ($retorno == "Cadastro realizado com sucesso!") {
  //   $mensagem = "E-mail de aceite dos termos enviado com sucesso!";
  //  } else {
  //   $mensagem = "Falha no envio do e-mail";
  //  }

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reenviar email de aceite</title>
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

<div class="row" style="background-color: white; height:19.5cm;">
    <section>
      <article class="card">
        <a href="Usuario-tela-inicial.php">Voltar ao menu</a>
        <div class="row g-0 text-center">
          <div class="col-6 col-md-4">
            <img src="../../Assets/Img/funcionarios.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
          </div>
          <div class="col-sm-6 col-md-8" id="content_inicio">
            <h2 class="content_inicioText">Alteração de um funcionário</h2>
            <h5> Verifique o resultado abaixo</h5>
          </div>
        </div>
      </article>

      <article class="card content_inicioText">

      <?php
        if ($mensagem == "Falha no envio do e-mail"){
          ?>
          <div class="alert alert-danger" role="alert">
          <?php
        } else {
          ?>
           <div class="alert alert-success" role="alert">
          <?php
        }
      ?>
        <h4> <?php echo $mensagem; ?> </h4>
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