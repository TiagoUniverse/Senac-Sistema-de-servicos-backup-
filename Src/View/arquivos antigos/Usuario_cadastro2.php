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
 * ║  │ @description: Result from the registry                                                                      |  ║
 * ║  │ @class: Usuario_cadastro2                                                                               │  ║
 * ║  │ @dir: Src/ View                                                                                             │  ║
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

require_once "Recursos/ValidaNivelDeAcesso.php";
ta_conectado();


//Validação do CPF
require_once "Recursos/CpfValidacao.php";

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Variables                                                                      │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

$nome = $_POST['nome'] ?? $_GET['nome'];
$nomeSobrenome = $_POST['nomeSobrenome'] ?? $_GET['nomeSobrenome'];
$cpf = $_POST['cpf'] ?? $_GET['cpf'];
$dataNascimento = $_POST['dataNascimento'] ?? $_GET['dataNascimento'];
$email = $_POST['email'] ?? $_GET['email'];
$telefone = $_POST['telefone'] ?? $_GET['telefone'];
$senha = $_POST['senha'] ?? $_GET['senha'];
$repitaSenha =$_POST['repitaSenha'] ?? $_GET['repitaSenha'];
$trocasenha = 0;

$idNivelDeAcesso = $_POST['idNivelDeAcesso'] ?? $_GET['idNivelDeAcesso'];
$idUnidade = $_POST['idUnidade'] ?? $_GET['idUnidade'];

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Usuario 's section                                                             │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Usuario.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Usuario_repositorio.php";

use model\Usuario;
use model\Usuario_repositorio;

$Usuario_repositorio = new Usuario_repositorio();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                NivelDeAcesso 's section                                                       │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\NivelDeAcesso.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\NivelDeAcesso_repositorio.php";

use model\NivelDeAcesso;
use model\NivelDeAcesso_repositorio;

$NivelDeAcesso_repositorio = new NivelDeAcesso_repositorio();


/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Validation                                                                     │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

$dataValidacao = explode('-', $dataNascimento);
$ano = $dataValidacao[0];
$mes = $dataValidacao[1];
$dia = $dataValidacao[2];

$validacao = 0;


if ($nome == "") {
  $mensagem = "Preencha o nome completo";
} else if ($nomeSobrenome == "") {
  $mensagem = "Preencha o nome e o sobrenome.";
} else if ($repitaSenha != $senha) {
  $mensagem = "As senhas digitadas não são iguais. Por favor, digite as senhas novamente.";
} else if (strlen($nome) > 200) {
  $mensagem = "Quantidade de caracteres maiores que 200. Por favor, preencha novamente";
} else if ($cpf == null) {
  $mensagem = "Preencha o CPF";
} else if (strlen($cpf) < 11) {
  $mensagem = "Digite o CPF completo";
} else if ($Usuario_repositorio->consultar_CPF($cpf) != null) {
  $mensagem = "CPF digitado já existe no sistema. Por favor, verifique o seu CPF";
} else if (checkdate($mes, $dia, $ano) == false) {
  $mensagem = "Data de nascimento inválida. Por favor, digite novamente";
} else if ($email == "") {
  $mensagem = "Preencha o email pessoal";
} else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
  $mensagem = "E-mail pessoal cadastrado incorretamente. Por favor, preencha novamente";
} else if ($Usuario_repositorio->ValidarEmail($email)) {
  $mensagem = "E-mail pessoal já está cadastrado no sistema. Por favor, preencha novamente";
} else if ($telefone == "") {
  $mensagem = "Preencha o telefone de contato";
} else if (strlen($telefone) > 12) {
  $mensagem = "Quantidade incorreta do telefone. Por favor, digite 11 números de telefone de acordo com o exemplo: 81988889999";
}  else if ($idNivelDeAcesso == "") {
  $mensagem = "Selecione um nivel de acesso";
} else if ($idUnidade == "") {
  $mensagem = "Selecione uma unidade";
} else if ($_SESSION['acessLevel'] == 7 && $idNivelDeAcesso == 1) {
  $mensagem = "Suporte GTI não pode cadastrar usuário do tipo administrador.";
} else if (!validaCPF($cpf)){
  $mensagem = "CPF digitado inválido. Por favor, digite um CPF válido!";
} else {
  $validacao = 1;
  $mensagem = "Cadastro realizado com sucesso!";
  /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
  * │                                Creation of the object                                                         │
  * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
  */

  $Usuario = new Usuario();

  $Usuario->setnome($nome);
  $Usuario->setNomeSobrenome($nomeSobrenome);
  $Usuario->setCpf($cpf);
  $Usuario->setDataNascimento($dataNascimento);
  $Usuario->setemail($email);
  $Usuario->setTelefone($telefone);
  $Usuario->setSenha($senha);
  $Usuario->setTrocaSenha($trocasenha);

  $Usuario->getNivelDeAcesso()->setId($idNivelDeAcesso);
  $Usuario->getUnidade()->setId($idUnidade);

  $Usuario = $Usuario_repositorio->cadastro($Usuario);

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Usuário</title>
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
        <a href="Usuario-tela-inicial.php">Tela inicial</a>
        <div class="row g-0 text-center">
          <div class="col-6 col-md-4">
            <img src="../../Assets/Img/funcionarios.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
          </div>
          <div class="col-sm-6 col-md-8" id="content_inicio">
            <h2 class="content_inicioText">Cadastro de um funcionário</h2>

          </div>
        </div>
      </article>

      <article class="card content_inicioText">
        <!-- Resultado -->
        <h3>Resultado</h3>
        <?php
        if ($validacao == 0) {
        ?>
          <div class="alert alert-danger" role="alert">
          <?php
        } else {
          ?>
           <div class="alert alert-success" role="alert">
            <?php
          }
            ?>
            <p class="h2 color_black"> <?php echo $mensagem; ?> </p>
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