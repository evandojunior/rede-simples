<?php
if(!isset($_SESSION)){ session_start(); }

include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

//ocultar fluxo
if(isset($_GET['edOculto'])){
	$bbh_flu_oculto="0";
	if(isset($_POST['bbh_flu_oculto'])){
		$bbh_flu_oculto="1";
	}
		$bbh_flu_codigo 		= $_GET['bbh_flu_codigo'];
		$bbh_flu_codigobarras	= trim($_POST['bbh_flu_codigobarras']);
		$bbh_flu_observacao    	= ($_POST['bbh_flu_observacao']);
		$bbh_flu_titulo			= ($_POST['bbh_flu_titulo']);

		$ateracao				= 0;
		
		//se tiver alteração de título devo mudar os status de todos que já estão ciente, pois pode ter mudado algo no fluxo
		if(isset($_POST['bbh_flu_titulo_anterior']) && ($_POST['bbh_flu_titulo_anterior']) != ($_POST['bbh_flu_titulo'])){
			$ateracao = 1;
		}
		if(isset($_POST['bbh_flu_observacao_anterior']) && ($_POST['bbh_flu_observacao_anterior']) != ($_POST['bbh_flu_observacao'])){
			$ateracao = 1;
		}
		//verifica se o código de barras foi utilizado
	$query_CodigoBarras = "select count(*) as total from bbh_fluxo Where bbh_flu_codigobarras='$bbh_flu_codigobarras' AND bbh_flu_codigo not in ($bbh_flu_codigo)";
    list($CodigoBarras, $row_CodigoBarras, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_CodigoBarras);
	
	if($row_CodigoBarras['total']==0 || empty($bbh_flu_codigobarras)){
			$updateSQL = "UPDATE bbh_fluxo SET bbh_flu_oculto='$bbh_flu_oculto', bbh_flu_codigobarras='$bbh_flu_codigobarras', bbh_flu_observacao='$bbh_flu_observacao', bbh_flu_titulo='$bbh_flu_titulo' WHERE bbh_flu_codigo=$bbh_flu_codigo";				   		mysqli_select_db($bbhive, $database_bbhive);
            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
			
			//se teve atualização, devo mudar todos os status para 1 e tirar a data de lido
			if($ateracao == 1){
				$updateSQL = "UPDATE bbh_atividade SET bbh_sta_ati_codigo=1, bbh_ati_inicio_real=NULL 
								WHERE bbh_flu_codigo = $bbh_flu_codigo";
                list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
			}
			
			
		//atualiza apenas a parte de perfil
		$TimeStamp 	= time();
		$homeDestino= '/corporativo/servicos/bbhive/fluxo/menuEsquerda.php?perfil=1&fluxo=1&Ts='.$TimeStamp;
		$carrega 	= "showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=".$bbh_flu_codigo."|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=".$bbh_flu_codigo."&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');";
		echo '<var style="display:none">'.$carrega.'</var>';
	} else {
		echo '<var style="display:none">document.getElementById("bbh_flu_codigobarras").value="";alert("Etiqueta já utilizada!\nEscolha outra e tente novamente.");</var>';	
	}
exit;
}
//recebe dados do form para inserção na tabela de fluxo
	$bbh_mod_flu_codigo    	= $_POST['bbh_mod_flu_codigo'];
	$bbh_flu_observacao    	= ($_POST['bbh_flu_observacao']);
	$bbh_flu_data_iniciado 	= $_POST['bbh_flu_data_iniciado'];
	$bbh_flu_titulo			= ($_POST['bbh_flu_titulo']);
	$bbh_usu_codigo			= $_SESSION['usuCod'];
//inserimos a partir da atividade
$complemento="";
$complValue="";
$bbh_flu_oculto="0";
if(isset($_POST['bbh_ati_codigo'])){
	$complemento 	= ", bbh_flu_tarefa_pai";
	$complValue		= ", ".$_POST['bbh_ati_codigo'];
}	
	
