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
 * ║  │ @description: Change of password through email						                                                  │  ║
 * ║  │ @class: alterar_senha                                                                                       │  ║
 * ║  │ @dir: email model/                                                                                          │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 29/10/2022                                                                                           │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 * ║                                                     UPGRADES                                                      ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 1. @date: 22/05/23                                                                                          │  ║
 * ║  │    @description: Updating the visual of the website                                                         │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║                                                                                                                   ║
 * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
 */

require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Usuario.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Usuario_repositorio.php";

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Usuario 's section                                                             │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

use model\Usuario;
use model\Usuario_repositorio;

$Usuario = new Usuario();
$Usuario_repositorio = new Usuario_repositorio();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Variables                                                                      │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

if (isset($_GET['id']) == null) {
  //echo "Voce não precisa confirmar os termos";
  $codigo = null;
} else {
  $codigo = $_GET['id'] ?? $_POST['id'];

  $Usuario = $Usuario_repositorio->consultaIdEStatus($codigo);
}

$statusTrocaSenha = $Usuario_repositorio->consultar_StatusAlterarSenha($codigo);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trocar a senha</title>
  <!-- CSS -->
  <link rel="stylesheet" href="../../Assets/Css/components/Header.css" />
  <link rel="stylesheet" href="../../Assets/Css/components/body.css" />
  <link rel="stylesheet" href="../../Assets/Css/components/navbar.css" />
  <link rel="stylesheet" href="../../Assets/Css/components/content.css" />
  <link rel="stylesheet" href="../../Assets/Css/components/SideBar.css" />
  <link rel="stylesheet" href="../../Assets/Css/components/footer.css" />
  <link rel="stylesheet" href="../../Assets/Css/components/filter.css" />
  <link rel="stylesheet" href="../../Assets/Css/components/Table.css" />
  <!--Boostrap link-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

  <meta name="description" content="Sistema de termo de aceite" />
  <meta name="keywords" content="sistema" />
  <meta name="theme-color" content="#ffffff" />
  <link rel="apple-touch-icon" href="/assets/icons/apple-touch-icon.png">
  <link rel="manifest" href="/Termo-de-compromisso/manifest.json">
</head>

<body id="body_aceite">

  <?php
  if (isset($_POST['listarRegistros']) == false || $_POST['listarRegistros'] == 0) {
    echo " <div class='row' style='background-color: white; height:19.5cm;'>";
  } else {
    echo " <div class='row' style='background-color: white;'>";
  }
  ?>

  <header>
    <img src="../../Assets/Img/senac_logo_branco.png">
    <h1>Termo de compromisso</h1>
  </header>

  <nav>
    <ul>
      <?php
      if ($statusTrocaSenha != 0) {
        echo "<li><a id='username_Aceite'> Usuário:  " . $Usuario->getNomeSobrenome() . " ?> </a></li>";
      } else {
        echo "<li> <a id='username'></a>";
      }
      ?>
    </ul>
  </nav>

  <section>
    <article class="card">
      <div class="row g-0 text-center" id="div_alterarSenha">
        <div class="col-6 col-md-4">
          <img src="../../Assets/Img/contrato.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
        </div>
        <div class="col-sm-6 col-md-8" id="content_inicio">
          <h2 class="content_inicioText">Redefinição de senha</h2>
          <h4>Digite a sua nova senha duas vezes e clique em alterar senha:</h4>
        </div>
      </div>
    </article>

    <article class="card content_textLeft">
      <?php
      if ($statusTrocaSenha == 0) {
      ?>
        <h4 class="content_inicioText"> Não foi solicitado para alterar a sua senha </h4>
      <?php
      } else {
      ?>
        <form action="alterar_senha2.php" method="POST">
          <input type="hidden" value=" <?php echo $Usuario->getNomeSobrenome() ?> " name="nomeUsuario">
          <input type="hidden" value="<?php echo $codigo; ?>" name="idUsuario">

          <br><br>
          <div class="form-floating">
            <label for="validationCustom01" class="form-label">Senha:</label>
            <input type="password" class="form-control" name="senha" id="formulario_entrada" required>
            <div class="valid-feedback">
              Muito bem!
            </div>
          </div>

          <br>
          <div class="form-floating">
            <label for="validationCustom01" class="form-label">Repita a senha:</label>
            <input type="password" class="form-control" name="repitaSenha" id="formulario_entrada" required>
            <div class="valid-feedback">
              Muito bem!
            </div>
          </div>

          <!-- Button trigger modal -->
          <br>
          <a class="btn btn-danger" data-bs-toggle="modal" id="button_expanded" data-bs-target="#exampleModal">Alterar a senha</a>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Confirmar alteração</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                  Deseja confirmar a alteração da senha?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  <button type="submit" class="btn btn-danger">Alterar</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      <?php
      }
      ?>
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