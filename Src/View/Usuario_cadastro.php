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
 * ║  │ @description: Registration of the Funcionario                                                               │  ║
 * ║  │ @class: Usuario_cadastro                                                                                │  ║
 * ║  │ @dir:  View/                                                                                                │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 14/11/22                                                                                             │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 * ║                                                     UPGRADES                                                      ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ 1. @date:                                                                                                   │  ║
 * ║  │    @description:                                                                                            │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║                                                                                                                   ║
 * ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
 */

if (isset($_POST['status_cadastro']) == false) {
  $status_cadastro = null;
} else {
  $status_cadastro = $_POST['status_cadastro'];
}

require "C:\\xampp\\htdocs\\Termo-de-compromisso\\config.php";

require_once "Recursos/ValidaNivelDeAcesso.php";
ta_conectado();

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                NivelDeAcesso 's section                                                       │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\NivelDeAcesso.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\NivelDeAcesso_repositorio.php";

use model\NivelDeAcesso;
use model\NivelDeAcesso_repositorio;

$NivelDeAcesso = new NivelDeAcesso();
$NivelDeAcesso_repositorio = new NivelDeAcesso_repositorio();


$listar = $NivelDeAcesso_repositorio->listar();

$listarNivelDeAcesso = "";

foreach ($listar as $NivelDeAcesso) {
  $listarNivelDeAcesso .= "<option value='{$NivelDeAcesso->getId()}'>{$NivelDeAcesso->getNome()}</option>";
}

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
* │                                Unidade 's section                                                             │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Unidade.php";
require_once $_SESSION['URL_SYSTEM'] .  "\\src\\model\\Unidade_repositorio.php";

use model\Unidade;
use model\Unidade_repositorio;

$Unidade = new Unidade();
$Unidade_repositorio = new Unidade_repositorio();


$listar = $Unidade_repositorio->listar();

$listarUnidade = "";

