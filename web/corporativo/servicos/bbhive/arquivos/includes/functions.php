<?php
$meusArquivos = "select 
		 bbh_arq_codigo,
		 DATE_FORMAT(bbh_arq_data_modificado, '%d/%m/%Y %H:%i:%s') as publicado,
		 bbh_arq_tipo as tipo,
		 bbh_arq_titulo as titulo,
		 bbh_arq_autor as autor,
		 bbh_flu_titulo as titulo_fluxo,
		 bbh_arq_mime,
		 bbh_arq_compartilhado,
		 bbh_arquivo.bbh_flu_codigo,
		 bbh_mod_flu_nome,
		 bbh_flu_finalizado,
		 bbh_arq_publico,
		 bbh_flu_autonumeracao, bbh_tip_flu_identificacao, bbh_flu_anonumeracao,
		 concat(bbh_flu_autonumeracao,'/',bbh_flu_anonumeracao) numero,
		 concat(bbh_arq_localizacao,'/',bbh_arq_nome) arquivo
		from bbh_arquivo 
		  inner join bbh_fluxo on bbh_arquivo.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo
		  inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo
		  inner join bbh_tipo_fluxo  on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo
			Where bbh_arquivo.bbh_usu_codigo = $bbh_usu_codigo 
		  	 ORDER BY bbh_arquivo.bbh_flu_codigo DESC, bbh_arq_codigo ASC";
			
$fluxoArquivos = "select 
		 bbh_arq_codigo,
		 DATE_FORMAT(bbh_arq_data_modificado, '%d/%m/%Y') as publicado,
		 bbh_arq_tipo as tipo,
		 bbh_arq_titulo as titulo,
		 bbh_arq_autor as autor,
		 bbh_flu_titulo as titulo_fluxo,
		 bbh_flu_finalizado,
		 bbh_arq_mime,
		 bbh_arq_compartilhado,
		 bbh_arquivo.bbh_flu_codigo,
		 bbh_mod_flu_nome,
		 bbh_flu_autonumeracao, bbh_tip_flu_identificacao, bbh_flu_anonumeracao,
		 concat(bbh_flu_autonumeracao,'/',bbh_flu_anonumeracao) numero,
		 concat(bbh_arq_localizacao,'/',bbh_arq_nome) arquivo
		from bbh_arquivo 
		  inner join bbh_fluxo on bbh_arquivo.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo
		  inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo
		  inner join bbh_tipo_fluxo  on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo
		  inner join bbh_usuario on bbh_arquivo.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
		Where 
		(bbh_arquivo.bbh_flu_codigo = $bbh_flu_codigo AND bbh_arq_compartilhado='1') 
		 #OR bbh_arquivo.bbh_usu_codigo=$bbh_usu_codigo
		 #AND bbh_dep_codigo = (select bbh_dep_codigo FROM bbh_usuario Where bbh_usu_codigo = $bbh_usu_codigo)
		 AND bbh_arquivo.bbh_flu_codigo IN (
											select bbh_fluxo.bbh_flu_codigo from bbh_fluxo
											  inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
											   Where bbh_atividade.bbh_usu_codigo = $bbh_usu_codigo
												 group by bbh_fluxo.bbh_flu_codigo
											)
		   ORDER BY bbh_arquivo.bbh_flu_codigo DESC, bbh_arq_codigo ASC";
		   
		   
$compartilhadoArquivos = "select 
		 bbh_arq_codigo,
		 DATE_FORMAT(bbh_arq_data_modificado, '%d/%m/%Y') as publicado,
		 bbh_arq_tipo as tipo,
		 bbh_arq_titulo as titulo,
		 bbh_arq_autor as autor,
		 bbh_flu_titulo as titulo_fluxo,
		 bbh_arq_mime,
		 bbh_arq_compartilhado,
		 bbh_dep_codigo,
		 bbh_arq_nome_logico,
		 bbh_arq_titulo,
		 bbh_arq_autor,
		 bbh_flu_titulo,
		 bbh_arquivo.bbh_flu_codigo,
		 bbh_mod_flu_nome,
		 bbh_flu_finalizado,
		 bbh_flu_autonumeracao, bbh_tip_flu_identificacao, bbh_flu_anonumeracao,
		 concat(bbh_flu_autonumeracao,'/',bbh_flu_anonumeracao) numero,
		 concat(bbh_arq_localizacao,'/',bbh_arq_nome) arquivo
		from bbh_arquivo 
		  inner join bbh_fluxo on bbh_arquivo.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo
		  inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo
		  inner join bbh_tipo_fluxo  on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo
		  inner join bbh_usuario on bbh_arquivo.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
		Where 
		 bbh_arq_compartilhado='1' 
		 #AND bbh_dep_codigo = (select bbh_dep_codigo FROM bbh_usuario Where bbh_usu_codigo = $bbh_usu_codigo) 
		 AND bbh_arquivo.bbh_flu_codigo IN (
											select bbh_fluxo.bbh_flu_codigo from bbh_fluxo
											  inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
											  inner join bbh_usuario on bbh_atividade.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
											   Where (bbh_atividade.bbh_usu_codigo = $bbh_usu_codigo OR bbh_usuario.bbh_usu_chefe=$bbh_usu_codigo)
												 group by bbh_fluxo.bbh_flu_codigo
											)
		 $compl
		  $group 
		   ORDER BY bbh_arquivo.bbh_flu_codigo DESC, bbh_arq_codigo ASC";
		   
		// # 
