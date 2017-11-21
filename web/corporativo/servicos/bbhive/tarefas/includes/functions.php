<?php
	//verifica departamento do usuário logado
	$query_Depto = "select bbh_dep_codigo from bbh_usuario Where bbh_usu_codigo=".$_SESSION['usuCod'];
    list($Depto, $row_Depto, $totalRows_Depto) = executeQuery($bbhive, $database_bbhive, $query_Depto, $initResult = false);

if (!function_exists('usuario_departamento')) {
	function usuario_departamento($depCodigo, $depUsuario, $depNome, $usuNome){
		if($depCodigo == $depUsuario){
			return $usuNome;
		} else {
			return $depNome;
		}
	}
}

if (!function_exists('contaAtividades')) {
	function contaAtividades($database_bbhive, $bbhive, $codFluxo, $and){
		$sql = "select count(bbh_ati_codigo) as Total from bbh_atividade
		  inner join bbh_fluxo on bbh_atividade.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo
		   Where $and and bbh_fluxo.bbh_flu_codigo =$codFluxo ";
        list($QtAti, $row_QtAti, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql);

		return $row_QtAti['Total'];
	}
}

if (!function_exists('verificaAlternativas')) {
	function verificaAlternativas($database_bbhive, $bbhive, $codModAti, $codAtividade, $nmModAti, $modAtiIcone){
		//verifica se tem alternativas
		$query_Alternativas = "select bbh_flu_alt_codigo, bbh_mod_flu_codigo from bbh_fluxo_alternativa Where bbh_mod_ati_codigo=$codModAti and bbh_mod_flu_codigo<>'NULL'";
        list($Alternativas, $row_Alternativas, $totalRows_Alternativas) = executeQuery($bbhive, $database_bbhive, $query_Alternativas);
		
		$Icone = '<img src="/datafiles/servicos/bbhive/corporativo/images/tarefas/'.$modAtiIcone.'" border="0" align="absmiddle" />';
		
		if($totalRows_Alternativas>0){
			$TimeStamp 			= time();
			$homeDestino		= '/corporativo/servicos/bbhive/tarefas/includes/subFluxo.php?Ts='.$TimeStamp."&filho=sub_".$codAtividade."&titulo=".$nmModAti."&bbh_mod_flu_codigo=".$row_Alternativas['bbh_mod_flu_codigo'];
			$idMensagemFinal 	= 'sub_'.$codAtividade;
			$infoGet_Post		= '&bbh_ati_codigo='.$codAtividade;//Se envio for POST, colocar nome do formulário
			$Mensagem			= "Carregando...";
			$idResultado		= $idMensagemFinal;
			$Metodo				= '2';//1-POST, 2-GET
			$TpMens				= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
			
			$onClick 			= "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
			
			$linkComplemento 	= "<a href='#@' onClick=\"".$onClick."\" title='Clique para vizualizar o subfluxo'>$Icone</a>";
			$Icone = $linkComplemento."|".$row_Alternativas['bbh_mod_flu_codigo'];
		}
		return $Icone;
	}
}

if (!function_exists('verificaTomadaDescisao')) {
	function verificaTomadaDescisao($AltFluxo, $modAtiIcone){
		//verifico se a descisão foi tomada
		if($AltFluxo!=NULL){
			return '<img src="/datafiles/servicos/bbhive/corporativo/images/tarefas/'.$modAtiIcone.'" border="0" align="absmiddle" />';
		}
	}
}

if (!function_exists('verificaSubFluxoTarefa')) {
	function verificaSubFluxoTarefa($database_bbhive, $bbhive, $codAtividade){
		//verifico se a tarefa tem subFluxo
		$query_subFluxo = "select bbh_flu_tarefa_pai from bbh_fluxo Where bbh_flu_tarefa_pai=$codAtividade";
        list($subFluxo, $row_subFluxo, $totalRows_subFluxo) = executeQuery($bbhive, $database_bbhive, $query_subFluxo);

		if($totalRows_subFluxo>0){
			return '<img src="/corporativo/servicos/bbhive/images/fluxograma_mini.gif" align="absmiddle" border="0"/>';
		}	
	}
}
?>