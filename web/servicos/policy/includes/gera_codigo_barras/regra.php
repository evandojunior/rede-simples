<?php
//gera código de barras
$codigo 		= geraCodigo($tratado);//somente com 19 caracteres, completar com zero

$destinoImagem	= '../../../../datafiles/servicos/policy/documentos/codigo_barra/';//caminho de onde a imagem ficará
require_once("gera_codigo.php");

//redimencionaImg($destinoImagem.$codigo.".png", $codigo, $destinoImagem);
?>
