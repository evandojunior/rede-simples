<?php
if(!isset($_SESSION)){ session_start(); } 	
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	
	settype($_GET['bbh_flu_codigo'],"integer");
	settype($_GET['bbh_rel_codigo'],"integer");
	settype($_GET['bbh_ati_codigo'],"integer");
	//--
	$_SESSION['upl_flu_codigo'] = $_GET['bbh_flu_codigo'];
	$_SESSION['upl_rel_codigo'] = $_GET['bbh_rel_codigo'];
	//--
	$barra = '<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
			  <tr>
				<td height="23" align="right" bgcolor="#FFFFFF"><a href="#@" onClick="window.top.document.getElementById(\'carregaTudo\').innerHTML = \'&nbsp;\';"><span style="color:#F60"><strong>Fechar janela de fotos</strong></span>&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/fechar.gif" width="18" height="18" border="0" align="absmiddle" /></a></td>
			  </tr>
			</table>';	
	//--
	$uploadPHP 		= "/corporativo/servicos/bbhive/relatorios/painel/fotos/upload.php";
	$fecharPHP 		= "window.top.location.href='/corporativo/servicos/bbhive/index.php'";
	$fecharPHP      = "window.top.LoadSimultaneo('perfil/index.php?perfil=1&tarefas=1|relatorios/painel/propriedades.php?bbh_rel_codigo={$_GET['bbh_rel_codigo']}&bbh_ati_codigo={$_GET['bbh_ati_codigo']}','menuEsquerda|ambienteRelatorio');window.top.document.getElementById('carregaTudo').innerHTML = '';";

	$tipoArquivo 	= '{title : "Arquivos de imagens", extensions : "jpg,gif,png,bmp"}'; 
	//--
	require_once("../../../includes/js_css/upload_multiplo/index.php");
exit;
?>