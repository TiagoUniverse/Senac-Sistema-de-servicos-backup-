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
* ║  │ @description: View of information from the 'Colaborador' class                                              │  ║
* ║  │ @class: Colaborador-SuporteGTI-consultar                                                                    │  ║
* ║  │ @dir: Html Website/                                                                                         │  ║
* ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
* ║  │ @date: 16/11/22                                                                                             │  ║
* ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
* ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
* ║                                                     UPGRADES                                                      ║
* ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
* ║  │ 1. @date: 13/02/23                                                                                          │  ║
* ║  │    @description: Usando Id criptografado nos links                                                          │  ║
* ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
* ║                                                                                                                   ║
* ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
*/

//O nome é ID, mas na verdade ele vai verificar o id criptografado no banco de dados
//Data: 13/02/23
$codigo = $_POST['id'] ?? $_GET['id'];

require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";

require_once "Recursos/ValidaNivelDeAcesso.php";
ta_conectado();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Colaborador 's section                                                         │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Colaborador_repositorio.php";

use model\Colaborador;
use model\Colaborador_repositorio;

$Colaborador = new Colaborador();
$Colaborador_repositorio = new Colaborador_repositorio();

$Colaborador = $Colaborador_repositorio->consultarByIdCriptografado($codigo);


/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Timeline 's section                                                            │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Timeline.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Timeline_repositorio.php";

use model\Timeline;
use model\Timeline_repositorio;

$Timeline = new Timeline();
$Timeline_repositorio = new Timeline_repositorio();

