<!-- CSS do Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<!-- JavaScript do Bootstrap (opcional, mas necessário para funcionalidades avançadas) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


<form class="was-validated">
  <div class="form-group">
    <label for="name">Nome:</label>
    <input type="text" class="form-control" id="name" placeholder="Digite seu nome" required>
    <div class="invalid-feedback">Por favor, insira seu nome.</div>
  </div>
  <div class="form-group">
    <label for="email">E-mail:</label>
    <input type="email" class="form-control" id="email" placeholder="Digite seu e-mail" required>
    <div class="invalid-feedback">Por favor, insira um e-mail válido.</div>
  </div>
  <button type="submit" class="btn btn-primary">Enviar</button>
</form>
