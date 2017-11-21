<?php
if(!isset($_SESSION)){session_start();}

//recupera o diretório da aplicação, sendo que não sei em qual aplicação estou
$divisor = "web";//padrão letra minuscula
$dirPadrao = explode($divisor,str_replace("\\","/",dirname(__FILE__)));
$dirOnde = $dirPadrao[1];

require_once($dirPadrao[0]."web/Connections/setup.php");//SETUP

//conecta com servidor BBPASS
$servidorBBPASS = $BBP_protocolo. $BBP_host . $BBP_porta."/servicos/bbpass/modulos_autenticacao/destroiSessaoRemota.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Central de antentica&ccedil;&otilde;es</title>
<style type="text/css">
<!--
.verdana {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	color: #00F;
}
-->
</style>
<script type="text/javascript">
  function redireciona(){
	var minhaURL = document.URL.split("logoutRegeneration.php");
	parent.frames['login'].location ="<?php echo $servidorBBPASS; ?>?urlRetorno="+minhaURL[0]+"login.php?abandona=sim";
  }
</script>
</head>

<body class="verdana" onload="redireciona()">
Aguarde o redirecionamento...
<iframe name="login" frameborder="0" width="100%" height="200" allowtransparency="true" src=""></iframe>
</body>
</html>