$buscaArquivos = "select 
		 bbh_arq_codigo,
		 DATE_FORMAT(bbh_arq_data_modificado, '%d/%m/%Y') as publicado,
		 bbh_arq_tipo as tipo,
		 bbh_arq_titulo as titulo,
		 bbh_arq_autor as autor,
		 bbh_flu_titulo as titulo_fluxo,
		 bbh_arq_mime,
		 bbh_arq_compartilhado,
		 bbh_dep_codigo,
		 bbh_arq_nome_logico,
		 bbh_arq_titulo,
		 bbh_arq_autor,
		 bbh_flu_titulo,
		 bbh_flu_finalizado,
		 bbh_arquivo.bbh_flu_codigo,
		 bbh_mod_flu_nome,
		 bbh_flu_autonumeracao, bbh_tip_flu_identificacao, bbh_flu_anonumeracao,
		 concat(bbh_flu_autonumeracao,'/',bbh_flu_anonumeracao) numero,
		 concat(bbh_arq_localizacao,'/',bbh_arq_nome) arquivo
		from bbh_arquivo 
		  inner join bbh_fluxo on bbh_arquivo.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo
		  inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo
		  inner join bbh_tipo_fluxo  on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo
		  inner join bbh_usuario on bbh_arquivo.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
		Where 
		 bbh_arq_compartilhado='1' 
		 #AND bbh_dep_codigo = (select bbh_dep_codigo FROM bbh_usuario Where bbh_usu_codigo = $bbh_usu_codigo) 
		 AND bbh_arquivo.bbh_flu_codigo IN (
											select bbh_fluxo.bbh_flu_codigo from bbh_fluxo
											  inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
											   Where bbh_atividade.bbh_usu_codigo = $bbh_usu_codigo
												 group by bbh_fluxo.bbh_flu_codigo
											)
		 $compl
		   ORDER BY bbh_arquivo.bbh_flu_codigo DESC, bbh_arq_codigo ASC";
		   

$arquivosFluxo = "SELECT 
		 bbh_arq_codigo, DATE_FORMAT(bbh_arq_data_modificado, '%d/%m/%Y %H:%i:%s') AS publicado,
		 bbh_arq_tipo AS tipo,
		 bbh_arq_titulo AS titulo,
		 bbh_arq_autor AS autor,
		 bbh_flu_titulo AS titulo_fluxo,
		 bbh_arq_mime,
		 bbh_arq_compartilhado,
		 arq.bbh_flu_codigo,
		 bbh_mod_flu_nome,
		 bbh_flu_finalizado,
		 bbh_arq_publico,
		 bbh_flu_autonumeracao, bbh_tip_flu_identificacao, bbh_flu_anonumeracao, CONCAT(bbh_flu_autonumeracao,'/',bbh_flu_anonumeracao) numero, CONCAT(bbh_arq_localizacao,'/',bbh_arq_nome) arquivo
FROM bbh_arquivo arq
INNER JOIN bbh_fluxo flu ON arq.bbh_flu_codigo = flu.bbh_flu_codigo
INNER JOIN bbh_modelo_fluxo mod_flu ON flu.bbh_mod_flu_codigo = mod_flu.bbh_mod_flu_codigo
INNER JOIN bbh_tipo_fluxo tip_flu ON mod_flu.bbh_tip_flu_codigo = tip_flu.bbh_tip_flu_codigo
WHERE arq.bbh_flu_codigo = $bbh_flu_codigo
ORDER BY arq.bbh_flu_codigo DESC, bbh_arq_codigo ASC";
?>