if (!isset($_POST['cpf'])) {
  foreach ($listar as $Unidade) {
    $listarUnidade .= "<option value='{$Unidade->getId()}'>{$Unidade->getNome()}</option>";
  }
} else {

  $retorno = $TOTVS_repositorio->CPF_existe($_POST['cpf']);

  if ($retorno) {

    $TOTVS = $TOTVS_repositorio->ConsultaByCPF($_POST['cpf']);

    $Unidade_colaborador = $Unidade_repositorio->consultaByNome($TOTVS->getUnidade());


    foreach ($listar as $Unidade) {

      if ($Unidade_colaborador != null) {
        if ($Unidade_colaborador->getId() == $Unidade->getId()) {
          $listarUnidade .= "<option selected value='{$Unidade->getId()}'>{$Unidade->getNome()}</option>";
        } else {
          $listarUnidade .= "<option value='{$Unidade->getId()}'>{$Unidade->getNome()}</option>";
        }
      } else {
        $listarUnidade .= "<option value='{$Unidade->getId()}'>{$Unidade->getNome()}</option>";
      }
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
  <title>Cadastro de Usuário</title>
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
  if ($status_cadastro == null) {
  ?>
    <div class="row" style="background-color: white; height:19.5cm;">
      <?php
    } else {


      if (isset($_POST['cpf'])) {

        $retorno = $TOTVS_repositorio->CPF_existe($_POST['cpf']);

        if (!$retorno) {
      ?>
          <div class="row" style="background-color: white; height:19.5cm">
          <?php
        } else {
          ?>
            <div class="row" style="background-color: white;">
            <?php
          }
        } else {
            ?>
            <div class="row" style="background-color: white;">
          <?php
        }
      }


          ?>
          <section>
            <article class="card">
              <a href="Usuario-tela-inicial.php">Voltar</a>
              <div class="row g-0 text-center">
                <div class="col-6 col-md-4">
                  <img src="../../Assets/Img/funcionarios.png" alt="Icone da solicitação de acesso" width="200" height="200" id="content_icon">
                </div>
                <div class="col-sm-6 col-md-8" id="content_inicio">
                  <h2 class="content_inicioText">Cadastro de um funcionário</h2>
                  <h4 class="content_inicioText">Os campos com "*" são obrigatórios</h4>
                </div>
              </div>
            </article>

            <article class="card content_textLeft">


              <?php

              if ($status_cadastro == null) {
              ?>
                <form action="Usuario_cadastro.php" method="POST">
                  <input type="hidden" name="status_cadastro" value="CADASTRO COM TOTVS">
                  <h5>Digite uma informação do usuário ou inicie um formulário vazio</h5>
                  <div class="form-floating">
                    <label for="validationCustom01" class="form-label">CPF:</label>
                    <input type="text" maxlength="11" value="" class="form-control" name="cpf" id="formulario_entrada">
                    <div class="valid-feedback">
                      Muito bem!
                    </div>
                  </div>
                  <br>
                  <button type="submit" class="btn btn-primary">Pesquisar</button>
                </form>

                <br>
                <form action="Usuario_cadastro.php" method="POST">
                  <input type="hidden" name="status_cadastro" value="VAZIO">
                  <button type="submit" class="btn btn-secondary">Começar um cadastro sem busca </button>
                </form>

                <?php
              } else {


                if ($status_cadastro == "CADASTRO COM TOTVS") {

                  if ($_POST['cpf'] == "" && $status_cadastro != "VAZIO") {
                ?>
                    <div class="alert alert-danger" role="alert">
                      <h5>Digite algum campo para pesquisar</h5>
                    </div>
                    <?php
                  } else {

                    $retorno = $TOTVS_repositorio->CPF_existe($_POST['cpf']);

                    if (!$retorno) {
                    ?>
                      <div class="alert alert-danger" role="alert">
                        <h5>Nenhum registro encontrado para criar o usuário</h5>
                      </div>
                    <?php
                    } else {

                      //Separando o nome do usuário
                      $pieces = explode(" ", $TOTVS->getNome());

                      $primeiroNome = $pieces[0];
                      $segundoNome = $pieces[1];


                    ?>
                      <form action="Usuario_cadastro2.php" method="post">

                        <h5>Unidade*</h5>

                        <select class="form-select" name="idUnidade" id="validationCustom04" required>
                          <option selected disabled value="<?php echo $TOTVS->getUnidade();  ?>">Selecione uma opção</option>
                          <?= $listarUnidade; ?>
                        </select>
                        <div class="invalid-feedback">
                          Por favor, escolha um nível de acesso.
                        </div>

                        <br>
                        <h5>Nível de acesso*</h5>
                        <select class="form-select" name="idNivelDeAcesso" id="validationCustom04" required>
                          <option selected disabled value="">Selecione uma opção</option>
                          <?= $listarNivelDeAcesso; ?>
                        </select>
                        <div class="invalid-feedback">
                          Por favor, escolha um nível de acesso.
                        </div>


                        <br>
                        <h5>Informações pessoais</h5>
                        <div class="form-floating">
                          <label for="validationCustom01" class="form-label">Nome completo*:</label>
                          <input type="text" class="form-control" value="<?php echo $TOTVS->getNome();  ?>" name="nome" id="formulario_entrada" required>
                          <div class="valid-feedback">
                            Muito bem!
                          </div>
                        </div>



                        <div class="form-floating">
                          <label for="validationCustom01" class="form-label">Nome e sobrenome*:</label>
                          <input type="text" class="form-control" value="<?php echo $primeiroNome . " "  . $segundoNome;  ?>" name="nomeSobrenome" id="formulario_entrada" required>
                          <div class="valid-feedback">
                            Muito bem!
                          </div>
                        </div>


                        <div class="form-floating">
                          <label for="validationCustom01" class="form-label">CPF*:</label>
                          <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="<?php echo $TOTVS->getCpf();  ?>" type="number" maxlength="11" class="form-control" name="cpf" id="formulario_entrada" required>
                          <div class="valid-feedback">
                            Muito bem!
                          </div>
                        </div>

                        <br>
                        <label>Data de nascimento encontrado no banco de dados: <b><?php echo $TOTVS->getDataNascimento(); ?> </b> </label>
                        <div class="form-floating">
                          <label for="validationCustom01" class="form-label">Data de nascimento*:</label>
                          <input type="date" class="form-control" name="dataNascimento" id="formulario_entrada" required>
                          <div class="valid-feedback">
                            Muito bem!
                          </div>
                        </div>

                        <div class="form-floating">
                          <label for="validationCustom01" class="form-label">Email*:</label>
                          <input type="email" class="form-control" name="email" value="<?php echo $TOTVS->getEmail();  ?>" id="formulario_entrada" required>
                          <div class="valid-feedback">
                            Muito bem!
                          </div>
                        </div>


                        <div class="form-floating">
                          <label for="validationCustom01" class="form-label">Telefone*:</label>
                          <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="<?php echo $TOTVS->getTelefone();  ?>" type="number" maxlength="15" class="form-control" name="telefone" id="formulario_entrada" required>
                          <div class="valid-feedback">
                            Muito bem!
                          </div>
                        </div>

                        <br>

                        <h5>Senha de acesso deste funcionário</h5>

                        <div class="form-floating">
                          <label for="validationCustom01" class="form-label">Sua senha de acesso*:</label>
                          <input type="password" class="form-control" name="senha" id="formulario_entrada" required>
                          <div class="valid-feedback">
                            Muito bem!
                          </div>
                        </div>

                        <div class="form-floating">
                          <label for="validationCustom01" class="form-label">Repita a sua senha*:</label>
                          <input type="password" class="form-control" name="repitaSenha" id="formulario_entrada" required>
                          <div class="valid-feedback">
                            Muito bem!
                          </div>
                        </div>


                        <!-- <br>
<div class="form-check form-switch">
  <input class="form-check-input" name="trocarSenha" value="1"  type="checkbox" role="switch" id="flexSwitchCheckDefault">
  <label class="form-check-label" for="flexSwitchCheckDefault">Enviar e-mail de troca de senha</label>
</div> -->

                        <!-- <h5>Será enviado um e-mail no e-mail  para que o usuário possa criar a sua senha </h5> -->
                        <br>
                        <!-- Button trigger modal -->
                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="button_expanded">Cadastrar</a>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">

                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirmar cadastro</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>

                              <div class="modal-body">
                                Por favor, verifique as informações digitadas e confirme que estão digitadas corretamente.
                                Deseja
                                confirmar este cadastro?
                              </div>

                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                              </div>

                            </div>
                          </div>
                        </div>

                      </form>

                  <?php
                    }
                  }
                }


                if ($status_cadastro == "VAZIO") {
                  ?>
                  <form action="Usuario_cadastro2.php" method="post">

                    <h5>Unidade*</h5>

                    <select class="form-select" name="idUnidade" id="validationCustom04" required>
                      <option selected disabled value="">Selecione uma opção</option>
                      <?= $listarUnidade; ?>
                    </select>
                    <div class="invalid-feedback">
                      Por favor, escolha um nível de acesso.
                    </div>

                    <br>
                    <h5>Nível de acesso*</h5>
                    <select class="form-select" name="idNivelDeAcesso" id="validationCustom04" required>
                      <option selected disabled value="">Selecione uma opção</option>
                      <?= $listarNivelDeAcesso; ?>
                    </select>
                    <div class="invalid-feedback">
                      Por favor, escolha um nível de acesso.
                    </div>


                    <br>
                    <h5>Informações pessoais</h5>
                    <div class="form-floating">
                      <label for="validationCustom01" class="form-label">Nome completo*:</label>
                      <input type="text" class="form-control" name="nome" id="formulario_entrada" required>
                      <div class="valid-feedback">
                        Muito bem!
                      </div>
                    </div>

                    <div class="form-floating">
                      <label for="validationCustom01" class="form-label">Nome e sobrenome*:</label>
                      <input type="text" class="form-control" name="nomeSobrenome" id="formulario_entrada" required>
                      <div class="valid-feedback">
                        Muito bem!
                      </div>
                    </div>


                    <div class="form-floating">
                      <label for="validationCustom01" class="form-label">CPF*:</label>
                      <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" maxlength="11" class="form-control" name="cpf" id="formulario_entrada" required>
                      <div class="valid-feedback">
                        Muito bem!
                      </div>
                    </div>

                    <div class="form-floating">
                      <label for="validationCustom01" class="form-label">Data de nascimento*:</label>
                      <input type="date" class="form-control" name="dataNascimento" id="formulario_entrada" required>
                      <div class="valid-feedback">
                        Muito bem!
                      </div>
                    </div>

                    <div class="form-floating">
                      <label for="validationCustom01" class="form-label">Email*:</label>
                      <input type="email" class="form-control" name="email" id="formulario_entrada" required>
                      <div class="valid-feedback">
                        Muito bem!
                      </div>
                    </div>


                    <div class="form-floating">
                      <label for="validationCustom01" class="form-label">Telefone*:</label>
                      <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" maxlength="15" class="form-control" name="telefone" id="formulario_entrada" required>
                      <div class="valid-feedback">
                        Muito bem!
                      </div>
                    </div>

                    <br>

                    <h5>Senha de acesso deste funcionário</h5>

                    <div class="form-floating">
                      <label for="validationCustom01" class="form-label">Sua senha de acesso*:</label>
                      <input type="password" class="form-control" name="senha" id="formulario_entrada" required>
                      <div class="valid-feedback">
                        Muito bem!
                      </div>
                    </div>

                    <div class="form-floating">
                      <label for="validationCustom01" class="form-label">Repita a sua senha*:</label>
                      <input type="password" class="form-control" name="repitaSenha" id="formulario_entrada" required>
                      <div class="valid-feedback">
                        Muito bem!
                      </div>
                    </div>


                    <!-- <br>
<div class="form-check form-switch">
  <input class="form-check-input" name="trocarSenha" value="1"  type="checkbox" role="switch" id="flexSwitchCheckDefault">
  <label class="form-check-label" for="flexSwitchCheckDefault">Enviar e-mail de troca de senha</label>
</div> -->

                    <!-- <h5>Será enviado um e-mail no e-mail  para que o usuário possa criar a sua senha </h5> -->
                    <br>
                    <!-- Button trigger modal -->
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="button_expanded">Cadastrar</a>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">

                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmar cadastro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>

                          <div class="modal-body">
                            Por favor, verifique as informações digitadas e confirme que estão digitadas corretamente.
                            Deseja
                            confirmar este cadastro?
                          </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                          </div>

                        </div>
                      </div>
                    </div>

                  </form>

              <?php
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
              if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/Termo-de-compromisso/sw.js', {
                  scope: '/Termo-de-compromisso/'
                });
              }
            </script>

</body>

</html>