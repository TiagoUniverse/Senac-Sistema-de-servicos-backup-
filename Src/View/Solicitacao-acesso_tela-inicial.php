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
 * ║  │ @description: Initial page to demand the process of the 'Colaborador'                                       │  ║
 * ║  │ @class: Solicitacao-acesso_tela-inicial                                                                     │  ║
 * ║  │ @dir: Html Website/                                                                                         │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 07/12/2022                                                                                           │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 * ║                                                     UPGRADES                                                      ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 1. @date: 17/01/23                                                                                          │  ║
 * ║  │    @description: Adding the option the send the email again to the worker                                   │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 2. @date: 28/06/23                                                                                          │  ║
 * ║  │    @description: Applying pagination to this page                                                           │  ║
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

// echo "entrei";
if (!isset($_SESSION['filtro'])) {
  $_SESSION['filtro'] = "inativo";
}

if (isset($_POST['filtro'])) {
  $_SESSION['filtro'] = $_POST['filtro'];
}

$_SESSION['filtroUnidade'] = "inativo";
$_SESSION['filtroUsuario'] = "inativo";

// echo $_SESSION['filtro'];

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
* │                                TOTVS 's section                                                               │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\TOTVS.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\TOTVS_repositorio.php";

use model\TOTVS;
use model\TOTVS_repositorio;

$TOTVS = new TOTVS();
$TOTVS_repositorio = new TOTVS_repositorio();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Timeline 's section                                                            │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Timeline_repositorio.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Timeline.php";

use model\Timeline_repositorio;
use model\Timeline;

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Functions                                                                      │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

