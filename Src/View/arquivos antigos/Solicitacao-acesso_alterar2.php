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
* ║  │ @description: Result of the alteration of the 'motivo'                                                      │  ║
* ║  │ @class: Solicitacao-acesso_alterar2                                                                         │  ║
* ║  │ @dir: Html Website/                                                                                         │  ║
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

$codigo_usuario = $_POST['idColaborador'] ?? $_GET['idUsuario'];

$motivo = $_POST['motivo'] ?? $_GET['motivo'];

$emailPessoal = $_POST['email_pessoal'];
$telefone = $_POST['telefone'];
$matricula = $_POST['matricula'];
$funcao = $_POST['funcao'];
$gerencia = $_POST['gerencia'];
$setor = $_POST['setor'];
$ramal = $_POST['ramal'];
$rua = $_POST['rua'];
$numero_endereco = $_POST['numero_endereco'];
$bairro = $_POST['bairro'];
$horarioTrabalho = $_POST['horarioTrabalho'];
$observacao = $_POST['horarioTrabalho'];

$idUnidade = $_POST['idUnidade'] ?? $_GET['idUnidade'];

require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";

require_once "Recursos/ValidaNivelDeAcesso.php";
ta_conectado();


require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador_repositorio.php";

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Colaborador 's section                                                         │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

use model\Colaborador_repositorio;

$Colaborador_repositorio = new Colaborador_repositorio();

// $Colaborador_repositorio->alterar_motivo($motivo, $codigo_usuario);

$mensagemVermelha = true;

if ($codigo_usuario == "") {
  $mensagem = "Colaborador não encontrado";
} else if ($motivo ==  "") {
  $mensagem = "Prencha o motivo";
} else if ($emailPessoal == "") {
  $mensagem = "Preencha o e-mail pessoal";
} else if ($telefone == "") {
  $mensagem = "Preencha o telefone";
} else if ($matricula == "") {
  $mensagem = "Preencha a matrícula";
} else if ($funcao == "") {
  $mensagem = "Preencha a função";
} else if ($gerencia == "") {
  $mensagem = "Preencha a gerência";
} else if ($setor == "") {
  $mensagem = "Preencha o setor";
} else if ($rua == "") {
  $mensagem = "Preencha o endereço de trabalho";
} else if ($numero_endereco == "") {
  $mensagem = "Preencha o número da rua do endereço de trabalho";
} else if ($bairro == "") {
  $mensagem = "Preencha o bairro do trabalho";
} else if ($horarioTrabalho == "") {
  $mensagem = "Preencha o horário de trabalho do colaborador";
} else {
  $mensagemVermelha = false;
  $mensagem = "Alteração da solicitação com sucesso!";

  $Colaborador_repositorio->alterar_solicitacao(
    $motivo,
    $emailPessoal,
    $telefone,
    $matricula,
    $funcao,
    $gerencia,
    $setor,
    $ramal,
    $rua,
    $numero_endereco,
    $bairro,
    $horarioTrabalho,
    $observacao,
    $idUnidade ,
    $codigo_usuario
  );
}



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alterar motivo do Colaborador</title>
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
    1, 2
  );

  valida_acesso($NivelAcesso_disponivel);

  ?>

  <div class="row" style="background-color: white; height:19.3cm;">
    <section>
      <article class="card">
        <div class="row g-0 text-center">
          <div class="col-6 col-md-4">
            <img src="../../Assets/Img/funcionarios.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
          </div>
          <div class="col-sm-6 col-md-8" id="content_inicio">
            <h2 class="content_inicioText">Alteração de solicitação do colaborador</h2>

          </div>
        </div>
      </article>

      <article class="card content_inicioText">
        <h3>Resultado:</h3>

        <?php
        // Mensagem do resultado
        if ($mensagemVermelha) {
          echo "<div class='alert alert-danger' role='alert'> ";
        } else {
          echo "<div class='alert alert-success' role='alert'> ";
        }
        echo $mensagem;
        echo "</div>";

        ?>

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