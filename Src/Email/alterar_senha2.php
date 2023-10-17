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
 * ║  │ @description: Result of the change of password through email		                                        │  ║
 * ║  │ @class: alterar_senha2                                                                                      │  ║
 * ║  │ @dir: email model/                                                                                          │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 29/10/2022                                                                                           │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 * ║                                                     UPGRADES                                                      ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 1. @date: 23/05/23                                                                                          │  ║
 * ║  │    @description: Updating the visual of the website                                                         │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║                                                                                                                   ║
 * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
 */

require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Usuario.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Usuario_repositorio.php";

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Variables                                                                      │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

$idUsuario = $_POST['idUsuario'] ?? $_GET['idUsuario'];
$senha = $_POST['senha'] ?? $_GET['senha'];
$repitaSenha = $_POST['repitaSenha'] ?? $_GET['repitaSenha'];
$nomeUsuario = $_POST['nomeUsuario'] ?? $_GET['nomeUsuario'];

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Usuario 's section                                                             │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

use model\Usuario;
use model\Usuario_repositorio;

$Usuario = new Usuario();
$Usuario_repositorio = new Usuario_repositorio();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Validation                                                                     │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/
$sucesso = 0;

if ($senha == null) {
    $mensagem = "Senha vazia. Por favor, digite novamente";
} else if ($repitaSenha == null) {
    $mensagem = "Senha vazia. Por favor, digite novamente";
} else if ($senha != $repitaSenha) {
    $mensagem = "As senhas não são iguais. Por favor, clique em voltar e tente novamente.";
} else {
    $mensagem = "Senha alterada com sucesso!";
    $sucesso = 1;

    $Usuario_repositorio->alterarSenha($senha, $idUsuario);

    $Usuario_repositorio->desativar_trocarSenha($idUsuario);
}

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
    <link rel="stylesheet" href="../../Assets/Css/components/Table.css" />
    <link rel="stylesheet" href="../../Assets/Css/components/login.css" />
    <!--Boostrap link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <meta name="description" content="Sistema de termo de aceite" />
    <meta name="keywords" content="sistema" />
    <meta name="theme-color" content="#ffffff" />
    <link rel="apple-touch-icon" href="/assets/icons/apple-touch-icon.png">
    <link rel="manifest" href="/Termo-de-compromisso/manifest.json">
</head>

<body id="body_aceite">
    <?php
    if (isset($_POST['listarRegistros']) == false || $_POST['listarRegistros'] == 0) {
        echo " <div class='row' style='background-color: white; height:19.5cm;'>";
    } else {
        echo " <div class='row' style='background-color: white;'>";
    }
    ?>

    <header>
        <img src="../../Assets/Img/senac_logo_branco.png">
        <h1>Termo de compromisso</h1>
    </header>

    <nav>
        <ul>
            <li><a id="username_Aceite"> Usuário: <?php echo $nomeUsuario; ?> </a></li>
        </ul>
    </nav>

    <section>
        <article class="card">
            <div class="row g-0 text-center">

                <?php $link = "alterar_senha.php?id=" . $idUsuario; ?>
                <a href="<?php echo $link; ?>" style="text-align:left;">Voltar</a>

                <div class="col-6 col-md-4">
                    <img src="../../Assets/Img/contrato.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
                </div>

                <div class="col-sm-6 col-md-8" id="content_inicio">
                    <h2 class="content_inicioText">Trocar senha</h2>
                    <h5 class="content_inicioText">Resultado da operação</h5>

                </div>
            </div>
        </article>

        <article class="card content_inicioText">
            <?php
            // Mensagem do resultado
            if ($sucesso == 0) {
                echo "<div class='alert alert-danger' role='alert'> ";
            } else {
                echo "<div class='alert alert-success' role='alert'> ";
            }
            echo "<h2>" .  $mensagem . "</h2>";
            echo "</div>";
            ?>
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