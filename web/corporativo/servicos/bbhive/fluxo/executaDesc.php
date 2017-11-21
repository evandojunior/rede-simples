<?php
if(!isset($_SESSION)){ session_start(); }

include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

//recebe dados do form para inserção na tabela de fluxo
	$bbh_mod_flu_codigo    	= $_POST['bbh_mod_flu_codigo'];
	$bbh_flu_observacao    	= ($_POST['bbh_flu_observacao']);
	$bbh_flu_data_iniciado 	= $_POST['bbh_flu_data_iniciado'];
	$bbh_flu_titulo			= ($_POST['bbh_flu_titulo']);
	$bbh_usu_codigo			= $_POST['bbh_usu_codigo'];
	$bbh_flu_tarefa_pai		= $_POST['bbh_flu_tarefa_pai'];
	$modAtividade			= $_POST['bbh_mod_ati_codigo'];
	$FinalPrevistoDias		= $_POST['FinalPrevistoDias'];
	$codigoAtividade		= $_POST['bbh_ati_codigo'];
	$codFluxoPai			= $_POST['bbh_flu_codigo'];
	$alternativa			= $_POST['alternativa'];
	
//inserimos a partir da atividade
$complemento	="";
$complValue		="";
$bbh_flu_oculto	="0";
	
//verifica a autonumeração deste modelo de fluxo
	$bbh_flu_autonumeracao = "";
	$bbh_flu_anonumeracao  = "";
//=====================================================================================

    // Recupera código do fluxo para buscar protocolo de referencia
    $detalheAtividade = "select f.bbh_protocolo_referencia from bbh_atividade as a
                                inner join bbh_fluxo f on a.bbh_flu_codigo = f.bbh_flu_codigo
                             where a.bbh_ati_codigo = {$codigoAtividade}";
    list($Result2, $detalheFluxo, $totalRows) = executeQuery($bbhive, $database_bbhive, $detalheAtividade);

    if (!empty($detalheFluxo['bbh_protocolo_referencia'])) {
        $complemento = ", bbh_protocolo_referencia";
        $complValue = ", " . $detalheFluxo['bbh_protocolo_referencia'];
    }

    $insertSQL = "INSERT INTO bbh_fluxo (bbh_mod_flu_codigo, bbh_flu_observacao, bbh_flu_data_iniciado, bbh_flu_titulo, bbh_usu_codigo, bbh_flu_oculto,  bbh_flu_tarefa_pai $complemento)
                  VALUES ($bbh_mod_flu_codigo, '$bbh_flu_observacao', '$bbh_flu_data_iniciado', '$bbh_flu_titulo', $bbh_usu_codigo, '$bbh_flu_oculto', $bbh_flu_tarefa_pai $complValue)";

    list($tabDet, $row_tabDet, $totalRows_tabDet) = executeQuery($bbhive, $database_bbhive, $insertSQL);
  
//recupera id da inserção que acabou de ser feita
	$query_Fluxo = "select bbh_flu_codigo from bbh_fluxo Where bbh_flu_codigo = LAST_INSERT_ID()";
    list($Fluxo, $row_Fluxo, $totalRows_Fluxo) = executeQuery($bbhive, $database_bbhive, $query_Fluxo);
	
	$idFluxo = $row_Fluxo['bbh_flu_codigo'];
	
