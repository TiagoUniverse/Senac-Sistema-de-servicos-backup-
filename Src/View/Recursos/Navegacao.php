<header>
  <img src="../../Assets/Img/senac_logo_branco.png">
  <h1>Sistema de Serviços</h1>
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
  

    ?>

    <li><a href="Solicitacao-acesso_tela-inicial.php">Solicitação de um novo colaborador</a></li>


  </ul>
</aside>