// Listagem com a união do resultados dos colaboradores em processo e das sugestões do TOTVS.
// Data: 28/06/23
function CriaTela_SolicitacaoRH(array $resultado_Listagem)
{
  $contador = 1;
  // Configurações da paginação
  $porPagina = 10; // Quantidade de itens por página
  $totalItens = count($resultado_Listagem); // Total de itens na array
  $totalPaginas = ceil($totalItens / $porPagina); // Total de páginas

  // Obtém o número da página atual
  $paginaAtual = isset($_POST['pagina']) ? $_POST['pagina'] : 1;
  $paginaAtual = max($paginaAtual, 1); // Garante que o número da página seja no mínimo 1
  $paginaAtual = min($paginaAtual, $totalPaginas); // Garante que o número da página não ultrapasse o total de páginas

  // Calcula os limites da página atual
  $inicio = ($paginaAtual - 1) * $porPagina;
  $fim = $inicio + $porPagina - 1;
  $fim = min($fim, $totalItens - 1); // Garante que o limite final não ultrapasse o total de itens

  // Obtém a parte da array correspondente à página atual
  $parteArray = array_slice($resultado_Listagem, $inicio, $porPagina);

  foreach ($parteArray as $resultado) {
    echo "  <article class='card'>
              <div class='row g-0 text-center'>
                <div class='col-sm-6 col-md-6'>
                  <h3 style='text-align: left;'> " . ($contador + $inicio) . ". " . $resultado[1] . "</h3>
                </div>";
    echo "      <div class='col-sm-6 col-md-6'>
                  <button type='button' class='btn dropdown-toggle button_Dropdown' id='buton_MaisOpcoes' data-bs-toggle='dropdown' aria-expanded='false'>
                    <img src='../../Assets/Icons/node_modules/bootstrap-icons/icons/list-ol.svg'>
                    Mais opções
                  </button>";
    // Se o colaborador possui id diferente de zero, então está no processo em andamento
    if ($resultado[0] != 0) {
      echo "
                  <ul class='dropdown-menu'>
                  <form action='Solicitacao-acesso_consultar.php' method='POST'>
                    <li>
                      <input name='id_usuario' value='" . $resultado[0] . "' type='hidden'> </input>
                      <button type='submit' class='dropdown-item'>
                        <img src='../../Assets/Icons/node_modules/bootstrap-icons/icons/eye-fill.svg'>
                        Consultar
                      </button>
                    </li>
                  </form>

                  <form action='Solicitacao-acesso_alterar.php' method='POST'>
                    <li>
                      <input name='id_usuario' value='" . $resultado[0] . "' type='hidden'> </input>
                      <button type='submit' class='dropdown-item'>
                        <img src='../../Assets/Icons/node_modules/bootstrap-icons/icons/pencil.svg'>
                        Alterar a solicitação
                      </button>
                    </li>
                  </form>

                  <form action='Timeline.php' method='POST'>
                    <li>
                      <input name='id_usuario' value='" . $resultado[0] . "' type='hidden'> </input>
                      <input name='nome_colaborador' value='" . $resultado[1] . "' type='hidden'> </input>
                      <button type='submit' class='dropdown-item'>
                        <img src='../../Assets/Icons/node_modules/bootstrap-icons/icons/archive-fill.svg'>
                        Checar a timeline
                      </button>
                    </li>
                  </form>

                  <form action='Reenviar_emailAceite.php' method='POST'>
                    <li>
                      <input name='id_usuario' value='" . $resultado[0] . "' type='hidden'> </input>
                      <input name='nome_colaborador' value='" . $resultado[1] . "' type='hidden'> </input>
                      <button type='submit' class='dropdown-item'>
                        <img src='../../Assets/Icons/node_modules/bootstrap-icons/icons/mailbox.svg'>
                        Reenviar e-mail de aceite
                      </button>
                    </li>
                  </form>";
      if ($_SESSION['acessLevel'] == 1) {
        echo "
                  <form action='deletar solicitacao.php' method='POST'>
                    <li>
                      <input name='id_usuario' value='" . $resultado[0] . "' type='hidden'> </input>
                      <input name='nome_colaborador' value='" . $resultado[1] . "' type='hidden'> </input>
                      <button type='submit' class='dropdown-item'>
                        <img src='../../Assets/Icons/node_modules/bootstrap-icons/icons/device-hdd.svg'>
                        Deletar solicitação
                      </button>
                    </li>
                  </form>";
      }
    } else {
      echo "
                <ul class='dropdown-menu'>
                  <form action='Solicitar acesso colaborador.php' method='POST'>
                    <li>
                      <input name='colaborador_cpf' value='" . $resultado[2] . "' type='hidden'> </input>
                      <button type='submit' class='dropdown-item'>
                        <img src='../../Assets/Icons/node_modules/bootstrap-icons/icons/eye-fill.svg'>
                        Solicitar e-mail deste colaborador
                      </button>
                    </li>
                  </form>";
    }

    echo "</ul>
    </div>
  </div>";

    // Exibição do Status do colaborador
    echo "<div class='col-6 col-md-4' style='width: 49%;'>";

    if ($resultado[0] != 0) {
      $Timeline_repositorio = new Timeline_repositorio();
      $Timeline = new Timeline();

      $lista_IdStatusTimeline = $Timeline_repositorio->consultar_idStatusTimeline($resultado[0]);
      $idStatusTimeline_atual = max($lista_IdStatusTimeline);

      $Timeline = $Timeline_repositorio->consultaBy_IdStatusTimeline($idStatusTimeline_atual, $resultado[0]);

      echo "
            <img src='../../Assets/Icons/processo-2.ico' class='status_user'>
            <a id='status_colaborador'>";
      echo $Timeline->getNome();
      echo ' <b>' . $Timeline->getCreated() . '</b>';
      echo "</a>";
    } else {
      echo "
          <div class='col-6 col-md-4'>
            <img src='../../Assets/Icons/processo-1.ico' class='status_user_pendente'>
            <a id='status_colaborador'> Processo não inicializado
            </a>
        </div>";
    }

    echo "</div>
    </article>";
    $contador++;
  }

  // Exibe os links de navegação das páginas
  echo "<div class='pagination'>";
  for ($i = 1; $i <= $totalPaginas; $i++) {
    echo "<form action='' method='POST'>";
    echo "<input type='hidden' name='pagina' value='" . $i . "'>";
    echo "<button class='pagination-link'> " . $i . " </button>";
    echo "</form>";
  }
  echo "</div>";
}


