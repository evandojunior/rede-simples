<?php
	//descobre o Fluxo desta atividade
	$query_Fluxo =  "select bbh_fluxo.bbh_flu_codigo, bbh_mod_ati_codigo, bbh_fluxo.bbh_mod_flu_codigo, DATE_FORMAT(bbh_flu_data_iniciado, '%d/%m/%Y') as bbh_flu_data_iniciado, bbh_flu_titulo, 	
					bbh_mod_flu_nome, bbh_tip_flu_identificacao, bbh_tip_flu_nome, bbh_flu_observacao,
					 ROUND(SUM(bbh_sta_ati_peso)/count(bbh_fluxo.bbh_flu_codigo),2) as concluido, bbh_dep_nome, MAX(bbh_ati_final_previsto) as final, bbh_usu_apelido, bbh_usu_nome, bbh_flu_finalizado
					 	from bbh_fluxo 
					
					inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo 
					inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo 
					inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
					inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
					inner join bbh_usuario on bbh_fluxo.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
					inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
						Where bbh_fluxo.bbh_flu_codigo = $bbh_flu_codigo
							group by bbh_fluxo.bbh_flu_codigo
								order by bbh_flu_codigo desc LIMIT 0,1";
    list($Fluxo, $row_Fluxo, $totalRows_Fluxo) = executeQuery($bbhive, $database_bbhive, $query_Fluxo);
	
    //quantas tem no fluxo
	$query_strArquivos = "select count(bbh_arq_codigo) as total from bbh_arquivo Where bbh_arq_compartilhado = '1' and bbh_flu_codigo=$bbh_flu_codigo";
    list($strArquivos, $row_strArquivos, $totalRows_strArquivos) = executeQuery($bbhive, $database_bbhive, $query_strArquivos);
	
    //quantas tarefas tem no fluxo
	$query_strMinhasTarefas = "select count(bbh_ati_codigo) as total from bbh_atividade Where bbh_flu_codigo=$bbh_flu_codigo";
    list($strMinhasTarefas, $row_strMinhasTarefas, $totalRows_strMinhasTarefas) = executeQuery($bbhive, $database_bbhive, $query_strMinhasTarefas);
?>