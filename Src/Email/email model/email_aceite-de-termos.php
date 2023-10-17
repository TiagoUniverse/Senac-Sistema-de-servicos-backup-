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
 * ║  │ @description: Confirmation from the user of his acceptance of the terms                                     │  ║
 * ║  │ @class: confirmar_leitura                                                                                   │  ║
 * ║  │ @dir: email model/                                                                                          │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 11/10/2022                                                                                           │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
*/
require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";
require $_SESSION['URL_SYSTEM'] .  "\\src\\ View\\Recursos\\Head_Importacao.php";

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
    <title>Novo email</title>
<meta name="description" content="Sistema de termo de aceite" />
  <meta name="keywords" content="sistema" />
  <meta name="theme-color" content="#ffffff" />
  <link rel="apple-touch-icon" href="/assets/icons/apple-touch-icon.png">
  <link rel="manifest" href="/Termo-de-compromisso/manifest.json">

</head>

<body  class="body">
    <td style="padding:15px" align="center" valign="top">
        <table style="max-width:600px;width:100%" border="0" width="600" cellspacing="0" cellpadding="0" align="center">
            <tbody>
                <tr>
                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece"
                        align="left" valign="top" bgcolor="#FFFFFF" width="400">
                        <table style="max-width:400px;width:100%; background: #3c70ca;" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="center" valign="top" width="400"><img style="padding:20px"
                                            src="../../../Assets/Img/senac_logo_branco.png"
                                            alt="Logo Senac - Pesquisa Egressos - Ativar imagens" width="130"
                                            class="CToWUd" data-bit="iit"></td>
                                </tr>
                            </tbody>
                        </table>

                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <h3 align="center"> Sistema Termos de Aceite</h3>
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px"
                                        align="left" valign="top" width="400">Solicitamos o seu aceite dos termos de
                                        uso!</td>
                                </tr>
                            </tbody>
                        </table>

                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400">Agradecemos por ter escolhido o Senac e
                                        é um imenso prazer te ter na nossa equipe. Esperamos que a sua contribuição e
                                        experiência seja positiva. </td>
                                </tr>
                            </tbody>
                        </table>

                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400">Agora queremos que você confirme a sua
                                        leitura e confirme a concordância com os termos de aceite para que possamos
                                        finalizar o seu processo de criação de e-mail e liberação de acesso aos seus sistemas . </td>
                                </tr>
                            </tbody>
                        </table>

                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400">Para confirmar o seu aceite dos termo, 
                                        clique no botão abaixo ou no link.  </td>
                                </tr>
                            </tbody>
                        </table>

                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400"></td>
                                </tr>
                            </tbody>
                        </table>

                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:30px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="center" valign="top" width="400">
                                        <table style="border-radius:4px" border="0" width="200" cellspacing="0"
                                            cellpadding="0" bgcolor="#004a8d">
                                            <tbody>
                                                <tr>
                                                    <a class="btn btn-info my-1 buttoesMargin" href="http://google.com?name=oie" role="button"> Confirmar leitura </a>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <p>Ou através deste link:
                            <a href="confirmar_leitura.php?valor_recebido=oieee"> Passar informações </a>
                        </p>
                    </td>
                    <td style="padding:10px;max-width:200px" align="center" valign="top" width="200"></td>
                </tr>
            </tbody>
        </table>

    </td>
<script>
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('/Termo-de-compromisso/sw.js', {
        scope: '/Termo-de-compromisso/'
      });
    }
  </script>

</body>

</html>