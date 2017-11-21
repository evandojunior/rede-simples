<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	$query_modFluxos = "select count(bbh_mod_ati_codigo) as total FROM bbh_modelo_atividade Where bbh_mod_flu_codigo = ".$_GET['bbh_mod_flu_codigo'];
    list($modFluxos, $row_modFluxos, $totalRows_modFluxos) = executeQuery($bbhive, $database_bbhive, $query_modFluxos);
	/*
	$page 		= "1";
	$nElements 	= "50";
		if(isset($_GET["page"])){
			$page 	= $_GET["page"];
		}
	$Inicio = ($nElements*$page)-$nElements;
	$homeDestino	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/modelosAtividades/index.php?Ts='.$_SERVER['REQUEST_TIME']."&bbh_mod_flu.codigo=".$_GET['bbh_mod_flu_codigo'];
	$exibe			= 'conteudoGeral';
	$pages 			= ceil($row_modFluxos['total']/$nElements);*/
?>
<var style="display:none">txtSimples('tagPerfil', 'Modelos de  atividades')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td width="55%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-fluxo-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de modelos de atividades</td>
    <td width="32%" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/index.php','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="3"></td>
  </tr>
</table>
<?php require_once('cabecaModelo.php'); ?>
<br>
<div id="loadOrdena" style="position:absolute; margin-top:-18px;" class="verdana_11 color">&nbsp;</div>
<div id="conteudoListado">
	<?php require_once('listaAtividades.php'); ?>
</div>