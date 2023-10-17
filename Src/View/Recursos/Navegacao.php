<header>
  <img src="../../Assets/Img/senac_logo_branco.png">
  <h1>Termo de compromisso</h1>
</header>

<nav>
  <ul>
    <ul>
      <div class="row">
        <div class="col-sm-10">
          <li><a href="Trocar senha.php">Alterar senha</a></li>
          <li><a href="logoff.php">Sair</a></li>
        </div>
        <div class="col-sm-2">
          <li><a id="username"> Usuário: <?php echo  $_SESSION['nameUser']; ?> </a></li>
        </div>
      </div>
    </ul>
  </ul>
</nav>

<aside>
  <ul>
    <?php

    require_once "Recursos/ValidaNivelDeAcesso.php";

    // Lista dos níveis de acesso
    //id = 1 - Administrador
    //id = 2 - RH
    //id = 3 - Suporte GTI

    //Níveis de acesso disponíveis que podem ver este botão. Caso o id do usuário não esteja
    //nesta lista, ele não poderá ver o botão

    // SOLICITACAO DE COLABORADOR
    $NivelAcesso_disponivel = array(
      1, 2
    );
    $retorno_valida = exibe_botao($NivelAcesso_disponivel);

    if ($retorno_valida) {
    ?>
      <li><a href="Solicitacao-acesso_tela-inicial.php">Solicitação de um novo colaborador</a></li>
    <?php
    }

    // FIM DE PROCESSO DE COLABORADOR
    $NivelAcesso_disponivel = array(
      1, 2, 3
    );
    $retorno_valida = exibe_botao($NivelAcesso_disponivel);

    if ($retorno_valida) {
    ?>
      <li><a href="fimProcesso_tela-inicial.php">Lista de processos concluídos</a></li>
    <?php
    }



    // Solicitação de código de ética
    $NivelAcesso_disponivel = array(
      1, 2
    );
    $retorno_valida = exibe_botao($NivelAcesso_disponivel);

    if ($retorno_valida) {
    ?>
      <li><a href="codigo etica_tela-inicial.php">Solicitação de código de ética</a></li>
      <li><a href="codigo etica fim_processo.php">Resultado do código de ética</a></li>
      <!-- <li>
        <div class="btn-group opcao-dropdown">
          <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Solicitação de código de ética
          </button>
          <ul class="dropdown-menu">
            <li><a href="codigo etica_tela-inicial.php">Solicitação de código de ética</a></li>
            <li><a href="codigo etica_tela-inicial.php">Resultados do código de ética</a></li>
          </ul>
        </div>
      </li> -->

    <?php
    }



    //CRIAÇÃO DE EMAIL
    $NivelAcesso_disponivel = array(
      1, 3
    );
    $retorno_valida = exibe_botao($NivelAcesso_disponivel);

    if ($retorno_valida) {
    ?>
      <li><a href="Criacao-email_tela-inicial.php">Criar e-mail do colaborador</a></li>
    <?php
    }

    //USUARIO
    $NivelAcesso_disponivel = array(
      1, 3
    );
    $retorno_valida = exibe_botao($NivelAcesso_disponivel);

    if ($retorno_valida) {
    ?>
      <li><a href="Usuario-tela-inicial.php">Usuário</a></li>
    <?php
    }

    //UNIDADE
    $NivelAcesso_disponivel = array(
      1
    );
    $retorno_valida = exibe_botao($NivelAcesso_disponivel);

    if ($retorno_valida) {
    ?>
      <li><a href="Unidade-tela-inicial.php">Unidade</a></li>
    <?php
    }

    // TELA DO NIVEL DE ACESSO
    $NivelAcesso_disponivel = array(
      1
    );
    $retorno_valida = exibe_botao($NivelAcesso_disponivel);

    if ($retorno_valida) {
    ?>
      <li><a href="NivelDeAcesso-tela-inicial.php">Nivel de acesso</a></li>
    <?php
    }
    ?>

  </ul>
</aside>