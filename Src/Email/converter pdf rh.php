<?php

namespace Email;

// require 'C:/xampp/libraries/dompdf/vendor/autoload.php';

require '../../vendor/autoload.php';

use Dompdf\Dompdf;


function pdf_RH($nome_colaborador, $cpf, $email_colaborador, $data_Aceite)
{

    if (isset($nome_colaborador) && isset($cpf) && isset($email_colaborador) && isset($data_Aceite)) {

        $documento = "<!DOCTYPE html>
    <html>
    
    <head>
        <title>Comprovante de aceite do código de ética</title>
    </head>
    
    <body>
    
            <div style='align-items: center; display: flex; align-items: center; justify-content: center;'>
                <table style=' width: 100%; border: 0;  align-items: center;'>
                    <tbody>
                        <tr>
                            <td
                                style='padding: 10px; font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
                            font-size: 16px;  width: 400px; background-color: rgba(255, 255, 255, 0.8); border: solid;'>
                                <div style='background-color:#3c70ca; text-align: center;'>
                                    <img style='padding:20px'
                                        src='https://www5.pe.senac.br/Termo-de-compromisso/Assets/Img/senac_logo_branco.png'
                                        alt='Logo Senac - Pesquisa Egressos - Ativar imagens' width='130' class='CToWUd'
                                        data-bit='iit'>
                                </div>
                                <br><br>
                                <h4> O colaborador(a) <b> {$nome_colaborador} </b> confirmou o seu aceite do código de ética
                                    e finalizou o seu processo solicitado.</h4>
                                <h4>Segue abaixo alguma das informações
                                    do colaborador: <br>
                                    Nome: {$nome_colaborador} <br>
                                    CPF: {$cpf} <br>
                                    E-mail do colaborador: {$email_colaborador}<br>
                                    Data de aceite: {$data_Aceite}
                                </h4>
                                   
                                <br>
                                <h4>Em caso de dúvidas, entre em contato
                                    com o nosso suporte através do sistema de chamados: <br><br>
                                    <a target='_Blank' href='https://www7.pe.senac.br/taskmanager/login'
                                        style='text-align: center;'>Senac Task Manager </a>
                                    <br> <br> Para acessar o sistema de chamados, utilize o mesmo login e senha
                                    do seu email @pe.senac.br.
                                </h4>
                                <br>
                                <h5>Serviço Nacional de Aprendizagem
                                    Comercial - Departamento Regional de Pernambuco<br>
                                    Avenida Visconde de Suassuna, 500 • Santo Amaro • CEP 50.050-540<br>
                                    Recife / PE • Tel.: 0800 081 1688 • www.pe.senac.br </h5>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    
    </body>
    
    </html>";





        //**************************************************************************************************

        $dompdf = new Dompdf();

        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);


        $dompdf->loadHtml($documento);
        $dompdf->setPaper('A4', 'landscape');


        $canvas = $dompdf->getCanvas();

        // Render HTML para PDF
        $dompdf->render();

        // Nome do arquivo PDF gerado
        $hoje = date('d-m-Y - H-s'); 
        // echo $hoje;


        $nomeArquivo = "comprovante codigo etica " . $nome_colaborador . ' ' . $hoje .  '.pdf';

        // Caminho para a pasta onde você deseja salvar o arquivo PDF
        $pastaDestino = 'documentos/';

        // Verifica se a pasta de destino existe, senão cria
        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0755, true);
        }

        // Caminho completo para o arquivo PDF
        $caminhoArquivo = $pastaDestino . $nomeArquivo;

        // Salva o arquivo PDF na pasta de destino
        file_put_contents($caminhoArquivo, $dompdf->output());




        // $mensagem        = "<p>Olá,  {$nome_colaborador}.</p>
        //                         <p>Segue o seu documento assiando  <a href='https://www5.pe.senac.br/.../{$nomeArquivo}'>clique aqui</a></p>";


        // echo $mensagem;

        return $nomeArquivo;
    } else {
        echo "Error nas variáveis";
    }
}


// pdf_RH('Tiago', '1234', 'tiago@gmail.com', '12/05/12 18:00');

