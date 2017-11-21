<?php if(!isset($_SESSION)){ session_start(); }
//recupera dados do modelo do parágrafo
function recuperaParagrafo($codModeloParagrafo){
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");

	$query_paragrafos = "SELECT bbh_mod_par_titulo, bbh_mod_par_paragrafo  FROM bbh_modelo_paragrafo WHERE bbh_mod_par_codigo = $codModeloParagrafo AND (bbh_mod_par_privado = 0 OR bbh_usu_autor = " . $_SESSION['usuCod'].")";
    list($modelo_paragrafos, $row_modelo_paragrafos, $totalRows_modelo_paragrafos) = executeQuery($bbhive, $database_bbhive, $query_paragrafos);
	
	//retorna o título do paragrafo e o paragrafo
	return $row_modelo_paragrafos['bbh_mod_par_titulo']."|*|".$row_modelo_paragrafos['bbh_mod_par_paragrafo'];
}

function recuperaCampos($CodAtividade){
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/fluxo/detalhamento/includes/functions.php");

	$query_camposDetalhamento = "SELECT  bbh_fluxo.bbh_mod_flu_codigo,bbh_fluxo.bbh_flu_codigo, bbh_campo_detalhamento_fluxo.*  FROM bbh_atividade INNER JOIN bbh_fluxo ON bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo  INNER JOIN bbh_detalhamento_fluxo  ON bbh_detalhamento_fluxo.bbh_mod_flu_codigo = bbh_fluxo.bbh_mod_flu_codigo INNER JOIN bbh_campo_detalhamento_fluxo  ON bbh_campo_detalhamento_fluxo.bbh_det_flu_codigo = bbh_detalhamento_fluxo.bbh_det_flu_codigo WHERE bbh_ati_codigo = $CodAtividade AND bbh_cam_det_flu_curinga IS NOT NULL AND bbh_det_flu_tabela_criada='1' Group By bbh_cam_det_flu_codigo";
    list($camposDetalhamento, $row_camposDetalhamento, $totalRows_camposDetalhamento) = executeQuery($bbhive, $database_bbhive, $query_camposDetalhamento);
	
	$nomeTabelaDinamica = "bbh_modelo_fluxo_" . $row_camposDetalhamento['bbh_mod_flu_codigo'] . "_detalhado";
	$codigo_fluxo = $row_camposDetalhamento['bbh_flu_codigo'];
	//===Fazendo um laço para obter os nomes das colunas que possuem curinga
	$colunasDetalhamento = "";	
	/*Dois arrays. 
	Os dois terão seus indices sincronizados, um armazena os dados reais do detalhamento. Outro seu respectivo curinga.*/
	$arrDetalhamento = array();
	$arrCuringa = array();
	//========

	if($totalRows_camposDetalhamento > 0){
			do{
				$colunasDetalhamento .= $row_camposDetalhamento['bbh_cam_det_flu_nome'] . ",";
				array_push($arrCuringa,$row_camposDetalhamento['bbh_cam_det_flu_curinga']);
			}while($row_camposDetalhamento = mysqli_fetch_assoc($camposDetalhamento));
			
		$colunasDetalhamento .= "bbh_flu_codigo ";
		//=====Tabela Detalhada

		$query_tabelaDetalhada = "SELECT $colunasDetalhamento FROM $nomeTabelaDinamica WHERE bbh_flu_codigo = " . $codigo_fluxo;
        list($tabelaDetalhada, $row_tabelaDetalhada, $totalRows_tabelaDetalhada) = executeQuery($bbhive, $database_bbhive, $query_tabelaDetalhada);
		//=====
		if($totalRows_tabelaDetalhada > 0){
			//Agora preciso colocar os campos do detalhamento no array sincronizado com os dados do array do curinga
			for($cont = 0; $cont < count($arrCuringa); $cont++){
                //tratando os tipos de dados do banco
                $finfo = mysqli_fetch_field_direct($tabelaDetalhada, $cont);
                $fieldName = $finfo->name;

			    // Recupera o tipo do campo na tabela de detalhamento
                //$queryDetalhamento = "select * from bbh_campo_detalhamento_fluxo c where c.bbh_cam_det_flu_nome = '{$fieldName}' limit 1;";
                //list($campoDetalhamento, $row_detalhamento, $totalRows) = executeQuery($bbhive, $database_bbhive, $queryDetalhamento);

                $tipo = $finfo->type;

                if($tipo == "date"){
					$registro = retornaData($row_tabelaDetalhada[$fieldName]);
				} else if($tipo == "datetime"){
					$registro = mysql_datetime_para_humano($row_tabelaDetalhada[$fieldName]);
				} else if($tipo == "real"){
					$registro = Real($row_tabelaDetalhada[$fieldName]);
				} else{
					$registro = $row_tabelaDetalhada[$fieldName];
				}
				
				array_push($arrDetalhamento,$registro);
			}
		}// else {
		//	echo "<span class='aviso'>Contate o respons&aacute;vel pelo fluxo - campos curingas inv&aacute;lido!</span>";
		//	exit;
		//}
	}
	if(!isset($_SESSION)){session_start();}
	$_SESSION['arrayCuringa'] = $arrCuringa;
	$_SESSION['arrayDetalhamento'] = $arrDetalhamento;
	return "true";
}

