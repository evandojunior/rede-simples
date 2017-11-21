<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");
	
//troca a ordem do modelo de atividade
$bbh_cam_list_ordem		= $_GET['ordem'];
$bbh_cam_list_codigo	= $_GET['bbh_cam_list_codigo'];
$homeDestinoOrdem		= "/e-solution/servicos/bbhive/configuracao/lista_dinamica/gerenciamento/index.php";

function listaCampos($database_bbhive, $bbhive, $bbh_cam_list_codigo, $aOrdem){
	$comp = " and bbh_cam_list_ordem=$aOrdem";
	//--Descobre a lista
	$query_lista = "SELECT bbh_cam_list_titulo FROM bbh_campo_lista_dinamica where bbh_cam_list_codigo=$bbh_cam_list_codigo";
    list($gerenciamentolista, $row_lista, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_lista);
	
	$bbh_cam_list_titulo = $row_lista["bbh_cam_list_titulo"];
	define("tituloLista", $bbh_cam_list_titulo);
	//--
	$query_ordem = "select * FROM bbh_campo_lista_dinamica Where bbh_cam_list_titulo='$bbh_cam_list_titulo' $comp";
    list($ordem, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_ordem, $initResult = false);
		//cria vetor com campos e valores a serem atualizados
		$cadaCampo = array(); $colunas   = array();
		//================================================================	
			$i = 0;
			#while ($i < mysqli_num_fields($ordem)) {
    		while ($meta = mysqli_fetch_field($ordem)) {
				#$meta = mysqli_fetch_field($ordem, $i);
					$cadaCampo[$meta->name] = "";
				$i++;
			}$i = 0;
		//================================================================
    	list($ordem, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_ordem, $initResult = false);
		//================================================================	
			while ($row_ordem = mysqli_fetch_assoc($ordem)){
				foreach($cadaCampo as $indice => $valor){
					$cadaCampo[$indice] = $row_ordem[$indice];
				}
			}
		//================================================================	
		return $cadaCampo;
}

function atualizaOrdem($database_bbhive, $bbhive, $campos, $bbh_cam_list_codigo, $ordem){
		
	$cadaCampo = "bbh_cam_list_ordem='$ordem' ";
		foreach($campos as $indice => $valor){
			if($indice!="bbh_cam_list_codigo" && $indice!="bbh_cam_list_ordem"){
				$cadaCampo.= ", ".$indice."='$valor'";
			}
		}
	
	$updateSQL = "UPDATE bbh_campo_lista_dinamica SET ".($cadaCampo)." WHERE bbh_cam_list_codigo = $bbh_cam_list_codigo";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL, $initResult = false);
}

//==============================================================================================================================

	if($_GET['acao']=="descer"){
		//verifico quem é o proximo para trocar comigo
		$nvOrdem = $bbh_cam_list_ordem + 1;
		$campos	 = listaCampos($database_bbhive, $bbhive, $bbh_cam_list_codigo, $nvOrdem);

		//verifico meus dados
		$osCampos= listaCampos($database_bbhive, $bbhive, $bbh_cam_list_codigo, $bbh_cam_list_ordem);

		//1º UPDATE
		atualizaOrdem($database_bbhive, $bbhive, $campos, $osCampos['bbh_cam_list_codigo'], $osCampos['bbh_cam_list_ordem']);
		
		//2º UPDATE
		atualizaOrdem($database_bbhive, $bbhive, $osCampos, $campos['bbh_cam_list_codigo'], $campos['bbh_cam_list_ordem']);
		//================================================================

	} else {
		//verifico quem é o proximo para trocar comigo
		$nvOrdem = $bbh_cam_list_ordem - 1;
		$campos	 = listaCampos($database_bbhive, $bbhive, $bbh_cam_list_codigo, $nvOrdem);
		
		//verifico meus dados
		$osCampos= listaCampos($database_bbhive, $bbhive, $bbh_cam_list_codigo, $bbh_cam_list_ordem);
	
		//1º UPDATE
		atualizaOrdem($database_bbhive, $bbhive, $campos, $osCampos['bbh_cam_list_codigo'], $osCampos['bbh_cam_list_ordem']);
		//2º UPDATE
		atualizaOrdem($database_bbhive, $bbhive, $osCampos, $campos['bbh_cam_list_codigo'], $campos['bbh_cam_list_ordem']);
		//================================================================

	}

echo "<var style='display:none'>OpenAjaxPostCmd('".$homeDestinoOrdem."?bbh_cam_list_titulo=".tituloLista."','conteudoGeral','&1=1','Atualizando dados...','conteudoGeral','2','2');</var>";
?>

