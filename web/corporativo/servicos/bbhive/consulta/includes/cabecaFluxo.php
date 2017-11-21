<?php
$query_CabFluxo = "select bbh_fluxo.bbh_flu_codigo, bbh_flu_titulo
from bbh_atividade 
inner join bbh_modelo_atividade on bbh_atividade.bbh_mod_ati_codigo = bbh_modelo_atividade.bbh_mod_ati_codigo 
inner join bbh_fluxo on bbh_atividade.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo 
Where bbh_fluxo.bbh_flu_codigo=$bbh_flu_codigo";
list($CabFluxo, $row_CabFluxo, $totalRows_CabFluxo) = executeQuery($bbhive, $database_bbhive, $query_CabFluxo);

$query_Modelo = "select bbh_flu_autonumeracao, bbh_tip_flu_identificacao, bbh_mod_flu_nome, bbh_flu_anonumeracao 
	from bbh_fluxo
		inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo
		inner join bbh_tipo_fluxo  on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo
			Where bbh_flu_codigo =".$row_CabFluxo['bbh_flu_codigo'];
list($Modelo, $row_Modelo, $totalRows_Modelo) = executeQuery($bbhive, $database_bbhive, $query_Modelo);

//--
	$nomeFluxo 		= $row_Modelo['bbh_mod_flu_nome'];
	$autoNumeracao	= $row_Modelo['bbh_flu_autonumeracao'];
	$tipoProcesso	= explode(".",$row_Modelo['bbh_tip_flu_identificacao']);
	$tipoProcesso	= (int)$tipoProcesso[0];
	$anoNumeracao	= $row_Modelo['bbh_flu_anonumeracao'];
	//--
	$numeroProcesso	= $nomeFluxo . " - " . $autoNumeracao . "." . $tipoProcesso . "/" . $anoNumeracao;
	//--
//--	
?>