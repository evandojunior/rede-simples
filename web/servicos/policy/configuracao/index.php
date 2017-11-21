<?php
	require_once("../includes/autentica.php");
	require_once("../includes/functions.php");
if (!isset($_SESSION)) {
  session_start();
}


//Auditoria do próprio Policy
/*$_SESSION['relevancia']="0";
$_SESSION['nivel']="1";
EnviaPolicy("Acessou a página inicial do sistema");*/

mysql_select_db($database_policy, $policy);
$query_perfil = "SELECT pol_aud_codigo FROM pol_auditoria Order by pol_aud_codigo ASC LIMIT 1";
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
            <td width="81%" align="left" bgcolor="#FFFFFF" class="verdana_12"><strong>&nbsp;&nbsp;<img src="/e-solution/servicos/policy/images/ferramentas.gif" alt="Configura&ccedil;&otilde;es" align="absmiddle"/>&nbsp;Configura&ccedil;&otilde;es</strong></td>
            <td width="19%" colspan="-2" align="center" valign="middle" class="verdana_11">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
            <td width="19%" colspan="-2" align="center" valign="middle" class="verdana_11"></td>
          </tr>
        </table>
          <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">

            <tr bgcolor="#FFFFFF" class="verdana_12" style="cursor:pointer;" >
             <td width="89%" height="27" background="../images/barra_horizontal.jpg">&nbsp;<span class="verdana_12"><strong></strong></span> Rotatividade de logs - log atual iniciando no registro <strong><?php echo $row_perfil['pol_aud_codigo']>=0?$row_perfil['pol_aud_codigo']:0; ?></strong></td>
              <td width="5%" align="center" background="../images/barra_horizontal.jpg">&nbsp;</td>
              <td width="6%" align="left" background="../images/barra_horizontal.jpg">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="5" colspan="4" align="right" class="verdana_11_bold"></td>
                  </tr>
                <tr>
                  <td width="10%" rowspan="2" align="center" valign="middle" class="verdana_11_cinza">&nbsp;<a href="/e-solution/servicos/policy/configuracao/rotatividade_log/manual/index.php"><img src="/e-solution/servicos/policy/images/rotatividade_auto_48px.gif" alt="Rotatividade Manual" width="48" height="48" border="0"/></a></td>
                  <td width="10%" rowspan="2" align="center" valign="bottom" class="verdana_11_cinza"><a href="/e-solution/servicos/policy/configuracao/rotatividade_log/automatica/index.php"><img src="/e-solution/servicos/policy/images/rotatividade_auto_48px.gif" alt="Rotatividade Autom&aacute;tica" width="48" height="48" border="0" /></a></td>
                  <td width="23%" height="20" class="verdana_11_cinza"><a href="/e-solution/servicos/policy/configuracao/rotatividade_log/manual/index.php"></a></td>
                  <td width="57%" class="verdana_11_cinza">&nbsp;</td>
                </tr>
                <tr>
                  <td height="20" class="verdana_11_cinza">&nbsp;</td>
                  <td height="20" class="verdana_11_cinza">&nbsp;</td>
                </tr>
                
                <tr>
                  <td height="18" align="center" valign="top" class="verdana_11_cinza"><a href="/e-solution/servicos/policy/configuracao/rotatividade_log/manual/index.php"><strong>Manual</strong></a></td>
                  <td height="18" align="center" valign="top" class="verdana_11_cinza"><a href="/e-solution/servicos/policy/configuracao/rotatividade_log/automatica/index.php"><strong>Autom&aacute;tica</strong></a></td>
                  <td height="18" valign="top" class="verdana_11_cinza">&nbsp;</td>
                  <td height="18" valign="top" class="verdana_11_cinza">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="4" align="left" class="verdana_11">
                  <!--
                  <strong style="margin-left:15px">Manual </strong>
                  <strong style="margin-left:15px">Autom&aacute;tica</strong>   
                   -->                                </td>
                </tr>
                <tr>
                  <td height="1" colspan="4" align="right" background="/e-solution/servicos/policy/images/separador.gif" class="verdana_11"></td>
                </tr>
                <tr>
                  <td height="1" colspan="4" align="right" class="verdana_11"></td>
                </tr>
              </table>
              
              
              
              </td>
</tr>

          </table>
         <br/>
          
          
          </td>
      </tr>
      
      <tr>
        <td height="230" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
      	<td bgcolor="#FFFFFF"><?php require_once('../includes/rodape.php'); ?></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>