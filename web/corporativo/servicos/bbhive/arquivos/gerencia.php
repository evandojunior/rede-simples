<?php
if(!isset($_SESSION)){ session_start(); } 	
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	
	settype($_GET['bbh_flu_codigo'],"integer");
	//--
	//--
	$barra = '<table width="98%" border="0" align="center" cellpadding="0" style="class="verdana_11">
			  <tr>
				<td height="23" align="right" bgcolor="#FFFFFF"><a href="#@" onClick="window.top.document.getElementById(\'ambienteRelatorio\').innerHTML = \'&nbsp;\';"><span style="color:#F60"><strong>Fechar janela de upload</strong></span>&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/fechar.gif" width="18" height="18" border="0" align="absmiddle" /></a></td>
			  </tr>
			</table>';	
	//--
	$flu_cel = '';
	$ati_cod = '';
	$compl = '';
	if(isset($_GET['bbh_flu_codigo_sel'])){
		$compl .= "&bbh_flu_codigo=".$_GET['bbh_flu_codigo_sel'];
	}
	if(isset($_GET['bbh_ati_codigo'])){
		$compl .= "&bbh_ati_codigo=".$_GET['bbh_ati_codigo'];
	}
	
	$uploadPHP 		= "/corporativo/servicos/bbhive/arquivos/upload/executa.php?ts=".$_GET['ts'];
//	$fecharPHP 		= "window.top.location.href='/corporativo/servicos/bbhive/arquivos/upload/limpa.php'";
	
	$fecharPHP 		= "window.top.showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&arquivos=1|arquivos/index.php?lp=true$compl|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&equipeArquivos=1','menuEsquerda|colCentro|colDireita');";
	
	$tipoArquivo 	= '//{title : "Arquivos de imagens", extensions : "zip"}'; 
	//--
	require_once("../includes/js_css/upload_multiplo/index.php");
//echo('sdf');
exit;
?>