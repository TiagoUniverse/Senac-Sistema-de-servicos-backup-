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
 * ║  │ @description: Tela de solicitação de aceite do código de ética                                              │  ║
 * ║  │ @class: Solicitar codigo etica                                                                              │  ║
 * ║  │ @dir: View/                                                                                                 │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 04/10/23                                                                                             │  ║
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

//Validação do CPF
require_once "Recursos/CpfValidacao.php";

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                TOTVS 's section                                                               │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\TOTVS.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\TOTVS_repositorio.php";

use model\TOTVS;
use model\TOTVS_repositorio;

$TOTVS = new TOTVS();
$TOTVS_repositorio = new TOTVS_repositorio();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                       CodigoEtica_Colaborador' section                                        │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\CodigoEtica_Colaborador_repositorio.php";

use model\CodigoEtica_Colaborador_repositorio;

$CodigoEtica_Colaborador_repositorio = new CodigoEtica_Colaborador_repositorio();


/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Variables                                                                      │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

if (isset($_POST['colaborador_cpf']) == false) {
  $colaborador_cpf = null;
} else {
  $colaborador_cpf = $_POST['colaborador_cpf'] ?? $_GET['colaborador_cpf'];

  $retorno = $TOTVS_repositorio->CPF_existe($colaborador_cpf);

  //Se o CPF existe no BD de TOTVS, consulte essa informação e coloque num objeto
  if ($retorno) {
    $TOTVS = $TOTVS_repositorio->ConsultaByCPF($colaborador_cpf);
  }
}

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Validar se já existe algum colaborador com este cpf                            │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

