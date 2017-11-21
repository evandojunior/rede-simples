<?php
//FLUXO EM QUESTÃO
	$SQL=" and bbh_flu_tarefa_pai is NULL";
	if(isset($_GET['bbh_flu_codigo'])){
		$SQL = " and bbh_flu_codigo=".$_GET['bbh_flu_codigo'];
	}
	$query_Fluxos = "select bbh_flu_codigo, bbh_fluxo.bbh_mod_flu_codigo, bbh_flu_data_iniciado, bbh_flu_titulo, bbh_mod_flu_nome, bbh_tip_flu_identificacao, bbh_flu_observacao from bbh_fluxo
		inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo
		inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo
		  Where bbh_usu_codigo = ".$_SESSION['usuCod']." $SQL
			   order by bbh_flu_codigo desc
				LIMIT 0,1";
    list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);
	
	$codigoFluxo =0;
	if($totalRows_Fluxos>0){
		$codigoFluxo = $row_Fluxos['bbh_flu_codigo'];
	}
?>