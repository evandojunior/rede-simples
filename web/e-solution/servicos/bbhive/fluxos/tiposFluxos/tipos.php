<?php 
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");



	$idMensagemFinal= 'exibeTipo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulÃ¡rio
	$Mensagem		= 'Atualizando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteÃºdo sem apagar anterior , 2-Troca conteÃºdo apagando o anterior antes
	$homeDestino	= '/e-solution/servicos/bbhive/fluxos/tiposFluxos/lista.php';
	$homeDestinoII	= '/e-solution/servicos/bbhive/fluxos/tiposFluxos/arvore.php';
	

	if(!isset($_GET['page'])){
	
		echo "<var style=\"display:none\">OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')</var>";
		
	} else {
	
		$homeDestinoIII = '/e-solution/servicos/bbhive/fluxos/tiposFluxos/lista.php';

		echo "<var style=\"display:none\">OpenAjaxPostCmd('".$homeDestinoIII."','".$idResultado."','?page=".$_GET['page']."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')</var>";
		
	}
	$onClick = "OpenAjaxPostCmd('".$homeDestinoII."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')";
	$onClick2 = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')";
?>
<var style="display:none">txtSimples('tagPerfil', 'Tipos de <?php echo $_SESSION['adm_FluxoNome']; ?>')</var>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_10">
  <tr>
    <td width="55%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-tipofluxo-16px.gif" width="14" height="16" align="absmiddle" /> Gerenciamento de Tipos de <?php echo $_SESSION['adm_FluxoNome']; ?></td>
    <td width="32%" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><strong>Exibi&ccedil;&atilde;o</strong>: <a href="#" onClick="<?php echo $onClick; ?>"><img src="/e-solution/servicos/bbhive/images/arvore.gif" alt="" width="16" height="16" border="0" align="absmiddle" />&nbsp;&Aacute;rvore</a>&nbsp;&nbsp;<a href="#" onclick="<?php echo $onClick2; ?>"><img src="/e-solution/servicos/bbhive/images/lista.gif" alt="" width="16" height="16" border="0" align="absmiddle" />&nbsp;Lista</a></td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/index.php','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="3"></td>
  </tr>
  <tr>
    <td id="exibeTipo" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>