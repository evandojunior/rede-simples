<?php
if(!isset($_SESSION)){ session_start(); } 

include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

	foreach($_GET as $indice=>$valor){
		if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ 	$bbh_flu_codigo= $valor; } 
	}

	$query_Fluxos = "select bbh_fluxo.bbh_flu_codigo, bbh_mod_ati_codigo, bbh_fluxo.bbh_mod_flu_codigo, 
			DATE_FORMAT(bbh_flu_data_iniciado, '%d/%m/%Y') as bbh_flu_data_iniciado, bbh_flu_titulo, 	
					bbh_mod_flu_nome, bbh_tip_flu_identificacao, bbh_flu_observacao,
					 ROUND(SUM(bbh_sta_ati_peso)/count(bbh_fluxo.bbh_flu_codigo),2) as concluido
					 	from bbh_fluxo 
					
					inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo 
					inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo 
					inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
					inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
					
						Where bbh_fluxo.bbh_flu_codigo = $bbh_flu_codigo
							group by bbh_fluxo.bbh_flu_codigo
								order by bbh_flu_codigo desc LIMIT 0,1";
    list($fluxo, $row_fluxo, $totalRows_fluxo) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);
	
	$bbh_mod_flu_codigo = $row_Fluxos['bbh_mod_flu_codigo'];
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11 color">
  <tr>
    <td><?php require_once("cabecalhoModeloFluxo.php"); ?>
      <div style="float:right; "><strong><span id="statusFluxo">0.00%</span></strong></div>
    </td>
  </tr>
  <tr>
    <td height="4" background="/corporativo/servicos/bbhive/images/barra_tar.gif"></td>
  </tr>
  <tr>
    <td height="20" align="right" class="verdana_11"> 
    	<label id="maisInfo" style="float:right"><a href="#@" onClick="javascript: document.getElementById('tabFluxo').style.display='block';document.getElementById('maisInfo').style.display='none';document.getElementById('menosInfo').style.display='block';"><span class="color">[ Mais informa&ccedil;&otilde;es ]</span></a></label>
        <label id="menosInfo" style="display:none;float:right"><a href="#@" onClick="javascript: document.getElementById('tabFluxo').style.display='none';document.getElementById('menosInfo').style.display='none';document.getElementById('maisInfo').style.display='block';"><span class="color">[ Menos informa&ccedil;&otilde;es ]</span></a></label>
        &nbsp;&nbsp;</td>
  </tr>
</table>
<br>
<table width="595" border="0" cellpadding="0" cellspacing="0" class="verdana_11" id="tabFluxo" style="display:none">
  <tr>
    <td width="570" height="25" colspan="2" bgcolor="#FAFAFA"  style="cursor:pointer">&nbsp;<img src="/corporativo/servicos/bbhive/images/listaIII.gif" border="0" align="absmiddle" />&nbsp;<strong><?php echo $row_Fluxos['bbh_flu_titulo']; ?></strong></td>
  </tr>
  <tr>
    <td height="25" colspan="2">&nbsp;&nbsp;&nbsp;<img src="/corporativo/servicos/bbhive/images/casos.gif" width="24" height="24" align="absmiddle" />&nbsp;<strong><?php echo normatizaCep($row_Fluxos['bbh_tip_flu_identificacao'])."&nbsp;".$row_Fluxos['bbh_mod_flu_nome']; ?></strong></strong>&nbsp;</td>
  </tr>
  
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
  <tr>
    <td height="22" colspan="2">&nbsp;&nbsp;&nbsp;<img src="/corporativo/servicos/bbhive/images/marcador.gif" width="4" height="6" />&nbsp;<strong>T&iacute;tulo:</strong> <?php echo $row_Fluxos['bbh_flu_titulo']; ?>
    </td>
  </tr>
  <tr>
    <td height="22" colspan="2"><label style="float:right;margin-right:15px;" class="color">Iniciado em <?php echo $row_Fluxos['bbh_flu_data_iniciado']; ?></label></td>
  </tr>
  
  <tr>
    <td height="22" colspan="2" bgcolor="#FAFAFA"  style="cursor:pointer">&nbsp;<img src="/corporativo/servicos/bbhive/images/engrenagem.gif" border="0" align="absmiddle" />&nbsp;<strong>Descri&ccedil;&atilde;o da fluxo </strong></td>
  </tr>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr>
    <td height="22" colspan="2"><?php echo nl2br($row_Fluxos['bbh_flu_observacao']); ?></td>
  </tr>
  <tr>
    <td height="22" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td height="4" background="/corporativo/servicos/bbhive/images/barra_tar.gif" colspan="2"></td>
  </tr>
</table><form name="updateFluxo" id="updateFluxo" style="margin-top:5px;width:300px;">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="33" class="verdana_12">&nbsp;<img src="/corporativo/servicos/bbhive/images/28.gif" width="19" height="19" align="absmiddle">&nbsp;Cadastre o m&aacute;ximo de informa&ccedil;&otilde;es poss&iacute;veis, pois isso facilitar&aacute; o andamento do <?php echo $_SESSION['FluxoNome']; ?>.</td>
  </tr>
  <tr>
    <td width="595" height="33" background="/corporativo/servicos/bbhive/images/backTopII.jpg" style="border-left:#D7D7D7 solid 1px;">
    <div id="titulo" style="width:117px; height:25px; margin-top:5px; vertical-align:middle;font-weight:bold;" class="verdana_12 color">&nbsp;<strong>Detalhamento</strong></div>
    <div id="conteudoDetalhamento" class="verdana_11 color" style="position:absolute;z-index:500000; margin-top:-20px; margin-left:280px">&nbsp;</div>
    </td>
  </tr>
  <tr>
    <td height="200" valign="top" style="border-left:#D7D7D7 solid 1px; border-right:#EBEFF0 solid 1px; border-bottom:#D7D7D7 solid 1px" id="corpoFluxo" >
    <div id="detalhamento" 	class="show"><span class="verdana_12">&nbsp;Carregando dados...</span></div>
	<div id="atividade" 	class="hide">&nbsp;</div>
    </td>
  </tr>
</table>
</form>
<?php
/*
	Responsável pela chamada assíuncrona dos objetos que serão listados na página
	Chamo apenas um objeto e ele faz o resto
*/
$TimeStamp 		= time();
$homeDestino	= '/corporativo/servicos/bbhive/fluxo/detalhamento/edita.php?bbh_mod_flu_codigo='.$bbh_mod_flu_codigo.'&bbh_flu_codigo='.$bbh_flu_codigo.'&cadastraDet=true&Ts='.$TimeStamp."&";
$carregaPagina	= "OpenAjaxPostCmd('".$homeDestino."','detalhamento','&1=1','&nbsp;Carregando dados...','atividade','2','1');";
?>
<var style="display:none"><?php echo $carregaPagina; ?></var>