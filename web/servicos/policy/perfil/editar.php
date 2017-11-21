<?php
	require_once("../includes/autentica.php");
	require_once("../includes/functions.php");
	
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$erro = '';

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	
	//Aqui começa o Recordset que faz validação de emails iguais.
	mysql_select_db($database_policy, $policy);
	$query_validaperfil = sprintf("SELECT pol_usu_identificacao FROM pol_usuario WHERE pol_usu_identificacao = '".$_POST['pol_usu_identificacao']."' AND pol_usu_codigo <> " . $_GET['pol_usu_codigo']);
	$validaperfil = mysql_query($query_validaperfil, $policy) or die(mysql_error());
	$row_validaperfil = mysql_fetch_assoc($validaperfil);
	$totalRows_validaperfil = mysql_num_rows($validaperfil);
	//Aqui termina o Recordset

  $pol_usu_sexo		= $_POST['pol_usu_sexo'];

  if($totalRows_validaperfil==0  ){
   $updateSQL = "UPDATE pol_usuario SET pol_usu_identificacao = '".$_POST['pol_usu_identificacao']."', pol_usu_nome = '".$_POST['pol_usu_nome']."', pol_usu_observacao = '".$_POST['pol_usu_observacao']."', pol_usu_sexo= '".$_POST['pol_usu_sexo']."' WHERE pol_usu_codigo = " . $_GET['pol_usu_codigo'];

  mysql_select_db($database_policy, $policy);
  $Result1 = mysql_query($updateSQL, $policy) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
 header(sprintf("Location: %s", $updateGoTo));
} else {
	$erro = '<span style="color:#FF0000">E-mail já cadastrado, por favor entre com outro e-mail</span>';
}

}

mysql_select_db($database_policy, $policy);
$query_perfil = "SELECT pol_usu_codigo, pol_usu_identificacao, pol_usu_nome, pol_usu_sexo, pol_usu_observacao FROM pol_usuario WHERE pol_usu_codigo = " . $_GET['pol_usu_codigo'];
$perfil = mysql_query($query_perfil, $policy) or die(mysql_error());
$row_perfil = mysql_fetch_assoc($perfil);
$totalRows_perfil = mysql_num_rows($perfil);

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
            <td width="92%" align="left" bgcolor="#FFFFFF" class="verdana_11_bold">&nbsp;&nbsp;<img src="/e-solution/servicos/policy/images/icon_lado.gif" alt="Edição de Perfil" align="absmiddle"/>&nbsp;Editar Perfil</td>
            <td width="8%" colspan="-2" align="center" valign="middle" class="verdana_11">&nbsp;</td>
          </tr>
         
        </table>
          <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>"><table width="550" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FBFFFB" style="border:1px solid #CCCCCC;">
            <tr>
              <td height="20" colspan="2" align="right" class="verdana_11"><span style="color:#FF0000"> * Campos obrigatórios&nbsp;&nbsp;</span>
                              </td>
                </tr>
              

              <tr>
                <td width="20%" height="25" align="right" class="verdana_11">*Nome :</td>
                <td width="80%" height="25" align="left" class="verdana_11">&nbsp;<span id="sprytextfield1">
                  <input name="pol_usu_nome" type="text" class="verdana_11" id="pol_usu_nome" size="40" maxlength="75" value="<?php echo $row_perfil['pol_usu_nome'] ?>" />
                  <span class="textfieldRequiredMsg">Campo obrigat&oacute;rio.</span></span></td>
              </tr>
              <tr>
                <td height="28" align="right" class="verdana_11">*E-mail :</td>
                <td height="28" align="left" class="verdana_11">&nbsp;<span id="sprytextfield2">
                  <input name="pol_usu_identificacao" type="text" class="verdana_11" id="pol_usu_identificacao" value="<?php echo $row_perfil['pol_usu_identificacao']; ?>" size="40" maxlength="75"  /> <span class="textfieldRequiredMsg">Campo obrigat&oacute;rio.</span></span>                </td>
              </tr>
              <tr>
                <td height="26" align="right" valign="top" class="verdana_11">Observa&ccedil;&atilde;o :</td>
                <td align="left" class="verdana_11">&nbsp;
                  <textarea name="pol_usu_observacao" cols="60" rows="5" class="verdana_11" id="pol_usu_observacao"><?php echo $row_perfil['pol_usu_observacao']; ?></textarea></td>
              </tr>
              <tr>
                <td height="26" align="right" class="verdana_11">Sexo : </td>
                <td align="left">&nbsp;<span class="verdana_11">
                  <select name="pol_usu_sexo" id="pol_usu_sexo" class="formulario2">
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
                <input name="button" type="submit" class="button" id="button" value="Editar" /></td>
            </tr>
              <tr>
                <td colspan="2" align="right">&nbsp;</td>
                </tr>
          </table>
            <input type="hidden" name="MM_update" value="form1" />
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