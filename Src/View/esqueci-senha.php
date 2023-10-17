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
 * ║  │ @description: Screen of login                                                                               │  ║
 * ║  │ @class: login                                                                                               │  ║
 * ║  │ @dir: View                                                                                                  │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 13/11/22                                                                                             │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 * ║                                                     UPGRADES                                                      ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 1. @date: 24/01/23                                                                                          │  ║
 * ║  │    @description: Updating the design                                                                        │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║                                                                                                                   ║
 * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
 */
require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Variables                                                                      │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

if (isset($_GET['id']) == true) {
  $_SESSION['idColaborador'] = $_POST['id'] ?? $_GET['id'];
  $_SESSION['criar_email'] = 'PENDENTE';
  // echo $_SESSION['idColaborador'];
} else {
  $_SESSION['idColaborador'] = null;
}

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Usuario 's section                                                             │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Usuario.php";
require $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Usuario_repositorio.php";

use model\Usuario;
use model\Usuario_repositorio;

$Usuario = new Usuario();
$Usuario_repositorio = new Usuario_repositorio();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Envio_Emails 's section                                                        │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Envio_emails_repositorio.php";

use model\Envio_emails_repositorio;

$Envio_emails_repositorio = new Envio_emails_repositorio();

//Email's section
require_once "../Email/enviarEmail.php";

use function Email\consulta_AlterarSenha;
use function Email\Email_AlterarSenha;

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Functions 's section                                                           │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

if (isset($_POST['status_operacao'])) {

  $mensagemVermelha = true;
  if ($_POST['status_operacao'] == "") {
    $mensagem = "Erro na solicitação. Por favor, tente novamente.";
  } else if ($_POST['email'] == "") {
    $mensagem = "E-mail incorreto. Por favor, preencha ";
  } else {

    $_POST['status_operacao'] = "";

    $resultado =  $Usuario_repositorio->consulta_Email($_POST['email']);

    if ($resultado == false) {
      $mensagem = "E-mail não encontrado. Por favor, tente novamente.";
    } else {
      $mensagemVermelha = false;
      $mensagem = "Email de recuperação enviado!";

      $Usuario_repositorio->ativar_trocarSenha($resultado->getId());

      // 1ª opção
      // Email_AlterarSenha($resultado->getEmail() , $resultado->getNome() , $resultado->getId());


      // 2ª opção
      /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
      * │                                Envio_Emails 's section                                                        │
      * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
      */

      $consultaEmail = consulta_AlterarSenha($resultado->getNome() , $resultado->getId());

      $email_destinatario = $resultado->getEmail();
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
        $resultado->getId()
      );

    }
  }



  // Mensagem do resultado
  if ($mensagemVermelha) {
    echo "<div class='alert alert-danger' role='alert'> ";
  } else {
    echo "<div class='alert alert-success' role='alert'> ";
  }
  echo "<h2>" .  $mensagem . "</h2>";
  echo "</div>";

  if ($mensagemVermelha == false) {
    header("refresh:3;url= login.php");
    // header("refresh:2;url= teste.php");
  }
}



?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Esqueci minha senha</title>
  <meta name="description" content="Sistema de termo de aceite" />
  <meta name="keywords" content="sistema" />
  <meta name="theme-color" content="#ffffff" />
  <link rel="apple-touch-icon" href="/assets/icons/apple-touch-icon.png">
  <link rel="manifest" href="/Termo-de-compromisso/manifest.json">
  <!-- CSS -->
  <link rel="stylesheet" href="../../Assets/Css/components/Header.css" />
  <link rel="stylesheet" href="../../Assets/Css/components/body.css " />
  <link rel="stylesheet" href="../../Assets/Css/components/login.css " />
  <link rel="stylesheet" href="../../Assets/Css/components/footer.css " />
  <!--Boostrap link-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

</head>

<body id="body_Login">

  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
          <div class="card" id="card">
            <div class="row g-0 box_shadow_login">

              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img src="../../Assets/Img/wallpaper/AdobeStock_557049755.jpeg" alt="login form" class="img-fluid" id="img_login" />
              </div>

              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">

                  <form action="login.php">
                    <button type="submit" id="botao-voltar"> <u>Voltar</u></button>
                  </form>
                  <form action="esqueci-senha.php" method="POST">
                    <input type="hidden" value="RECUPERANDO SENHA" name="status_operacao">
                    <div class="d-flex align-items-center mb-3 pb-1">
                      <i class="fas fa-cubes fa-2x me-3 logo-color"></i>
                      <span id="login_title">Redefinir a sua senha</span>
                    </div>

                    <!-- <span id="login_title">Termos de aceite</span> -->
                    <h5 class="fw-normal mb-3 pb-3 titulo">Preencha os dados abaixo para solicitar a recuperação de senha.</h5>



                    <div class="form-outline mb-4">
                      <input type="email" name="email" class="form-control form-control-lg" required />
                      <b><label class="form-label">Seu e-mail de acesso</label></b>
                      <p>Você irá receber um e-mail no endereço informado acima contendo o procedimento para criar uma nova senha para este usuário. Caso seja necessário,
                        verifique também a sua caixa de spam. </p>
                    </div>


                    <div class="pt-1 mb-4">
                      <button class="btn btn-dark btn-lg btn-block" type="submit">Enviar</button>
                    </div>

                  </form>
                  <h6>© Todos os Direitos Reservados - Senac, PE GTI 2023.</h6>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>






  <script>
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('/Termo-de-compromisso/sw.js', {
        scope: '/Termo-de-compromisso/'
      });
    }
  </script>

</body>

</html>