<?php
 //responsável pela conexao com banco, autenticaçao, logoff
 require_once("includes/autenticacao/index.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BBPASS - Central de Autentica&ccedil;&atilde;o</title>
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/bbpass/includes/layout/bbpass.css">
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/bbpass/includes/layout/login.css">
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/bbpass/includes/layout/menu.css">
<!-- GERAL DE TODOS OS LOCKS-->
	<script type="text/javascript" src="/e-solution/servicos/bbpass/includes/geral.js"></script>
<!-- FIM GERAL DE TODOS OS LOCKS-->
<!-- TRATAMENTO DE URL -->
	<script type="text/javascript" src="/e-solution/servicos/bbpass/includes/javascript_backsite/tratamento/gerencia.js"></script>
   	<script type="text/javascript" src="/e-solution/servicos/bbpass/includes/javascript_backsite/formulario_data/dhtmlgoodies_calendar.js"></script>
	<link rel="stylesheet" type="text/css" href="/e-solution/servicos/bbpass/includes/javascript_backsite/formulario_data/dhtmlgoodies_calendar.css">
<!-- TRATAMENTO DE URL -->
<!-- AJAX -->
	<script type="text/javascript" src="/e-solution/servicos/bbpass/includes/javascript_backsite/ajax/ajax.js"></script>
	<script type="text/javascript" src="/e-solution/servicos/bbpass/includes/javascript_backsite/ajax/projeto.js"></script>
<!-- AJAX-->
<!-- TRATAMENTO DE IMAGENS -->
<script type="text/javascript" src="/e-solution/servicos/bbpass/includes/javascript_backsite/historico/jquery.js"></script>
<!-- FIM TRATAMENTO DE IMAGENS -->
<!-- HISTÓRICO DO NAVEGADOR -->
	<script type="text/javascript" src="/e-solution/servicos/bbpass/includes/javascript_backsite/historico/jquery.js"></script>
	<script type="text/javascript" src="/e-solution/servicos/bbpass/includes/javascript_backsite/historico/jquery.history.js"></script>
	<script type="text/javascript" src="/e-solution/servicos/bbpass/includes/javascript_backsite/historico/load_files.js"></script>
<!-- FIM HISTÓRICO DO NAVEGADOR -->
</head>

<body>
    <table width="777" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="margin-top:25px;">
      <tr>
        <td><?php require_once("includes/layout/cabLogin.php"); ?></td>
      </tr>
      <tr>
        <td height="22" valign="top"><?php require_once("includes/layout/menu.php"); ?></td>
      </tr>
      <tr>
        <td height="25" valign="middle" bgcolor="#FFFBF4" style="font-family:arial;text-align:left;font-weight:bold;padding:5 0;border-bottom:1px solid #FFECC7; ">&nbsp;&nbsp;<img src="images/key.gif" width="16" height="16" align="absmiddle" />&nbsp;&nbsp;Central de autentica&ccedil;&atilde;o</td>
      </tr>
      <tr>
        <td height="490" align="center" valign="top" style="border-left:#EDDD92 solid 1px; border-bottom:#EDDD92 solid 1px;">
          <div id="load" style="width:770px;margin-left:5px;" align="center"></div>
        </td>
      </tr>
</table>
<div style="position:absolute" id="descarte"></div>
<div id="div_fixa" style="display:none">
  <div style="border:#FFF solid 1px;height:21px;">
    Aguarde enquando a p&aacute;gina est&aacute; sendo carregada.
  </div>  
</div>