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
 * ║  │ @date: 17/10/23                                                                                             │  ║
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
require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";

//Variables
if (isset($_GET['id']) == true) {
  $_SESSION['idColaborador'] = $_POST['id'] ?? $_GET['id'];
  $_SESSION['criar_email'] = 'PENDENTE';
  // echo $_SESSION['idColaborador'];
} else {
  $_SESSION['idColaborador'] = null;
}

//Usuario's section
require $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Usuario.php";
require $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Usuario_repositorio.php";

use model\Usuario;
use model\Usuario_repositorio;

$Usuario = new Usuario();
$Usuario_repositorio = new Usuario_repositorio();

//Validation
// Already connected verification
if (isset($_SESSION['connected'])) {
  if ($_SESSION['connected'] == '1') {
    if ($_SESSION['acessLevel'] == 1 || $_SESSION['acessLevel'] == 4) {
      header('Location: Solicitacao-acesso_tela-inicial.php');
    } else if ($_SESSION['acessLevel'] == 7) {
      //Se o suporte GTI estiver fazendo login num link com id, redirecione para a criação do e-mail
      if (isset($_GET['id'])) {
        header('Location: Criar_email.php?id=' . $_GET['id']);
      } else {
        header('Location: Criacao-email_tela-inicial.php');
      }
    }
  }
}

if (isset($_POST['email']) == true && isset($_POST['senha']) == true) {
  $Usuario_repositorio->Login($_POST['email'], $_POST['senha']);

  $loginfuncionou = $Usuario_repositorio->login_deuSucesso($_POST['email'], $_POST['senha']);

  if ($loginfuncionou) {
   
    $Usuario = $Usuario_repositorio->consulta_nomeSobrenome($_POST['email'], $_POST['senha']);


    $_SESSION['connected'] = '1';
    $_SESSION['acessLevel'] = $Usuario->getNivelDeAcesso()->getId();
    $_SESSION['idUser'] = $Usuario->getId();
    $_SESSION['nameUser'] = $Usuario->getNomeSobrenome();
    $_SESSION['nameComplete'] = $Usuario->getNome();

    if ($_SESSION['acessLevel'] == 1 || $_SESSION['acessLevel'] == 2) {
      header('Location: Solicitacao-acesso_tela-inicial.php');
    } else if ($_SESSION['acessLevel'] == 3) {

      //Se o suporte GTI estiver fazendo login num link com id, redirecione para a criação do e-mail
      if (isset($_GET['id'])) {
        header('Location: Criar_email.php?id=' . $_GET['id']);
      } else {
        header('Location: Criacao-email_tela-inicial.php');
      }
    }
  } else if ($loginfuncionou == false) {
?>
    <div class="alert alert-danger" role="alert">
      <h1>Falha a acessar sua conta. Por favor, Tente novamente!</h1>
    </div>
<?php
  }
}
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
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

                  <?php
                  if (isset($_SESSION['idColaborador']) == true) {
                    $link = "login.php?id=" . $_SESSION['idColaborador'];
                  ?>
                    <form action="<?php echo $link; ?>" method="POST">
                      <h5 style="color: red;">Suporte GTI, você será redirecionado para criar o e-mail</h5>
                    <?php
                  } else {
                    ?>
                      <form action="login.php" method="POST">
                      <?php
                    }
                      ?>

                      <div class="d-flex align-items-center mb-3 pb-1">
                        <i class="fas fa-cubes fa-2x me-3 logo-color"></i>
                        <span id="login_title">Termo de compromisso</span>
                      </div>

                      <!-- <span id="login_title">Termos de aceite</span> -->
                      <h5 class="fw-normal mb-3 pb-3 titulo">Entre no sistema com sua conta</h5>

                      <div class="form-outline mb-4">
                        <input type="email" name="email" class="form-control form-control-lg" required />
                        <label class="form-label">Email institucional</label>
                      </div>

                      <div class="form-outline mb-4">
                        <input type="password" name="senha" class="form-control form-control-lg" required />
                        <label class="form-label">Senha</label>
                      </div>

                      <div class="pt-1 mb-4">
                        <button class="btn btn-dark btn-lg btn-block" type="submit">Acessar</button>
                        <br><br><a href="esqueci-senha.php">Esqueci a senha</a>
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