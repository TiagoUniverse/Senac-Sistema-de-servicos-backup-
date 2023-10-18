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
* ║  │ @description: View of information from the 'Colaborador' class                                              │  ║
* ║  │ @class: Colaborador-Unidade-consultar                                                                       │  ║
* ║  │ @dir: Html Website/                                                                                         │  ║
* ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
* ║  │ @date: 09/01/23                                                                                             │  ║
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

$codigo = $_POST['id_usuario'] ?? $_GET['id_usuario'];
$nome_colaborador = $_POST['nome_colaborador'] ?? $_GET['nome_colaborador'];

require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";
require_once "Recursos/ValidaNivelDeAcesso.php";
ta_conectado();

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\NivelDeAcesso.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\NivelDeAcesso_repositorio.php";

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
  $listarNivelDeAcesso .= "<option value='{$NivelDeAcesso->getId()}'>{$NivelDeAcesso->getNome()}</option>";
}

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Colaborador 's section                                                         │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador_repositorio.php";

use model\Colaborador;
use model\Colaborador_repositorio;

$Colaborador = new Colaborador();
$Colaborador_repositorio = new Colaborador_repositorio();

$Colaborador = $Colaborador_repositorio->consultarById($codigo);

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Timeline 's section                                                            │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Timeline.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Timeline_repositorio.php";

use model\Timeline;
use model\Timeline_repositorio;

$Timeline = new Timeline();
$Timeline_repositorio = new Timeline_repositorio();

$listaTimeline = $Timeline_repositorio->listarTimeline($codigo);



/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                StatusTimeline 's section                                                      │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\StatusTimeline.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\StatusTimeline_repositorio.php";

use model\StatusTimeline;
use model\StatusTimeline_repositorio;

$StatusTimeline = new StatusTimeline();
$StatusTimeline_repositorio = new StatusTimeline_repositorio();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Usuario 's section                                                             │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Usuario.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Usuario_repositorio.php";

use model\Usuario;
use model\Usuario_repositorio;

$Usuario = new Usuario();
$Usuario_repositorio = new Usuario_repositorio();



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Timeline</title>
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
    1, 2, 3
  );

  valida_acesso($NivelAcesso_disponivel);

  ?>

  <?php
  if (count($listaTimeline) == 1) {
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
        <article class="card">
          <div class="row g-0 text-center">
            <div class="col-6 col-md-4">
              <img src="../../Assets/Img/funcionarios.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
            </div>
            <div class="col-sm-6 col-md-8" id="content_inicio">
              <h2 class="content_inicioText">Consulta da Timeline de:</h2>
              <h3 class="textoVermelho"> <?php echo $nome_colaborador; ?> </h3>
            </div>
          </div>
        </article>


        <?php
        $contador = 1;
        foreach ($listaTimeline as $timeline) {
        ?>

          <article class="card">
            <div class="form-floating">
              <!-- <label for="floatingPassword">Motivo da solicitação:</label> -->

              <?php
              $descricaoStatus = $StatusTimeline_repositorio->consultar_Status($timeline->getStatusTimeline()->getId());
              ?>

              <!-- Título -->
              <h3> <?php echo $contador . ". ";
                    echo $descricaoStatus; ?> </h3>
              <br>
              <!-- Descrição da timeline -->
              <h5> <?php echo "Descrição: " .  $timeline->getNome(); ?></h5>

              <?php
              $Usuario = $Usuario_repositorio->consultaIdEStatus($timeline->getId_funcionario());


              if ($timeline->getStatusTimeline()->getid() == 2) {
              ?>
                <h5 style="text-align: right;color: gray;"><?php echo $nome_colaborador;
                                                            echo " - " . $timeline->getCreated();; ?> </h5>
              <?php
              } else {
              ?>
                <!-- Nome do responsável pela ação || Dia e hora de execução -->
                <h5 style="text-align: right; color: gray;"><?php echo $Usuario->getNome();
                                                            echo " - " . $timeline->getCreated();; ?> </h5>
              <?php
              }
              ?>

              <h6></h6>
            </div>
          </article>
        <?php
          $contador++;
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