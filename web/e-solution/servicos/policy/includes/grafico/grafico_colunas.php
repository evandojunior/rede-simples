<?php
 if(isset($_GET['acao'])){
	include_once("classes/GeraGraficoBarra.php");
	header("Content-type: image/png");
				
	// ------ definição dos dados ----------
	$texto_linha 		= array("Casa","Cachorro","Gato","Passaro");
	$texto_coluna 		= array("10","15","20","30");
	$valores 			= array("10","15","20","30");
	$nomeTituloEixoX	= "Eventos cadastrados";
	$nomeTituloEixoY	= "Número de acesso";
	$nmTituloGrafico	= "Equipe Backsite";
	$exibir_legenda		= "sim";//s - Sim // n - Não
	$exibe_legendaCol	= "nao";
		
	$GGB = new GeraGraficoBarra($texto_linha,$texto_coluna, $valores,$nomeTituloEixoX,$nomeTituloEixoY,$nmTituloGrafico,$exibir_legenda,$exibe_legendaCol);
	exit;
 }
?>
<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
     <fieldset>
     	<legend><strong>Gráfico de Colunas - Policy</strong></legend>
    <iframe allowtransparency="true" src="grafico_colunas.php?acao=true" name="autPOLICY" height="550" width="750" frameborder="0"></iframe>
     </fieldset>
    </td>
  </tr>
</table>