<?php
// Configuração do Gráfico


if(count($dados) < 8){
	$altura = 500;
	$largura = 700;
	$lx = 650;
}elseif(count($dados) < 30){
	$altura = 700;
	$largura = 1000;
	$lx = 900;
}elseif(count($dados) > 30){
	$altura = 1500;
	$largura = 1000;
	$lx = 900;
}elseif(count($dados) > 90){
	$altura = 5000;
	$largura = 1000;
	$lx = 900;
}

//Configuração do círculo
$centrox = 200;
$centroy = 200;
$diametro = 280;
$angulo = 0;

//Configuração da legenda
$exibir_legenda = "sim";
$fonte = 3;
$largura_fonte = 8;
$altura_fonte = 10;
$espaco_entre_linhas = 10;
$margem_vertical = 5;

//canto superior da legenda

$ly = 30;

?>