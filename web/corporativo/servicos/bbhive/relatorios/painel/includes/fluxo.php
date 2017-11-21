<?php if(!isset($_SESSION)){ session_start(); } 

	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/fluxo/detalhamento/includes/functions.php");
	
foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){	$bbh_flu_codigo= $valor; } 
	if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){	$bbh_ati_codigo= $valor; } 
}

	$query_Fluxos = "select bbh_flu_observacao from bbh_fluxo inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo Where bbh_atividade.bbh_ati_codigo = $bbh_ati_codigo";
    list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);
?><table width="420" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#FFF;border:#A0AFC3 solid 1px; ">
  <tr>
    <td width="287" height="23" align="left" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><span class="verdana_12">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/ferramentas.gif" alt="" align="absmiddle" />&nbsp;<strong>Descri&ccedil;ao <?php echo $_SESSION['FluxoNome']; ?></strong></span></td>
    <td width="131" height="23" align="right" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><a href="#@" onclick="window.top.document.getElementById('carregaTudo').innerHTML = '&nbsp;';"><span style="color:#F60" class="verdana_12"><strong>Fechar janela</strong></span>&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/fechar.gif" width="18" height="18" border="0" align="absmiddle" /></a></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12">&nbsp;</td>
  </tr>
  <tr>
    <td height="200" colspan="2" align="left" valign="top" bgcolor="#FFFFFF" class="verdana_12">
    <div style="margin:10px;"><?php echo nl2br($row_Fluxos['bbh_flu_observacao']); ?></div>
    </td>
  </tr>
  </table>
