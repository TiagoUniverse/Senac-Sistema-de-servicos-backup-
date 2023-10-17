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
 * ║  │ @description: Initial page to demand the process of the 'Código de ética'                                   │  ║
 * ║  │ @class: codigo etica_tela-inicial                                                                           │  ║
 * ║  │ @dir: Html Website/                                                                                         │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 04/10/2023                                                                                           │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
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
require_once "Recursos/ValidaNivelDeAcesso.php";
ta_conectado();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                      Variables                                                                │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

if (!isset($_SESSION['filtro'])) {
  $_SESSION['filtro'] = "inativo";
}

if (isset($_POST['filtro'])) {
  $_SESSION['filtro'] = $_POST['filtro'];
}

$_SESSION['filtroUnidade'] = "inativo";
$_SESSION['filtroUsuario'] = "inativo";

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                       'CodigoEtica_Colaborador' section                                       │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\CodigoEtica_Colaborador_repositorio.php";

use model\CodigoEtica_Colaborador_repositorio;
use model\StatusTimeline_CodigoEtica_repositorio;

$CodigoEtica_Colaborador_repositorio = new CodigoEtica_Colaborador_repositorio();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                       Timeline_CodigoEtica's section                                          │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Timeline_CodigoEtica_repositorio.php";

use model\Timeline_CodigoEtica_repositorio;

$Timeline_CodigoEtica_repositorio = new Timeline_CodigoEtica_repositorio();


/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Functions                                                                      │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

// Listagem com a união do resultados dos colaboradores em processo e das sugestões do TOTVS.
// Data: 28/06/23
function CriarTela(array $resultado_Listagem)
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

    $Timeline_CodigoEtica_repositorio = new Timeline_CodigoEtica_repositorio();

    $listaIds = $Timeline_CodigoEtica_repositorio->consultar_idStatusTimeline($resultado[0]);
    $idAtual = max($listaIds);

    if ($idAtual == 1) {

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
                  <form action='codigo etica_consultar.php' method='POST'>
                    <li>
                      <input name='id_usuario' value='" . $resultado[0] . "' type='hidden'> </input>
                      <button type='submit' class='dropdown-item'>
                        <img src='../../Assets/Icons/node_modules/bootstrap-icons/icons/eye-fill.svg'>
                        Consultar
                      </button>
                    </li>
                  </form>

                  <form action='codigo etica_alterar.php' method='POST'>
                    <li>
                      <input name='id_usuario' value='" . $resultado[0] . "' type='hidden'> </input>
                      <button type='submit' class='dropdown-item'>
                        <img src='../../Assets/Icons/node_modules/bootstrap-icons/icons/pencil.svg'>
                        Alterar a solicitação
                      </button>
                    </li>
                  </form>

                  <form action='codigo etica_timeline.php' method='POST'>
                    <li>
                      <input name='id_usuario' value='" . $resultado[0] . "' type='hidden'> </input>
                      <input name='nome_colaborador' value='" . $resultado[1] . "' type='hidden'> </input>
                      <button type='submit' class='dropdown-item'>
                        <img src='../../Assets/Icons/node_modules/bootstrap-icons/icons/archive-fill.svg'>
                        Checar a timeline
                      </button>
                    </li>
                  </form>

                  <form action='codigo etica reenviar_aceite.php' method='POST'>
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
                  <form action='codigo etica deletar.php' method='POST'>
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
      $Timeline_CodigoEtica_repositorio = new Timeline_CodigoEtica_repositorio();

      $lista_IdStatusTimeline = $Timeline_CodigoEtica_repositorio->consultar_idStatusTimeline($resultado[0]);
      $idStatusTimeline_atual = max($lista_IdStatusTimeline);

      $Timeline = $Timeline_CodigoEtica_repositorio->consultaBy_IdStatusTimeline($idStatusTimeline_atual, $resultado[0]);

      echo " <div>
    <img src='../../Assets/Icons/processo-2.ico' class='status_user'>
    <a id='status_colaborador'>";
      echo $Timeline[1];
      echo ' <b>' . $Timeline[2] . '</b>';
      echo "</a>";



      echo "</div>
    </article>";
      $contador++;
    }
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



