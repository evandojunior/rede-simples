<link rel="stylesheet" type="text/css" href="/servicos/bbpass/includes/autenticacao.css">
<script type="text/javascript">//window.top.window.limpaMsgPadrao();</script>
<?php
  //responsável pela conexão
  require_once(__DIR__ . "/../../../Connections/bbpass.php");

  //responsável por dados da aplicação
  require_once("../aplicacao/gerencia_autenticacaoRemota.php");

  //Id da aplicação
  $idAplic = $_GET['idApl'];
  //recupera sessão
  $nmSessao= session_id();

  //instância classe de autenticação e verifica se a aplicação tem locks cadastrados
  $autentica = new AutenticacaoRemota($database_bbpass, $bbpass, $idAplic, $nmSessao);