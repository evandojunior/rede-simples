<?php 

foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){	$bbh_ati_codigo= $valor; } 
	if(($indice=="amp;bbh_rel_codigo")||($indice=="bbh_rel_codigo")){ 	$bbh_rel_codigo= $valor; } 
}

require_once("includes/cabecalhoModeloFluxo.php");
require_once("includes/cabecalhoAtividade.php");
require_once("includes/functions.php");
$finalizado = relatorioFinalizado($database_bbhive, $bbhive, $bbh_ati_codigo);

$bbh_flu_codigo = $atividade->codigoFluxo;

	//minha versão
	$query_versao = "select count(*) as versao, 
 (select bbh_rel_titulo from bbh_relatorio where bbh_rel_codigo = $bbh_rel_codigo) as bbh_rel_titulo 
    from bbh_relatorio where bbh_ati_codigo = $bbh_ati_codigo and bbh_rel_codigo <= $bbh_rel_codigo";
    list($versao, $row_versao, $totalRows_versao) = executeQuery($bbhive, $database_bbhive, $query_versao);

	unset($_SESSION['arquivos_externos']);
?><div style="position: absolute; z-index:7000;background-color:#FFF" id="carregaTudo">&nbsp;</div><div style="background-color:#FFF; width:992px; height:675px;" align="center" id="hmRelatorio">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:10px;">
  <tr>
    <td height="23" align="left" bgcolor="#FFFFFF" class="verdana_11 color">&nbsp;<strong>Gerenciamento de relat&oacute;rios - <?php echo $row_Modelo['bbh_mod_flu_nome']." - ".$row_Modelo['bbh_flu_autonumeracao']."/".$row_Modelo['bbh_flu_anonumeracao']; ?></strong></td>
  </tr>
  <tr>
    <td height="23" align="left" bgcolor="#FFFFFF" style="background-image:url(/corporativo/servicos/bbhive/images/painel/dividos.gif); background-repeat:no-repeat; background-position:bottom; font-size:15px" class="verdana_11 color">&nbsp;<strong><?php echo $row_versao['bbh_rel_titulo']; ?></strong></td>
  </tr>
</table>
<?php require_once("includes/menu_propriedades.php"); 
 
	if($finalizado > 0){ ?>
    	<div style="color:#F60; font-size:16px;height:25px; vertical-align:text-bottom" align="center" class="titulo_setor">Atividade finalizada!!!</div>
    <?php } ?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#A0AFC3 solid 1px; margin-left:10px;margin-top:10px;">
  <tr>
    <td height="23" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><div style="position:absolute; width:98%;color:#F60" align="center"><strong>Versão <?php echo $row_versao['versao']; ?></strong></div>&nbsp;<img src="/corporativo/servicos/bbhive/images/setaII.gif" border="0" align="absmiddle" />&nbsp;<strong><?php echo $atividade->nome; ?></strong>
    
    </td>
  </tr>
  <tr>
    <td width="194" height="25" align="left" valign="middle" bgcolor="#F5F9FD" class="verdana_12" style="border-right:#A0AFC3 solid 1px;border-bottom:#A0AFC3 solid 1px;">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/anexos.gif" align="absmiddle" />&nbsp;<strong>(<label id="qtAnexos">0</label>) anexos</strong></td>
    <td width="776" height="400" rowspan="4" align="left" valign="top" bgcolor="#FFFFFF">
    <div style="overflow:auto; height:415px;" id="listaParagrafos" class="verdana_12">
    <?php require_once("includes/lista.php"); ?>
  	</div>
    </td>
  </tr>
  <tr>
    <td height="180" align="left" valign="top" bgcolor="#FFFFFF" style="border-right:#A0AFC3 solid 1px;border-bottom:#A0AFC3 solid 1px;"><iframe src="" allowtransparency="1" frameborder="0" height="180" width="190" id="listaAnexos" name="listaAnexos"></iframe></td>
  </tr>
  <tr>
    <td height="25" align="left" valign="middle" bgcolor="#F5F9FD" style="border-right:#A0AFC3 solid 1px;border-bottom:#A0AFC3 solid 1px;" class="verdana_12">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/ferramentas.gif" align="absmiddle" />&nbsp;<strong>A&ccedil;&atilde;o</strong></td>
  </tr>
  <tr>
    <td height="180" align="left" valign="top" bgcolor="#FFFFFF" style="border-right:#A0AFC3 solid 1px;"><iframe src="/corporativo/servicos/bbhive/relatorios/painel/includes/acao.php?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo; ?>&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>" allowtransparency="1" frameborder="0" height="180" width="190"></iframe></td>
  </tr>
</table>
</div>