if(isset($_POST['bbh_flu_oculto'])){
	$bbh_flu_oculto="1";
}	
//verifica a autonumeração deste modelo de fluxo
	$query_AutoNumeracao = "select MAX(bbh_flu_autonumeracao) as ultimo from bbh_fluxo Where bbh_mod_flu_codigo =$bbh_mod_flu_codigo AND bbh_flu_anonumeracao=".date('Y');
    list($AutoNumeracao, $row_AutoNumeracao, $totalRows_AutoNumeracao) = executeQuery($bbhive, $database_bbhive, $query_AutoNumeracao);
	$bbh_flu_autonumeracao = $row_AutoNumeracao['ultimo'] + 1;
	$bbh_flu_anonumeracao  = date('Y');
//=====================================================================================

	$insertSQL = "INSERT INTO bbh_fluxo (bbh_mod_flu_codigo, bbh_flu_observacao, bbh_flu_data_iniciado, bbh_flu_titulo, bbh_usu_codigo, bbh_flu_oculto, bbh_flu_autonumeracao, bbh_flu_anonumeracao $complemento) VALUES ($bbh_mod_flu_codigo, '$bbh_flu_observacao', '$bbh_flu_data_iniciado', '$bbh_flu_titulo', $bbh_usu_codigo, '$bbh_flu_oculto', $bbh_flu_autonumeracao, $bbh_flu_anonumeracao $complValue)";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);

//recupera id da inserção que acabou de ser feita
	$query_Fluxo = "select bbh_flu_codigo from bbh_fluxo Where bbh_flu_codigo = LAST_INSERT_ID()";
    list($Fluxo, $row_Fluxo, $totalRows_Fluxo) = executeQuery($bbhive, $database_bbhive, $query_Fluxo);
	
	$idFluxo = $row_Fluxo['bbh_flu_codigo'];
//--UPDATE MUDANDO O TÍTULO DO FLUXO
	$sqlNumeracao = "select bbh_fluxo.bbh_flu_codigo, bbh_mod_flu_nome, bbh_flu_anonumeracao, bbh_flu_autonumeracao, bbh_tip_flu_identificacao
 	from bbh_fluxo 
		inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo 
		inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo 
				Where bbh_fluxo.bbh_flu_codigo = $idFluxo
						LIMIT 0,1";
    list($FlNumeracao, $row_FlNumeracao, $totalRows) = executeQuery($bbhive, $database_bbhive, $sqlNumeracao);
	//--
	$nomeFluxo 		= $row_FlNumeracao['bbh_mod_flu_nome'];
	$autoNumeracao	= $row_FlNumeracao['bbh_flu_autonumeracao'];
	$tipoProcesso	= explode(".",$row_FlNumeracao['bbh_tip_flu_identificacao']);
	$tipoProcesso	= (int)$tipoProcesso[0];
	$anoNumeracao	= $row_FlNumeracao['bbh_flu_anonumeracao'];
	//--
	$numeroProcesso	= $nomeFluxo . " - " . $autoNumeracao . "." . $tipoProcesso . "/" . $anoNumeracao;
	$numeroProcesso.= " ($bbh_flu_titulo)";
	//--
		$updateFl = "UPDATE bbh_fluxo SET bbh_flu_titulo='$numeroProcesso' WHERE bbh_flu_codigo = $idFluxo";
        list($Result3, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateFl);
	//--
//cadastra no protocolo o id do fluxo
if(isset($_POST['bbh_pro_codigo'])){
	$pro_codigo = $_POST['bbh_pro_codigo'];
	//--
		$updateSQLP = "UPDATE bbh_protocolos SET bbh_pro_status='4', bbh_flu_codigo=$idFluxo WHERE bbh_pro_codigo=".$pro_codigo;
        list($Result3, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQLP);

        $updateFluxoReferencia = "UPDATE bbh_fluxo SET bbh_protocolo_referencia='{$pro_codigo}' WHERE bbh_flu_codigo={$idFluxo}";
        list($Result4, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateFluxoReferencia);

		//--Este fluxo foi iniciado a partir de um protocolo
			//--Este protocolo é final de algum fluxo?
				$query_Final = "select bbh_flu_pai from bbh_protocolos Where bbh_pro_codigo=".$pro_codigo;
                list($Final, $row_Final, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_Final);
				//--
				if($row_Final['bbh_flu_pai'] > 0){
					$bbh_flu_codigo_p 	= $row_Final['bbh_flu_pai'];
					$bbh_flu_codigo_f	= $idFluxo;
					//--
				   $insertSQL = "INSERT INTO bbh_fluxo_relacionado (bbh_flu_codigo_p, bbh_flu_codigo_f)
									VALUES ($bbh_flu_codigo_p, $bbh_flu_codigo_f)";
				   list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
				}
}
	
