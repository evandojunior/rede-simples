<?php

	  require_once("../../../includes/autentica.php");
	require_once("../../../includes/functions.php");
if (!isset($_SESSION)) {
  session_start();
}

//Auditoria do próprio Policy
/*$_SESSION['relevancia']="0";
$_SESSION['nivel']="1";
EnviaPolicy("Acessou a página inicial do sistema");*/
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
            <td width="81%" align="left" bgcolor="#FFFFFF" class="verdana_12"><strong>&nbsp;&nbsp;<img src="/e-solution/servicos/policy/images/ferramentas.gif" alt="Configura&ccedil;&otilde;es" align="absmiddle"/>&nbsp;Rotatividade manual de logs<span class="verdana_11"></span></strong></td>
            <td width="19%" colspan="-2" align="center" valign="middle" class="verdana_11">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12">
            <div style="width:80%;margin-left:55px;" class="aviso">
            A rotatividade de logs indisponibiliza os eventos anteriores a data de hoje para leitura e edi&ccedil;&atilde;o por interm&eacute;dio do Policy. Para visualizar os dados rotacionados voc&ecirc; precisar&aacute; utilizar a ferramenta de Bussiness Inteligence devidamente configurada. Se voc&ecirc; tem certeza de que deseja dar sequ&ecirc;ncia neste procedimento clique no link abaixo, caso contr&aacute;rio volte ao menu principal.
            </div>
            </td>
            </tr>
        </table>
          <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">

            <tr bgcolor="#FFFFFF" class="verdana_12" style="cursor:pointer;" >
              <td height="27" background="../images/barra_horizontal.jpg">&nbsp;</td>
              <td align="center" background="../images/barra_horizontal.jpg">&nbsp;</td>
              <td align="left" background="../images/barra_horizontal.jpg">&nbsp;</td>
            </tr>
            <tr bgcolor="#FFFFFF" class="verdana_12" style="cursor:pointer;" >
              <td width="89%" height="27" background="../images/barra_horizontal.jpg">&nbsp;<span class="verdana_12"><strong></strong></span> <img src="/e-solution/servicos/policy/images/rotatividade_22px.gif" alt="Rotatividade Manual" width="22" height="22" align="absbottom" /> <a href="index.php?executa=true"><span class="color">Clique aqui para iniciar o processo de rotatividade manual de logs.</span></a></td>
              <td width="5%" align="center" background="../images/barra_horizontal.jpg">&nbsp;</td>
              <td width="6%" align="left" background="../images/barra_horizontal.jpg">&nbsp;</td>
            </tr>
            <tr>
              <td height="30" colspan="3" align="center" class="verdana_12" style="color:#C60"><?php if(isset($_GET['msgAcao'])){ echo utf8_decode($_GET['msgAcao']);  } ?></td>
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