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
 * ║  │ @description: Initial page to create emails                                                                 │  ║
 * ║  │ @class: Criacao-email_tela-inicial                                                                    	    │  ║
 * ║  │ @dir: Html Website/                                                                                         │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 16/11/22                                                                                             │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 * ║                                                     UPGRADES                                                      ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 1. @date: 03/01/23                                                                                          │  ║
 * ║  │    @description: Adicionando redirecionamento do suporte gti para o colaborador específico                  │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║                                                                                                                   ║
 * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
 */

require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";

require_once "Recursos/ValidaNivelDeAcesso.php";
ta_conectado();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                      Variables                                                                │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

if (isset($_POST['filtro']) == null) {
  $_POST['filtro'] = null;
}


/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                       'Colaborador' section                                                   │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador_repositorio.php";

use model\Colaborador;
use model\Colaborador_repositorio;

$Colaborador = new Colaborador();
$Colaborador_repositorio = new Colaborador_repositorio();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Timeline 's section                                                            │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Timeline.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Timeline_repositorio.php";


use model\Timeline;
use model\Timeline_repositorio;

$Timeline = new Timeline();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Criacao_email 's section                                                       │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Criacao_email.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Criacao_email_repositorio.php";

use model\Criacao_email;
use model\Criacao_email_repositorio;

$Criacao_email = new Criacao_email();

$Criacao_email_repositorio = new Criacao_email_repositorio();


/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Functions                                                                      │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

