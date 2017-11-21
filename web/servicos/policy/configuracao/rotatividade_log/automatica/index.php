<?php
require_once("../../../../../../Connections/policy.php");

//executa a rotatividade de logs
require_once("../executa.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>POLICY</title>
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/policy/includes/policy.css">

<link type="text/css" rel="stylesheet" href="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<script type="text/javascript" src="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.js"></script></head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:25px;">
  <tr>
    <td align="center" valign="top">
    <table width="777" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" valign="top"><?php require_once('../../../includes/cabecalho.php'); ?></td>
      </tr>
      
      <tr>
        <td height="20" bgcolor="#FFFFFF"><?php require_once('../../../includes/menu_horizontal.php'); ?></td>
      </tr>
      <tr>
        <td height="22" align="right" valign="top" bgcolor="#FFFFFF" class="verdana_9">&nbsp;</td>
      </tr>
      <tr>
        <td height="75" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="81%" align="left" bgcolor="#FFFFFF" class="verdana_12"><strong>&nbsp;&nbsp;<img src="/e-solution/servicos/policy/images/ferramentas.gif" alt="Configura&ccedil;&otilde;es" align="absmiddle"/>&nbsp;Rotatividade autom&aacute;tica de logs<span class="verdana_11"></span></strong></td>
            <td width="19%" colspan="-2" align="center" valign="middle" class="verdana_11">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
            <td width="19%" colspan="-2" align="center" valign="middle" class="verdana_11"></td>
          </tr>
        </table>
          <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">

            <tr bgcolor="#FFFFFF" class="verdana_12" style="cursor:pointer;" >
              <td height="27" background="../images/barra_horizontal.jpg">&nbsp;<img src="/e-solution/servicos/policy/images/rotatividade_22px.gif" alt="Rotatividade Manual" width="22" height="22" align="absbottom" /><span class="verdana_12"><strong></strong></span>  Copie a URL abaixo e execute em qualquer navegador ou agendador de taferas<span class="verdana_11">. </span></td>
              <td width="6%" align="left" background="../images/barra_horizontal.jpg">&nbsp;</td>
            </tr>
            <tr bgcolor="#FFFFFF" class="verdana_12">
              <td height="27" colspan="2">&nbsp;</td>
            </tr>
            <tr bgcolor="#FFFFFF" class="verdana_12">
              <td height="27" colspan="2">Url : <strong>http://<?php echo $_SERVER['HTTP_HOST']; ?><?php echo $_SERVER['SCRIPT_NAME']; ?>?executa=true</strong></td>
              </tr>
            <tr>
              <td height="30" colspan="2" align="center" class="verdana_12" style="color:#C60"><?php if(isset($_GET['msgAcao'])){ echo utf8_decode($_GET['msgAcao']);  } ?></td>
</tr>
            </table>
         <br/>
          
          
          </td>
      </tr>
      
      <tr>
        <td height="230" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
      	<td bgcolor="#FFFFFF"><?php require_once('../../../includes/rodape.php'); ?></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>