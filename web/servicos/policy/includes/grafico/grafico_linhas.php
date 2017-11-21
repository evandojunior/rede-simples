<?php
 if(isset($_GET['acao'])){
	include_once("classes/GeraGraficoLinhas.php");
	header("Content-type: image/png");
				
	// ------ definição dos dados ----------
	$texto_linha 	= array("Casa","Cachorro","Gato","Passaro");
	$texto_coluna 	= array("1980","1990","2000","2010");
	$valores 		= array(10,15,20,30,85,62,22,12,20,65,64,66,3,9,27,81);
	
	$nomeTituloEixoX= "Eventos cadastrados";
	$nomeTituloEixoY= "Número de acesso";
	$nmTituloGrafico= "Equipe Backsite";
	$exibir_legenda	= "sim";//s - Sim // n - Não
		
	$GGL = new GeraGraficoLinha($texto_linha,$texto_coluna, $valores,$nomeTituloEixoX,$nomeTituloEixoY,$nmTituloGrafico,$exibir_legenda);
	exit;
 }
?>
<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
     <fieldset>
     	<legend><strong>Gr&aacute;fico de Linhas - Policy</strong></legend>
    <iframe allowtransparency="true" src="grafico_linhas.php?acao=true" name="autPOLICY" height="550" width="750" frameborder="0"></iframe>
     </fieldset>
    </td>
  </tr>
</table>