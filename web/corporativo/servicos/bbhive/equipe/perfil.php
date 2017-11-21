<?php
	if(!isset($_SESSION)){session_start();}
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
?>
<var style="display:none">txtSimples('tagPerfil', 'Nomear perfil')</var>
<div id="resto" style="position:absolute; z-index:50000;"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_9">
  <tr>
    <td width="595" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"><img src="/corporativo/servicos/bbhive/images/perfil-pequeno.gif" alt="" width="23" height="23" align="absmiddle" /> <strong class="verdana_11">Lista de perfis para nomea&ccedil;&atilde;o</strong>
    <label></label></td>
  </tr>
  <tr>
    <td class="verdana_11">&nbsp;</td>
  </tr>
</table>
<?php require_once('lista.php'); ?>