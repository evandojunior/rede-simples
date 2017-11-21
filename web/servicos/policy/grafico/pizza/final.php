<?php
//header('Content-Type: text/html; charset=utf-8');
 if(isset($_GET['acao'])){
//	include_once("classes/GeraGraficoBarra.php");
	require_once("../../includes/grafico/classes/GeraGraficoPizza.php");
	require_once("grafico.php");
	header("Content-type: image/png");

	// ------ definio dos dados ----------
	$dados 			= $texto_linha;
	$valores 		= $valores;
	$exibir_legenda = "sim";
		
	$GGB = new GeraGraficoPizza($dados,$valores,$exibir_legenda);
	exit;
 }
 require_once("grafico.php");
?>
<html>
<head>

<title>Gr&aacute;ficos do Policy</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	color: #333;
}
-->
</style></head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<b><big><big><?php echo $row_dadosPolitica['pol_pol_titulo']; ?></big></big></b>
<hr>
<i>Visualiza&ccedil;&atilde;o por gr&aacute;fico de pizza e estat&iacute;stas</i>
<p>&nbsp;</p>
<p>Gr&aacute;fico: <big><b><?php echo $row_dadosGrafico['pol_graf_titulo']; ?></b></big></p>
<iframe allowtransparency="true" src="final.php?pol_graf_codigo=<?php echo $_GET['pol_graf_codigo']; ?>&acao=true" name="autPOLICY" height="540" width="750" frameborder="0"></iframe><br>
<p>Informa&ccedil;&atilde;o: <big><b>Dados Estat&iacute;sticos</b></big></p>
<table border="1" align="left" cellpadding="3" cellspacing="0">
  <tr>
    <td align="left"><b><?php echo $d=extenso($row_dadosGrafico['pol_graf_grupo']); ?></b></td>
    <td align="center"><b>Acessos</b></td>
    <td align="center"><b>%</b></td>
  </tr>
  <?php for($a=0;$a<count($valores);$a++){?>
  <tr>
    <td align="left"><?php echo $texto_linha[$a]; ?></td>
    <td align="center"><?php echo $valores[$a]; ?></td>
    <td align="center"><?php echo round(($valores[$a]/$total)*100,2); ?>%</td>
  </tr>
  <?php } ?>
  <tr>
    <td align="left"><b>Acessos</b></td>
    <td align="center"><?php echo $total; ?></td>
    <td align="center">100.00%</td>
  </tr>
</table>
</body>
</html>