/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Permissão pra acessar esta tela                                                │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once "Recursos/Navegacao.php";

//Niveis de acesso disponíveis para acessar a página atual
$NivelAcesso_disponivel = array(1, 2);
valida_acesso($NivelAcesso_disponivel);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Código de ética</title>
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

  <div class="row">
    <!-- 
    ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    │ Article: Sessão central da tela, com o título e os botões de ação                                             |
    └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    -->
    <article class="card box_shadow">
      <div class="row g-0 text-center">
        <div class="col-6 col-md-4">
          <img src="../../Assets/Img/justica.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
        </div>
        <div class="col-sm-6 col-md-8" id="content_inicio">
          <h2 class="content_inicioText">Solicitação de aceite do código de ética</h2>
          <h5 class="content_inicioText">Para começar o processo de aceite do código de ética de um colaborador, basta selecionar o botão abaixo e localizar o colaborador desejado.</h5>
        </div>

        <!-- Sessão dos botões -->
        <div class="container text-center">
          <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">

            <?php
            // Botão do Filtro
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
                  <form action="codigo etica_tela-inicial.php" method="POST">
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
                <a type="button" class="btn btn-warning" href="Solicitar codigo etica.php">
                  <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/plus.svg" class="backgroung-color-White">
                  Solicitar aceite do código de ética
                </a>
              </div>
            </div>


          </div>

          <!-- Tela do filtro -->
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasRightLabel">Filtro</h5>
              <button type="reset" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
              <form action="codigo etica_tela-inicial.php" method="post">
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

                  <!-- <div class="input-group-text">
                    <input class="form-check-input mt-0" name="apenas_colaborador" value="1" type="checkbox" aria-label=""> Colaboradores que iniciaram o processo </input>
                  </div> -->

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

    <!-- 
    ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
    │ Seção da listagem de colaboradores que irão aceitar o código de ética                                         |
    └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
    -->
    <?php
    if ($_SESSION['filtro'] != 'ativo') {
      $resultado = $CodigoEtica_Colaborador_repositorio->listagem_TodasRequisicoes();
      CriarTela($resultado);
    } else {

      if (isset($_POST['nome'])) {
        $_SESSION['nome'] = $_POST['nome'] ?? $_GET['nome'];
      }

      if (isset($_POST['email'])) {
        $_SESSION['email'] = $_POST['email'] ?? $_GET['email'];
      }

      if (isset($_POST['cpf'])) {
        $_SESSION['cpf'] = $_POST['cpf'] ?? $_GET['cpf'];
      }

      /* ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
      * │                               Filtro vazio                                                                    | 
      * | Descrição: Se todos os campos estiverem vazios, então dê uma resposta                                         │
      * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
      */
      if ($_SESSION['nome'] == null && $_SESSION['cpf'] == null && $_SESSION['email'] == null) {
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
        /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
        * │                               Trazendo o resultado do Filtro                                                  │
        * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
        */
        $listarColaborador = $CodigoEtica_Colaborador_repositorio->listarColaborador($_SESSION['nome'], $_SESSION['cpf'], $_SESSION['email']);


        if (sizeof($listarColaborador) == 0) {
          echo "
          <article class='card'>
            <div class='row g-0 text-center'>
              <div class='col-sm-6 col-md-8'>
                <h3 style='text-align: left;'>Nenhum resultado encontrado! Por favor, tente novamente buscando por outra palavra chave.</h3>
              </div>
              <div class='col-6 col-md-4'></div>
            </div>
          </article>";

        } else{

          // $listagemFiltro = $Colaborador_repositorio->listagemFILTRO_SolicitacaoColaborador($listarColaborador, $ListarTOTVS, $_SESSION['apenas_colaborador']);
          // CriaTela_SolicitacaoRH($listagemFiltro, $_SESSION['filtro']);

          CriarTela($listarColaborador);

        }


      }
    }
    ?>


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