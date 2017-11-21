<?php
function relatorioFinalizado($database_bbhive, $bbhive, $bbh_ati_codigo){
	$query_relatorios = "SELECT SUM(bbh_rel_finalizado) as finalizados FROM bbh_relatorio WHERE bbh_ati_codigo = $bbh_ati_codigo";
    list($relatorios, $row_relatorios, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_relatorios);
	return $row_relatorios['finalizados'];
}
?>