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
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Upload de Imagens</title>
</head>

<body>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:10px;">
  <tr>
    <td height="23" align="left" bgcolor="#FFFFFF" style="background-image:url(/corporativo/servicos/bbhive/images/painel/dividos.gif); background-repeat:no-repeat; background-position:bottom;" class="verdana_11 color">&nbsp;<strong>Gerenciamento de relat&oacute;rios - <?php echo $row_Modelo['bbh_mod_flu_nome']." - ".$row_Modelo['bbh_flu_autonumeracao']."/".$row_Modelo['bbh_flu_anonumeracao']; ?></strong></td>
  </tr>
  <tr>
    <td height="520" align="left" bgcolor="#FFFFFF"class="verdana_11 color">
<iframe src="relatorios/painel/anexos/gerencia.php?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo; ?>&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>" name="fotos" id="fotos" width="100%" height="100%" allowtransparency="1" frameborder="0" scrolling="auto" />
    </td>
  </tr>
</table>

</body>
</html>