$validaCpf = $CodigoEtica_Colaborador_repositorio->consultar_CPF($colaborador_cpf);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Solicitação de código de ética</title>
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
  //Permissão para acessar esta tela
  require_once "Recursos/Navegacao.php";

  //Niveis de acesso disponíveis para acessar a página atual
  $NivelAcesso_disponivel = array(
    1, 2
  );

  valida_acesso($NivelAcesso_disponivel);
  ?>

  <?php
  if (isset($_POST['colaborador_cpf']) == null || !validaCPF($colaborador_cpf)) {
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
          <a href="codigo etica_tela-inicial.php">Voltar</a>
          <div class="row g-0 text-center">
            <div class="col-6 col-md-4">
              <img src="../../Assets/Img/justica.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
            </div>
            <div class="col-sm-6 col-md-8" id="content_inicio">
              <h2 class="content_inicioText">Solicitação de código de ética</h2>
              <br>
              <h4 class="content_textLeft">Preencha o formulário abaixo. Os campos com "*" são obrigatórios. </h4>
            </div>
          </div>
        </article>

        <article class="card content_textLeft">

          <?php

          if ($colaborador_cpf == null) {
          ?>
            <form action="Solicitar codigo etica.php" method="POST">
              <h5>Primeiramente, informe o CPF do colaborador:</h5>
              <div class="form-floating">
                <label for="validationCustom01" class="form-label">CPF*:</label>
                <input type="text" maxlength="11" value="" class="form-control" name="colaborador_cpf" id="formulario_entrada" required>
                <div class="valid-feedback">
                  Muito bem!
                </div>
              </div>

              <br>
              <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>

            <?php
          } else {

            if (!validaCPF($colaborador_cpf)) {
            ?>
              <div class="alert alert-danger" role="alert">
                <h5>CPF digitado inválido. Por favor, digite um CPF válido!</h5>
              </div>
              <?php
            } else {
              //CPF VÁLIDO

              if ($validaCpf != null) {
              ?>
                <div class="alert alert-warning" role="alert">
                  <h5>Esse CPF já está cadastrado para um colaborador. Por favor, tente novamente ou verifique esta solicitação na lista de processos.</h5>
                </div>
              <?php
              } else if ($retorno == false) {
              ?>
                <div class="alert alert-warning" role="alert">
                  <h5>O CPF digitado não foi encontrado no banco de dados do TOTVS. Dessa forma, por favor preencha o formulário abaixo </h5>
                </div>
                <form action="Solicitar codigo etica2.php" method="post" class="was-validated">
                  <!-- The code from the Collaborator-->

                  <input name="data_totvs" value="false" type="hidden"> </input>
                  <input name="cpf" value="<?php echo $_POST['colaborador_cpf']; ?>" type="hidden"> </input>


                  <br>
                  <h5>Informações pessoais</h5>
                  <div class="form-floating">
                    <label for="validationCustom01" class="form-label">Nome completo*:</label>
                    <input type="text" class="form-control" value="" name="nomeCompleto" id="formulario_entrada" required>
                    <div class="valid-feedback">
                      Muito bem!
                    </div>
                    <div class="invalid-feedback">Por favor, insira o nome do colaborador.</div>
                  </div>


                  <div class="form-floating">
                    <label for="validationCustom01" class="form-label">CPF*:</label>
                    <input type="text" maxlength="11" value="<?php echo $colaborador_cpf; ?>" class="form-control" name="cpf" id="formulario_entrada" disabled required>
                    <div class="valid-feedback">
                      Muito bem!
                    </div>
                  </div>


                  <div class="form-floating">
                    <label for="validationCustom01" class="form-label">Email pessoal*:</label>
                    <input type="email" class="form-control" value="" name="email_pessoal" id="formulario_entrada" required>
                    <div class="valid-feedback">
                      Muito bem!
                    </div>
                    <div class="invalid-feedback">Por favor, insira o email do colaborador.</div>

                  </div>

                  <div class="form-floating">
                    <label for="validationCustom01" class="form-label">Telefone*:</label>
                    <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" maxlength="15" value="" class="form-control" name="telefone" id="formulario_entrada" required>
                    <div class="valid-feedback">
                      Muito bem!
                    </div>
                    <div class="invalid-feedback">Por favor, insira o telefone deste colaborador.</div>
                  </div>

                  <br>
                  <!-- Button trigger modal -->
                  <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="EnableButton()" id="button_expanded">Solicitar novo colaborador</a>

                  <!-- Modal -->
                  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">

                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Confirmar cadastro</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                          Por favor, verifique as informações digitadas e confirme se estão digitadas corretamente.
                          Deseja
                          confirmar este cadastro?
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                          <button type="submit" id="botaoConfirmar" onclick="DisableButton()" class="btn btn-primary">Cadastrar</button>
                        </div>

                      </div>
                    </div>
                  </div>

                </form>
              <?php
              } else {


                /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
                * │                                Formulário com informações vindas do Banco de dados                            │
                * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
                */

              ?>
                <form action="Solicitar codigo etica2.php" method="post" class="was-validated">
                  <!-- The code from the Collaborator-->
                  <input name="nomeCompleto" value="<?php echo $TOTVS->getNome(); ?>" type="hidden"> </input>
                  <input name="cpf" value="<?php echo $TOTVS->getCpf(); ?>" type="hidden"> </input>
                  <!-- <input name="matricula" value="<?php echo $TOTVS->getChapa(); ?>" type="hidden"> </input> -->
                  <!-- <input name="funcao" value="<?php echo $TOTVS->getCargo(); ?>" type="hidden"> </input> -->

                  <h5>Informações pessoais</h5>
                  <div class="form-floating">
                    <label for="validationCustom01" class="form-label">Nome completo*:</label>
                    <input type="text" class="form-control" value="<?php echo $TOTVS->getNome(); ?>" name="nomeCompleto" id="formulario_entrada" disabled required>
                    <div class="valid-feedback">
                      Muito bem!
                    </div>
                  </div>


                  <div class="form-floating">
                    <label for="validationCustom01" class="form-label">CPF*:</label>
                    <input type="text" maxlength="11" value="<?php echo $TOTVS->getCpf(); ?>" class="form-control" name="cpf" id="formulario_entrada" disabled required>
                    <div class="valid-feedback">
                      Muito bem!
                    </div>
                  </div>

                 

                  <div class="form-floating">
                    <label for="validationCustom01" class="form-label">Email pessoal*:</label>
                    <input type="email" class="form-control" value="<?php echo $TOTVS->getEmail(); ?>" name="email_pessoal" id="formulario_entrada" required>
                    <div class="valid-feedback">
                      Muito bem!
                    </div>
                    <div class="invalid-feedback">Por favor, insira o email pessoal do colaborador.</div>
                  </div>

                  <div class="form-floating">
                    <label for="validationCustom01" class="form-label">Telefone*:</label>
                    <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" maxlength="15" value="<?php echo $TOTVS->getTelefone(); ?>" class="form-control" name="telefone" id="formulario_entrada" required>
                    <div class="valid-feedback">
                      Muito bem!
                    </div>
                    <div class="invalid-feedback">Por favor, insira um número de telefone válido.</div>
                  </div>

                  <br>

                  <!-- Button trigger modal -->
                  <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="EnableButton()" id="button_expanded">Solicitar aceite do código de ética</a>

                  <!-- Modal -->
                  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">

                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Confirmar cadastro</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                          Por favor, verifique as informações digitadas e confirme se estão digitadas corretamente.
                          Deseja
                          confirmar este cadastro?
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                          <button type="submit" id="botaoConfirmar" onclick="DisableButton()" class="btn btn-primary">Cadastrar</button>
                        </div>

                      </div>
                    </div>
                  </div>

                </form>
          <?php
              }
            }
          }
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
        function DisableButton() {
          document.getElementById("botaoConfirmar").style.display = "none";
        }

        function EnableButton() {
          document.getElementById("botaoConfirmar").style.display = "block";
        }
      </script>

      <script>
        if ('serviceWorker' in navigator) {
          navigator.serviceWorker.register('/Termo-de-compromisso/sw.js', {
            scope: '/Termo-de-compromisso/'
          });
        }
      </script>

</body>

</html>