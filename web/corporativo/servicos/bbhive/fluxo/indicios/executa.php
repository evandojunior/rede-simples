<?php
if(!isset($_SESSION)){ session_start(); } 

include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

//TROCA DE RESPONSÁVEL=====================================================================================
	if(isset($_POST['bbh_trocaResponsavel'])){
		$bbh_ind_codigo 		= $_POST['bbh_ind_codigo'];
		$bbh_ind_responsavel	= $_SESSION['MM_User_email'];
		$bbh_ind_dt_recebimento	= date("Y-m-d H:i:s");
		$bbh_flu_codigo			= $_POST['bbh_flu_codigo'];
		
		$updateSQL = "UPDATE bbh_indicio SET bbh_ind_responsavel='$bbh_ind_responsavel', bbh_ind_dt_recebimento='$bbh_ind_dt_recebimento' WHERE bbh_ind_codigo = $bbh_ind_codigo";
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
		
		$retorno = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?bbh_flu_codigo=".$bbh_flu_codigo."&exibeIndicios=true|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=".$bbh_flu_codigo."&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');";
		echo "<var style='display:none'>".$retorno."</var>";
	}
//========================================================================================================

//EXAME REALIZADO=========================================================================================
if(isset($_POST['bbh_exameRealizado'])){
		$bbh_flu_codigo			= $_POST['bbh_flu_codigo'];
		$bbh_ind_codigo 		= $_POST['bbh_ind_codigoReal'];
		$bbh_ind_dt_exame		= $_POST['bbh_realizado']==1 ? "'".arrumadata($_POST['bbh_ind_dt_exame'])."'" : "NULL";
		$bbh_ind_procedimentos	= $_POST['bbh_realizado']==1 ? "'".apostrofo(mysqli_fetch_assoc($_POST['bbh_ind_procedimentos']))."'" : "NULL";
		$bbh_ind_qt_procedimento= $_POST['bbh_realizado']==1 ? "'".$_POST['bbh_ind_qt_procedimento']."'" : "'0'";
		$bbh_ind_profissional	= $_SESSION['MM_BBhive_Email'];
		
		$updateSQL = "UPDATE bbh_indicio SET bbh_ind_dt_exame=$bbh_ind_dt_exame, bbh_ind_procedimentos=$bbh_ind_procedimentos, bbh_ind_qt_procedimento=$bbh_ind_qt_procedimento, bbh_ind_profissional='$bbh_ind_profissional' WHERE bbh_ind_codigo = $bbh_ind_codigo";
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
		
		$retorno = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?bbh_flu_codigo=".$bbh_flu_codigo."&exibeIndicios=true|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=".$bbh_flu_codigo."&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');";
		echo "<var style='display:none'>".$retorno."</var>";
}
//========================================================================================================
?>