//recupera resto das informações que vieram por POST para cadastrar as atividades
	//verifica se 1 caracter é uma vírgula
	$PostFluxos = $_POST['fluxos'];
	if(substr($_POST['fluxos'],0,1)==","){
		$PostFluxos = substr($_POST['fluxos'],1);
	}

	$cadaAtividade	= explode(",",$PostFluxos);
	$totAtividade	= count($cadaAtividade);
	
	for($a=0; $a<$totAtividade;$a++){
		$atividade		= explode("|",$cadaAtividade[$a]);
		$codAtividade 	= $atividade[0];//0 - codigo da atividade
		$codUsuario		= $atividade[3];//2 - Codigo do usuário
		$tmpInicioTarefa= $atividade[1];//1 - tempo para inicio da tarefa
		$tmpDuracao		= $atividade[2];//3 - tempo para finalização da atividade
		
		//calcula data de inicio da tarefa
		$bbh_ati_inicio_previsto 	= addDayIntoDate(date('Ymd'),$tmpInicioTarefa);
		$bbh_ati_final_previsto		= addDayIntoDate($bbh_ati_inicio_previsto,$tmpDuracao);
		
		$bbh_ati_inicio_previsto = substr($bbh_ati_inicio_previsto,0,4)."-".substr($bbh_ati_inicio_previsto,4,2)."-".substr($bbh_ati_inicio_previsto,6,2);
		$bbh_ati_final_previsto = substr($bbh_ati_final_previsto,0,4)."-".substr($bbh_ati_final_previsto,4,2)."-".substr($bbh_ati_final_previsto,6,2);
		
		$insertSQL2 = "INSERT INTO bbh_atividade (bbh_flu_codigo, bbh_mod_ati_codigo, bbh_ati_inicio_previsto, bbh_ati_final_previsto, bbh_usu_codigo, bbh_ati_andamento) VALUES ($idFluxo, $codAtividade, '$bbh_ati_inicio_previsto', '$bbh_ati_final_previsto', $codUsuario, '<andamento></andamento>')";
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL2);

	    //UPDATE DE ULTIMA ATRIBUIÇÃO AO USUÁRIO
		$updateSQL = "UPDATE bbh_usuario SET bbh_usu_atribuicao='".date("Y-m-d H:i:s")."' WHERE bbh_usu_codigo=$codUsuario";
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	}
	
	 //DESCOBRIR O FINAL PREVISTO DAS ATIVIDADES
	$query_Fprevisto = "select bbh_ati_codigo, bbh_ati_final_previsto from bbh_modelo_atividade
		inner join bbh_atividade on bbh_modelo_atividade.bbh_mod_ati_codigo = bbh_atividade.bbh_mod_ati_codigo
      Where bbh_flu_codigo = $codFluxoPai and bbh_mod_atiInicio='0' and bbh_mod_atiFim='1'
           order by bbh_mod_ati_ordem asc";
    list($Fprevisto, $row_Fprevisto, $totalRows_Fprevisto) = executeQuery($bbhive, $database_bbhive, $query_Fprevisto);
	//FORMATA DATA
	$bbh_ati_codigo	= $row_Fprevisto['bbh_ati_codigo'];
	$dataPrevista	= str_replace("-", "", $row_Fprevisto['bbh_ati_final_previsto']);

	$dtFinal 		= addDayIntoDate($dataPrevista, $FinalPrevistoDias);
	$dtFinal 		= substr($dtFinal,0,4)."-".substr($dtFinal,4,2)."-".substr($dtFinal,6,2);

	//UPDATE NO FLUXO PAI INFORMANDO A NOVA FINALIZAÇÃO PREVISTA!!!
	$updateP = "UPDATE bbh_atividade SET bbh_ati_final_previsto='$dtFinal' WHERE bbh_ati_codigo=$codigoAtividade";
    list($Result2, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateP);
	
	//MUDO O STATUS DA ATIVIDADE QUE DEU INICIO A OUTRO FLUXO
	$updateC = "UPDATE bbh_atividade SET bbh_sta_ati_codigo=2, bbh_ati_final_real='".date("Y-m-d")."', bbh_flu_alt_codigo=$alternativa, bbh_alternativa_fluxo=$idFluxo WHERE bbh_ati_codigo=$codigoAtividade";
    list($Result2, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateC);
	
//Finalizou o processo
//=============================================RESOLVE SUCESSORAS=====================================================
$codigo	= $modAtividade; 
	while($codigo>0){
		$codigo = atualizaPredecessora($codigo, $codFluxoPai);//função responsável pela verificação de dependencias de atividades

		if($codigo==0){
			$codigo=0;//quando não houver resultados o sistema atribui zero e para o laço
		}
	}
//====================================================================================================================
function atualizaPredecessora($codigo, $codFluxoPai){
    global $bbhive, $database_bbhive, $global;
    include($_SESSION['caminhoFisico']."/Connections/bbhive.php");

	//verifica se tenho sucessora
	$query_Sucessora = "select bbh_pre_mod_ati_codigo, bbh_modelo_atividade_sucessora, bbh_ati_codigo, 
	bbh_sta_ati_codigo, bbh_ati_andamento from bbh_dependencia
      inner join bbh_modelo_atividade on bbh_dependencia.bbh_modelo_atividade_sucessora = bbh_modelo_atividade.bbh_mod_ati_codigo
           inner join bbh_atividade on bbh_modelo_atividade.bbh_mod_ati_codigo = bbh_atividade.bbh_mod_ati_codigo
                Where bbh_modelo_atividade_predecessora=$codigo and bbh_flu_codigo = $codFluxoPai
                     order by bbh_mod_ati_ordem asc";
	//echo "<hr>";
	//echo $codFluxoPai;
	//echo "<hr>";
    list($Sucessora, $row_Sucessora, $totalRows_Sucessora) = executeQuery($bbhive, $database_bbhive, $query_Sucessora);
	
	if($totalRows_Sucessora>0){
		$codigo 	= $row_Sucessora['bbh_ati_codigo'];
		$Sucessora 	= $row_Sucessora['bbh_modelo_atividade_sucessora'];
		//APAGA ATIVIDADE SUCESSORA
			$deleteSQL = "DELETE FROM bbh_atividade WHERE bbh_ati_codigo=$codigo and bbh_flu_codigo=$codFluxoPai";
			//echo "<hr>";
            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);
		$codigo = $Sucessora; 
		return $codigo;
	} else {
		$codigo = 0;
		return $codigo;
	}
}
//====================================================================================================================
//ENVIO PARA TELA DO NOVO FLUXO E LISTO TODAS ATIVIDADES
	$paginaDestino = "fluxo/index.php?menu=1&bbh_flu_codigo=".$idFluxo."&exibeAtividade=true";	
//---------------?>
<var style="display:none">
	showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|<?php echo $paginaDestino; ?>|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');
</var>
<?php
exit;

//VOLTA PARA LISTA DAS ATIVIDADES
?>
<var style="display:none">
	showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|tarefas/index.php|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');
</var>