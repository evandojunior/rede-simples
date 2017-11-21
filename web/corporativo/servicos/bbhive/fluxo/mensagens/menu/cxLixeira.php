<?php
$bbh_flu_codigo = isset($bbh_flu_codigo) ? "AND bbh_flu_codigo=".$bbh_flu_codigo : "";

	$query_mensagens = "
				select * from (
				select 
				 m.bbh_men_codigo,
				 date_format(m.bbh_men_data_recebida,'%d/%m/%Y %H:%i') as momento,
				 date_format(m.bbh_men_data_leitura,'%d/%m/%Y %H:%i') as data_leitura,
				 m.bbh_men_assunto as assunto,
				 r.bbh_usu_apelido as destinatario,
				 d.bbh_usu_apelido as remetente,
				 d.bbh_usu_codigo as cddestinatario,
				 r.bbh_usu_codigo as cdremetente
				 
				  from bbh_mensagens as m
					inner join bbh_usuario as r on m.bbh_usu_codigo_remet  = r.bbh_usu_codigo
					inner join bbh_usuario as d on m.bbh_usu_codigo_destin = d.bbh_usu_codigo
					 Where m.bbh_usu_codigo_remet = ".$_SESSION['usuCod']." AND m.bbh_men_exclusao_remetente ='1'  $bbh_flu_codigo
					       $SQLAjuste
				UNION 
					
				select 
				 m.bbh_men_codigo,
				 date_format(m.bbh_men_data_recebida,'%d/%m/%Y %H:%i') as momento,
				 date_format(m.bbh_men_data_leitura,'%d/%m/%Y %H:%i') as data_leitura,
				 m.bbh_men_assunto as assunto,
				 r.bbh_usu_apelido as remetente,
				 d.bbh_usu_apelido as destinatario,
				 d.bbh_usu_codigo as cddestinatario,
				 r.bbh_usu_codigo as cdremetente
				 
				  from bbh_mensagens as m
					inner join bbh_usuario as r on m.bbh_usu_codigo_remet  = r.bbh_usu_codigo
					inner join bbh_usuario as d on m.bbh_usu_codigo_destin = d.bbh_usu_codigo
					 Where m.bbh_usu_codigo_destin = ".$_SESSION['usuCod']." AND m.bbh_men_exclusao_destinatario ='1' $bbh_flu_codigo
					        $SQLAjuste
				) as mx
					 
						ORDER BY 
							date_format(mx.momento,'%Y') DESC,
							date_format(mx.momento,'%m') DESC ,
							date_format(mx.momento,'%d') DESC, 
							date_format(mx.momento, '%H') DESC, 
							date_format(mx.momento, '%i') DESC, 
							date_format(mx.momento, '%s') DESC";
    list($mensagens, $row_mensagens, $totalRows_mensagens) = executeQuery($bbhive, $database_bbhive, $query_mensagens);

	$query_contadormsg = "SELECT 
							bbh_usu_codigo_destin 
								FROM bbh_mensagens 
									WHERE 
(bbh_mensagens.bbh_usu_codigo_destin = ".$_SESSION['usuCod']." AND bbh_mensagens.bbh_men_exclusao_destinatario = '1'  $bbh_flu_codigo) 
OR 
(bbh_mensagens.bbh_usu_codigo_remet = ".$_SESSION['usuCod']." AND bbh_mensagens.bbh_men_exclusao_remetente = '1' $bbh_flu_codigo) 
	 $SQLAjuste";
    list($contadormsg, $row_contadormsg, $totalRows_contadormsg) = executeQuery($bbhive, $database_bbhive, $query_contadormsg);
	
/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1.1";
$Evento="Acessou a lixeira - BBHive corporativo.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/ 
?>