<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

$query_modFluxos = "select count(bbh_mod_ati_codigo) as total FROM bbh_modelo_atividade Where bbh_mod_flu_codigo = ".$_GET['bbh_mod_flu_codigo'];
list($modFluxos, $row_modFluxos, $totalRows_modFluxos) = executeQuery($bbhive, $database_bbhive, $query_modFluxos);

$homeDestino	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/paragrafos/paragrafos.php?bbh_mod_flu_codigo='.$_GET['bbh_mod_flu_codigo']."&Ts=".time();
$acao = "OpenAjaxPostCmd('".$homeDestino."','exibePar','&2=2','Carregando dados...','exibePar','2','2');";

	unset($_SESSION['textoEdito']);
	unset($_SESSION['textoParNome']);
	unset($_SESSION['textoParTitulo']);
	unset($_SESSION['textoParmomento']);
	unset($_SESSION['textoMonGrava']);
	unset($_SESSION['textoParAutor']);
?>

<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
<var style="display:none">txtSimples('tagPerfil', 'Modelos de par&aacute;grafos')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td width="55%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-fluxo-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de textos pr&eacute;-definidos</td>
    <td width="32%" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/index.php','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="3"></td>
  </tr>
</table>
<?php require_once('../modelosAtividades/cabecaModelo.php'); ?>
<br />
<div id="loadOrdena" class="verdana_12" style="position:absolute; margin-top:-5px;">&nbsp;</div>
<div id="exibePar" class="verdana_12" style="margin-top:30px;">&nbsp;</div>
<var style="display:none"><?php echo $acao; ?></var>