//recupera resto das informações que vieram por POST para cadastrar as atividades
//MUDAMOS O MÉTODO DE LAÇO PELO SIMPLES FATO DE QUE NO CLIENTE EM DETERMINADO MOMENTO ELE FAZIA A CONCATENAÇÃO DUAS VEZES DAS OS ATORES QUE ESTAVAM NO COMBO, PARA RESOLVER ADICIONEI O QUE VEM DO POST EM ÍNDICE DE ARRAY QUE LOGICAMENTE NÃO É POSSÍVEL DOIS ÍNDICES IGUAIS FORÇANDO ENTÃO A FILTRAGEM DO DADO, UMA VEZ QUE NÃO POSSO TER ATIVIDADES DUPLICADAS PARA O MESMO USUÁRIO NO MESMO FLUXO, OU MELHOR, 
/*
ATIVIDADE A =====> COLABORADOR 15
ATIVIDADE A =====> COLABORADOR 15 (ERRADO, AGORA FAÇO A FILTRAGEM E TRATO ESTA INCONSISTÊNCIA
								   TRATADO EM 12/03/2010 18:00:00
*/

	//verifica se 1 caracter é uma vírgula
	$PostFluxos = $_POST['fluxos'];
	if(substr($_POST['fluxos'],0,1)==","){
		$PostFluxos = substr($_POST['fluxos'],1);
	}

	$cadaAtividade	= explode(",",$PostFluxos);
	$totAtividade	= count($cadaAtividade);
		//adiciona como índice do array, logicamente só terá um par para cada
		$atividades = array();
	for($a=0; $a<$totAtividade;$a++){
		$atividades[$cadaAtividade[$a]."|".$idFluxo] = 1;
	}
	//---------------
	$totAtividade = count($atividades);

	//for($a=0; $a<$totAtividade;$a++){
	foreach($atividades as $cadaAtividade=>$valorNulo){	
		//$atividade		= explode("|",$atividades[$a]);
		$atividade		= explode("|",$cadaAtividade);
		$codAtividade 	= $atividade[0];//0 - codigo da atividade
		$codUsuario		= $atividade[3];//2 - Codigo do usuário
		$tmpInicioTarefa= $atividade[1];//1 - tempo para inicio da tarefa
		$tmpDuracao		= $atividade[2];//3 - tempo para finalização da atividade
		$codFluxoAti	= $atividade[4];//4 - Codigo do fluxo que acabei de inserir
		
		//calcula data de inicio da tarefa
		$bbh_ati_inicio_previsto 	= addDayIntoDate(date('Ymd'),$tmpInicioTarefa);
		$bbh_ati_final_previsto		= addDayIntoDate($bbh_ati_inicio_previsto,$tmpDuracao);
		
		$bbh_ati_inicio_previsto = substr($bbh_ati_inicio_previsto,0,4)."-".substr($bbh_ati_inicio_previsto,4,2)."-".substr($bbh_ati_inicio_previsto,6,2);
		$bbh_ati_final_previsto = substr($bbh_ati_final_previsto,0,4)."-".substr($bbh_ati_final_previsto,4,2)."-".substr($bbh_ati_final_previsto,6,2);
		
		$insertSQL2 = "INSERT INTO bbh_atividade (bbh_flu_codigo, bbh_mod_ati_codigo, bbh_ati_inicio_previsto, bbh_ati_final_previsto, bbh_usu_codigo, bbh_ati_andamento) VALUES ($codFluxoAti, $codAtividade, '$bbh_ati_inicio_previsto', '$bbh_ati_final_previsto', $codUsuario, '<andamento></andamento>')";

        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL2);

	//UPDATE DE ULTIMA ATRIBUIÇÃO AO USUÁRIO
		$updateSQL = "UPDATE bbh_usuario SET bbh_usu_atribuicao='".date("Y-m-d H:i:s")."' WHERE bbh_usu_codigo=$codUsuario";				   		mysqli_select_db($bbhive, $database_bbhive);
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	}
//Finalizou o processo

