<?php
 if(isset($_GET['acao'])){
	include_once("classes/GeraGraficoPizza.php");
	header("Content-type: image/png");
				
	// ------ definição dos dados ----------
	$dados 			= array("Casa","Cachorro", "Gato", "Passaro");
	$valores 		= array("10","25","40","17");
	$exibir_legenda = "sim";
	
	$GGB = new GeraGraficoPizza($dados,$valores,$exibir_legenda);
	exit;
 }
?>
<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
     <fieldset>
     	<legend><strong>Gráfico de Pizza - Policy</strong></legend>
    <iframe allowtransparency="true" src="grafico_pizza.php?acao=true" name="autPOLICY" height="550" width="750" frameborder="0"></iframe>
     </fieldset>
    </td>
  </tr>
</table>