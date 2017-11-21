<?php if(!isset($_SESSION)){session_start();} ?>
<?php require_once("includes/autentica.php"); 
//Valida quando o usuário clica em voltar do navegador
if (!isset($_SESSION)) { session_start(); }
if(isset($_SESSION["urlAnteriorPub"])){

		$_SESSION['urlEnviaPub'] = $_SESSION['urlAnteriorPub'];
		$_SESSION['exPaginaPub'] = $_SESSION['exAnteriorPub']	;
		echo "<script>history.go(1);</script>";
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BBhive</title>
<link rel="stylesheet" type="text/css" href="includes/bbhive.css">
<script>
function bbpass(){
	parent.frames['login'].location ="<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/modulos_autenticacao/autenticaRemoto.php?<?php echo "idApl=".$idAplicacaoBBPASS_Servicos; ?>";
}
function limpaMsgPadrao(){
	document.getElementById('msgLockRemoto').style.display = "none";
}
</script>
</head>
<body onLoad="return bbpass();">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle"><table width="420" border="0" cellpadding="0" cellspacing="0" bgcolor="#F1F3F8" class="borderAlljanela">
      <tr>
        <td height="90" background="/datafiles/servicos/bbhive/servicos/imagens/sistema/cabecalho_login.jpg">&nbsp;</td>
      </tr>
      <tr>
          <td height="25" class="verdana_11" align="right" bgcolor="#FFFFFF">
         <label>	
            	<a href="/corporativo/servicos/bbhive/logoutRegeneration.php?abandona=sim"><span class="color">Acesso Corporativo</span></a>
         </label>
         |
         <label style="margin-right:5px;">
            <a href="/e-solution/servicos/bbhive/logoutRegeneration.php?abandona=sim"><span class="color">Acesso Administrativo</span></a>
         </label>
          <iframe name="login" frameborder="0" width="100%" height="200" allowtransparency="true"></iframe>
          </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><table width="420" border="0" cellpadding="0" cellspacing="0" bgcolor="#F1F3F8" class="borderAlljanela">
    </table></td>
  </tr>
</table>
</body>
</html>