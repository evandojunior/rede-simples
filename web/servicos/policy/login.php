<?php if(!isset($_SESSION)){session_start();} ?>
<?php require_once("includes/autentica.php"); 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>POLICY</title>
<link rel="stylesheet" type="text/css" href="includes/policy.css">
<script>
//document.domain = "microsoft.com";

function bbpass(){
	parent.frames['login'].location ="<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/modulos_autenticacao/autenticaRemoto.php?<?php echo "idApl=".$idAplicacaoBBPASS; ?>";
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
        <td height="89" background="/datafiles/servicos/policy/sistema/e-solution/cabecalho_login.jpg">&nbsp;</td>
      </tr>
      <tr>
          <td height="25" class="verdana_11"><iframe name="login" frameborder="0" width="100%" height="200" allowtransparency="true"></iframe>
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
