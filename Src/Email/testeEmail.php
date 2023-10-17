<?php
$id = 10;


$link = "https://www5.pe.senac.br//Senac-Aceite/src/Email/confirmar_leitura.php?id=" . $id; 
echo $link;

$texto = '



<td style="padding:15px" align="center" valign="top">
    <table style="max-width:600px;width:100%" border="0" width="600" cellspacing="0" cellpadding="0" align="center">
        <tbody>
            <tr>
                <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px;background-color:rgba(255,255,255,0.8);border:solid 1px #cecece" align="left" valign="top" bgcolor="#FFFFFF" width="400">
                    <table style="max-width:400px;width:100%; background: #3c70ca;" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                        <tbody>
                            <tr>
                                <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="center" valign="top" width="400">
                                    <img style="padding:20px" src="https://www5.pe.senac.br/Senac-Aceite/Assets/Img/senac_logo_branco.png" alt="Logo Senac - Pesquisa Egressos - Ativar imagens" width="130" class="CToWUd" data-bit="iit">
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                        <h3 align="center"> Sistema Termos de Aceite</h3>
                        <tbody>
                            <tr>
                                <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:20px;max-width:400px" align="left" valign="top" width="400">Solicitamos o seu aceite dos termos de
                                    uso!</td>
                            </tr>
                        </tbody>
                    </table>

                    <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                        <tbody>
                            <tr>
                                <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="left" valign="top" width="400">Agradecemos por ter escolhido o Senac e
                                    é um imenso prazer te ter na nossa equipe. Esperamos que a sua contribuição e
                                    experiência seja positiva. </td>
                            </tr>
                        </tbody>
                    </table>

                    <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                        <tbody>
                            <tr>
                                <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="left" valign="top" width="400">Agora queremos que você confirme a sua
                                    leitura e confirme a concordância com os termos de aceite para que possamos
                                    finalizar o seu processo de criação de e-mail e liberação de acesso aos seus sistemas . </td>
                            </tr>
                        </tbody>
                    </table>

                    <table style="max-width:400px;width:100%" border="0" width="400" cellspacing="0" cellpadding="0" align="center">
                        <tbody>
                            <tr>
                                <td style="padding:10px;font-family:" Trebuchet MS",Helvetica,sans-serif;color:#000000;font-size:16px;max-width:400px" align="left" valign="top" width="400">Para confirmar o seu aceite dos termo,
                                    clique no botão abaixo ou no link. </td>
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
                                                <a class="btn btn-info my-1 buttoesMargin" href=' . $link . '  role="button" 
                                                style="border-radius: 20px; background-color:  #4278d4; color: white; font-weight: bold; 
                                                width: auto; height: auto; padding: 5px 30px 5px 30px;">
                                                    Confirmar leitura
                                                </a>

                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p>Ou através deste link:
                        <a href= ' . $link . ' > Confirmar leitura </a>
                    </p>
                </td>
                <td style="padding:10px;max-width:200px" align="center" valign="top" width="200"></td>
            </tr>
        </tbody>
    </table>

</td>


<h3> https://www5.pe.senac.br//Senac-Aceite/src/Email/confirmar_leitura.php?id= ' . $id; ' </h3>

';


echo $texto;