function listaCuringas($CodAtividade){
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/fluxo/detalhamento/includes/functions.php");

	$query_camposDetalhamento = "SELECT  bbh_fluxo.bbh_mod_flu_codigo,bbh_fluxo.bbh_flu_codigo, bbh_campo_detalhamento_fluxo.*  FROM bbh_atividade INNER JOIN bbh_fluxo ON bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo  INNER JOIN bbh_detalhamento_fluxo  ON bbh_detalhamento_fluxo.bbh_mod_flu_codigo = bbh_fluxo.bbh_mod_flu_codigo INNER JOIN bbh_campo_detalhamento_fluxo  ON bbh_campo_detalhamento_fluxo.bbh_det_flu_codigo = bbh_detalhamento_fluxo.bbh_det_flu_codigo WHERE bbh_ati_codigo = $CodAtividade AND bbh_cam_det_flu_curinga IS NOT NULL Group By bbh_cam_det_flu_codigo";
    list($camposDetalhamento, $row_camposDetalhamento, $totalRows_camposDetalhamento) = executeQuery($bbhive, $database_bbhive, $query_camposDetalhamento);
	
	$nomeTabelaDinamica = "bbh_modelo_fluxo_" . $row_camposDetalhamento['bbh_mod_flu_codigo'] . "_detalhado";
	$codigo_fluxo = $row_camposDetalhamento['bbh_flu_codigo'];
	//===Fazendo um laço para obter os nomes das colunas que possuem curinga
	$colunasDetalhamento = "";	
	/*Dois arrays. 
	Os dois terão seus indices sincronizados, um armazena os dados reais do detalhamento. Outro seu respectivo curinga.*/
	$arrDetalhamento = array();
	$arrCuringa 	 = array();
	$arrTratado		 = array();
	//========
	
	if($totalRows_camposDetalhamento > 0){
			do{
				$colunasDetalhamento .= $row_camposDetalhamento['bbh_cam_det_flu_nome'] . ",";
				array_push($arrCuringa,$row_camposDetalhamento['bbh_cam_det_flu_curinga']);
				array_push($arrTratado,$row_camposDetalhamento['bbh_cam_det_flu_titulo']);
			}while($row_camposDetalhamento = mysqli_fetch_assoc($camposDetalhamento));
			
		$colunasDetalhamento .= "bbh_flu_codigo ";
		//=====Tabela Detalhada

		$query_tabelaDetalhada = "SELECT $colunasDetalhamento FROM $nomeTabelaDinamica WHERE bbh_flu_codigo = " . $codigo_fluxo;
        list($tabelaDetalhada, $row_tabelaDetalhada, $totalRows_tabelaDetalhada) = executeQuery($bbhive, $database_bbhive, $query_tabelaDetalhada);
		//=====
		if($totalRows_tabelaDetalhada > 0){
			//Agora preciso colocar os campos do detalhamento no arrray sincronizado com os dados do array do curinga
			for($cont = 0; $cont < count($arrCuringa); $cont++){ 
				//tratando os tipos de dados do banco
                $finfo = mysqli_fetch_field_direct($tabelaDetalhada, $cont);
                $fieldName = $finfo->name;
                $tipo = $finfo->type;

                if($tipo == "date"){
                    $registro = retornaData($row_tabelaDetalhada[$fieldName]);
                }else if($tipo == "datetime"){
                    $registro = mysql_datetime_para_humano($row_tabelaDetalhada[$fieldName]);
                }else if($tipo == "real"){
                    $registro = Real($row_tabelaDetalhada[$fieldName]);
                }else{
                    $registro = $row_tabelaDetalhada[$fieldName];
                }
				
				array_push($arrDetalhamento,$arrTratado[$cont]."|".$registro);
			}
		}
	}
	
	return $arrDetalhamento;
}
?>