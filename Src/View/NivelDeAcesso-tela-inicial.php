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
 * ║  │ @description: Page from the entity 'NivelDeAcesso'                                                          │  ║
 * ║  │ @class: NivelDeAcesso-tela-inicial                                                                          │  ║
 * ║  │ @dir:  View/                                                                                                │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 14/11/22                                                                                             │  ║
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

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\NivelDeAcesso.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\NivelDeAcesso_repositorio.php";


require_once "Recursos/ValidaNivelDeAcesso.php";
ta_conectado();
/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Nivel de acesso 's section                                                     │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

use model\NivelDeAcesso;
use model\NivelDeAcesso_repositorio;

$NivelDeAcesso = new NivelDeAcesso();

$NivelDeAcesso_repositorio = new NivelDeAcesso_repositorio();


/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Functions                                                                      │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

function CriaTela($listar)
{
  //This function will create the result based on the 'List' variable.   
  $contador  = '1';

  foreach ($listar as $NivelDeAcesso) {
?>
    <article class="card">
      <div class="row g-0 text-center">
        <div class="col-sm-6 col-md-6">
          <h3 style="text-align: left;"><?php echo ($contador) . ". " . $NivelDeAcesso->getNome(); ?></h3>
        </div>

        <div class="col-sm-6 col-md-6">
          <button type="button" class="btn dropdown-toggle button_Dropdown" id="buton_MaisOpcoes" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/list-ol.svg">
            Mais opções
          </button>

          <ul class="dropdown-menu">

            <form action="NivelDeAcesso_consultar.php" method="POST">
              <li>
                <input name="id_NivelDeAcesso" value="<?php echo ($NivelDeAcesso->getId()); ?>" type="hidden"> </input>

                <button type="submit" class="dropdown-item">
                  <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/eye-fill.svg">
                  Consultar
                </button>

              </li>
            </form>

            <form action="NivelDeAcesso_alterar.php" method="POST">
              <li>
                <input name="id_NivelDeAcesso2" value="<?php echo ($NivelDeAcesso->getId()); ?>" type="hidden"> </input>

                <button type="submit" class="dropdown-item">
                  <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/pencil.svg">
                  Alterar
                </button>

              </li>
            </form>
          </ul>
        </div>

      </div>

    </article>
<?php
    $contador++;
  }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nível de acesso</title>
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
    1
  );

  valida_acesso($NivelAcesso_disponivel);

  ?>

  <?php
  if (isset($_POST['listarRegistros']) == false || $_POST['listarRegistros'] == 0) {
  ?>
    <div class="row" style="background-color: white; height:19.5cm;">
    <?php
  } else {
    ?>
      <div class="row" style="background-color: white;">
      <?php
    }
      ?>
    <section>
      <article class="card box_shadow">
        <div class="row g-0 text-center">
          <div class="col-6 col-md-4">
            <img src="../../Assets/Img/controle-de-acesso.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
          </div>
          <div class="col-sm-6 col-md-8" id="content_inicio">
            <h2 class="content_inicioText">Busca de um nível de acesso</h2>
            <h4 class="content_inicioText">Utilize o filtro para começar a pesquisar</h4>
          </div>

          <!--OffCanvas - Botão do filtro-->
          <div id="myModal">
            <div class="container text-center">
              <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">

                <div class="col">
                  <div class="p-3 ">
                    <button class="btn" id="buton_Filtro" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                      <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/filter.svg">
                      Filtro
                    </button>
                  </div>
                </div>

                <div class="col">
                  <div class="p-3 ">
                    <a type="button" class="btn btn-primary" href="NivelDeAcesso_cadastro.php">
                      <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/plus.svg" class="backgroung-color-White">
                      Novo
                    </a>
                  </div>
                </div>

                <div class="col">
                  <div class="p-3 ">
                    <form action="NivelDeAcesso-tela-inicial.php" method="POST">
                      <input name="listarRegistros" value="1" type="hidden">
                      <button class="btn" id="buton_Listar">
                        Listar todos os registros
                      </button>
                    </form>
                  </div>
                </div>

                <div class="col">
                  <div class="p-3 ">
                    <form action="NivelDeAcesso-tela-inicial.php" method="POST">
                      <input name="listarRegistros" value="0" type="hidden">
                      <button class="btn btn-secondary">
                        Tirar o registro
                      </button>
                    </form>
                  </div>
                </div>

              </div>
            </div>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasRightLabel">Filtro</h5>
                <button type="reset" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>

              <div class="offcanvas-body">
                <!--Floating Label - Formulário -->
                <form action="NivelDeAcesso-tela-inicial.php" method="post">

                  <div class="Filtro_Cor">
                    <label class="Filtro_Label">Nome: </label>
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control " name="nome" id="floating_Nome" placeholder="Nome">
                      <label for="floatingInput">Nome do nível de acesso</label>
                    </div>
                  </div>

                  <button class="btn" id="Filtro_botao" type="submit">
                    <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/search.svg" class="icon_filter">
                    Pesquisar
                  </button>

                </form>

              </div>
            </div>
          </div>

        </div>
      </article>

      <?php

      /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
      * │                                1.0 Making an list of all the registers                                        │
      * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
      */

      //Validação se existe valor recebido no $_POST[listarRegistros]
      if (isset($_POST['listarRegistros']) == true) {

        //Esta variável vai verificar se o usuário clicou para ver todos os registros
        $_SESSION['listarRegistros'] = $_POST['listarRegistros'] ?? $_GET['listarRegistros'];

        //echo $_SESSION['listarRegistros'];


        if ($_SESSION['listarRegistros'] == '1') {

          $listar = $NivelDeAcesso_repositorio->listar();

          CriaTela($listar);
        }
      }

      /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
      * │                                2.0 FILTER SEARCH                                                              │
      * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
      */

      //Validação se existe valor em algum $_POST[]
      if (isset($_POST['nome']) == true) {

        $_SESSION['nome'] = $_POST['nome'] ?? $_GET['nome'];

        /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
        * │                               Filtro vazio                                                                    | 
        * | Descrição: Se todos os campos estiverem vazios, então dê uma resposta                                         │
        * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
        */

        if ($_SESSION['nome'] == null) {
      ?>
          <article class="card">
            <div class="row g-0 text-center">
              <div class="col-sm-6 col-md-8">
                <h3 style="text-align: left;">Nenhum resultado encontrado! Por favor, tente novamente buscando por outra palavra chave.</h3>
              </div>
              <div class="col-6 col-md-4">
              </div>
            </div>
          </article>
          <?php
        } else {
          /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
          * │                               Trazendo o resultado do Filtro                                                  │
          * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
          */
          $listar = $NivelDeAcesso_repositorio->listarNivelDeAcesso($_SESSION['nome']);

          if (sizeof($listar) == 0) {
          ?>
            <article class="card">
              <div class="row g-0 text-center">
                <div class="col-sm-6 col-md-8">
                  <h3 style="text-align: left;">Nenhum resultado encontrado! Por favor, tente novamente buscando por outra palavra chave.</h3>
                </div>
                <div class="col-6 col-md-4">
                </div>
              </div>
            </article>
      <?php
          } else {
            CriaTela($listar);
          }
        }
      }
      ?>


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