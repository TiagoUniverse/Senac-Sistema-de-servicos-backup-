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
 * ║  │ @description: Result of the acceptance of the terms                                                         │  ║
 * ║  │ @class: confirmar_leitura2                                                                                  │  ║
 * ║  │ @dir: email model/                                                                                          │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 20/10/2022                                                                                           │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║    
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 * ║                                                     UPGRADES                                                      ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 1. @date: 06/01/23                                                                                          │  ║
 * ║  │    @description: Update to Colaborador                                                                      │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║                                                                                                                   ║
 * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
 */
require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";

//Variables
if (isset($_POST['NomeSobrenome']) == null) {
    $nome_colaborador = null;
} else {
    $nome_colaborador = $_POST['NomeSobrenome'];
}

if (isset($_POST['codigo']) == null) {
    $id_colaborador = null;
} else {
    $id_colaborador = $_POST['codigo'] ?? $_POST['codigo'];
}

// Colaborador 's section
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador_repositorio.php";

use model\Colaborador_repositorio;
use model\Colaborador;

$Colaborador = new Colaborador();
$Colaborador_repositorio = new Colaborador_repositorio();

$Colaborador = $Colaborador_repositorio->consultarById($id_colaborador);

//Timeline's section
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Timeline.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Timeline_repositorio.php";

use model\Timeline_repositorio;
use model\Timeline;

$Timeline = new Timeline();
$Timeline_repositorio = new Timeline_repositorio();

//Email's section
require_once "enviarEmail.php";

use function Email\Email_CriarEmail;
use function Email\consulta_CriarEmail;


/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Envio_Emails 's section                                                        │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Envio_emails_repositorio.php";

use model\Envio_emails_repositorio;

$Envio_emails_repositorio = new Envio_emails_repositorio();



//Validation
$TeveAceite = 0;

if ($nome_colaborador == null) {
    $mensagem = "Error com o nome do colaborador. Por favor, tente novamente.";
} else if ($id_colaborador == null) {
    $mensagem = "Error com código deste colaborador. Por favor, tente novamente.";
} else {
    $listaIds = $Timeline_repositorio->consultar_idStatusTimeline($id_colaborador);
    $idAtual = max($listaIds);

    if ($idAtual == 1) {
        $TeveAceite = 1;
        $mensagem = "Confirmação dos termos concluído! Iremos entrar em contato pelo seu e-mail com mais informações.";


        //Email's section
        // $email_destinarário = 'gti-suporte@pe.senac.br';
        // $mensagem = Email_CriarEmail($email_destinarário, 'Suporte GTI', $Colaborador->getId());

        //Colaborador's section
        $Colaborador->setId($id_colaborador);
        $Colaborador_repositorio->alterar_dataAceiteTermo($Colaborador);

        //Timeline's section
        $Timeline->setNome("O colaborador aceitou os termos de aceite e está aguardando a criação do seu e-mail institucional.");
        $Timeline->setId_funcionario(0);
        $Timeline->getColaborador()->setId($id_colaborador);
        $Timeline_repositorio->registrar_AceiteColaborador($Timeline);


        /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
        * │                                Envio_Emails 's section                                                        │
        * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
        */

        $consultaEmail = consulta_CriarEmail($Colaborador->getId(), $Colaborador->getNome());

        $email_destinatario = "gti-suporte@pe.senac.br";
        $de = "naoresponda@pe.senac.br";
        $para = $email_destinatario;
        $cc = "";
        $assunto = $consultaEmail[0];
        $conteudo = str_replace("'", "''", $consultaEmail[1]);


        $Envio_emails_repositorio->cadastro(
            $de,
            $para,
            $cc,
            $assunto,
            $conteudo,
            $Colaborador->getId()
        );
    } else {
        $mensagem = "Voce não precisa confirmar os termos";
    }
}

// $email_destinarário = 'tiagocesar68@gmail.com';

// $consultaEmail = consulta_CriarEmail($Colaborador->getId(), $Colaborador->getNome());

// $Emails_enviado_repositorio->cadastro($email_destinarário, $consultaEmail[0], $consultaEmail[1], $Colaborador->getId());
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aceite dos Termos</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../../Assets/Css/components/Header.css" />
    <link rel="stylesheet" href="../../Assets/Css/components/body.css" />
    <link rel="stylesheet" href="../../Assets/Css/components/navbar.css" />
    <link rel="stylesheet" href="../../Assets/Css/components/content.css" />
    <link rel="stylesheet" href="../../Assets/Css/components/SideBar.css" />
    <link rel="stylesheet" href="../../Assets/Css/components/footer.css" />
    <link rel="stylesheet" href="../../Assets/Css/components/filter.css" />
    <!--Boostrap link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <meta name="description" content="Sistema de termo de aceite" />
    <meta name="keywords" content="sistema" />
    <meta name="theme-color" content="#ffffff" />
    <link rel="apple-touch-icon" href="/assets/icons/apple-touch-icon.png">
    <link rel="manifest" href="/Termo-de-compromisso/manifest.json">
</head>

<body>

    <header>
        <img src="../../Assets/Img/senac_logo_branco.png">
        <h1>Termo de compromisso</h1>
    </header>

    <nav>
        <ul>
            <?php
            if ($id_colaborador != null) {
            ?>
                <li><a id="username"> Colaborador: <?php echo $Colaborador->getNome(); ?> </a></li>
            <?php
            } else {
            ?>
                <li> <a id="username"></a>
                <?php
            }
                ?>
        </ul>
    </nav>

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
                    <div class="row g-0 text-center">
                        <div class="col-6 col-md-4">
                            <img src="../../Assets/Img/funcionarios.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
                        </div>
                        <div class="col-sm-6 col-md-8" id="content_inicio">
                            <h1>Finalização do aceite dos termos</h1>
                        </div>
                    </div>
                </article>

                <article class="card content_inicioText">
                    <?php
                    if ($TeveAceite == 1) {
                    ?>
                        <div class="alert alert-success" role="alert">
                        <?PHP
                    } else {
                        ?>
                            <div class="alert alert-danger" role="alert">
                            <?php
                        }
                            ?>
                            <h4><?php echo $mensagem; ?> </h4>
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
                        scope: '/Senac-Aceite/'
                    });
                }
            </script>

</body>

</html>