<?php
if(!isset($_SESSION)){ session_start(); }
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/fluxo/detalhamento/includes/functions.php");
	
	//recebe código do fluxo
	$bbh_flu_codigo = $_GET['bbh_flu_codigo'];
	
	//descobre código da tarefa com atividade final
	$query_Atividade = "select bbh_ati_codigo from bbh_atividade
 inner join bbh_modelo_atividade on bbh_atividade.bbh_mod_ati_codigo = bbh_modelo_atividade.bbh_mod_ati_codigo
   where bbh_flu_codigo = $bbh_flu_codigo AND bbh_mod_atiFim = '1'";
    list($Atividade, $row_Atividade, $totalRows_Atividade) = executeQuery($bbhive, $database_bbhive, $query_Atividade);
	
	//desmarca data final da atividade
		$updateSQL = "UPDATE bbh_atividade SET bbh_ati_final_real = null, bbh_ati_inicio_real = null, bbh_sta_ati_codigo=1 WHERE bbh_ati_codigo=".$row_Atividade['bbh_ati_codigo'];
        list($Result, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
		
	//atualiza fluxo
		$updateSQL = "UPDATE bbh_fluxo SET bbh_flu_finalizado = '0' WHERE bbh_flu_codigo=$bbh_flu_codigo";
        list($Result, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
		
	//redireciona para página do fluxo com atividades em aberto
	echo "<var style='display:none'>showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?bbh_flu_codigo=".$bbh_flu_codigo."&exibeAtividade=true|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=".$bbh_flu_codigo."&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');</var>";
?>