//cria diretórios
		$localizacao_documento = explode("web",$_SESSION['caminhoFisico']);
		$diretorio = $localizacao_documento[0] . "database/servicos/bbhive/fluxo/fluxo_".$idFluxo;
		if(!file_exists($diretorio)) {	
			mkdir($diretorio, 777);
			chmod($diretorio,0777);
		}
		if(!file_exists($diretorio."/documentos")) {
            $diretorio .= "/documentos";
			mkdir($diretorio, 777);
			chmod($diretorio,0777);
		}
		if(!file_exists($diretorio."/arquivos")) {
            $diretorio .= "/arquivos";
			mkdir($diretorio, 777);
			chmod($diretorio,0777);
		}
//--
//PREENCHIMENTO DO DETALHAMENTO
	//verifica se a tabela de detalhamento foi criada
	$query_tabDet = "select * from bbh_detalhamento_fluxo Where bbh_mod_flu_codigo=$bbh_mod_flu_codigo AND bbh_det_flu_tabela_criada=1";
    list($tabDet, $row_tabDet, $totalRows_tabDet) = executeQuery($bbhive, $database_bbhive, $query_tabDet);

//===============================================================================================
//CADASTRA DETALHAMENTOS
	if($totalRows_tabDet>0 && isset($_POST['cadastroInicio'])){
		//recupera o código do fluxo inserido
		$bbh_flu_codigo = $idFluxo;
		require_once("detalhamento/edita.php");
	}
//===============================================================================================
//exit("Cadastrado com sucesso");
	//if(($row_AltDetal['total']>0)and($totalRows_tabDet>0)) {
	//	$paginaDestino = "fluxo/completaDetalhamento.php?menu=1&bbh_flu_codigo=$idFluxo";
	//} else {
		$paginaDestino = "fluxo/index.php?menu=1&bbh_flu_codigo=".$idFluxo;	
	//}
//exit;
?>
<var style="display:none">
	showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|<?php echo $paginaDestino; ?>|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');
</var><?php exit; ?>
<table width="280" border="0" cellspacing="0" cellpadding="0" style="margin-left:100px; margin-top:-100px; position:absolute; z-index:5000">
  <tr>
    <td height="27" background="/corporativo/servicos/bbhive/images/back_top.gif" style="border-left:#FBC203 solid 1px; border-right:#FBC203 solid 1px;" class="verdana_12">&nbsp;&nbsp;<img src="/corporativo/servicos/bbhive/images/icon_05.gif" width="15" height="12">&nbsp;&nbsp;&nbsp;Confirma&ccedil;&atilde;o</td>
  </tr>
  <tr>
    <td height="112" align="center" bgcolor="#FFFFFF" style="border-left:#FBC203 solid 1px; border-right:#FBC203 solid 1px; border-bottom:#FBC203 solid 1px">Este procedimento foi finalizado com sucesso!<br>
      <br>
      <br>
        <table width="102" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
          <tr>
            <td align="left" bgcolor="#FFFFFF" class="verdana_12" style="cursor:pointer; width:102px;" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita')">
             <a href="#" style="cursor:pointer; width:102px;">
            	&nbsp;<img src="/corporativo/servicos/bbhive/images/05_.gif" width="16" height="16" border="0">
            	<label style="margin-left:15px;">Ok</label>
             </a>
            </td>
          </tr>
        </table>
    </td>
  </tr>
</table>