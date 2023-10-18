<?php
/*
* ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
* ║                                                    Senac - Aceite                                                 ║
* ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
* ║  │ NOTA: Todas as informações contidas neste documento são propriedade do SENAC PERNAMBUCO e seus fornecedores,│  ║
* ║  │ caso existam. Os conceitos intelectuais e técnicos contidos são propriedade do SENAC PERNAMBUCO e seus      │  ║
* ║  │ fornecedores e podem estar cobertos pelas patentes nacionais, e estão protegidas por segredo comercial ou   │  ║
* ║  │ lei de direitos autorais. Divulgação desta informação ou reprodução deste material é estritamente proibido, │  ║
* ║  │ a menos que seja obtida permissão prévia por escrito do SENAC PERNAMBUCO.                                   │  ║
* ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
* ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
* ║  │ @description: Result of the alteration                                                                      |  ║
* ║  │ @class: Usuario_alterar2                                                                                    │  ║
* ║  │ @dir: Src/ View                                                                                             │  ║
* ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
* ║  │ @date: 14/11/22                                                                                             │  ║
* ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
* ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
* ║                                                     UPGRADES                                                      ║
* ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
* ║  │ 1. @date: 08/02/23                                                                                          │  ║
* ║  │    @description: Update of the code and the results                                                         │  ║
* ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
* ║                                                                                                                   ║
* ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
*/

require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";

require_once "Recursos/ValidaNivelDeAcesso.php";
ta_conectado();


//Validação do CPF
require_once "Recursos/CpfValidacao.php";

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Variables                                                                      │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

$id = $_POST['id'] ?? $_GET['id'];;

$nomeCompleto = $_POST['nomeCompleto'] ?? $_GET['nomeCompleto'];
$nome_Sobrenome = $_POST['NomeSobrenome'] ?? $_GET['nomeSobrenome'];
$dataNascimento = $_POST['dataNascimento'] ?? $_GET['dataNascimento'];
$email_pessoal = $_POST['email_pessoal'] ?? $_GET['email_pessoal'];
$telefone = $_POST['telefone'] ?? $_GET['telefone'];
$cpf = $_POST['cpf'] ?? $_GET['cpf'];

$status = $_POST['status'] ?? $_GET['status'];

$idNivelDeAcesso = $_POST['idNivelDeAcesso'] ?? $_GET['idNivelDeAcesso'];

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Usuario 's section                                                             │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Usuario.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Usuario_repositorio.php";

use model\Usuario;
use model\Usuario_repositorio;

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
* │                                Validation                                                                     │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

$dataValidacao = explode('-', $dataNascimento);
$ano = $dataValidacao[0];
$mes = $dataValidacao[1];
$dia = $dataValidacao[2];


$corVermelha = true;
if ($nomeCompleto == "") {
  $mensagem = "Preencha o nome completo";
} else if ($id == "") {
  $mensagem = "Id inválido";
} else if (strlen($nomeCompleto) > 200) {
  $mensagem = "Quantidade de caracteres maiores que 200. Por favor, preencha novamente";
} else if ($nome_Sobrenome == "") {
  $mensagem = "Preencha o nome e Sobrenome";
} else if (str_word_count($nome_Sobrenome) > 3) {
  $mensagem = "Nome e Sobrenome com mais de duas palavras. Por favor, preencha novamente";
} else if (checkdate($mes, $dia, $ano) == false) {
  $mensagem = "Data de nascimento inválida. Por favor, digite novamente";
} else if ($email_pessoal == "") {
  $mensagem = "Preencha o email pessoal";
} else if (filter_var($email_pessoal, FILTER_VALIDATE_EMAIL) == false) {
  $mensagem = "E-mail cadastrado incorretamente. Por favor, preencha novamente";
} else if ($telefone == "") {
  $mensagem = "Preencha o telefone de contato";
} else if (!validaCPF($cpf)){
  $mensagem = "CPF digitado inválido. Por favor, digite um CPF válido!";
} else if (strlen($telefone) > 12) {
  $mensagem = "Quantidade incorreta do telefone. Por favor, digite 11 números de telefone de acordo com o exemplo: 8188889999";
  //Se uma pessoa de acessLevel 7 (Suporte GTI) tentar alterar uma conta de administrador, ele não vai conseguir
} else  if ($_SESSION['acessLevel'] == 7 && $idNivelDeAcesso == 1) {
  $mensagem = "Você não tem autorização para alterar contas de administradores.";

  if ($status == 0) {
    $mensagem = "Voce não tem autorização para deletar administradores";
  }
} else {

  $corVermelha = false;
  $mensagem = "Alteração realizada com sucesso!";
  /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
  * │                                Update of the User class                                                       │
  * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
  */

  $Usuario = new Usuario();
  $Usuario_repositorio = new Usuario_repositorio();

  $Usuario->setId($id);
  $Usuario->setNome($nomeCompleto);
  $Usuario->setNomeSobrenome($nome_Sobrenome);
  $Usuario->setDataNascimento($dataNascimento);
  $Usuario->setemail($email_pessoal);
  $Usuario->setTelefone($telefone);

  $Usuario->setStatus($status);
  $Usuario->getNivelDeAcesso()->setId($idNivelDeAcesso);

  $Usuario = $Usuario_repositorio->alterar($Usuario);

  /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
  * │                                Deleting the user                                                              │
  * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
  */

  if ($status == 0) {
    $mensagem = "Usuário deletado com sucesso!";
    $Usuario = $Usuario_repositorio->consultaIdEStatus($id);

    $Usuario_repositorio->deletar($Usuario);
  }
}

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
        <article class="card">
          <a href="Usuario-tela-inicial.php">Voltar ao menu</a>
          <div class="row g-0 text-center">
            <div class="col-6 col-md-4">
              <img src="../../Assets/Img/funcionarios.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
            </div>
            <div class="col-sm-6 col-md-8" id="content_inicio">
              <h2 class="content_inicioText">Alteração de um funcionário</h2>
              <h5> Verifique o resultado abaixo</h5>
            </div>
          </div>
        </article>

        <article class="card content_inicioText">
          <?php
          if ($corVermelha) {
          ?>
            <div class="alert alert-danger" role="alert">
            <?php
          } else {
            ?>
              <div class="alert alert-success" role="alert">
              <?php
            }
              ?>
              <h4> <?php echo $mensagem; ?> </h4>
              </div>

              <br>
              <div class="row g-0 text-center">
                <div class="col-sm-6 col-md-12">
                  <h3 class="content_inicioText"> Retornar à tela inicial</h3>
                  <a class="btn btn-info my-1" id="" href="Usuario-tela-inicial.php" role="button">Menu inicial</a>
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