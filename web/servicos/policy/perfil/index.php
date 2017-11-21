<?php
	  require_once("../includes/autentica.php");
	  require_once("../includes/functions.php");
	  
if (!isset($_SESSION)) {
  session_start();
}
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

mysql_select_db($database_policy, $policy);
$query_perfil = "SELECT pol_usu_codigo, pol_usu_identificacao, pol_usu_nome, pol_usu_sexo, pol_usu_observacao FROM pol_usuario";
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
<script type="text/javascript" src="../includes/boxover.js"></script>
<script type="text/javascript" src="/e-solution/servicos/policy/includes/functions.js"></script>
<script type="text/javascript">
function Popula(valor){
		document.getElementById(valor).className = "ativo";
}

function Desativa(valor){
		document.getElementById(valor).className = "comum";
}
</script>
</head>

<body >
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
            <td width="85%" height="20" align="left" bgcolor="#FFFFFF" class="verdana_12" style="border-bottom:1px solid #CCCCCC;"><strong>&nbsp;&nbsp;<img src="/e-solution/servicos/policy/images/icon_lado.gif" alt=" " align="absmiddle"/>&nbsp;Perfis</strong></td>
            <td width="15%" height="20" colspan="-2" align="center" valign="middle" class="verdana_11" style="border-bottom:1px solid #CCCCCC;"><span class="verdana_11_bold"><a href='javascript:history.go(-1);'>.: Voltar :.</a></span></td>
          </tr>
          </table>
          <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%">
              
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="400" colspan="2" valign="top" class="verdana_11" style="border-right:dashed 1px #999999;">
                    
                      <table width="765" border="0" align="center" cellpadding="6" cellspacing="0">
  <tr class="verdana_11_bold">
    <td width="206" height="0" align="left" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">Nome</td>
                  <td width="245" height="0" align="left" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">E-mail</td>
      <td width="207" height="0" align="left" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">Sexo</td>
      <td colspan="2" align="center" background="/e-solution/servicos/policy/images/barra_horizontal.jpg"> <a href="/e-solution/servicos/policy/perfil/novo.php" title="Cadastrar um novo perfil"><img src="../images/novo.gif"  width="12" height="15" border="0" align="absmiddle" /> Novo  </a></td>
    </tr>
  <?php if ($totalRows_perfil > 0) { ?>  
  <?php  do { ?>
                        <tr>
                          <td align="left" style="border-bottom:dotted 1px #333333;">&nbsp;<?php echo $row_perfil['pol_usu_nome']; ?></td>
		  <td align="left" style="border-bottom:dotted 1px #333333;">&nbsp;<?php echo $row_perfil['pol_usu_identificacao']; ?></td>
		  <td align="left" style="border-bottom:dotted 1px #333333;">
		    <?php if ($row_perfil['pol_usu_sexo'] == 'm' ) { 
				  echo 'Masculino';
				  } else {
				  echo 'Feminino';
				  }
				  ?>		    </td>
                    <td width="17" align="center" style="border-bottom:dotted 1px #333333;"><a href="editar.php?pol_usu_codigo=<?php echo $row_perfil['pol_usu_codigo']; ?>"><img src="/e-solution/servicos/policy/images/editar.gif" alt="Editar perfil" width="17" height="17" border="0" /></a></td>
                    
                  <td width="25" align="center" style="border-bottom:dotted 1px #333333;"><a href="excluir.php?pol_usu_codigo=<?php echo $row_perfil['pol_usu_codigo']; ?>"><img src="/e-solution/servicos/policy/images/excluir.gif" alt="Excluir perfil" width="17" height="17" border="0" /></a></td>
                    </tr>
  <?php }  while ( $row_perfil = mysql_fetch_assoc($perfil) ); ?>
  <?php } else { ?>
                        <tr class="verdana_11">
                          <td colspan="5" align="left">N&atilde;o h&aacute; informa&ccedil;&otilde;es cadastradas</td>
                </tr>
  <?php } ?>                
                      </table></td>
                    </tr>
                  
                  <tr>
                    <td width="21%" align="right" background="/e-solution/servicos/policy/images/separador.gif" class="verdana_11"></td>
                    <td width="78%" height="1" align="right" background="/e-solution/servicos/policy/images/separador.gif" class="verdana_11"></td>
                  </tr>
                  <tr>
                    <td align="right" class="verdana_11"></td>
                    <td height="1" align="right" class="verdana_11"></td>
                  </tr>
              </table>
              
         	  </td>
            </tr>
<tr class="verdana_11_bold">
              <td valign="top"></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td height="1" bgcolor="#FFFFFF"></td>
      </tr>
            <tr>
      	<td height="0" bgcolor="#FFFFFF"><?php require_once('../includes/rodape.php'); ?></td>
      </tr>

    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($perfil);
?>