function CriaTela($listar)
{

  //This function will create the result based on the 'List' variable.   
  $contador  = '1';
  foreach ($listar as $Colaborador) {

    $Timeline_repositorio = new Timeline_repositorio();

    $retorno = $Timeline_repositorio->consultar_idStatusTimeline($Colaborador->getId());

    $idStatusTimeline = max($retorno);

    //Caso o id de status máximo dele não seja 2, então quer dizer que ele já tá no 3 e não precisa criar o e-mail
    if ($idStatusTimeline == 2) {
?>
      <article class="card">
        <div class="row g-0 text-center">
          <div class="col-sm-6 col-md-6">
            <h3 style="text-align: left;"><?php echo ($contador) . ". " . $Colaborador->getNome(); ?></h3>
          </div>

          <div class="col-sm-6 col-md-6">
            <button type="button" class="btn dropdown-toggle button_Dropdown" id="buton_MaisOpcoes" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/list-ol.svg">
              Mais opções
            </button>

            <ul class="dropdown-menu">
              <?php
              $link = "Criar_email.php?id=" . $Colaborador->getId_criptografado();
              ?>
              <form action="<?php echo $link; ?>" method="POST">
                <li>
                  <button type="submit" class="dropdown-item">
                    <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/eye-fill.svg">
                    Criar e-mail institucional
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

    ?>

  <?php

  }
}

function ContarRegistros($listar)
{

  //This function will create the result based on the 'List' variable.   
  $contador  = '1';
  foreach ($listar as $Colaborador) {

    $Timeline_repositorio = new Timeline_repositorio();

    $retorno = $Timeline_repositorio->consultar_idStatusTimeline($Colaborador->getId());

    $idStatusTimeline = max($retorno);

    //Caso o id de status máximo dele não seja 2, então quer dizer que ele já tá no 3 e não precisa criar o e-mail
    if ($idStatusTimeline == 2) {
      $contador++;
    }

  ?>

<?php

  }
  return $contador;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criação de e-mail</title>
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

  <?php

  /**
   * Fundo branco 
   * Funcionamento: Caso o filtro não tenha sido utilizado, ele vai contar a quantidade de registros que serão exibidos da lista. Caso a quantidade a ser exibida
   * seja até 3, o fundo branco será da altura de 19.5cm. Caso contrário, não precisa de um tamanho específico.
   * Isso ocorre porque caso só tivesse 1 registro ou menos, o fundo branco ficaria até a metade da tela e seria muito curto.
   * Data: 23/02/23
   */
  if (isset($_POST['filtro']) == false || $_POST['filtro'] != "ativo") {

    $listar = $Colaborador_repositorio->listarTodos_CriacaoEmail();
    $totalColaboradores = ContarRegistros($listar);

    if ($totalColaboradores <= 3) {
  ?>
      <div class="row" style="background-color: white; height:19.5cm;">
      <?php
    } else {
      ?>
        <div class="row" style="background-color: white;">
        <?php
      }
    } else {

      $listar = $Colaborador_repositorio->listarColaborador_criacaoEmail($_SESSION['nome'], $_SESSION['cpf'], $_SESSION['email']);
      // echo sizeof($listar);
      if (sizeof($listar) <= 3) {
        ?>
          <div class="row" style="background-color: white; height:19.9cm;">
          <?php
        } else {
          ?>
            <div class="row" style="background-color: white;">
          <?php
        }

      }

          ?>
          <section>
            <article class="card box_shadow">
              <div class="row g-0 text-center">
                <div class="col-6 col-md-4">
                  <img src="../../Assets/Img/register.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
                </div>
                <div class="col-sm-6 col-md-8" id="content_inicio">
                  <h2 class="content_inicioText">Criação de e-mail</h2>
                  <h4 class="content_inicioText">Utilize o filtro para começar a pesquisar</h4>
                </div>

                <!--OffCanvas - Botão do filtro-->
                <div id="myModal">
                  <div class="container text-center">
                    <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">

                      <?php
                      if ($_POST['filtro'] != 'ativo') {
                      ?>
                        <div class="col">
                          <div class="p-3 ">
                            <button class="btn" id="buton_Filtro" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                              <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/filter.svg">
                              Filtro
                            </button>
                          </div>
                        </div>
                      <?php
                      } else {
                      ?>
                        <div class="col">
                          <div class="p-3 ">
                            <form action="Criacao-email_tela-inicial.php" method="POST">
                              <input name="filtro" value="inativo" type="hidden">
                              <button class="btn" id="buton_Listar">
                                Listar todos os registros
                              </button>
                            </form>
                          </div>
                        </div>
                      <?php
                      }
                      ?>


                    </div>
                  </div>

                  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                    <div class="offcanvas-header">
                      <h5 class="offcanvas-title" id="offcanvasRightLabel">Filtro</h5>
                      <button type="reset" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>

                    <div class="offcanvas-body">
                      <!--Floating Label - Formulário -->
                      <form action="Criacao-email_tela-inicial.php" method="post">

                        <input name="filtro" value="ativo" type="hidden">

                        <div class="Filtro_Cor">
                          <label class="Filtro_Label">Nome: </label>
                          <div class="form-floating mb-3">
                            <input type="text" class="form-control " name="nome" id="floating_Nome" placeholder="Nome do funcionário">
                            <label for="floatingInput">Nome do colaborador</label>
                          </div>

                          <label class="Filtro_Label">CPF: </label>
                          <div class="form-floating">
                            <input type="text" maxlength="11" class="form-control " name="cpf" id="floating_cpf" placeholder="CPF">
                            <label for="floatingPassword">CPF</label>
                          </div>

                          <br>
                          <label class="Filtro_Label">E-mail: </label>
                          <div class="form-floating">
                            <input type="email" class="form-control " name="email" id="floating_email" placeholder="E-mail">
                            <label for="floatingPassword">E-mail</label>
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

            /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
      * │                                1.0 Making an list of all the registers                                        │
      * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
      */

            if ($_POST['filtro'] != 'ativo') {
              $listar = $Colaborador_repositorio->listarTodos_CriacaoEmail();
              CriaTela($listar);
            }


            /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
      * │                                2.0 FILTER SEARCH                                                              │
      * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
      */

            //Validação se existe valor em algum $_POST[]
            if (isset($_POST['nome']) == true || isset($_POST['email']) == true || isset($_POST['cpf']) == true) {

              $_SESSION['nome'] = $_POST['nome'] ?? $_GET['nome'];
              $_SESSION['email'] = $_POST['email'] ?? $_GET['email'];
              $_SESSION['cpf'] = $_POST['cpf'] ?? $_GET['cpf'];


              /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
        * │                               Filtro vazio                                                                    | 
        * | Descrição: Se todos os campos estiverem vazios, então dê uma resposta                                         │
        * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
        */

              if ($_SESSION['nome'] == null && $_SESSION['cpf'] == null && $_SESSION['email'] == null) {
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
                $listar = $Colaborador_repositorio->listarColaborador_criacaoEmail($_SESSION['nome'], $_SESSION['cpf'], $_SESSION['email']);

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