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
 * ║  │ @description: Cadastro da solicitação do código de ética                                                    |  ║
 * ║  │ @class: Solicitar codigo etica2                                                                             │  ║
 * ║  │ @dir: Src/ View                                                                                             │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 05/10/23                                                                                             │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 * ║                                                     UPGRADES                                                      ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 1. @date:                                                                                                   │  ║
 * ║  │    @description:                                                                                            │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║                                                                                                            ║
 * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
 */

require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";
require_once "Recursos/ValidaNivelDeAcesso.php";
ta_conectado();

//Variables
$nomeCompleto = $_POST['nomeCompleto'] ?? $_GET['nomeCompleto'];
$cpf = $_POST['cpf'] ?? $_GET['cpf'];
$email_pessoal = $_POST['email_pessoal'] ?? $_GET['email_pessoal'];
$telefone = $_POST['telefone'] ?? $_GET['telefone'];


/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                       CodigoEtica_Colaborador' section                                        │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\CodigoEtica_Colaborador_repositorio.php";

use model\CodigoEtica_Colaborador_repositorio;

$CodigoEtica_Colaborador_repositorio = new CodigoEtica_Colaborador_repositorio();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                       Timeline_CodigoEtica_repositorio' section                               │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Timeline_CodigoEtica_repositorio.php";

use model\Timeline_CodigoEtica_repositorio;

$Timeline_CodigoEtica_repositorio = new Timeline_CodigoEtica_repositorio();


/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                EnviarEmail 's section                                                         │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\Email\\enviarEmail.php";

use function Email\consulta_AceiteCodigoEtica;

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                       EnviarEmail_CodigoEtica' section                                        │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Envio_emails_CodigoEtica_repositorio.php";

use model\Envio_emails_CodigoEtica_repositorio;

$Envio_emails_CodigoEtica_repositorio = new Envio_emails_CodigoEtica_repositorio();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Validation                                                                     │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

$validacao = 0;

if ($nomeCompleto == "") {
  $mensagem = "Preencha o nome completo";
} else if (strlen($nomeCompleto) > 200) {
  $mensagem = "Quantidade de caracteres maiores que 200. Por favor, preencha novamente";
} else if ($cpf == null) {
  $mensagem = "Preencha o CPF";
} else if (strlen($cpf) < 11) {
  $mensagem = "Digite o CPF completo";
} else if ($CodigoEtica_Colaborador_repositorio->consultar_CPF($cpf) != null) {
  $mensagem = "Já existe um colaborador cadastrado com este CPF. Por favor, verifique o seu CPF";
} else if ($email_pessoal == "") {
  $mensagem = "Preencha o email pessoal";
} else if (filter_var($email_pessoal, FILTER_VALIDATE_EMAIL) == false) {
  $mensagem = "E-mail pessoal cadastrado incorretamente. Por favor, preencha novamente";
} else if ($telefone == "") {
  $mensagem = "Preencha o telefone de contato";
} else if (strlen($telefone) > 12) {
  $mensagem = "Quantidade incorreta do telefone. Por favor, digite 11 números de telefone de acordo com o exemplo: 81988889999";
} else {

  $mensagem = "Cadastro realizado com sucesso!";
  $validacao = 1;

  $CodigoEtica_Colaborador_repositorio->cadastrar($nomeCompleto, $cpf, $email_pessoal, $telefone, $_SESSION['idUser']);


  //Consulta do colaborador que acabou de ser cadastrado
  $CodigoEtica_Colaborador = $CodigoEtica_Colaborador_repositorio->consultar_ByCPF($cpf);


  /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
  * │                                       Atualização do id criptografado                                         │
  * | Funcionamento: Este ID será utilizado quando o Suporte GTI for cliclar no e-mail, para que o sistema valide   │
  * | pelo id com criptografia.  Data:13/02/23                                                                      │
  * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
  */

  $CodigoEtica_Colaborador_repositorio->atualizar_IdCriptografado($cpf, hash('sha1', $CodigoEtica_Colaborador[0]));


  /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
  * │                                       Timeline Registry                                                       │
  * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
  */
  $Timeline_CodigoEtica_repositorio = new Timeline_CodigoEtica_repositorio();


  $Timeline_CodigoEtica_repositorio->registrar_timeline('O RH criou a solicitação de código de ética do colaborador' , $_SESSION['idUser'], $CodigoEtica_Colaborador[0], 1 );


  /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
  * │                                Envio_Emails_CodigoEtica 's section                                            │
  * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
  */

  $consultaEmail = consulta_AceiteCodigoEtica($CodigoEtica_Colaborador[0], $CodigoEtica_Colaborador[1]);

  $email_destinatario = $email_pessoal;
  $de = "naoresponda@pe.senac.br";
  $para = $email_destinatario;
  $cc = "";
  $assunto = $consultaEmail[0];
  $conteudo = str_replace("'", "''", $consultaEmail[1]);


  $Envio_emails_CodigoEtica_repositorio->cadastro(
    $de,
    $para,
    $cc,
    $assunto,
    $conteudo,
    $CodigoEtica_Colaborador[0]
  );
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Solicitação de novo colaborador</title>
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
        <a href="codigo etica_tela-inicial.php">Recomeçar</a>
        <div class="row g-0 text-center">
          <div class="col-6 col-md-4">
            <img src="../../Assets/Img/funcionarios.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
          </div>
          <div class="col-sm-6 col-md-8" id="content_inicio">
            <h2 class="content_inicioText">Solicitação de acesso de um novo colaborador</h2>
            <h4 class="content_inicioText"> Este formulário foi baseado no documento de "Criação de usuário e E-mail corporativo". A partir desta conclusão, a GTI vai prosseguir com o processo. </h4>
          </div>
        </div>
      </article>

      <article class="card content_inicioText">
        <h3>Resultado:</h3>
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
            <p class="h4 color_black"> <?php echo $mensagem; ?> </p>
            </div>

            <br>
            <div class="row g-0 text-center">
              <div class="col-sm-6 col-md-12">
                <h3 class="content_inicioText"> Retornar à tela inicial</h3>
                <a class="btn btn-info my-1" id="" href="codigo etica_tela-inicial.php" role="button">Menu inicial</a>
              </div>
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