<?php
if(!isset($_SESSION)){ session_start(); } 
require_once($_SESSION['caminhoFisico']."/Connections/bbhive.php");
require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

$stringAND="1=1";
$_SESSION['consultaAvancada'] = "0";

foreach($_POST as $indice=>$valor){
	//verifica se foi checado algum item
	$check = strpos($indice,"chk_");

	if(strlen($check) > 0){
		//Prepara variáveis dinâmicas para montar o select
		$id 		= str_replace("chk_","",$indice);
		$tipoCampo	= $_POST['tp_campo_'.$id];
		$nmCampo	= $_POST['nm_campo_'.$id];
		
		//verifica se é tipo data
		if($tipoCampo=="time_stamp"){
			//recupera dia/mes/ano hora:minuto
			$data_inicial 	= $_POST['ano_inicial_'.$id] ."-". $_POST['mes_inicial_'.$id] ."-". $_POST['dia_inicial_'.$id] ." ". $_POST['hora_inicial_'.$id] .":". $_POST['minuto_inicial_'.$id] .":00";
			$data_final 	= $_POST['ano_final_'.$id] ."-". $_POST['mes_final_'.$id] ."-". $_POST['dia_final_'.$id] ." ". $_POST['hora_final_'.$id] .":". $_POST['minuto_final_'.$id] .":59";
			$stringAND.= " AND ".$nmCampo ." >= '$data_inicial' AND ".$nmCampo." <= '$data_final' ";
			
		} elseif($tipoCampo=="horario_editavel"){
			//recupera dia/mes/ano
			$data_inicial 	= $_POST['ano_inicial_'.$id] ."-". $_POST['mes_inicial_'.$id] ."-". $_POST['dia_inicial_'.$id];
			$data_final 	= $_POST['ano_final_'.$id] ."-". $_POST['mes_final_'.$id] ."-". $_POST['dia_final_'.$id];

			$stringAND.= " AND ".$nmCampo ." >= '$data_inicial' AND ".$nmCampo." <= '$data_final' ";
			
		} elseif($tipoCampo=="numero") {
			$condicao	= $_POST["condicao_".$id];
			$vrCampo	= !empty($_POST["campo_".$id]) ? $_POST["campo_".$id] : 0;
			
			$stringAND.= " AND ".$nmCampo ." $condicao $vrCampo ";
			
		} else {
			$condicao	= $_POST["condicao_".$id];
			$vrCampo	= mysqli_fetch_assoc($_POST["campo_".$id]);
			
				//verifica busca por LIKE
				if($condicao=="inicio"){
					$stringAND.= " AND ".$nmCampo ." LIKE '$vrCampo%' ";
				} elseif($condicao=="fim"){
					$stringAND.= " AND ".$nmCampo ." LIKE '%$vrCampo' ";
				} elseif($condicao=="contenha"){
					$stringAND.= " AND ".$nmCampo ." LIKE '%$vrCampo%' ";
				} else {
					$stringAND.= " AND ".$nmCampo ." $condicao '$vrCampo' ";
				}
		}
	}
}

//--
$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
			WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_modelo_fluxo_".$_POST['bbh_mod_flu_codigo']."_detalhado'";
list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
//--

if($tabelaCriada==1){
//recupera o nome da tabela para fazer a consulta
	$sql = "SELECT * FROM bbh_modelo_fluxo_".$_POST['bbh_mod_flu_codigo']."_detalhado Where $stringAND";

    list($Consulta, $rows, $totalRows_Consulta) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
	
	if($totalRows_Consulta>0){
		while($row_Consulta = mysqli_fetch_assoc($Consulta)){
			$_SESSION['consultaAvancada'].= ",".$row_Consulta['bbh_flu_codigo'];
		}
		$_SESSION['buscaAvancada'] = 0;
		echo "<var style='display:none'>showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|consulta/index.php','menuEsquerda|conteudoGeral')</var>";
	} else {
		echo '<var style="display:none">alert("A consulta não retornou dados!")</var>';
	}
} else {
  echo '<var style="display:none">alert("A consulta não retornou dados!")</var>';
}
?>