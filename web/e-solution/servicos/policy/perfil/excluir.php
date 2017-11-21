<?php
		require_once("../includes/autentica.php");
	require_once("../includes/functions.php");
	
if (!isset($_SESSION)) {
  session_start();
}
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$erro = '';

if ((isset($_POST["MM_delete"])) && ($_POST["MM_delete"] == "form1")) {
	
	//Aqui começa o Recordset que faz validação de emails iguais.
	mysqli_select_db($policy, $database_policy);
	$query_validaperfil = sprintf("SELECT pol_usu_identificacao FROM pol_usuario WHERE pol_usu_identificacao = '".$_POST['pol_usu_identificacao']."'");
	$validaperfil = mysqli_query($policy, $query_validaperfil) or die(mysql_error());
	$row_validaperfil = mysqli_fetch_assoc($validaperfil);
	$totalRows_validaperfil = mysqli_num_rows($validaperfil);
	//Aqui termina o Recordset

  $pol_usu_sexo		= $_POST['pol_usu_sexo'];

  if($totalRows_validaperfil!=0){
   $deleteSQL = "DELETE FROM pol_usuario WHERE pol_usu_codigo = " . $_GET['pol_usu_codigo'];

  mysqli_select_db($policy, $database_policy);
  $Result1 = mysqli_query($policy, $deleteSQL) or die(mysql_error());

  $deleteGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
 header(sprintf("Location: %s", $deleteGoTo));
} else {
	$erro = '<span style="color:#FF0000">Seu e-mail não confere, confirme seu e-mail ou contate o administrador</span>';
}

}

mysqli_select_db($policy, $database_policy);
$query_perfil = "SELECT pol_usu_codigo, pol_usu_identificacao, pol_usu_nome, pol_usu_sexo, pol_usu_observacao FROM pol_usuario WHERE pol_usu_codigo = " . $_GET['pol_usu_codigo'];
$perfil = mysqli_query($policy, $query_perfil) or die(mysql_error());
$row_perfil = mysqli_fetch_assoc($perfil);
$totalRows_perfil = mysqli_num_rows($perfil);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>POLICY</title>
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/policy/includes/policy.css">

<link type="text/css" rel="stylesheet" href="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<script type="text/javascript" src="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.js"></script>
<script src="../../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<script type="text/javascript">
	function exibeIcone(nmIcone){
	
		document.getElementById('iconeSelecionado').innerHTML = "&nbsp;<img src='/datafiles/servicos/policy/aplicacoes/"+nmIcone+"'  align='absmiddle' /><input name='pol_apl_icone' id='pol_apl_icone' type='hidden' value='"+nmIcone+"' />";
	}
</script>

<link href="../../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:25px;">
  <tr>
    <td align="center" valign="top">
    <table width="777" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" valign="top"><?php require_once('../includes/cabecalho.php'); ?></td>
      </tr>
      
      <tr>
        <td height="20" bgcolor="#FFFFFF"><?php require_once('../includes/menu_horizontal.php'); ?></td>
      </tr>
      <tr>
        <td height="22" align="right" valign="top" bgcolor="#FFFFFF" class="verdana_9">&nbsp;</td>
      </tr>
      <tr>
        <td height="75" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="92%" align="left" bgcolor="#FFFFFF" class="verdana_11_bold">&nbsp;&nbsp;<img src="/e-solution/servicos/policy/images/icon_lado.gif" alt="Exclusão de Perfil" align="absmiddle"/>&nbsp;Excluir Perfil</td>
            <td width="8%" colspan="-2" align="center" valign="middle" class="verdana_11">&nbsp;</td>
          </tr>
          
        </table>
          <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>"><table width="550" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FBFFFB" style="border:1px solid #CCCCCC;">
            <tr>
              <td height="10" colspan="2" align="right" class="verdana_11">               </td>
                </tr>
          	 <tr>
                <td width="20%" height="25" align="right" class="verdana_11">*Nome :</td>
                <td width="80%" height="25" align="left" class="verdana_11">&nbsp;<span id="sprytextfield1">
                  <input name="pol_usu_nome" type="text" class="verdana_11" id="pol_usu_nome" size="40" maxlength="75" value="<?php echo $row_perfil['pol_usu_nome'] ?>" disabled="disabled" />
                  <span class="textfieldRequiredMsg">Campo obrigat&oacute;rio.</span></span></td>
              </tr>
              <tr>
                <td height="28" align="right" class="verdana_11">*E-mail :</td>
                <td height="28" align="left" class="verdana_11">&nbsp;<span id="sprytextfield2">
                  <input name="pol_usu_identificacao_exibe" type="text" class="verdana_11" id="pol_usu_identificacao_exibe" value="<?php echo $row_perfil['pol_usu_identificacao']; ?>" size="40" maxlength="75" disabled="disabled" /> <span class="textfieldRequiredMsg">Campo obrigat&oacute;rio.</span></span>
                <input name="pol_usu_identificacao" type="hidden" class="verdana_11" id="pol_usu_identificacao" value="<?php echo $row_perfil['pol_usu_identificacao']; ?>" size="35" maxlength="75"  />
                </td>
              </tr>
              <tr>
                <td height="26" align="right" valign="top" class="verdana_11">Observa&ccedil;&atilde;o :</td>
                <td align="left" class="verdana_11">&nbsp;
                  <textarea name="pol_usu_observacao" cols="60" rows="5" class="verdana_11" id="pol_usu_observacao" disabled="disabled"><?php echo $row_perfil['pol_usu_observacao']; ?></textarea></td>
              </tr>
              <tr>
                <td height="28" align="right" class="verdana_11">Sexo : </td>
                <td height="28" align="left">&nbsp;<span class="verdana_11">
                  <select name="pol_usu_sexo" id="pol_usu_sexo" class="formulario2" disabled="disabled">
                    <option value="m" <?php if($row_perfil['pol_usu_sexo']=="m") { echo 'selected="selected"';} ?>>Masculino</option>
                    <option value="f" <?php if($row_perfil['pol_usu_sexo']=="f") { echo 'selected="selected"';} ?> >Feminino</option>
                  </select>
                </span></td>
              </tr>
              <tr>
                <td height="10" align="right"></td>
                <td align="left" class="verdana_11">
                <?php echo $erro; ?></td>
              </tr>
              <tr>
                <td height="26" align="right">&nbsp;</td>
                <td align="left">&nbsp;
                  <input name="button2" type="button" class="button" id="button2" onclick="location.href='index.php'" value="Cancelar" />
                  <input name="button" type="submit" class="button" id="button" value="Excluir" /></td></tr>
              <tr>
                <td colspan="2" align="right">&nbsp;</td>
                </tr>
          </table>
            <input type="hidden" name="MM_delete" value="form1" />
          </form>
         </td>
      </tr>
     <tr>
        <td height="130" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none");
//-->
</script>
</body>
</html>