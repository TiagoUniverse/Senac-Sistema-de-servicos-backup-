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
* ║  │ @description: Alteration from the 'Funcionario' class                                                       │  ║
* ║  │ @class: Usuario_alterar                                                                                 │  ║
* ║  │ @dir:  View/                                                                                                │  ║
* ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
* ║  │ @date: 11/11/22                                                                                             │  ║
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

$codigo = $_POST['id_usuario2'] ?? $_GET['id_usuario2'];

require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";

require_once "Recursos/ValidaNivelDeAcesso.php";
ta_conectado();

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\NivelDeAcesso.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\NivelDeAcesso_repositorio.php";

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

$Usuario = $Usuario_repositorio->consultaId($codigo);


/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                NivelDeAcesso 's section                                                       │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

use model\NivelDeAcesso;
use model\NivelDeAcesso_repositorio;

$NivelDeAcesso = new NivelDeAcesso();
$NivelDeAcesso_repositorio = new NivelDeAcesso_repositorio();


$listar = $NivelDeAcesso_repositorio->listar();

$listarNivelDeAcesso = "";

foreach ($listar as $NivelDeAcesso) {
  if ($NivelDeAcesso->getId() == $Usuario->getNivelDeAcesso()->getId()) {
    $listarNivelDeAcesso .= "<option value='{$NivelDeAcesso->getId()}' selected>{$NivelDeAcesso->getNome()}</option>";
  } else {
    $listarNivelDeAcesso .= "<option value='{$NivelDeAcesso->getId()}'>{$NivelDeAcesso->getNome()}</option>";
  }
}

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Acess level validation                                                         |
* | Description: It need to be above the //NavBar_comNome function to validate the acess Level                    │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/
$idTelas_has_Funcao = 6;

//// //validacao_NivelDeAcesso($idTelas_has_Funcao);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alterar usuário</title>
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
  


  <div class="row" style="background-color: white;">

    <section>
      <article class="card">
        <a href="Usuario-tela-inicial.php">Voltar</a>
        <div class="row g-0 text-center">
          <div class="col-6 col-md-4">
            <img src="../../Assets/Img/funcionarios.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
          </div>
          <div class="col-sm-6 col-md-8" id="content_inicio">
            <h2 class="content_inicioText">Alteração de um funcionário</h2>
          </div>
        </div>
      </article>

      <article class="card content_textLeft">
        <form action="Usuario_alterar2.php" method="post">
          <input type="hidden" value="<?php echo $Usuario->getNivelDeAcesso()->getId(); ?>" name="idNivelDeAcesso">
          <input type="hidden" value="<?php echo $Usuario->getCpf(); ?>" name="cpf">

          <?php

          if ($Usuario->getStatus() == '1') {
          ?>
            <!--Radio button-->
            <div id="ativo_inativo">
              <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="status" id="btnradio1" value="1" autocomplete="off" checked>
                <label class="btn btn-outline-success" for="btnradio1">Ativo</label>

                <input type="radio" class="btn-check" name="status" id="btnradio2" value="0" autocomplete="off">
                <label class="btn btn-outline-danger" for="btnradio2">Inativo</label>
              </div>
            </div>

          <?php
          } else {
          ?>

            <!--Radio button-->
            <div id="ativo_inativo">
              <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="status" id="btnradio1" value="1" autocomplete="off">
                <label class="btn btn-outline-success" for="btnradio1">Ativo</label>

                <input type="radio" class="btn-check" name="status" id="btnradio2" value="0" autocomplete="off" checked>
                <label class="btn btn-outline-danger" for="btnradio2">Inativo</label>
              </div>
            </div>

          <?php
          }
          ?>

          <input name="id" value="<?php echo ($codigo); ?>" type="hidden">
          <label for="basic-url" class="form-label">Informações pessoais</label>
          <div class="form-floating">
            <input type="text" class="form-control" value="<?php echo $Usuario->getNome(); ?>" name="nomeCompleto" id="nomeCompleto" placeholder="Nome Completo">
            <label for="floatingPassword">Nome completo</label>
          </div>

          <div class="form-floating">
            <input type="text" class="form-control my-2" value="<?php echo $Usuario->getNomeSobrenome(); ?>" name="NomeSobrenome" id="NomeSobrenome" placeholder="Nome e Sobrenome">
            <label for="floatingPassword">Nome e Sobrenome</label>
          </div>

          <div class="form-floating">
            <input type="text" class="form-control my-2" value="<?php echo $Usuario->getCpf(); ?>" name="cpf" id="cpf" disabled placeholder="CPF:">
            <label for="floatingPassword">CPF:</label>
          </div>

          <div class="form-floating">
            <input type="date" class="form-control my-2" value="<?php echo $Usuario->getDataNascimento(); ?>" name="dataNascimento" id="dataNascimento" placeholder="Data de nascimento">
            <label for="floatingPassword">Data de nascimento</label>
          </div>

          <div class="form-floating">
            <input type="email" class="form-control my-2" value="<?php echo $Usuario->getEmail(); ?>" name="email_pessoal" id="email_pessoal" placeholder="Email pessoal">
            <label for="floatingPassword">Email pessoal</label>
          </div>

          <div class="form-floating">
            <input type="tel" class="form-control my-2" value="<?php echo $Usuario->getTelefone(); ?>" name="telefone" id="telefone" placeholder="Telefone">
            <label for="floatingPassword">Telefone</label>
          </div>

          <br>
          <!-- Button trigger modal -->
          <a id="button_expanded" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Alterar</a>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Confirmar alteração</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                  Por favor, verifique as informações digitadas e confirme que estão digitadas corretamente. Deseja continuar?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  <button type="submit" class="btn btn-danger">Alterar</button>
                </div>
              </div>
            </div>
          </div>

        </form>
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