function CriaTela_Colaborador($listar)
{

  foreach ($listar as $Colaborador) {

    $Timeline_repositorio = new Timeline_repositorio();

    $idStatusTimeline =  $Timeline_repositorio->consultar_idStatusTimeline($Colaborador->getId());

    $idAtual = max($idStatusTimeline);

    if ($idAtual != 3) {
?>
      <article class="card">
        <div class="row g-0 text-center">
          <div class="col-sm-6 col-md-6">
            <h3 style="text-align: left;"><?php echo $Colaborador->getNome(); ?></h3>
            <?php


            ?>
          </div>

          <div class="col-sm-6 col-md-6">
            <button type="button" class="btn dropdown-toggle button_Dropdown" id="buton_MaisOpcoes" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/list-ol.svg">
              Mais opções
            </button>

            <ul class="dropdown-menu">
              <form action="Solicitacao-acesso_consultar.php" method="POST">
                <li>
                  <input name="id_usuario" value="<?php echo ($Colaborador->getId()); ?>" type="hidden"> </input>
                  <button type="submit" class="dropdown-item">
                    <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/eye-fill.svg">
                    Consultar
                  </button>
                </li>
              </form>

              <form action="Solicitacao-acesso_alterar.php" method="POST">
                <li>
                  <input name="id_usuario" value="<?php echo ($Colaborador->getId()); ?>" type="hidden"> </input>
                  <button type="submit" class="dropdown-item">
                    <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/pencil.svg">
                    Alterar a solicitação
                  </button>
                </li>
              </form>

              <form action="Timeline.php" method="POST">
                <li>
                  <input name="id_usuario" value="<?php echo ($Colaborador->getId()); ?>" type="hidden"> </input>
                  <input name="nome_colaborador" value="<?php echo ($Colaborador->getNome()); ?>" type="hidden"> </input>
                  <button type="submit" class="dropdown-item">
                    <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/archive-fill.svg">
                    Checar a timeline
                  </button>
                </li>
              </form>

              <form action="Reenviar_emailAceite.php" method="POST">
                <li>
                  <input name="id_usuario" value="<?php echo ($Colaborador->getId()); ?>" type="hidden"> </input>
                  <input name="nome_colaborador" value="<?php echo ($Colaborador->getNome()); ?>" type="hidden"> </input>
                  <button type="submit" class="dropdown-item">
                    <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/mailbox.svg">
                    Reenviar e-mail de aceite
                  </button>
                </li>
              </form>


              <?php
              if ($_SESSION['acessLevel'] == 1) {
              ?>
                <form action="deletar solicitacao.php" method="POST">
                  <li>
                    <input name="id_usuario" value="<?php echo ($Colaborador->getId()); ?>" type="hidden"> </input>
                    <input name="nome_colaborador" value="<?php echo ($Colaborador->getNome()); ?>" type="hidden"> </input>
                    <button type="submit" class="dropdown-item">
                      <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/device-hdd.svg">
                      Deletar solicitação
                    </button>
                  </li>
                </form>
              <?php
              }
              ?>

            </ul>
          </div>
        </div>


        <div class="col-6 col-md-4" style="width: 49%;">
          <?php

          /**
           * Exibição do status mais atual e da última data
           * Funcionamento: O sistema irá verificar na timeline do colaborador o registro mais atual, que no caso, é o que possui o id do status maior.
           * Data: 01/03/23
           */

          $Timeline_repositorio = new Timeline_repositorio();
          $Timeline = new Timeline();

          $lista_IdStatusTimeline = $Timeline_repositorio->consultar_idStatusTimeline($Colaborador->getId());

          $idStatusTimeline_atual = max($lista_IdStatusTimeline);

          $Timeline = $Timeline_repositorio->consultaBy_IdStatusTimeline($idStatusTimeline_atual, $Colaborador->getId());




          ?>
          <img src="../../Assets/Icons/processo-2.ico" class="status_user">
          <a id="status_colaborador">
            <?php
            echo $Timeline->getNome();
            echo " <b>" . $Timeline->getCreated() . "</b>";
            ?>
          </a>
          <?php


          ?>

        </div>
      </article>
    <?php
    }
  }
}