$Timeline = $Timeline_repositorio->consultaByColaboradorID($Colaborador->getId());

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar email</title>
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
  <link rel="stylesheet" href="../../Assets/Css/components/Table.css" />

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
  if ($Colaborador == false || $Colaborador == null || $Timeline->getStatusTimeline()->getId() != 2) {
  ?>
    <div class="row" style="background-color: white; height:19.3cm; ">
    <?php
  } else {
    ?>
      <div class="row" style="background-color: white; ">
      <?php
    }
      ?>

      <section>
        <article class="card">
          <a href="Criacao-email_tela-inicial.php">Voltar</a>
          <div class="row g-0 text-center">
            <div class="col-6 col-md-4">
              <img src="../../Assets/Img/funcionarios.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
            </div>
            <div class="col-sm-6 col-md-8" id="content_inicio">
              <h2 class="content_inicioText">Criação do e-mail do colaborador</h2>
              <h5 class="content_inicioText">Utilize estas informações para criar um novo e-mail institucional no seu sistema</h5>
            </div>
          </div>
        </article>

        <?php
        if ($Colaborador == false || $Colaborador == null) {
          $_SESSION['criar_email'] = "finalizado";
        ?>
          <article class="card content_textLeft">
            <h5>Colaborador não encontrado com o código identificador.</h5>
          </article>
          <?php
        } else {

          if ($Timeline->getStatusTimeline()->getId() != 2) {
            $_SESSION['criar_email'] = "finalizado";
          ?>
            <article class="card content_textLeft">
              <h5>Colaborador não está na fase de criação de e-mail institucional. </h5>
            </article>
          <?php
          } else {
          ?>
            <article class="card content_textLeft">
              <form action="Criar_email2.php" method="POST">
                <input type="hidden" value="<?php echo $Colaborador->getId(); ?>" name="idColaborador">
                <input type="hidden" value="<?php echo $Colaborador->getNome(); ?>" name="nome_colaborador">
                <input type="hidden" value="<?php echo $Colaborador->getEmail_pessoal(); ?>" name="emailPessoal_colaborador">
                <input type="hidden" value="<?php echo $Colaborador->getCpf(); ?>" name="cpf_Colaborador">

              
                <?php
                if ($Colaborador->getFuncao() == "INSTRUTOR" 
                || $Colaborador->getFuncao() == "PROFESSOR CONVIDADO" 
                || $Colaborador->getFuncao() == "PROFESSOR ASSISTENTE" 
                || $Colaborador->getFuncao() == "PROFESSOR ASSISTENTE I" 
                || $Colaborador->getFuncao() == "PROFESSOR ASSISTENTE II" 
                || $Colaborador->getFuncao() == "PROFESSOR VISITANTE"
                || $Colaborador->getFuncao() == "PROFESSOR ADJUNTO"
                || $Colaborador->getFuncao() == "PROFESSOR DO ENSINO MÉDIO"
                || $Colaborador->getFuncao() == "PROFESSOR SUBSTITUTO"
                
                ) {
                ?>
                  <div class="alert alert-warning" role="alert">
                    <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/exclamation-triangle.svg">
                    Aviso: Crie apenas o e-mail para colaboradores que são professores.
                  </div>
                <?php
                } else {
                ?>
                  <div class="alert alert-info" role="alert">
                    <img src="../../Assets/Icons/node_modules/bootstrap-icons/icons/exclamation-triangle.svg">
                    Aviso: Crie o e-mail e a conta da rede deste colaborador.
                  </div>
                <?php
                }
                ?>



                <div class="form-floating">
                  <input type="text" class="form-control" value="<?php echo $Colaborador->getNome(); ?>" disabled id="nomeCompleto" placeholder="Nome Completo do colaborador">
                  <label for="floatingPassword">Nome completo do colaborador</label>
                </div>

                <div class="form-floating">
                  <input type="text" class="form-control" value="<?php echo $Colaborador->getUnidade()->getNome(); ?>" disabled id="unidade" placeholder="Unidade do colaborador">
                  <label for="floatingPassword">Unidade do colaborador</label>
                </div>

                <br>
                <div class="form-floating">
                  <input type="text" class="form-control" value="<?php echo $Colaborador->getMotivo_solicitacao(); ?>" disabled id="motivoEscolha" placeholder="Motivo da solicitação do e-mail:">
                  <label for="floatingPassword">Motivo da solicitação do e-mail:</label>
                </div>


                <div class="form-floating">
                  <input type="text" class="form-control my-2" value="<?php echo $Colaborador->getFuncao(); ?>" disabled id="funcao" placeholder="Função">
                  <label for="floatingPassword">Função</label>
                </div>


                  <br>
                  <div class="form-floating">
                    <input type="text" class="form-control" value="<?php echo $Colaborador->getHorarioTrabalho(); ?>" disabled id="horarioTrabalho" placeholder="Horário de trabalho">
                    <label for="floatingPassword">Horário de trabalho</label>
                  </div>


                <?php
                //Separando o nome do colaborador para sugerir um email
                $pieces = explode(" ", $Colaborador->getNome());

                //Contando a quantidade de strings
                //  echo count($pieces);

                
                $primeiroNome = $pieces[0];
                $UltimoNome = $pieces[count($pieces) - 1];

                if ($Colaborador->getFuncao() == "INSTRUTOR" 
                || $Colaborador->getFuncao() == "PROFESSOR CONVIDADO" 
                || $Colaborador->getFuncao() == "PROFESSOR ASSISTENTE" 
                || $Colaborador->getFuncao() == "PROFESSOR ASSISTENTE I" 
                || $Colaborador->getFuncao() == "PROFESSOR ASSISTENTE II" 
                || $Colaborador->getFuncao() == "PROFESSOR VISITANTE"
                || $Colaborador->getFuncao() == "PROFESSOR ADJUNTO"
                || $Colaborador->getFuncao() == "PROFESSOR DO ENSINO MÉDIO"
                || $Colaborador->getFuncao() == "PROFESSOR SUBSTITUTO"
                ) {
                  $emailSugerido = strtolower($primeiroNome . "." . $UltimoNome . "@pe.senac.br" );
                } else {
                  $emailSugerido = strtolower($primeiroNome . $UltimoNome . "@pe.senac.br" );
                }

                ?>


                <br>
                <h5>Por favor, preencha o campo abaixo com as informações geradas. O sistema irá sugerir um e-mail institucional:</h5>
                <div class="form-floating">
                  <input type="email" class="form-control my-2" value="<?php echo $emailSugerido; ?>" required name="email_institucional" id="email_institucional" placeholder="Novo Email institucional">
                  <label for="floatingPassword">Novo email institucional</label>
                </div>

                <div class="form-floating">
                  <input type="text" class="form-control my-2" value="Senac@<?php echo date("Y"); ?> " required name="senhaPadrao" id="senhapadrao" placeholder="Senha do e-mail:">
                  <label for="floatingPassword">Senha do e-mail:</label>
                </div>

                <br>
                <?php
                if ($Colaborador->getFuncao() == "INSTRUTOR" 
                || $Colaborador->getFuncao() == "PROFESSOR CONVIDADO" 
                || $Colaborador->getFuncao() == "PROFESSOR ASSISTENTE" 
                || $Colaborador->getFuncao() == "PROFESSOR ASSISTENTE I" 
                || $Colaborador->getFuncao() == "PROFESSOR ASSISTENTE II" 
                || $Colaborador->getFuncao() == "PROFESSOR VISITANTE"
                || $Colaborador->getFuncao() == "PROFESSOR ADJUNTO"
                || $Colaborador->getFuncao() == "PROFESSOR DO ENSINO MÉDIO"
                || $Colaborador->getFuncao() == "PROFESSOR SUBSTITUTO"
                ) {
                ?>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="email_apenasEmail" checked>
                    <label class="form-check-label" for="exampleRadios1">
                      Eu confirmo que criei <b>apenas</b> o e-mail deste colaborador
                    </label>
                  </div>
                  <!-- <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="email_contadeRede_Email">
                <label class="form-check-label" for="exampleRadios2">
                  Eu confirmo que criei o e-mail e a conta da rede deste colaborador
                </label>
              </div> -->
                <?php
                } else {
                ?>
                  <!-- <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="email_apenasEmail">
                <label class="form-check-label" for="exampleRadios1">
                  Eu confirmo que criei <b>apenas</b> o e-mail deste colaborador
                </label>
              </div> -->
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="email_contadeRede_Email" checked>
                    <label class="form-check-label" for="exampleRadios2">
                      Eu confirmo que criei o e-mail e a conta da rede deste colaborador
                    </label>
                  </div>
                <?php
                }
                ?>





                <!-- <div class="form-check">
                <input class="form-check-input" type="radio" name="email_apenasEmail" value="1" id="email_apenasEmail">
                <label class="form-check-label" for="exampleRadios1">
                  Eu confirmo que criei <b>apenas</b> o e-mail deste colaborador
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="email_contadeRede_Email" value="2" id="email_contadeRede_Email">
                <label class="form-check-label" for="exampleRadios2">
                  Eu confirmo que criei o e-mail e a conta da rede deste colaborador
                </label>
              </div> -->



                <br>
                <!-- Button trigger modal -->
                <a class="btn btn-danger" data-bs-toggle="modal" id="button_expanded" onclick="EnableButton()" data-bs-target="#exampleModal" id="">Confirmar criação de e-mail</a>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmar criação de e-mail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                        Por favor, verifique se as informações digitadas e confirme que estão digitadas corretamente.
                        Deseja confirmar a criação para este colaborador?
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


            </article>
          <?php
        }
          ?>



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

        function EnableButton() {
          document.getElementById("botaoConfirmar").style.display = "block";
        }
      </script>

</body>

</html>