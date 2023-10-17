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
 * ║  │ @date: 20/10/2022                                                                                           │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 * ║                                                     UPGRADES                                                      ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 1. @date: 06/01/23                                                                                          │  ║
 * ║  │    @description: Update to Colaborador                                                                      │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 2. @date: 17/01/23                                                                                          │  ║
 * ║  │    @description: Update the design of the website                                                           │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 2. @date: 20/01/23                                                                                          │  ║
 * ║  │    @description: Update the Colaborador's time                                                              │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║                                                                                                                   ║ 
 * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
 */
require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";

//Colaborador's section
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador_repositorio.php";

use model\Colaborador;
use model\Colaborador_repositorio;

$Colaborador = new Colaborador();
$Colaborador_repositorio = new Colaborador_repositorio();


//Variables

if (isset($_GET['id']) == null) {
  //echo "Voce não precisa confirmar os termos";
  $codigoCriptografado = null;
} else {
  //Função Trim tira o espaço que está vindo
  $codigoCriptografado = trim($_GET['id'] ?? $_POST['id']);
}


$validacao = null;

if (isset($_POST['cpf']) == null) {
  $cpf = null;
} else {
  $cpf = $_POST['cpf'];

  //Verificando 
  $Colaborador = $Colaborador_repositorio->consultaByCPF($cpf);

  if ($Colaborador == null) {
    $validacao = "CPF INVALIDO";
  } else {
    $validacao = "CPF VALIDADO";

    // Pega o cpf digitado e consulta: se o id com criptografia da consulta for igual ao id que veio no link, então validou
    $idDigitado_criptografia = hash('sha1', $Colaborador->getId());

    if ($idDigitado_criptografia == $codigoCriptografado) {
      $validacao = "CPF DO RESPECTIVO COLABORADOR";
    }
  }
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

      if ($cpf != null && ($validacao != null && $validacao == "CPF DO RESPECTIVO COLABORADOR")) {
      ?>
        <li><a id="username_Aceite" > Colaborador: <?php echo $Colaborador->getNome(); ?> </a></li>
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
              <h2 class="content_inicioText">Aceite do termo de compromisso</h2>
              <h5 class="content_textLeft"> Daremos continuidade com o seu processo de criação de e-mail institucional do Senac. Leia as informações abaixo e logo após clique em confirmar o aceite do termo. </h5>

            </div>
          </div>
        </article>


        <article class="card content_textLeft">
          <?php
          $link = "confirmar_leitura.php?id= " .  $codigoCriptografado;
          if ($cpf == null) {
          ?>
            <form action="<?php echo $link; ?>" method="POST">
              <h5>Por favor, informe o seu CPF para começarmos o processo:</h5>

              <div class="form-floating">
                <input type="text" maxlength="11" class="form-control" name="cpf" id="unidade" placeholder="CPF:">
                <label for="floatingPassword">CPF:</label>
              </div>

              <br>
              <button type="submit" class="btn btn-danger">Confirmar</button>
            </form>

            <?php
          } else {

            //CPF digitado na consulta resultou nulo
            if ($validacao == "CPF INVALIDO") {
            ?>
              <form action="<?php echo $link; ?>" method="POST">
                <h5>CPF não encontrado. Por favor, tente digitar o seu CPF novamente</h5>

                <br>
                <button type="submit" class="btn btn-danger">Tentar de novo</button>
              </form>
              <?php
            } else {


              // Pega o cpf digitado e consulta: se o id com criptografia da consulta for igual ao id que veio no link, então validou
              $idDigitado_criptografia = hash('sha1', $Colaborador->getId());

              if ($idDigitado_criptografia != $codigoCriptografado) {
              ?>
                <form action="<?php echo $link; ?>" method="POST">
                  <h5>CPF incorreto. Por favor, tente digitar o seu CPF novamente</h5>

                  <br>
                  <button type="submit" class="btn btn-danger">Tentar de novo</button>
                </form>
              <?php
              } else {
              ?>
                <form action="confirmar_leitura2.php" method="POST">
                  <input type="hidden" class="form-control my-2" value="<?php echo $Colaborador->getNome(); ?>" name="NomeSobrenome" id="NomeSobrenome" placeholder="Nome e Sobrenome">
                  <input type="hidden" value="<?php echo $Colaborador->getId(); ?>" name="codigo">
                  <h3 class="content_inicioText">TERMO DE COMPROMISSO DO USO DOS RECURSOS DE TI</h3>

                  <br>
                  <div class="row g-0 text-center">
                    <div class="col-sm-6 col-md-6">
                      <h5>Identificação do Funcionário</h5>
                    </div>

                    <div class="col-sm-6 col-md-6">
                      <h6>Data: <?php echo  date('d/m/Y'); ?> </h6>
                    </div>
                  </div>

                  <br>
                  <div class="form-floating">
                    <input type="text" class="form-control" value="<?php echo $Colaborador->getUnidade()->getNome(); ?>" disabled id="unidade" placeholder="Unidade:">
                    <label for="floatingPassword">Unidade:</label>
                  </div>

                  <br>
                  <div class="form-floating">
                    <input type="text" class="form-control" value="<?php echo $Colaborador->getChapa(); ?>" disabled id="matricula" placeholder="Matricula:">
                    <label for="floatingPassword">Matrícula:</label>
                  </div>

                  <div class="form-floating">
                    <input type="text" class="form-control" value="<?php echo $Colaborador->getCpf(); ?>" disabled id="cpf" placeholder="CPF:">
                    <label for="floatingPassword">CPF:</label>
                  </div>

                  <div class="form-floating">
                    <input type="text" class="form-control" value="<?php echo $Colaborador->getNome(); ?>" disabled id="nomeCompleto" placeholder="Nome Completo">
                    <label for="floatingPassword">Nome completo</label>
                  </div>


                  <br>
                  <div class="form-floating">
                    <input type="text" class="form-control" value="<?php echo $Colaborador->getHorarioTrabalho(); ?>" disabled id="horarioTrabalho" placeholder="Horário de trabalho">
                    <label for="floatingPassword">Horário de trabalho</label>
                  </div>


                  <br>
                  <h5> Comprometo-me a:</h5>

                  <br>
                  <ol class="list-group list-group-numbered">
                    <li class="list-group-item">Seguir as orientações da Política de Segurança e as Normas e Padrões vigentes na execução das minhas atividades. </li>
                    <li class="list-group-item">Não acessar sites indevidos, que possam comprometer a segurança das informações da instituição <b> SENAC-PE </b> .</li>
                    <li class="list-group-item">Não revelar fora do âmbito profissional, fato ou informações de qualquer natureza que tenha conhecimento devido a minhas atribuições, salvo em decorrência de decisão competente do superior hierárquico.</li>
                    <li class="list-group-item">Acessar as informações institucionais apenas por necessidade de serviço e por determinação expressa do superior hierárquico. </li>
                    <li class="list-group-item">Ser cauteloso(a) quanto a exibição de informações sigilosas e confidenciais em qualquer mídia eletrônica. </li>
                    <li class="list-group-item">Garantir a segurança e integridade dos dados pessoais, sistemas e equipamentos que fazem parte do escopo das minhas atividades.  </li>
                    <li class="list-group-item">Responsabilizar-me pelo conteúdo dos e-mails enviados e crítico quanto ao conteúdo de e-mails recebidos.</li>
                    <li class="list-group-item">Evitar o acesso de pessoas não autorizadas a sessão de uso do computador encerrando-a ao ausentar-me do ambiente de trabalho. </li>
                    <li class="list-group-item">Não divulgar a minha senha a outras pessoas pela premissa de que a senha de acesso ao computador é pessoal e intransferível. </li>
                    <li class="list-group-item">Não escrever a minha senha. Sempre memorizada.</li>
                    <li class="list-group-item">Sobre nenhuma hipótese ou pretexto devo procurar descobrir a(s) senha(s) de outra(s) pessoa(s). </li>
                    <li class="list-group-item">Alterar periodicamente minhas senhas, obedecendo aos critérios de senha segura da rede e dos sistemas, reduzindo assim os riscos de uma possível utilização da mesma por outros colaboradores. </li>
                    <li class="list-group-item">Usar os acessos da rede corporativa, computadores, internet, sistemas, telefonia etc, exclusivamente, para uso profissional na execução e desempenho dos objetivos da instituição.   </li>
                    <li class="list-group-item"> Responder em todas as instâncias, pelas consequências das ações ou omissões de minha parte que possam por em risco ou comprometer a exclusividade de conhecimento da minha senha ou das transações a que tenho acesso. </li>
                    <li class="list-group-item">Não mover/transferir equipamentos de propriedade da instituição, exceto, se houver autorização expressa seguindo as normas de transferências de bens da Gerência de Serviços Gerais.  </li>
                  </ol>

                  <br>
                  <h5>Declaro estar ciente das determinações acima, compreendendo que quaisquer descumprimentos dessas regras podem implicar na aplicação das sansões disciplinares cabíveis. </h5>

                  <BR>
                  <p class="content_inicioText">Serviço Nacional de Aprendizagem Comercial - Departamento Regional de Pernambuco <br>
                    Avenida Visconde de Suassuna, 500 • Santo Amaro • CEP 50.050-540 <br>
                    Recife / PE • Tel.: 0800 081 1688 • <a href="https://www.pe.senac.br" target="_blank">www.pe.senac.br </a>
                  </p>

                  <br>
                  <div class="container px-4 text-center">
                    <div class="row gx-5">
                      <div class="col">
                        <a class="btn btn-secondary" onclick="window.print()">Imprimir este documento</a>
                      </div>
                      <div class="col">
                        <!-- Button trigger modal -->
                        <a class="btn btn-danger" data-bs-toggle="modal" id="" data-bs-target="#exampleModal">Confirmo e aceito</a>
                      </div>
                    </div>

                    <br>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">

                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmar aceite dos termos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>

                          <div class="modal-body">
                            Por favor, leia os termos atentamente antes de confirmar a aceitação.
                            Deseja confirmar o aceitamento destes termos?
                          </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" id="botaoConfirmar" onclick="DisableButton()" class="btn btn-danger">Confirmar</button>
                          </div>

                        </div>
                      </div>
                    </div>
                </form>
              <?php
              }
              ?>

          <?php
            }
          }
          ?>

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

      <script>
        function DisableButton() {
          document.getElementById("botaoConfirmar").style.display = "none";
        }
      </script>

</body>

</html>