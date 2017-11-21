<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");
	
//troca a ordem do modelo de atividade
$bbh_mod_ati_codigo = $_GET['bbh_mod_ati_codigo'];
$bbh_mod_ati_ordem	= $_GET['ordem'];
$bbh_mod_flu_codigo	= $_GET['bbh_mod_flu_codigo'];
$homeDestino = "/e-solution/servicos/bbhive/fluxos/modelosFluxos/modelosAtividades/listaAtividades.php";

function listaCampos($database_bbhive, $bbhive, $bbh_mod_flu_codigo, $aOrdem, $modAtividade){
	$comp = empty($modAtividade) ? "bbh_mod_ati_ordem=$aOrdem" : "bbh_mod_ati_codigo=$modAtividade";

	$query_modAti = "select * FROM bbh_modelo_atividade Where bbh_mod_flu_codigo=$bbh_mod_flu_codigo and $comp";
    list($modAti, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_modAti, $initResult = false);
		//cria vetor com campos e valores a serem atualizados
		$cadaCampo = array(); $colunas   = array();
		//================================================================	
			$i = 0;
			while ($i < mysqli_num_fields($modAti)) {
				$meta = mysqli_fetch_field($modAti, $i);
					$cadaCampo[$meta->name]="";
				$i++;
			}$i = 0;
		//================================================================
    	list($modAti, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_modAti, $initResult = false);

		//================================================================	
			while ($row_modAti = mysqli_fetch_assoc($modAti)){
				foreach($cadaCampo as $indice => $valor){
					$cadaCampo[$indice] = $row_modAti[$indice];
				}
			}
		//================================================================	
		return $cadaCampo;
}

function atualizaOrdem($database_bbhive, $bbhive, $campos, $cod_mod_atividade, $ordem){
		
	$cadaCampo = "bbh_mod_ati_ordem='$ordem' ";
		foreach($campos as $indice => $valor){
			if($indice!="bbh_mod_ati_codigo" && $indice!="bbh_mod_ati_ordem"){
				$cadaCampo.= ", ".$indice."='$valor'";
			}
		}
	
	$updateSQL = "UPDATE bbh_modelo_atividade SET ".($cadaCampo)." WHERE bbh_mod_ati_codigo = $cod_mod_atividade";
	list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL, $initResult = false);
}

function analisaPredecessoras($database_bbhive, $bbhive, $bbh_mod_ati_codigo, $campo){
	$sql  = "select * from bbh_dependencia where  $campo = $bbh_mod_ati_codigo";
    list($Pred, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
	$cada="";
	while ($row_Pred = mysqli_fetch_assoc($Pred)){
			$cada.= ",".$row_Pred['bbh_pre_mod_ati_codigo'];
	}
	return substr($cada,1);
}
function atualizaPredSucess($database_bbhive, $bbhive, $condicao, $campo){
	$oSQL = "UPDATE bbh_dependencia SET $campo WHERE bbh_pre_mod_ati_codigo in ($condicao)";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $oSQL, $initResult = false);
}

function analisaAlternativas($database_bbhive, $bbhive, $bbh_mod_ati_codigo){
	$sql = "select * from bbh_fluxo_alternativa Where bbh_mod_ati_codigo = $bbh_mod_ati_codigo";
    list($Alt, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
	$cada="";
	while ($row_Alt = mysqli_fetch_assoc($Alt)){
			$cada.= ",".$row_Alt['bbh_flu_alt_codigo'];
	}
	return substr($cada,1);
}
function atualizaAlternativas($database_bbhive, $bbhive, $condicao, $vlCampo){
	$oSQL = "UPDATE bbh_fluxo_alternativa SET bbh_mod_ati_codigo = $vlCampo WHERE bbh_flu_alt_codigo in ($condicao)";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $oSQL, $initResult = false);
}
//==============================================================================================================================

	if($_GET['acao']=="descer"){
		//verifico quem é o proximo para trocar comigo
		$nvOrdem = $bbh_mod_ati_ordem + 1;
		$campos	 = listaCampos($database_bbhive, $bbhive, $bbh_mod_flu_codigo, $nvOrdem, "");
		
		//verifico meus dados
		$osCampos	 = listaCampos($database_bbhive, $bbhive, $bbh_mod_flu_codigo, $nvOrdem, $bbh_mod_ati_codigo);
		
		//1º UPDATE
		atualizaOrdem($database_bbhive, $bbhive, $campos, $bbh_mod_ati_codigo, $osCampos['bbh_mod_ati_ordem']);
		//2º UPDATE
		atualizaOrdem($database_bbhive, $bbhive, $osCampos, $campos['bbh_mod_ati_codigo'], $campos['bbh_mod_ati_ordem']);
		//================================================================
		//ATUALIZAÇÃO DE PREMISSAS========================================
		require_once("atualizaPremissas.php");
		//================================================================
		//ATUALIZAÇÃO DE ALTERNATIVAS=====================================
		
		//================================================================
	} else {
		//verifico quem é o proximo para trocar comigo
		$nvOrdem = $bbh_mod_ati_ordem - 1;
		$campos	 = listaCampos($database_bbhive, $bbhive, $bbh_mod_flu_codigo, $nvOrdem, "");
		
		//verifico meus dados
		$osCampos	 = listaCampos($database_bbhive, $bbhive, $bbh_mod_flu_codigo, $nvOrdem, $bbh_mod_ati_codigo);
	
		//1º UPDATE
		atualizaOrdem($database_bbhive, $bbhive, $campos, $bbh_mod_ati_codigo, $osCampos['bbh_mod_ati_ordem']);
		//2º UPDATE
		atualizaOrdem($database_bbhive, $bbhive, $osCampos, $campos['bbh_mod_ati_codigo'], $campos['bbh_mod_ati_ordem']);
		//================================================================
		//ATUALIZAÇÃO DE PREMISSAS========================================
		require_once("atualizaPremissas.php");
		//================================================================
		//ATUALIZAÇÃO DE ALTERNATIVAS=====================================
		
		//================================================================
	}

echo "<var style='display:none'>OpenAjaxPostCmd('".$homeDestino."?bbh_mod_flu_codigo=".$_GET['bbh_mod_flu_codigo']."','conteudoListado','&1=1','Atualizando dados...','loadOrdena','2','1');</var>";
?>

