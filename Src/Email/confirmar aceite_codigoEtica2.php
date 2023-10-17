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
 * ║  │ @class: confirmar aceite_codigoEtica2                                                                       │  ║
 * ║  │ @dir: email model/                                                                                          │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 09/10/2023                                                                                           │  ║
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

if (isset($_POST['codigo']) == null) {
    $id_colaborador = null;
} else {
    $id_colaborador = $_POST['codigo'] ?? $_POST['codigo'];
}

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                       'CodigoEtica_Colaborador' section                                       │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\CodigoEtica_Colaborador_repositorio.php";

use model\CodigoEtica_Colaborador_repositorio;

$CodigoEtica_Colaborador_repositorio = new CodigoEtica_Colaborador_repositorio();

$CodigoEtica_Colaborador_repositorio = $CodigoEtica_Colaborador_repositorio->consultar_ByID($id_colaborador);

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

use function Email\consulta_EmailFinal_CodigoEtica_Colaborador;
use function Email\consulta_Email_CodigoEtica_RHComPDF;

use function Email\EmailFinal_CodigoEtica_Colaborador;
use function Email\Email_CodigoEtica_RHComPDF;

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                       Converter PDF RH' section                                               │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\Email\\converter pdf rh.php";

use function Email\pdf_RH;

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                       EnviarEmail_CodigoEtica' section                                        │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Envio_emails_CodigoEtica_repositorio.php";

use model\Envio_emails_CodigoEtica_repositorio;

$Envio_emails_CodigoEtica_repositorio = new Envio_emails_CodigoEtica_repositorio();



//Validation
$TeveAceite = 0;

if  ($id_colaborador == null) {
    $mensagem = "Error com código deste colaborador. Por favor, tente novamente.";
} else {

    $listaIds = $Timeline_CodigoEtica_repositorio->consultar_idStatusTimeline($id_colaborador);
    $idAtual = max($listaIds);

    if ($idAtual == 1) {
        $TeveAceite = 1;
        $mensagem = "Aceite do código de ética com sucesso! Iremos entrar em contato pelo seu e-mail com mais informações.";


        //Colaborador's section
        $CodigoEtica_Colaborador_repositorio = new CodigoEtica_Colaborador_repositorio();

        $CodigoEtica_Colaborador_repositorio->alterar_dataAceite($id_colaborador);




        //Timeline's section
        $idRH = $Timeline_CodigoEtica_repositorio->consultar_ID_RH($id_colaborador);

        $Timeline_CodigoEtica_repositorio->registrar_timeline("O colaborador aceitou o código de ética com sucesso através do link digital.", $idRH, $id_colaborador, 2  );


        // Gerar PDF para RH
        require_once $_SESSION['URL_SYSTEM'] .  "\\src\\Email\\converter pdf rh.php";



        $dataAceite = $CodigoEtica_Colaborador_repositorio->consultar_DataAceite($id_colaborador);

        $CodigoEtica_Colaborador = $CodigoEtica_Colaborador_repositorio->consultar_ByID($id_colaborador);

        $nomeArquivo = pdf_RH($CodigoEtica_Colaborador[1], $CodigoEtica_Colaborador[2], $CodigoEtica_Colaborador[3], $dataAceite );


        //Colaborador's section
        $CodigoEtica_Colaborador_repositorio->alterar_nomeArquivo($id_colaborador, $nomeArquivo);

        /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
        * │                                Envio_Emails 's section                                                        │
        * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
        */
        $CodigoEtica_Colaborador = $CodigoEtica_Colaborador_repositorio->consultar_ByID($id_colaborador);

        $consultaEmail = consulta_EmailFinal_CodigoEtica_Colaborador($CodigoEtica_Colaborador[1]);

        $email_destinatario = $CodigoEtica_Colaborador[3];
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


        // TESTE
        // EmailFinal_CodigoEtica_Colaborador('tiagocesar68@gmail.com', 'Tiago César da Silva Lopes');

        // EMAIL PARA RH
        $CodigoEtica_Colaborador = $CodigoEtica_Colaborador_repositorio->consultar_ByID($id_colaborador);

        $consultaEmail = consulta_Email_CodigoEtica_RHComPDF($CodigoEtica_Colaborador[1] , $nomeArquivo);

        // email do RH
        $email_destinatario = 'carlacosta@pe.senac.br';
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

        // TESTE
        // Email_CodigoEtica_RHComPDF('tiagocesar68@gmail.com', 'Tiago César da Silva Lopes', $nomeArquivo);

    } else {
        $mensagem = "Você não precisa aceitar o código de ética.";
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
    <title>Aceite do Código de Ética</title>
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
                $CodigoEtica_Colaborador_repositorio = new CodigoEtica_Colaborador_repositorio();
                $CodigoEtica_Colaborador = $CodigoEtica_Colaborador_repositorio->consultar_ByID($id_colaborador);
            ?>
                <li><a id="username"> Colaborador: <?php echo $CodigoEtica_Colaborador[1]; ?> </a></li>
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