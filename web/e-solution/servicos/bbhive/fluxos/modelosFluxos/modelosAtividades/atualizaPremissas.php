<?php
//ATUALIZAÇÃO DE PREMISSAS========================================
$Vl_IdSucess  =  analisaPredecessoras($database_bbhive, $bbhive, $bbh_mod_ati_codigo, "bbh_modelo_atividade_sucessora");
$Nv_IdSucess  =  analisaPredecessoras($database_bbhive, $bbhive, $campos['bbh_mod_ati_codigo'], "bbh_modelo_atividade_sucessora");

$Vl_IdPredess = analisaPredecessoras($database_bbhive, $bbhive, $bbh_mod_ati_codigo, "bbh_modelo_atividade_predecessora");
$Nv_IdPredess = analisaPredecessoras($database_bbhive, $bbhive, $campos['bbh_mod_ati_codigo'], "bbh_modelo_atividade_predecessora");

if(!empty($Vl_IdSucess)){
	atualizaPredSucess($database_bbhive, $bbhive, $Vl_IdSucess, "bbh_modelo_atividade_sucessora=".$campos['bbh_mod_ati_codigo']);
}
if(!empty($Nv_IdSucess)){
	atualizaPredSucess($database_bbhive, $bbhive, $Nv_IdSucess, "bbh_modelo_atividade_sucessora=".$bbh_mod_ati_codigo);
}

if(!empty($Vl_IdPredess)){
	atualizaPredSucess($database_bbhive, $bbhive, $Vl_IdPredess, "bbh_modelo_atividade_predecessora=".$campos['bbh_mod_ati_codigo']);
}
if(!empty($Nv_IdPredess)){
	atualizaPredSucess($database_bbhive, $bbhive, $Nv_IdPredess, "bbh_modelo_atividade_predecessora=".$bbh_mod_ati_codigo);
}
//================================================================


//ATUALIZAÇÃO DE ALTERNATIVAS=====================================
$Vl_IdAlt = analisaAlternativas($database_bbhive, $bbhive, $bbh_mod_ati_codigo);
$Nv_IdAlt = analisaAlternativas($database_bbhive, $bbhive, $campos['bbh_mod_ati_codigo']);

if(!empty($Vl_IdAlt)){
	atualizaAlternativas($database_bbhive, $bbhive, $Vl_IdAlt, $campos['bbh_mod_ati_codigo']);
}
if(!empty($Nv_IdAlt)){
	atualizaAlternativas($database_bbhive, $bbhive, $Nv_IdAlt, $bbh_mod_ati_codigo);
}
//================================================================
?>