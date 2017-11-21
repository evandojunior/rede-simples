<?php
$bbh_ati_codigo = $_GET['bbh_ati_codigo'];
$bbh_rel_codigo = $_GET['bbh_rel_codigo'];
require_once("../includes/cabecalhoModeloFluxo.php");
require_once("../includes/cabecalhoAtividade.php");

//grava texto na sessão
foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){	$bbh_ati_codigo= $valor; } 
	if(($indice=="amp;bbh_rel_codigo")||($indice=="bbh_rel_codigo")){ 	$bbh_rel_codigo= $valor; } 
	if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ 	$bbh_flu_codigo= $valor; } 
	if(($indice=="amp;bbh_par_codigo")||($indice=="bbh_par_codigo")){ 	$bbh_par_codigo= $valor; } 
}
//=====================

if(isset($bbh_par_codigo)){
	//verifico o texto e coloco os dados na sessão
	$query_txtSessao = "select bbh_par_codigo, bbh_par_titulo, bbh_par_paragrafo from bbh_paragrafo where bbh_par_codigo = $bbh_par_codigo";
    list($txtSessao, $row_txtSessao, $totalRows_txtSessao) = executeQuery($bbhive, $database_bbhive, $query_txtSessao);
	
	$_SESSION['bbh_par_titulo']	= $row_txtSessao['bbh_par_titulo'];
	$_SESSION['textoEdito'] 	= $row_txtSessao['bbh_par_paragrafo'];
	$_SESSION['bbh_par_codigo'] = $row_txtSessao['bbh_par_codigo'];
} else {
	$_SESSION['bbh_par_titulo']	= "";
	$_SESSION['textoEdito'] 	= "";
	$_SESSION['bbh_par_codigo'] = "";	
}

?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:10px;">
  <tr>
    <td height="23" align="left" bgcolor="#FFFFFF" style="background-image:url(/corporativo/servicos/bbhive/images/painel/dividos.gif); background-repeat:no-repeat; background-position:bottom;" class="verdana_11 color">&nbsp;<strong>Gerenciamento de relat&oacute;rios - <?php echo $row_Modelo['bbh_mod_flu_nome']." - ".$row_Modelo['bbh_flu_autonumeracao']."/".$row_Modelo['bbh_flu_anonumeracao']; ?></strong></td>
  </tr>
</table>
<?php require_once("../includes/curingas.php"); ?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:4px;">
  <tr>
    <td height="470" bgcolor="#FFFFFF"><iframe src="/corporativo/servicos/bbhive/includes/editorTexto/_samples/fullpage.php?urlRetorno=/relatorios/painel/paragrafos/executaParagrafos.php&bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo; ?>" name="editor" id="editor" width="100%" height="100%" allowtransparency="1" frameborder="0" /></td>
  </tr>
</table>