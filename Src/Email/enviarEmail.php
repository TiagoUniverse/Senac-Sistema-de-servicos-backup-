<?php

namespace Email;

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../vendor/autoload.php';



function Email_CriarEmail($email_destinatario, $nome, $id_colaborador)
{
    //17/01/23 - o idColaborador que vai ser enviado no link precisa ser do tipo inteiro, e não string.

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'tiago_cesar_6@hotmail.com';                     //SMTP username
        $mail->Password   = 'batatinha@67';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('tiago_cesar_6@hotmail.com', 'SENAC Termo de aceite');
        $mail->addAddress($email_destinatario, $nome);     //Add a recipient

        //Configs para funcionar em home office
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //Content
        $mail->CharSet = 'UTF-8';                            //Acentuations
        $mail->Encoding = 'base64';
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Colaborador solicita criação de seu e-mail || Sistema Termo de compromisso';

        $idCriptografado = hash('sha1', $id_colaborador);
        $link = "https://www5.pe.senac.br/Termo-de-compromisso/Src/View/login.php?id=" . $idCriptografado;
        $mail->Body    =  '
        <td style="padding:15px" align="center" valign="top">
            <table style="max-width:600px;width:100%" border="0" width="600" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                    <tr>
                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece" align="left" valign="top" bgcolor="#FFFFFF" width="400">
                            <table style="max-width:400px;width:100%; background: #3c70ca;" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                            <img style="padding:20px" src="https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png" alt="Logo Senac - Pesquisa Egressos - Ativar imagens" width="130" class="CToWUd" data-bit="iit">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <h3 align="center"> Sistema Termo de compromisso</h3>
                            <tbody>
                            </tbody>
                        </table>
	
						<br>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400">
                                        Houve uma nova solicitação de criação de usuário de rede para instrutor/professor ou colaborador e o mesmo já aceitou o Termo de Compromisso.
                                        Nesta etapa, por favor crie o usuário de rede e acesse o sistema para comunicação da criação do usuário. </td>   
                                </tr>
                            </tbody>
                        </table>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400">
                                        <br>
                                </tr>
                            </tbody>
                        </table>
					
                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="left" valign="top" width="400"></td>
                                    </tr>
                                </tbody>
                            </table>
							
                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:30px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                            <table style="border-radius:4px" border="0" width="200" cellspacing="0" cellpadding="0" >
                                                <tbody>
                                                    <tr>
                                                        <a class="btn btn-info my-1 buttoesMargin" href= ' . $link . '   role="button" 
                                                        style="border-radius: 20px; background-color:  #4278d4; color: white; font-weight: bold; 
                                                        width: auto; height: auto; padding: 5px 30px 5px 30px;">
                                                            Acessar o sistema 
                                                        </a>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>Ou através deste link:
                                <a href= ' . $link . '  > Acessar o sistema </a>
                            </p>
                        </td>
                        <td style="padding:10px;max-width:200px" align="center" valign="top" width="200"></td>
                    </tr>
                </tbody>
            </table>
        </td>
        ';

        $mail->send();
        return 'Confirmação dos termos concluído! Iremos entrar em contato pelo seu e-mail com mais informações.';
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function consulta_CriarEmail($id_colaborador)
{
    $mailTitle = 'Colaborador solicita criação de seu e-mail || Sistema Termo de compromisso';

    $idCriptografado = hash('sha1', $id_colaborador);
    $link = "https://www5.pe.senac.br/Termo-de-compromisso/Src/View/login.php?id=" . $idCriptografado;

    $mailBody    = " <td style='padding:15px' align='center' valign='top'>
    <table style='max-width:600px;width:100%' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
            <tr>
                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece' align='left' valign='top' bgcolor='#FFFFFF' width='400'>
                    <table style='max-width:400px;width:100%; background: #3c70ca;' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='center' valign='top' width='400'>
                                    <img style='padding:20px' src='https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png' alt='Logo Senac - Pesquisa Egressos - Ativar imagens' width='130' class='CToWUd' data-bit='iit'>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                    align='center'>
                    <h3 align='center'> Sistema Termo de compromisso</h3>
                    <tbody>
                    </tbody>
                </table>

                <br>
                <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                    align='center'>
                    <tbody>
                        <tr>
                            <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px'
                                align='left' valign='top' width='400'>
                                Houve uma nova solicitação de criação de usuário de rede para instrutor/professor ou colaborador e o mesmo já aceitou o Termo de Compromisso.
                                Nesta etapa, por favor crie o usuário de rede e acesse o sistema para comunicação da criação do usuário. </td>   
                        </tr>
                    </tbody>
                </table>
                <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                    align='center'>
                    <tbody>
                        <tr>
                            <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px'
                                align='left' valign='top' width='400'>
                                <br>
                        </tr>
                    </tbody>
                </table>
            
                    <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='left' valign='top' width='400'></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:30px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='center' valign='top' width='400'>
                                    <table style='border-radius:4px' border='0' width='200' cellspacing='0' cellpadding='0' >
                                        <tbody>
                                            <tr>
                                                <a class='btn btn-info my-1 buttoesMargin' href= '{$link}'    role='button' 
                                                style='border-radius: 20px; background-color:  #4278d4; color: white; font-weight: bold; 
                                                width: auto; height: auto; padding: 5px 30px 5px 30px;'>
                                                    Acessar o sistema 
                                                </a>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p>Ou através deste link:
                        <a href=  '{$link}'  > Acessar o sistema </a>
                    </p>
                </td>
                <td style='padding:10px;max-width:200px' align='center' valign='top' width='200'></td>
            </tr>
        </tbody>
    </table>
</td>

    ";

    $consulta[0] = $mailTitle;
    $consulta[1] = $mailBody;

    return $consulta;
}

function Email_AceiteTermos($email_destinatario, $nome, $id, $nome_colaborador)
{
    //17/01/23 - o idColaborador que vai ser enviado no link precisa ser do tipo inteiro, e não string.

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'tiago_cesar_6@hotmail.com';                     //SMTP username
        $mail->Password   = 'batatinha@67';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('tiago_cesar_6@hotmail.com', 'SENAC Termo de aceite');
        $mail->addAddress($email_destinatario, $nome);     //Add a recipient

        // //Configs para funcionar em home office
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //Content
        $mail->CharSet = 'UTF-8';                            //Acentuations
        $mail->Encoding = 'base64';
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Solicitamos o seu aceite do termo de compromisso || SENAC';
        $idCriptografado = hash('sha1', $id);
        $link = "https://www5.pe.senac.br/Termo-de-compromisso/src/Email/confirmar_leitura.php?id=" . $idCriptografado;
        $mail->Body    =   '



        <td style="padding:15px" align="center" valign="top">
            <table style="max-width:600px;width:100%" border="0" width="600" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                    <tr>
                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece" align="left" valign="top" bgcolor="#FFFFFF" width="400">
                            <table style="max-width:400px;width:100%; background: #3c70ca;" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                            <img style="padding:20px" src="https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png" alt="Logo Senac - Pesquisa Egressos - Ativar imagens" width="130" class="CToWUd" data-bit="iit">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <h3 align="center"> Sistema TERMO DE COMPROMISSO</h3>
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px" align="left" valign="top" width="400">
                                        Olá,' . $nome_colaborador . '. Caso não identifique o propósito deste e-mail desconsidere-o.  </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>

                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="left" valign="top" width="400">
                                        Agradecemos por ter escolhido o SENAC-PE é um imenso prazer tê-lo em nossa equipe. </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>

                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="left" valign="top" width="400">
                                        Precisamos que leia o TERMO DE COMPROMISSO e aceite-o para que possamos finalizar o processo de criação de usuário da rede Senac-PE. </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>

                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="left" valign="top" width="400">
                                        Para ler os Termo de compromisso, clique no botão abaixo: </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="left" valign="top" width="400"></td>
                                    </tr>
                                </tbody>
                            </table>

							<br>
                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:30px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                            <table style="border-radius:4px" border="0" width="200" cellspacing="0" cellpadding="0" >
                                                <tbody>
                                                    <tr>
                                                        <a class="btn btn-info my-1 buttoesMargin" href= ' . $link . '    role="button" 
                                                        style="border-radius: 20px; background-color:  #4278d4; color: white; font-weight: bold; 
                                                        width: auto; height: auto; padding: 5px 30px 5px 30px;">
                                                            Ler os termos
                                                        </a>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>Ou através deste link:
                                <a href= ' . $link . '  > Ler os termos </a>
                            </p>
                        </td>
                        <td style="padding:10px;max-width:200px" align="center" valign="top" width="200"></td>
                    </tr>
                </tbody>
            </table>

        </td>

        ';

        $mail->send();
        return 'Cadastro realizado com sucesso!';
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function consulta_AceiteTermos($id, $nome_colaborador)
{
    $mailTitle = 'Solicitamos o seu aceite do termo de compromisso || SENAC';
    $idCriptografado = hash('sha1', $id);
    $link = "https://www5.pe.senac.br/Termo-de-compromisso/src/Email/confirmar_leitura.php?id=" . $idCriptografado;

    $mailBody    = " <td style='padding:15px' align='center' valign='top'>
    <table style='max-width:600px;width:100%' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
            <tr>
                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece' align='left' valign='top' bgcolor='#FFFFFF' width='400'>
                    <table style='max-width:400px;width:100%; background: #3c70ca;' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='center' valign='top' width='400'>
                                    <img style='padding:20px' src='https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png' alt='Logo Senac - Pesquisa Egressos - Ativar imagens' width='130' class='CToWUd' data-bit='iit'>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <h3 align='center'> Sistema TERMO DE COMPROMISSO</h3>
                        <tbody>
                            <tr>
                                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px' align='left' valign='top' width='400'>
                                Olá, {$nome_colaborador}. Caso não identifique o propósito deste e-mail desconsidere-o.  </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>

                    <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='left' valign='top' width='400'>
                                Agradecemos por ter escolhido o SENAC-PE é um imenso prazer tê-lo em nossa equipe. </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>

                    <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='left' valign='top' width='400'>
                                Precisamos que leia o TERMO DE COMPROMISSO e aceite-o para que possamos finalizar o processo de criação de usuário da rede Senac-PE. </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>

                    <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='left' valign='top' width='400'>
                                Para ler os Termo de compromisso, clique no botão abaixo: </td>
                            </tr>
                        </tbody>
                    </table>

                    <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='left' valign='top' width='400'></td>
                            </tr>
                        </tbody>
                    </table>

                    <br>
                    <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:30px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='center' valign='top' width='400'>
                                    <table style='border-radius:4px' border='0' width='200' cellspacing='0' cellpadding='0' >
                                        <tbody>
                                            <tr>
                                                <a class='btn btn-info my-1 buttoesMargin' href= '{$link}'    role='button' 
                                                style='border-radius: 20px; background-color:  #4278d4; color: white; font-weight: bold; 
                                                width: auto; height: auto; padding: 5px 30px 5px 30px;'>
                                                    Ler os termos
                                                </a>

                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p>Ou através deste link:
                        <a href= '{$link}'  > Ler os termos </a>
                    </p>
                </td>
                <td style='padding:10px;max-width:200px' align='center' valign='top' width='200'></td>
            </tr>
        </tbody>
    </table>

    </td>";

    $consulta[0] = $mailTitle;
    $consulta[1] = $mailBody;

    return $consulta;
}

function Email_AceiteCodigoEtica($email_destinatario, $nome, $id, $nome_colaborador)
{
    //17/01/23 - o idColaborador que vai ser enviado no link precisa ser do tipo inteiro, e não string.

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'tiago_cesar_6@hotmail.com';                     //SMTP username
        $mail->Password   = 'batatinha@67';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('tiago_cesar_6@hotmail.com', 'SENAC Termo de aceite');
        $mail->addAddress($email_destinatario, $nome);     //Add a recipient

        // //Configs para funcionar em home office
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //Content
        $mail->CharSet = 'UTF-8';                            //Acentuations
        $mail->Encoding = 'base64';
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Solicitamos o seu aceite do código de ética|| SENAC';
        $idCriptografado = hash('sha1', $id);
        $link = "https://www5.pe.senac.br/Termo-de-compromisso/src/Email/confirmar%20aceite_codigoEtica.php?id=" . $idCriptografado;
        $mail->Body    =   '



        <td style="padding:15px" align="center" valign="top">
            <table style="max-width:600px;width:100%" border="0" width="600" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                    <tr>
                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece" align="left" valign="top" bgcolor="#FFFFFF" width="400">
                            <table style="max-width:400px;width:100%; background: #3c70ca;" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                            <img style="padding:20px" src="https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png" alt="Logo Senac - Pesquisa Egressos - Ativar imagens" width="130" class="CToWUd" data-bit="iit">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <h3 align="center"> Sistema TERMO DE COMPROMISSO</h3>
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px" align="left" valign="top" width="400">
                                        Olá,' . $nome_colaborador . '. Caso não identifique o propósito deste e-mail desconsidere-o.  </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>

                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="left" valign="top" width="400">
                                        Precisamos que leia o CÓDIGO DE ÉTICA para que possamos atualizar o seu cadastro no Senac-PE. </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>

                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="left" valign="top" width="400">
                                        Para ler o código de ética, clique no botão abaixo: </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="left" valign="top" width="400"></td>
                                    </tr>
                                </tbody>
                            </table>

							<br>
                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:30px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                            <table style="border-radius:4px" border="0" width="200" cellspacing="0" cellpadding="0" >
                                                <tbody>
                                                    <tr>
                                                        <a class="btn btn-info my-1 buttoesMargin" href= ' . $link . '    role="button" 
                                                        style="border-radius: 20px; background-color:  #4278d4; color: white; font-weight: bold; 
                                                        width: auto; height: auto; padding: 5px 30px 5px 30px;">
                                                            Ler o código de ética
                                                        </a>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>Ou através deste link:
                                <a href= ' . $link . '  > Ler o código de ética </a>
                            </p>
                        </td>
                        <td style="padding:10px;max-width:200px" align="center" valign="top" width="200"></td>
                    </tr>
                </tbody>
            </table>

        </td>

        ';

        $mail->send();
        return 'Cadastro realizado com sucesso!';
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function consulta_AceiteCodigoEtica($id, $nome_colaborador)
{
    $mailTitle = 'Solicitamos o seu aceite do código de ética|| SENAC';
    $idCriptografado = hash('sha1', $id);
    $link = "https://www5.pe.senac.br/Termo-de-compromisso/src/Email/confirmar%20aceite_codigoEtica.php?id=" . $idCriptografado;

    $mailBody    = " <td style='padding:15px' align='center' valign='top'>
    <table style='max-width:600px;width:100%' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
            <tr>
                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece' align='left' valign='top' bgcolor='#FFFFFF' width='400'>
                    <table style='max-width:400px;width:100%; background: #3c70ca;' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='center' valign='top' width='400'>
                                    <img style='padding:20px' src='https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png' alt='Logo Senac - Pesquisa Egressos - Ativar imagens' width='130' class='CToWUd' data-bit='iit'>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <h3 align='center'> Sistema TERMO DE COMPROMISSO</h3>
                        <tbody>
                            <tr>
                                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px' align='left' valign='top' width='400'>
                                Olá,{$nome_colaborador}. Caso não identifique o propósito deste e-mail desconsidere-o.  </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>

                    <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='left' valign='top' width='400'>
                                Precisamos que leia o CÓDIGO DE ÉTICA para que possamos atualizar o seu cadastro no Senac-PE. </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>

                    <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='left' valign='top' width='400'>
                                Para ler o código de ética, clique no botão abaixo: </td>
                            </tr>
                        </tbody>
                    </table>

                    <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='left' valign='top' width='400'></td>
                            </tr>
                        </tbody>
                    </table>

                    <br>
                    <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:30px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='center' valign='top' width='400'>
                                    <table style='border-radius:4px' border='0' width='200' cellspacing='0' cellpadding='0' >
                                        <tbody>
                                            <tr>
                                                <a class='btn btn-info my-1 buttoesMargin' href= ' {$link}'    role='button' 
                                                style='border-radius: 20px; background-color:  #4278d4; color: white; font-weight: bold; 
                                                width: auto; height: auto; padding: 5px 30px 5px 30px;'>
                                                    Ler o código de ética
                                                </a>

                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p>Ou através deste link:
                        <a href= '{$link}'  > Ler o código de ética </a>
                    </p>
                </td>
                <td style='padding:10px;max-width:200px' align='center' valign='top' width='200'></td>
            </tr>
        </tbody>
    </table>

</td>";

    $consulta[0] = $mailTitle;
    $consulta[1] = $mailBody;

    return $consulta;
}



function Email_fimDoProcesso($email_destinatario, $nome, $nome_colaborador)
{

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'tiago_cesar_6@hotmail.com';                     //SMTP username
        $mail->Password   = 'batatinha@67';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('tiago_cesar_6@hotmail.com', 'SENAC Termo de aceite');
        $mail->addAddress($email_destinatario, $nome);     //Add a recipient

        //Content
        $mail->CharSet = 'UTF-8';                            //Acentuations
        $mail->Encoding = 'base64';
        $mail->isHTML(true);                                  //Set email format to HTML       
        $mail->Subject = 'Processo de aceite finalizado! || Sistema Termo de compromisso ';
        $mail->Body    =   '
        <td style="padding:15px" align="center" valign="top">
            <table style="max-width:600px;width:100%" border="0" width="600" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                    <tr>
                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece" align="left" valign="top" bgcolor="#FFFFFF" width="400">
                            <table style="max-width:400px;width:100%; background: #3c70ca;" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                            <img style="padding:20px" src="https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png" alt="Logo Senac - Pesquisa Egressos - Ativar imagens" width="130" class="CToWUd" data-bit="iit">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <h3 align="center"> Sistema Termo de compromisso</h3>
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px"
                                        align="left" valign="top" width="400">Finalização do processo do sistema de
                                        Termo de Aceite!</td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400">O colaborador <b> ' . $nome_colaborador . ' </b> passou por todos os
                                        processos com sucesso! Ele teve seu e-mail corporativo criado. </td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400">Caso o RH  deseje solicitar
                                       uma nova solicitação, utilize o botão abaixo para acessar o sistema.</td>
                                </tr>
                            </tbody>
                        </table>
					
                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="left" valign="top" width="400"></td>
                                    </tr>
                                </tbody>
                            </table>
							
                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:30px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                            <table style="border-radius:4px" border="0" width="200" cellspacing="0" cellpadding="0" >
                                                <tbody>
                                                    <tr>
                                                        <a class="btn btn-info my-1 buttoesMargin" href= "https://www5.pe.senac.br/Termo-de-compromisso/Src/View/login.php"    role="button" 
                                                        style="border-radius: 20px; background-color:  #4278d4; color: white; font-weight: bold; 
                                                        width: auto; height: auto; padding: 5px 30px 5px 30px;">
                                                            Acessar o sistema 
                                                        </a>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>Ou através deste link:
                                <a href= "https://www5.pe.senac.br/Termo-de-compromisso/Src/View/login.php"  > Acessar o sistema </a>
                            </p>
                        </td>
                        <td style="padding:10px;max-width:200px" align="center" valign="top" width="200"></td>
                    </tr>
                </tbody>
            </table>
        </td>
        ';

        $mail->send();
        return 'Criação do e-mail institucional do colaborador com sucesso. Assim, o processo está finalizado.';
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function Email_InformacoesColaborador_apenasEmail($email_destinatario, $nome_colaborador, $email_gerado, $senhaPadrao)
{

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'tiago_cesar_6@hotmail.com';                     //SMTP username
        $mail->Password   = 'batatinha@67';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('tiago_cesar_6@hotmail.com', 'SENAC Termo de aceite');
        $mail->addAddress($email_destinatario, $nome_colaborador);     //Add a recipient

        //Content
        $mail->CharSet = 'UTF-8';                            //Acentuations
        $mail->Encoding = 'base64';
        $mail->isHTML(true);                                  //Set email format to HTML       
        $mail->Subject = 'Processo de aceite finalizado! || Sistema Termo de compromisso ';
        $mail->Body    =   '
        <td style="padding:15px" align="center" valign="top">
            <table style="max-width:600px;width:100%" border="0" width="600" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                    <tr>
                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece" align="left" valign="top" bgcolor="#FFFFFF" width="400">
                            <table style="max-width:400px;width:100%; background: #3c70ca;" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                            <img style="padding:20px" src="https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png" alt="Logo Senac - Pesquisa Egressos - Ativar imagens" width="130" class="CToWUd" data-bit="iit">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <h3 align="center"> Sistema Termo de compromisso</h3>
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px"
                                        align="left" valign="top" width="400">Saudações,' . $nome_colaborador . '! </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400">
                                        O seu processo de criação de usuário passou por todas as etapas e foi finalizado! Segue abaixo as suas informações para acesso:</td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400"> email: ' . $email_gerado . ' <br> Senha: ' . $senhaPadrao . ' <br> <br>
                                        <br> <a href="https://outlook.office.com/owa/"> https://outlook.office.com/owa/ </a>
                                        <br> <br> Acesseo site acima. Ao acessar pela primeira vez será solicitado que você crie a sua própria senha. </td>
                                </tr>
                            </tbody>
                        </table>
					
                           
                        </td>
                        <td style="padding:10px;max-width:200px" align="center" valign="top" width="200"></td>
                    </tr>
                </tbody>
            </table>
        </td>
        ';

        $mail->send();
        //echo 'Message has been sent';
        return 'Criação do e-mail institucional do colaborador com sucesso. Assim, o processo está finalizado.';
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function consulta_InformacoesColaborador_apenasEmail($nome_colaborador, $email_gerado, $senhaPadrao)
{
    $mailTitle = 'Processo de aceite finalizado! || Sistema Termo de compromisso';

    $mailBody    =  "<td style='padding:15px' align='center' valign='top'>
    <table style='max-width:600px;width:100%' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
            <tr>
                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece' align='left' valign='top' bgcolor='#FFFFFF' width='400'>
                    <table style='max-width:400px;width:100%; background: #3c70ca;' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='center' valign='top' width='400'>
                                    <img style='padding:20px' src='https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png' alt='Logo Senac - Pesquisa Egressos - Ativar imagens' width='130' class='CToWUd' data-bit='iit'>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                    align='center'>
                    <h3 align='center'> Sistema Termo de compromisso</h3>
                    <tbody>
                        <tr>
                            <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px'
                                align='left' valign='top' width='400'>Saudações, {$nome_colaborador} ! </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                    align='center'>
                    <tbody>
                        <tr>
                            <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px'
                                align='left' valign='top' width='400'>
                                O seu processo de criação de usuário passou por todas as etapas e foi finalizado! Segue abaixo as suas informações para acesso:</td>
                        </tr>
                    </tbody>
                </table>
                <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                    align='center'>
                    <tbody>
                        <tr>
                            <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px'
                                align='left' valign='top' width='400'> email: '{$email_gerado}' <br> Senha: '{$senhaPadrao}' <br> <br>
                                <br> <a href='https://outlook.office.com/owa/'> https://outlook.office.com/owa/ </a>
                                <br> <br> Acesseo site acima. Ao acessar pela primeira vez será solicitado que você crie a sua própria senha. </td>
                        </tr>
                    </tbody>
                </table>
            
                   
                </td>
                <td style='padding:10px;max-width:200px' align='center' valign='top' width='200'></td>
            </tr>
        </tbody>
    </table>
    </td>";

    $consulta[0] = $mailTitle;
    $consulta[1] = $mailBody;

    return $consulta;
}


function EmailFinal_CodigoEtica_Colaborador($email_destinatario, $nome_colaborador)
{

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'tiago_cesar_6@hotmail.com';                     //SMTP username
        $mail->Password   = 'batatinha@67';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('tiago_cesar_6@hotmail.com', 'SENAC Termo de aceite');
        $mail->addAddress($email_destinatario, $nome_colaborador);     //Add a recipient

        //Content
        $mail->CharSet = 'UTF-8';                            //Acentuations
        $mail->Encoding = 'base64';
        $mail->isHTML(true);                                  //Set email format to HTML       
        $mail->Subject = 'Processo de aceite do código de ética finalizado! || Sistema Termo de compromisso ';
        $mail->Body    =   '
        <td style="padding:15px" align="center" valign="top">
            <table style="max-width:600px;width:100%" border="0" width="600" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                    <tr>
                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece" align="left" valign="top" bgcolor="#FFFFFF" width="400">
                            <table style="max-width:400px;width:100%; background: #3c70ca;" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                            <img style="padding:20px" src="https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png" alt="Logo Senac - Pesquisa Egressos - Ativar imagens" width="130" class="CToWUd" data-bit="iit">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <h3 align="center"> Sistema Termo de compromisso</h3>
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px"
                                        align="left" valign="top" width="400">Saudações,' . $nome_colaborador . '! </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400">
                                        O seu processo de aceite do código de ética do <b>SENAC</b> passou por todas as etapas e foi finalizado! </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400"> Em caso de dúvidas, entre em contato com o nosso suporte através do sistema de chamados: <br><br>
                                        <a target="_Blank" href="https://www7.pe.senac.br/taskmanager/login" style="text-align: center;">Senac Task Manager </a>
                                        <br> <br> Para acessar o sistema de chamados, utilize o mesmo login e senha do seu email @pe.senac.br. </td>
                                </tr>
                            </tbody>
                        </table>
                        <br><br>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400"> Serviço Nacional de Aprendizagem Comercial - Departamento Regional de Pernambuco<br>
                                        Avenida Visconde de Suassuna, 500 • Santo Amaro • CEP 50.050-540<br>
                                        Recife / PE • Tel.: 0800 081 1688 • www.pe.senac.br </td>
                                </tr>
                            </tbody>
                        </table>
					
                           
                        </td>
                        <td style="padding:10px;max-width:200px" align="center" valign="top" width="200"></td>
                    </tr>
                </tbody>
            </table>
        </td>
        ';

        $mail->send();
        //echo 'Message has been sent';
        return 'Criação do e-mail institucional do colaborador com sucesso. Assim, o processo está finalizado.';
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function consulta_EmailFinal_CodigoEtica_Colaborador($nome_colaborador)
{
    $mailTitle = 'Processo de aceite do código de ética finalizado! || Sistema Termo de compromisso ';

    $mailBody    =  "
    <td style='padding:15px' align='center' valign='top'>
            <table style='max-width:600px;width:100%' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
                <tbody>
                    <tr>
                        <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece' align='left' valign='top' bgcolor='#FFFFFF' width='400'>
                            <table style='max-width:400px;width:100%; background: #3c70ca;' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                                <tbody>
                                    <tr>
                                        <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='center' valign='top' width='400'>
                                            <img style='padding:20px' src='https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png' alt='Logo Senac - Pesquisa Egressos - Ativar imagens' width='130' class='CToWUd' data-bit='iit'>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                            align='center'>
                            <h3 align='center'> Sistema Termo de compromisso</h3>
                            <tbody>
                                <tr>
                                    <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px'
                                        align='left' valign='top' width='400'>Saudações, {$nome_colaborador}! </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                            align='center'>
                            <tbody>
                                <tr>
                                    <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px'
                                        align='left' valign='top' width='400'>
                                        O seu processo de aceite do código de ética do <b>SENAC</b> passou por todas as etapas e foi finalizado! </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                            align='center'>
                            <tbody>
                                <tr>
                                    <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px'
                                        align='left' valign='top' width='400'> Em caso de dúvidas, entre em contato com o nosso suporte através do sistema de chamados: <br><br>
                                        <a target='_Blank' href='https://www7.pe.senac.br/taskmanager/login' style='text-align: center;'>Senac Task Manager </a>
                                        <br> <br> Para acessar o sistema de chamados, utilize o mesmo login e senha do seu email @pe.senac.br. </td>
                                </tr>
                            </tbody>
                        </table>
                        <br><br>
                        <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                            align='center'>
                            <tbody>
                                <tr>
                                    <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px'
                                        align='left' valign='top' width='400'> Serviço Nacional de Aprendizagem Comercial - Departamento Regional de Pernambuco<br>
                                        Avenida Visconde de Suassuna, 500 • Santo Amaro • CEP 50.050-540<br>
                                        Recife / PE • Tel.: 0800 081 1688 • www.pe.senac.br </td>
                                </tr>
                            </tbody>
                        </table>
					
                           
                        </td>
                        <td style='padding:10px;max-width:200px' align='center' valign='top' width='200'></td>
                    </tr>
                </tbody>
            </table>
        </td>
    ";

    $consulta[0] = $mailTitle;
    $consulta[1] = $mailBody;

    return $consulta;
}


function EmailFinal_CodigoEtica_RH($email_destinatario, $nome_colaborador, $cpf, $email_colaborador)
{

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'tiago_cesar_6@hotmail.com';                     //SMTP username
        $mail->Password   = 'batatinha@67';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('tiago_cesar_6@hotmail.com', 'SENAC Termo de aceite');
        $mail->addAddress($email_destinatario, $nome_colaborador);     //Add a recipient

        //Content
        $mail->CharSet = 'UTF-8';                            //Acentuations
        $mail->Encoding = 'base64';
        $mail->isHTML(true);                                  //Set email format to HTML    

        // $link = "https://cloud.plataforma.senac.br/#/login?returnUrl=%2F";
        $mail->Subject = ' Processo de aceite do código de ética finalizado || Sistema Termo de compromisso ';
        $mail->Body    =   '
        <td style="padding:15px" align="center" valign="top">
            <table style="max-width:600px;width:100%" border="0" width="600" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                    <tr>
                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece" align="left" valign="top" bgcolor="#FFFFFF" width="400">
                            <table style="max-width:400px;width:100%; background: #3c70ca;" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                            <img style="padding:20px" src="https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png" alt="Logo Senac - Pesquisa Egressos - Ativar imagens" width="130" class="CToWUd" data-bit="iit">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <h3 align="center"> Sistema Termo de compromisso</h3>
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px"
                                            align="left" valign="top" width="400"> O colaborador(a) <b> ' . $nome_colaborador . ' </b> confirmou o seu aceite do código de ética
                                            e finalizou o seu processo solicitado.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px"
                                        align="left" valign="top" width="400"> Segue abaixo alguma das informações do colaborador: <br>
                                        Nome: ' . $nome_colaborador . ' <br>
                                        CPF: ' . $cpf . ' <br>
                                        E-mail do colaborador: ' . $email_colaborador . ' 
                                     </td>
                                </tr>
                            </tbody>
                        </table>
                        <br><br>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400"> Em caso de dúvidas, entre em contato com o nosso suporte através do sistema de chamados: <br><br>
                                        <a target="_Blank" href="https://www7.pe.senac.br/taskmanager/login" style="text-align: center;">Senac Task Manager </a>
                                        <br> <br> Para acessar o sistema de chamados, utilize o mesmo login e senha do seu email @pe.senac.br. </td>
                                </tr>
                            </tbody>
                        </table>
                        <br><br>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400"> Serviço Nacional de Aprendizagem Comercial - Departamento Regional de Pernambuco<br>
                                        Avenida Visconde de Suassuna, 500 • Santo Amaro • CEP 50.050-540<br>
                                        Recife / PE • Tel.: 0800 081 1688 • www.pe.senac.br </td>
                                </tr>
                            </tbody>
                        </table>
                        <td style="padding:10px;max-width:200px" align="center" valign="top" width="200"></td>
                    </tr>
                </tbody>
            </table>
        </td>
        ';

        $mail->send();
        //echo 'Message has been sent';
        return 'Criação do e-mail institucional do colaborador com sucesso. Assim, o processo está finalizado.';
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function consulta_EmailFinal_CodigoEtica_RH($nome_colaborador, $cpf, $email_colaborador)
{
    // $link = "https://cloud.plataforma.senac.br/#/login?returnUrl=%2F";
    $mailTitle = 'Processo de aceite do código de ética finalizado || Sistema Termo de compromisso ';

    $mailBody    =  "
    <td style='padding:15px' align='center' valign='top'>
            <table style='max-width:600px;width:100%' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
                <tbody>
                    <tr>
                        <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece' align='left' valign='top' bgcolor='#FFFFFF' width='400'>
                            <table style='max-width:400px;width:100%; background: #3c70ca;' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                                <tbody>
                                    <tr>
                                        <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='center' valign='top' width='400'>
                                            <img style='padding:20px' src='https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png' alt='Logo Senac - Pesquisa Egressos - Ativar imagens' width='130' class='CToWUd' data-bit='iit'>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                                <h3 align='center'> Sistema Termo de compromisso</h3>
                                <tbody>
                                    <tr>
                                        <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px'
                                            align='left' valign='top' width='400'> O colaborador(a) <b> {$nome_colaborador} </b> confirmou o seu aceite do código de ética
                                            e finalizou o seu processo solicitado.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                            <tbody>
                                <tr>
                                    <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px'
                                        align='left' valign='top' width='400'> Segue abaixo alguma das informações do colaborador: <br>
                                        Nome: {$nome_colaborador} <br>
                                        CPF: {$cpf} <br>
                                        E-mail do colaborador: {$email_colaborador} 
                                     </td>
                                </tr>
                            </tbody>
                        </table>
                        <br><br>
                        <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                            align='center'>
                            <tbody>
                                <tr>
                                    <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px'
                                        align='left' valign='top' width='400'> Em caso de dúvidas, entre em contato com o nosso suporte através do sistema de chamados: <br><br>
                                        <a target='_Blank' href='https://www7.pe.senac.br/taskmanager/login' style='text-align: center;'>Senac Task Manager </a>
                                        <br> <br> Para acessar o sistema de chamados, utilize o mesmo login e senha do seu email @pe.senac.br. </td>
                                </tr>
                            </tbody>
                        </table>
                        <br><br>
                        <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                            align='center'>
                            <tbody>
                                <tr>
                                    <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px'
                                        align='left' valign='top' width='400'> Serviço Nacional de Aprendizagem Comercial - Departamento Regional de Pernambuco<br>
                                        Avenida Visconde de Suassuna, 500 • Santo Amaro • CEP 50.050-540<br>
                                        Recife / PE • Tel.: 0800 081 1688 • www.pe.senac.br </td>
                                </tr>
                            </tbody>
                        </table>
                        <td style='padding:10px;max-width:200px' align='center' valign='top' width='200'></td>
                    </tr>
                </tbody>
            </table>
        </td>
    ";

    $consulta[0] = $mailTitle;
    $consulta[1] = $mailBody;

    return $consulta;
}


function Email_CodigoEtica_RHComPDF($email_destinatario, $nome_colaborador, $nomeDocumento)
{

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'tiago_cesar_6@hotmail.com';                     //SMTP username
        $mail->Password   = 'batatinha@67';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('tiago_cesar_6@hotmail.com', 'SENAC Termo de aceite');
        $mail->addAddress($email_destinatario, $nome_colaborador);     //Add a recipient

        //Content
        $mail->CharSet = 'UTF-8';                            //Acentuations
        $mail->Encoding = 'base64';
        $mail->isHTML(true);                                  //Set email format to HTML    

        $link = "https://www5.pe.senac.br/Termo-de-compromisso/src/Email/documentos/" . $nomeDocumento . ".pdf";
        // echo $link;
        $mail->Subject = ' Processo de aceite do código de ética finalizado || Sistema Termo de compromisso ';
        $mail->Body    =   '
        <td style="padding:15px" align="center" valign="top">
            <table style="max-width:600px;width:100%" border="0" width="600" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                    <tr>
                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece" align="left" valign="top" bgcolor="#FFFFFF" width="400">
                            <table style="max-width:400px;width:100%; background: #3c70ca;" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                            <img style="padding:20px" src="https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png" alt="Logo Senac - Pesquisa Egressos - Ativar imagens" width="130" class="CToWUd" data-bit="iit">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <h3 align="center"> Sistema Termo de compromisso</h3>
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px"
                                            align="left" valign="top" width="400"> O colaborador(a) <b> ' . $nome_colaborador . ' </b> confirmou o seu aceite do código de ética
                                            e finalizou o seu processo solicitado. Segue abaixo o comprovante do seu aceite, com as suas informações.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <h3 align="center"> Sistema Termo de compromisso</h3>
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px"
                                            align="left" valign="top" width="400"> Para visualizar o documento, clique <a target="_Blank" href=  " '. $link . ' " >aqui</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400"> Em caso de dúvidas, entre em contato com o nosso suporte através do sistema de chamados: <br><br>
                                        <a target="_Blank" href="https://www7.pe.senac.br/taskmanager/login" style="text-align: center;">Senac Task Manager </a>
                                        <br> <br> Para acessar o sistema de chamados, utilize o mesmo login e senha do seu email @pe.senac.br. </td>
                                </tr>
                            </tbody>
                        </table>
                        <br><br>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400"> Serviço Nacional de Aprendizagem Comercial - Departamento Regional de Pernambuco<br>
                                        Avenida Visconde de Suassuna, 500 • Santo Amaro • CEP 50.050-540<br>
                                        Recife / PE • Tel.: 0800 081 1688 • www.pe.senac.br </td>
                                </tr>
                            </tbody>
                        </table>
                        <td style="padding:10px;max-width:200px" align="center" valign="top" width="200"></td>
                    </tr>
                </tbody>
            </table>
        </td>
        ';

        $mail->send();
        //echo 'Message has been sent';
        return 'Criação do e-mail institucional do colaborador com sucesso. Assim, o processo está finalizado.';
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function consulta_Email_CodigoEtica_RHComPDF($nome_colaborador, $nomeDocumento)
{
    $link = "https://www5.pe.senac.br/Termo-de-compromisso/src/Email/documentos/" . $nomeDocumento;
    $mailTitle = 'Processo de aceite do código de ética finalizado || Sistema Termo de compromisso ';

    $mailBody    =  "
    <td style='padding:15px' align='center' valign='top'>
            <table style='max-width:600px;width:100%' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
                <tbody>
                    <tr>
                        <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece' align='left' valign='top' bgcolor='#FFFFFF' width='400'>
                            <table style='max-width:400px;width:100%; background: #3c70ca;' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                                <tbody>
                                    <tr>
                                        <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='center' valign='top' width='400'>
                                            <img style='padding:20px' src='https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png' alt='Logo Senac - Pesquisa Egressos - Ativar imagens' width='130' class='CToWUd' data-bit='iit'>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                                <h3 align='center'> Sistema Termo de compromisso</h3>
                                <tbody>
                                    <tr>
                                        <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px'
                                            align='left' valign='top' width='400'> O colaborador(a) <b> {$nome_colaborador} </b> confirmou o seu aceite do código de ética
                                            e finalizou o seu processo solicitado. Segue abaixo o comprovante do seu aceite, com as suas informações.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                                <h3 align='center'> Sistema Termo de compromisso</h3>
                                <tbody>
                                    <tr>
                                        <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px'
                                            align='left' valign='top' width='400'> Para visualizar o documento, clique <a target='_Blank' href= ' {$link}'  >aqui</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                            align='center'>
                            <tbody>
                                <tr>
                                    <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px'
                                        align='left' valign='top' width='400'> Em caso de dúvidas, entre em contato com o nosso suporte através do sistema de chamados: <br><br>
                                        <a target='_Blank' href='https://www7.pe.senac.br/taskmanager/login' style='text-align: center;'>Senac Task Manager </a>
                                        <br> <br> Para acessar o sistema de chamados, utilize o mesmo login e senha do seu email @pe.senac.br. </td>
                                </tr>
                            </tbody>
                        </table>
                        <br><br>
                        <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                            align='center'>
                            <tbody>
                                <tr>
                                    <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px'
                                        align='left' valign='top' width='400'> Serviço Nacional de Aprendizagem Comercial - Departamento Regional de Pernambuco<br>
                                        Avenida Visconde de Suassuna, 500 • Santo Amaro • CEP 50.050-540<br>
                                        Recife / PE • Tel.: 0800 081 1688 • www.pe.senac.br </td>
                                </tr>
                            </tbody>
                        </table>
                        <td style='padding:10px;max-width:200px' align='center' valign='top' width='200'></td>
                    </tr>
                </tbody>
            </table>
        </td>
    ";

    $consulta[0] = $mailTitle;
    $consulta[1] = $mailBody;

    return $consulta;
}


function Email_InformacoesColaborador_contaRedeEmail($email_destinatario, $nome_colaborador, $email_gerado, $senhaPadrao)
{

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'tiago_cesar_6@hotmail.com';                     //SMTP username
        $mail->Password   = 'batatinha@67';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('tiago_cesar_6@hotmail.com', 'SENAC Termo de aceite');
        $mail->addAddress($email_destinatario, $nome_colaborador);     //Add a recipient

        //Content
        $mail->CharSet = 'UTF-8';                            //Acentuations
        $mail->Encoding = 'base64';
        $mail->isHTML(true);                                  //Set email format to HTML       
        $mail->Subject = 'Processo de aceite finalizado! || Sistema Termo de compromisso ';
        $mail->Body    =   '
        <td style="padding:15px" align="center" valign="top">
            <table style="max-width:600px;width:100%" border="0" width="600" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                    <tr>
                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece" align="left" valign="top" bgcolor="#FFFFFF" width="400">
                            <table style="max-width:400px;width:100%; background: #3c70ca;" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                            <img style="padding:20px" src="https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png" alt="Logo Senac - Pesquisa Egressos - Ativar imagens" width="130" class="CToWUd" data-bit="iit">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <h3 align="center"> Sistema Termo de compromisso</h3>
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px"
                                        align="left" valign="top" width="400">
                                        Saudações,' . $nome_colaborador . '!
                                        </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400">
                                        O seu processo de criação de usuário passou por todas as etapas e foi finalizado!
                                        Segue abaixo as instruções para acessar sua conta e as suas informações para acesso: </td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400">Primeiro, você precisa utilizar um computador nas instituições do SENAC e fazer login na conta do windows. 
                                        Isso permitirá que sua conta seja ativada e que você possa alterar sua senha para o seu uso. Para fazer login no windows, primeiro digite o seu login, 
                                        que é o nome que vem antes do @ no email e utilize a senha padrão para poder acessar e criar sua senha. Quando terminar, você poderá acessar o seu e-mail do Senac 
                                        em qualquer lugar normalmente. <br> </td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400"> email: ' . $email_gerado . ' <br> Senha: ' . $senhaPadrao . ' <br> <br>
                                        <br> Após ter feito login em um computador da instituição SENAC, você poderá acessar o site abaixo:  <br>
                                        <br> <a href="https://outlook.office.com/owa/"> https://outlook.office.com/owa/ </a>  </td>
                                </tr>
                            </tbody>
                        </table>
					
                           
                        </td>
                        <td style="padding:10px;max-width:200px" align="center" valign="top" width="200"></td>
                    </tr>
                </tbody>
            </table>
        </td>
        ';

        $mail->send();
        //echo 'Message has been sent';
        return 'Criação do e-mail institucional do colaborador com sucesso. Assim, o processo está finalizado.';
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function consulta_InformacoesColaborador_contaRedeEmail($nome_colaborador, $email_gerado, $senhaPadrao)
{
    $mailTitle = 'Processo de aceite finalizado! || Sistema Termo de compromisso';

    $mailBody    =  "<td style='padding:15px' align='center' valign='top'>
    <table style='max-width:600px;width:100%' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
            <tr>
                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece' align='left' valign='top' bgcolor='#FFFFFF' width='400'>
                    <table style='max-width:400px;width:100%; background: #3c70ca;' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='center' valign='top' width='400'>
                                    <img style='padding:20px' src='https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png' alt='Logo Senac - Pesquisa Egressos - Ativar imagens' width='130' class='CToWUd' data-bit='iit'>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                    align='center'>
                    <h3 align='center'> Sistema Termo de compromisso</h3>
                    <tbody>
                        <tr>
                            <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px'
                                align='left' valign='top' width='400'>
                                Saudações, {$nome_colaborador}!
                                </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                    align='center'>
                    <tbody>
                        <tr>
                            <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px'
                                align='left' valign='top' width='400'>
                                O seu processo de criação de usuário passou por todas as etapas e foi finalizado!
                                Segue abaixo as instruções para acessar sua conta e as suas informações para acesso: </td>
                        </tr>
                    </tbody>
                </table>
                <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                    align='center'>
                    <tbody>
                        <tr>
                            <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px'
                                align='left' valign='top' width='400'>Primeiro, você precisa utilizar um computador nas instituições do SENAC e fazer login na conta do windows. 
                                Isso permitirá que sua conta seja ativada e que você possa alterar sua senha para o seu uso. Para fazer login no windows, primeiro digite o seu login, 
                                que é o nome que vem antes do @ no email e utilize a senha padrão para poder acessar e criar sua senha. Quando terminar, você poderá acessar o seu e-mail do Senac 
                                em qualquer lugar normalmente. <br> </td>
                        </tr>
                    </tbody>
                </table>
                <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                    align='center'>
                    <tbody>
                        <tr>
                            <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px'
                                align='left' valign='top' width='400'> email: {$email_gerado} <br> Senha: {$senhaPadrao} <br> <br>
                                <br> Após ter feito login em um computador da instituição SENAC, você poderá acessar o site abaixo:  <br>
                                <br> <a href='https://outlook.office.com/owa/'> https://outlook.office.com/owa/ </a>  </td>
                        </tr>
                    </tbody>
                </table>
            
                   
                </td>
                <td style='padding:10px;max-width:200px' align='center' valign='top' width='200'></td>
            </tr>
        </tbody>
    </table>
</td>";

    $consulta[0] = $mailTitle;
    $consulta[1] = $mailBody;

    return $consulta;
}


// E-mail enviado par GTI SISTEMAS para informar que houve o cadastro de um e-mail de professor. Assim, o e-mail
// solicita a atualização no SIG
function Email_atualizacaoSIG($email_destinatario, $nome_colaborador, $email_gerado, $cpfProfessor)
{

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'tiago_cesar_6@hotmail.com';                     //SMTP username
        $mail->Password   = 'batatinha@67';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('tiago_cesar_6@hotmail.com', 'SENAC Termo de aceite');
        $mail->addAddress($email_destinatario, $nome_colaborador);     //Add a recipient

        //Content
        $mail->CharSet = 'UTF-8';                            //Acentuations
        $mail->Encoding = 'base64';
        $mail->isHTML(true);                                  //Set email format to HTML    

        $link = "https://cloud.plataforma.senac.br/#/login?returnUrl=%2F";
        $mail->Subject = ' Atualização no SIG || Sistema Termo de compromisso ';
        $mail->Body    =   '
        <td style="padding:15px" align="center" valign="top">
            <table style="max-width:600px;width:100%" border="0" width="600" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                    <tr>
                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece" align="left" valign="top" bgcolor="#FFFFFF" width="400">
                            <table style="max-width:400px;width:100%; background: #3c70ca;" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                            <img style="padding:20px" src="https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png" alt="Logo Senac - Pesquisa Egressos - Ativar imagens" width="130" class="CToWUd" data-bit="iit">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <h3 align="center"> Sistema Termo de compromisso</h3>
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px"
                                        align="left" valign="top" width="400"> O professor(a) <b> ' . $nome_colaborador . ' </b> confirmou o seu aceite dos Termos
                                        de compromisso e teve o seu e-mail corporativo cadastrado pelo Suporte GTI.
                                     </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400">
                                        Sendo assim, é solicitado à <b> GTI SISTEMAS </b> atualizar, o cadastro pessoa física no SIG, substituindo 
                                        do e-mail pessoal do colaborador pelo e-mail corporativo.     </td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0"
                            align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-family:"Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px"
                                        align="left" valign="top" width="400"> 
                                        <br> E-mail corporativo do professor: <br> ' . $email_gerado . ' <br>
                                        <br> CPF: <br> ' . $cpfProfessor . ' 
                                        </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:30px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                            <table style="border-radius:4px" border="0" width="200" cellspacing="0" cellpadding="0" >
                                                <tbody>
                                                    <tr>
                                                        <a class="btn btn-info my-1 buttoesMargin" href= ' . $link . '    role="button" 
                                                        style="border-radius: 20px; background-color:  #4278d4; color: white; font-weight: bold; 
                                                        width: auto; height: auto; padding: 5px 30px 5px 30px;">
                                                            Acessar o SIG
                                                        </a>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>Ou através deste link:
                                <a href= ' . $link . '  > Acessar o SIG </a>
                            </p>
                        <td style="padding:10px;max-width:200px" align="center" valign="top" width="200"></td>
                    </tr>
                </tbody>
            </table>
        </td>
        ';

        $mail->send();
        //echo 'Message has been sent';
        return 'Criação do e-mail institucional do colaborador com sucesso. Assim, o processo está finalizado.';
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function consulta_AtualizacaoSig($nome_colaborador, $email_gerado, $cpfProfessor)
{
    $link = "https://cloud.plataforma.senac.br/#/login?returnUrl=%2F";
    $mailTitle = 'Atualização no SIG || Sistema Termo de compromisso ';

    $mailBody    =  "<td style='padding:15px' align='center' valign='top'>
    <table style='max-width:600px;width:100%' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
            <tr>
                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece' align='left' valign='top' bgcolor='#FFFFFF' width='400'>
                    <table style='max-width:400px;width:100%; background: #3c70ca;' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='center' valign='top' width='400'>
                                    <img style='padding:20px' src='https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png' alt='Logo Senac - Pesquisa Egressos - Ativar imagens' width='130' class='CToWUd' data-bit='iit'>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                    align='center'>
                    <h3 align='center'> Sistema Termo de compromisso</h3>
                    <tbody>
                        <tr>
                            <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px'
                                align='left' valign='top' width='400'> O professor(a) <b> {$nome_colaborador} </b> confirmou o seu aceite dos Termos
                                de compromisso e teve o seu e-mail corporativo cadastrado pelo Suporte GTI.
                             </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                    align='center'>
                    <tbody>
                        <tr>
                            <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px'
                                align='left' valign='top' width='400'>
                                Sendo assim, é solicitado à <b> GTI SISTEMAS </b> atualizar, o cadastro pessoa física no SIG, substituindo do e-mail pessoal
                                 do colaborador pelo e-mail corporativo.     </td>
                        </tr>
                    </tbody>
                </table>
                <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0'
                    align='center'>
                    <tbody>
                        <tr>
                            <td style='padding:10px;font-family:'Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px'
                                align='left' valign='top' width='400'> 
                                    <br> E-mail corporativo do professor: <br> {$email_gerado} 
                                    <br> CPF: <br> {$cpfProfessor} 
                                </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                        <tbody>
                            <tr>
                                <td style='padding:30px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='center' valign='top' width='400'>
                                    <table style='border-radius:4px' border='0' width='200' cellspacing='0' cellpadding='0' >
                                        <tbody>
                                            <tr>
                                                <a class='btn btn-info my-1 buttoesMargin' href= '{$link}'    role='button' 
                                                style='border-radius: 20px; background-color:  #4278d4; color: white; font-weight: bold; 
                                                width: auto; height: auto; padding: 5px 30px 5px 30px;'>
                                                    Acessar o SIG
                                                </a>

                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p>Ou através deste link:
                        <a href= '{$link}'  > Acessar o SIG </a>
                    </p>
                <td style='padding:10px;max-width:200px' align='center' valign='top' width='200'></td>
            </tr>
        </tbody>
    </table>
    </td>";

    $consulta[0] = $mailTitle;
    $consulta[1] = $mailBody;

    return $consulta;
}



function Email_AlterarSenha($email_destinatario, $nome, $id)
{

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'tiago_cesar_6@hotmail.com';                     //SMTP username
        $mail->Password   = 'batatinha@67';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('tiago_cesar_6@hotmail.com', 'SENAC Termo de aceite');
        $mail->addAddress($email_destinatario, $nome);     //Add a recipient

        //Content
        $mail->CharSet = 'UTF-8';                            //Acentuations
        $mail->Encoding = 'base64';
        $mail->isHTML(true);                                  //Set email format to HTML       
        $mail->Subject = 'Redefinir a senha da sua conta || Sistema Termo de compromisso ';
        $link = "https://www5.pe.senac.br/Termo-de-compromisso/src/Email/alterar_senha.php?id=" . $id;
        $mail->Body    =   '

        <td style="padding:15px" align="center" valign="top">
            <table style="max-width:600px;width:100%" border="0" width="600" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                    <tr>
                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece" align="left" valign="top" bgcolor="#FFFFFF" width="400">
                            <table style="max-width:400px;width:100%; background: #3c70ca;" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                            <img style="padding:20px" src="https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png" alt="Logo Senac - Pesquisa Egressos - Ativar imagens" width="130" class="CToWUd" data-bit="iit">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <h3 align="center"> Sistema TERMO DE COMPROMISSO</h3>
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px" align="left" valign="top" width="400">
                                        Olá,' . $nome . '. Caso não identifique o propósito deste e-mail desconsidere-o.  </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>

                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="left" valign="top" width="400">
                                        Recebemos uma solicitação para redefinir a senha da sua conta. Para redefinir sua senha, clique no link abaixo e siga as instruções.  </td>
                                       
                                    </tr>
                                </tbody>
                            </table>
                            <br>

                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="left" valign="top" width="400">
                                        Se você não fez isso, simplesmente ignore este e-mail. </td>
                                       
                                    </tr>
                                </tbody>
                            </table>
                            <br>

                           

                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="left" valign="top" width="400"></td>
                                    </tr>
                                </tbody>
                            </table>

							<br>
                            <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding:30px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                            <table style="border-radius:4px" border="0" width="200" cellspacing="0" cellpadding="0" >
                                                <tbody>
                                                    <tr>
                                                        <a class="btn btn-info my-1 buttoesMargin" href= ' . $link . '    role="button" 
                                                        style="border-radius: 20px; background-color:  #4278d4; color: white; font-weight: bold; 
                                                        width: auto; height: auto; padding: 5px 30px 5px 30px;">
                                                            Trocar senha
                                                        </a>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>Ou através deste link:
                                <a href= ' . $link . '  > Trocar senha </a>
                            </p>
                        </td>


                        <td style="padding:10px;max-width:200px" align="center" valign="top" width="200"></td>
                    </tr>
                </tbody>
            </table>

        </td>

        ';

        $mail->send();
        return 'E-mail de alteração de senha enviado!';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


function consulta_AlterarSenha($nome, $id)
{
    $mailTitle = 'Redefinir a senha da sua conta || Sistema Termo de compromisso';
    $link = "https://www5.pe.senac.br/Termo-de-compromisso/src/Email/alterar_senha.php?id=" . $id;

    $mailBody    = "<td style='padding:15px' align='center' valign='top'>
            <table style='max-width:600px;width:100%' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
                <tbody>
                    <tr>
                        <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece' align='left' valign='top' bgcolor='#FFFFFF' width='400'>
                            <table style='max-width:400px;width:100%; background: #3c70ca;' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                                <tbody>
                                    <tr>
                                        <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='center' valign='top' width='400'>
                                            <img style='padding:20px' src='https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png' alt='Logo Senac - Pesquisa Egressos - Ativar imagens' width='130' class='CToWUd' data-bit='iit'>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                                <h3 align='center'> Sistema TERMO DE COMPROMISSO</h3>
                                <tbody>
                                    <tr>
                                        <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px' align='left' valign='top' width='400'>
                                        Olá," . $nome . ". Caso não identifique o propósito deste e-mail desconsidere-o.  </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>

                            <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                                <tbody>
                                    <tr>
                                        <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='left' valign='top' width='400'>
                                        Recebemos uma solicitação para redefinir a senha da sua conta. Para redefinir sua senha, clique no link abaixo e siga as instruções.  </td>
                                       
                                    </tr>
                                </tbody>
                            </table>
                            <br>

                            <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                                <tbody>
                                    <tr>
                                        <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='left' valign='top' width='400'>
                                        Se você não fez isso, simplesmente ignore este e-mail. </td>
                                       
                                    </tr>
                                </tbody>
                            </table>
                            <br>

                           

                            <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                                <tbody>
                                    <tr>
                                        <td style='padding:10px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='left' valign='top' width='400'></td>
                                    </tr>
                                </tbody>
                            </table>

							<br>
                            <table style='max-width:400px;width:100%' border='0' width='400' cellspacing='0' cellpadding='0' align='center'>
                                <tbody>
                                    <tr>
                                        <td style='padding:30px;font-family:' Trebuchet MS',Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px' align='center' valign='top' width='400'>
                                            <table style='border-radius:4px' border='0' width='200' cellspacing='0' cellpadding='0' >
                                                <tbody>
                                                    <tr>
                                                        <a class='btn btn-info my-1 buttoesMargin' href= " . $link . "    role='button' 
                                                        style='border-radius: 20px; background-color:  #4278d4; color: white; font-weight: bold; 
                                                        width: auto; height: auto; padding: 5px 30px 5px 30px;'>
                                                            Trocar senha
                                                        </a>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>Ou através deste link:
                                <a href= " . $link . "  > Trocar senha </a>
                            </p>
                        </td>


                        <td style='padding:10px;max-width:200px' align='center' valign='top' width='200'></td>
                    </tr>
                </tbody>
            </table>

        </td>";

    $consulta[0] = $mailTitle;
    $consulta[1] = $mailBody;

    return $consulta;
}


// Email_CriarEmail('tiagolopes@pe.senac.br', 'Tiago', 'Tiagão' , 2);

// Email_AceiteTermos('tiagocesar68@gmail.com', 'Tiago', 24 , "Tiagoooo");

//Email_fimDoProcesso('tiagolopes@pe.senac.br', 'Tiago', 'Huguinho');

//Email_InformacoesColaborador('tiagocesar68@gmail.com', 'Tiago', 'TIAGO CÉSAR DA SILVA LOPES' , 'tiagolopes@pe.senac.br');

// Email_InformacoesColaborador_apenasEmail('tiagocesar68@gmail.com', 'Tiago', 'tiagão@gmail.com', 'tiago2354');

// EmailFinal_CodigoEtica_Colaborador('tiagocesar68@gmail.com', 'Tiago');

// EmailFinal_CodigoEtica_RH('tiagolopes@pe.senac.br', 'Tiago César', '12345678910', 'tiago@gmail.com');

// Email_AlterarSenha('tiagocesar68@gmail.com' , 'Tiago' , 1);

// Email_InformacoesColaborador_contaRedeEmail('tiagocesar68@gmail.com' , 'Tiago' , 'tiagolopes@pe.senac.br' , 'senac2020');

// Email_atualizacaoSIG('tiagocesar68@gmail.com' , 'Tiago César' , 'tiagolopes@pe.senac.br' , '71240924429');


// Email_AceiteCodigoEtica('tiagocesar68@gmail.com', 'Tiago', 8, 'Tiagão' );

// Email_CodigoEtica_RHComPDF('tiagocesar68@gmail.com', 'Tiago César da Silva Lopes', 'comprovante codigo etica TIAGO CESAR DA SILVA LOPES 10-10-2023 - 15-33' );


// /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
// * │                                Envio_Emails 's section                                                        │
// * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
// */
// require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";
// require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Envio_emails_repositorio.php";

// use model\Envio_emails_repositorio;

// $Envio_emails_repositorio = new Envio_emails_repositorio();



// // 2ª e-mail: para a GTI SISTEMAS solicitando atualização do registro do professor no SIG
//     $consultaEmail = consulta_AtualizacaoSig('MARIA DE FATIMA SILVA','maria.fatima@pe.senac.br', '36664944472' );

//     $email_destinatario = "gti-sistemas@pe.senac.br";
//     $de = "naoresponda@pe.senac.br";
//     $para = $email_destinatario;
//     $cc = "";


//     $assunto = $consultaEmail[0];
//     $conteudo = str_replace("'", "''", $consultaEmail[1]);


//     $Envio_emails_repositorio->cadastro(
//       $de,
//       $para,
//       $cc,
//       $assunto,
//       $conteudo,
//       '1134'
//     );