function CriaTela_TOTVS($listar)
{
  foreach ($listar as $TOTVS) {
    $Colaborador_repositorio = new Colaborador_repositorio();
    $retorno = $Colaborador_repositorio->consultar_CPF($TOTVS->getCpf());

    // //Se retorna nada, é porque ele não encontrou o CPF no sistema
    if ($retorno == null && $retorno == false) {
    ?>
      <article class="card">
        <div class="row g-0 text-center">
          <div class="col-sm-6 col-md-6">
            <h3 style="text-align: left;"><?php echo $TOTVS->getNome(); ?></h3>
          </div>

          <div class="col-sm-6 col-md-6">
            <button type="button" class="btn dropdown-toggle button_Dropdown" id="buton_MaisOpcoes" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/list-ol.svg">
              Mais opções
            </button>

            <ul class="dropdown-menu">
              <form action="Solicitar acesso colaborador.php" method="POST">
                <li>
                  <input name="colaborador_cpf" value="<?php echo ($TOTVS->getCpf()); ?>" type="hidden"> </input>

                  <button type="submit" class="dropdown-item">
                    <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/eye-fill.svg">
                    Solicitar e-mail deste colaborador
                  </button>

                </li>
              </form>

            </ul>
          </div>
        </div>


        <div class="col-6 col-md-4">
          <img src="../../Assets/Icons/processo-1.ico" class="status_user_pendente">
          <a id="status_colaborador"> Processo não inicializado
          </a>
        </div>
      </article>
<?php
    }
  }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Colaborador</title>
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
  <link rel="stylesheet" href="../../Assets/Css/components/Content.css" />
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
  $NivelAcesso_disponivel = array(1, 2);
  valida_acesso($NivelAcesso_disponivel);
  ?>

  <div class="row">
    <section>
      <!-- 
      /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
      * │ Article: Exibição do título e os botões do filtro                                                             |
      * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
      -->
      <article class="card box_shadow">
        <div class="row g-0 text-center">
          <div class="col-6 col-md-4">
            <img src="../../Assets/Img/funcionarios.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
          </div>
          <div class="col-sm-6 col-md-8" id="content_inicio">
            <h2 class="content_inicioText">Solicitação dos colaboradores</h2>
            <h4 class="content_inicioText">Selecione um registro do TOTVS abaixo para começar o processo de criação de e-mail institucional. Caso precise, utilize o filtro para localizar um colaborador.</h4>
          </div>

          <!--OffCanvas - Botão do filtro-->
          <div id="myModal">
            <div class="container text-center">
              <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">

                <?php
                if ($_SESSION['filtro'] != 'ativo') {
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
                      <form action="Solicitacao-acesso_tela-inicial.php" method="POST">
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

                <div class="col">
                  <div class="p-3 ">
                    <a type="button" class="btn btn-primary" href="Solicitar acesso colaborador.php">
                      <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/plus.svg" class="backgroung-color-White">
                      Cadastrar outro colaborador
                    </a>
                  </div>
                </div>

                <!-- <div class="col">
                  <div class="p-3 ">
                    <a type="button" class="btn btn-warning" href="Solicitar codigo etica.php">
                      <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/plus.svg" class="backgroung-color-White">
                      Solicitar aceite do código de ética
                    </a>
                  </div>
                </div> -->


              </div>
            </div>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasRightLabel">Filtro</h5>
                <button type="reset" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>

              <div class="offcanvas-body">
                <!--Floating Label - Formulário -->
                <form action="Solicitacao-acesso_tela-inicial.php" method="post">
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

                    <div class="input-group-text">
                      <input class="form-check-input mt-0" name="apenas_colaborador" value="1" type="checkbox" aria-label=""> Colaboradores que iniciaram o processo </input>
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
      /* ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
      * │                                1.0 Listagem dos Colaboradores                                                 │
      * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
      */
      if ($_SESSION['filtro'] != 'ativo') {
        $resultado_Listagem = $Colaborador_repositorio->listagem_SolicitacaoColaborador();
        CriaTela_SolicitacaoRH($resultado_Listagem, $_SESSION['filtro']);
      }

      /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
      * │                                2.0 Busca com o filtro                                                         │
      * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
      */
      if ($_SESSION['filtro'] == "ativo") {

        if (isset($_POST['nome'])) {
          $_SESSION['nome'] = $_POST['nome'] ?? $_GET['nome'];
        }

        if (isset($_POST['email'])) {
          $_SESSION['email'] = $_POST['email'] ?? $_GET['email'];
        }

        if (isset($_POST['cpf'])) {
          $_SESSION['cpf'] = $_POST['cpf'] ?? $_GET['cpf'];
        }

        if (isset($_POST['apenas_colaborador'])) {
          $_SESSION['apenas_colaborador'] = $_POST['apenas_colaborador'] ?? $_GET['apenas_colaborador'];
        } else {
          $_SESSION['apenas_colaborador'] = null;
        }

        /* ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
        * │                               Filtro vazio                                                                    | 
        * | Descrição: Se todos os campos estiverem vazios, então dê uma resposta                                         │
        * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
        */
        if ($_SESSION['nome'] == null && $_SESSION['cpf'] == null && $_SESSION['email'] == null && $_SESSION['apenas_colaborador'] == null) {
          echo "
      <article class='card'>
        <div class='row g-0 text-center'>
          <div class='col-sm-6 col-md-8'>
            <h3 style='text-align: left;'>Nenhum resultado encontrado! Por favor, tente novamente buscando por outra palavra chave.</h3>
          </div>
          <div class='col-6 col-md-4'></div>
        </div>
      </article>";
        } else {

          /* ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
          * │                               Trazendo o resultado do Filtro                                                  │
          * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
          */

          // Caso o usuário não marque nenhum campo e apenas clique em exibir os colaboradores, então 
          // Exibe todos os colaboradores 
          if ($_SESSION['nome'] == null && $_SESSION['cpf'] == null && $_SESSION['email'] == null && $_SESSION['apenas_colaborador'] != null) {
            $listar = $Colaborador_repositorio->listar();
            CriaTela_Colaborador($listar);
          } else {

            // Caso contrário, lista de acordo com os campos digitados
            $listarColaborador = $Colaborador_repositorio->listarColaborador($_SESSION['nome'], $_SESSION['cpf'], $_SESSION['email']);
            $ListarTOTVS = $TOTVS_repositorio->ListarTOTVS($_SESSION['nome'], $_SESSION['cpf'], $_SESSION['email']);

            // Caso a busca retorne nada, então informa ao usuário
            if (sizeof($ListarTOTVS) == 0 && sizeof($listarColaborador) == 0) {
              echo "
          <article class='card'>
            <div class='row g-0 text-center'>
              <div class='col-sm-6 col-md-8'>
                <h3 style='text-align: left;'>Nenhum resultado encontrado! Por favor, tente novamente buscando por outra palavra chave.</h3>
              </div>
              <div class='col-6 col-md-4'></div>
            </div>
          </article>";
            } else {

              // Caso contrário, informa os resultados
              $listagemFiltro = $Colaborador_repositorio->listagemFILTRO_SolicitacaoColaborador($listarColaborador, $ListarTOTVS, $_SESSION['apenas_colaborador']);
              CriaTela_SolicitacaoRH($listagemFiltro, $_SESSION['filtro']);
            }
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