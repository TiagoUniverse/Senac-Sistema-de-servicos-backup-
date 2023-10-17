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

$codigo = $_POST['id_usuario'] ?? $_GET['id_usuario'];

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

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consulta de colaborador</title>
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
  <link rel="stylesheet" href="../../Assets/Css/components/Table.css" />

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

  <div class="row" style="background-color: white;">
    <section>
      <article class="card">
        <a href="Solicitacao-acesso_tela-inicial.php">Voltar</a>
        <div class="row g-0 text-center">
          <div class="col-6 col-md-4">
            <img src="../../Assets/Img/funcionarios.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
          </div>
          <div class="col-sm-6 col-md-8" id="content_inicio">
            <h2 class="content_inicioText">Consulta do colaborador</h2>
            <h5>Consulte as informações do colaborador abaixo</h5>
          </div>
        </div>
      </article>

      <article class="card">
        <input name="idColaborador" type="hidden" value='<?php echo $codigo; ?>'>

        <label for="basic-url" class="form-label content_textLeft">Informações sobre a solicitação</label>
        <div class="form-floating">
          <input type="text" class="form-control" value="<?php echo $Colaborador->getMotivo_solicitacao(); ?>" disabled id="motivoEscolha" placeholder="Motivo da solicitação:">
          <label for="floatingPassword">Motivo da solicitação:</label>
        </div>



        <div class="form-floating">
          <input type="email" class="form-control my-2" value="<?php echo $Colaborador->getEmail_institucional(); ?>" disabled id="email_institucional" placeholder="Email institucional">
          <label for="floatingPassword">Email institucional</label>
        </div>


        <br>
        <label for="basic-url" class="form-label content_textLeft">Informações pessoais</label>
        <div class="form-floating">
          <input type="text" class="form-control" value="<?php echo $Colaborador->getNome(); ?>" disabled id="nomeCompleto" placeholder="Nome Completo">
          <label for="floatingPassword">Nome completo</label>
        </div>


        <div class="form-floating">
          <input type="text" class="form-control my-2" value="<?php echo $Colaborador->getCpf(); ?>" disabled id="cpf" placeholder="CPF:">
          <label for="floatingPassword">CPF:</label>
        </div>

        <div class="form-floating">
          <input type="date" class="form-control my-2" value="<?php echo $Colaborador->getDataNascimento(); ?>" disabled id="dataNascimento" placeholder="Data de nascimento">
          <label for="floatingPassword">Data de nascimento</label>
        </div>

        <div class="form-floating">
          <input type="email" class="form-control my-2" value="<?php echo $Colaborador->getEmail_pessoal(); ?>" disabled id="email_pessoal" placeholder="Email pessoal">
          <label for="floatingPassword">Email pessoal</label>
        </div>

        <div class="form-floating">
          <input type="tel" class="form-control my-2" value="<?php echo $Colaborador->getTelefone(); ?>" disabled id="telefone" placeholder="Telefone">
          <label for="floatingPassword">Telefone</label>
        </div>

        <?php
        if ($Colaborador->getStatus() == 1) {
        ?>
          <div class="form-floating">
            <input type="tel" class="form-control my-2" value="ATIVO" disabled id="status" placeholder="Status">
            <label for="floatingPassword">Status:</label>
          </div>
        <?php
        } else {
        ?>
          <div class="form-floating">
            <input type="tel" class="form-control my-2" value="INATIVO" disabled id="status" placeholder="Status">
            <label for="floatingPassword">Status:</label>
          </div>
        <?php
        }
        ?>

        <div class="form-floating mb-3">
          <input type="text" class="form-control my-2" value="<?php echo $Colaborador->getUnidade()->getNome(); ?>" disabled id="unidade" placeholder="Unidade:">
          <label for="floatingInput">Unidade:</label>
        </div>

        <label for="basic-url" class="form-label my-3 content_textLeft">Informações de trabalho</label>
        <div class="form-floating mb-3">
          <input type="text" class="form-control my-2" value="<?php echo $Colaborador->getChapa(); ?>" disabled id="matricula" placeholder="name@example.com">
          <label for="floatingInput">Número da matrícula</label>
        </div>

        <div class="form-floating">
          <input type="text" class="form-control my-2" value="<?php echo $Colaborador->getFuncao(); ?>" disabled id="funcao" placeholder="Função">
          <label for="floatingPassword">Função</label>
        </div>

        <div class="form-floating">
          <input type="text" class="form-control my-2" value="<?php echo $Colaborador->getGerencia(); ?>" disabled id="gerencia" placeholder="Gerência">
          <label for="floatingPassword">Gerência</label>
        </div>

        <div class="form-floating">
          <input type="text" class="form-control my-2" value="<?php echo $Colaborador->getSetor(); ?>" disabled id="setor" placeholder="Setor">
          <label for="floatingPassword">Setor</label>
        </div>

        <div class="form-floating">
          <input type="tel" class="form-control my-2" value="<?php echo $Colaborador->getTelefone(); ?>" disabled id="ramal" placeholder="Ramal">
          <label for="floatingPassword">Ramal</label>
        </div>

        <div class="form-floating">
          <input type="text" class="form-control my-2" value="<?php echo $Colaborador->getRua(); ?>" disabled id="rua" placeholder="rua">
          <label for="floatingPassword">Rua</label>
        </div>

        <div class="form-floating">
          <input type="text" class="form-control my-2" value="<?php echo $Colaborador->getNumero_Endereco(); ?>" disabled id="numero_Endereco" placeholder="numero_Endereco">
          <label for="floatingPassword">Número da rua</label>
        </div>

        <div class="form-floating">
          <input type="text" class="form-control my-2" value="<?php echo $Colaborador->getBairro(); ?>" disabled id="bairro" placeholder="bairro">
          <label for="floatingPassword">Bairro</label>
        </div>

        <br>
        <div class="form-floating">
          <input type="text" class="form-control" value="<?php echo $Colaborador->getHorarioTrabalho(); ?>" disabled id="horarioTrabalho" placeholder="Horário de trabalho">
          <label for="floatingPassword">Horário de trabalho</label>
        </div>

        <br>
        <div class="input-group">
          <span class="input-group-text">Observação</span>
          <textarea class="form-control" aria-label="With textarea" id="observacao" placeholder="<?php echo $Colaborador->getObservacao(); ?>" disabled></textarea>
        </div>
      </article>


    </section>
  </div>

  <br>
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