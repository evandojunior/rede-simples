<?php
// ------ configurações do gráfico ----------
//$titulo = "Eixo Y - $nomeTituloEixoX, Eixo X - $nomeTituloEixoY";
$titulo = "";

/*
if(count($texto_linha) < 8){
	$altura 	= 500;
	$largura 	= 700;
	$lx 		= 650;
}elseif(count($texto_linha) < 30){
	$altura 	= 700;
	$largura 	= 1000;
	$lx 		= 900;
}elseif(count($texto_linha) > 30){
	$altura 	= 1500;
	$largura 	= 1000;
	$lx 		= 900;
}elseif(count($texto_linha) > 90){
	$altura 	= 5000;
	$largura 	= 1000;
	$lx = 900;
}
*/
	$altura 	= 500;
	$largura 	= 700;
	$lx 		= 650;

$largura_eixo_x 	= 450;
$largura_eixo_y 	= 300;
$inicio_grafico_x 	= 70;
$inicio_grafico_y 	= 360;

// ------ configurações da legenda ----------
$exibir_legenda = $exibir_legenda;
$fonte = 2;
$largura_fonte = 6; // largura em pixels (2=6,3=8,4=10)
$altura_fonte = 10; // altura em pixels (2=8,3=10,4=12)
$espaco_entre_linhas = 10;
$margem_vertical = 5;

// canto superior direito da legenda

$ly = 30;
?>
