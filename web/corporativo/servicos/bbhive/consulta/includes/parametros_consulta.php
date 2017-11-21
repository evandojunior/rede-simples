<?php
$nmSessao = $_SESSION['nomeBuscaSessao'] = 'pct_consulta_fluxo';
//--
//-------------------------------------------------------------------------------------------
if(isset($_POST['web'])){

	$indice = array();
	$indice['ck_prot'] 			= array("bbh_pro_codigo"," AND bbh_protocolos.bbh_pro_codigo='@sub#Var@Black'");
	$indice['ck_data'] 			= array("bbh_pro_momento"," AND bbh_protocolos.bbh_pro_momento BETWEEN '@sub#Var@Black 00:00:00' AND '@sub#Var@Black 23:59:59'");
	$indice['ck_tit']			= array("bbh_pro_titulo"," AND bbh_protocolos.bbh_pro_titulo LIKE '%@sub#Var@Black%'");

	$indice['busca_nome']		= array("bbh_flu_titulo"," AND bbh_flu_titulo LIKE '%@sub#Var@Black%'");
	$indice['busca_codigo']		= array("bbh_flu_codigobarras"," AND bbh_flu_codigobarras = '@sub#Var@Black'");
	$indice['busca_descricao']	= array("bbh_flu_observacao"," AND bbh_flu_observacao LIKE '%@sub#Var@Black%'");
	$indice['busca_data']		= array("bbh_flu_data_iniciado"," AND bbh_flu_data_iniciado BETWEEN '@subDtInicial@ 00:00:00' AND '@subDtFinal@ 23:59:59'");
	$indice['busca_envolvido']	= array("bbh_usu_codigo"," AND bbh_atividade.bbh_usu_codigo=".$_SESSION['usuCod']);
	$indice['inicia']			= array("bbh_inicia"," AND bbh_flu_titulo LIKE '@sub#Var@Black%'");
	$indice['busca_avancada']	= array("bscAvc"," AND bbh_fluxo.bbh_flu_codigo in(@sub#Var@Black)");
	
	//--
	$ttAr = count($indice);
	//--
	foreach($_POST as $i=>$v){
		if(array_key_exists($i,$indice)){
			//se não existir sessão devo criar
			if(!isset($_SESSION[$nmSessao])){
//				criaSessao($nmSessao, $i, $indice[$i][0], $indice[$i][1], "");
				criaSessao($nmSessao, $indice);
			}
			//adicionaSessao($nmSessao, $i, $indice[$i], $_POST[$indice[$i]]);
			adicionaSessao($nmSessao, $i, $indice[$i][0], $indice[$i][1], $_POST[$indice[$i][0]]);
			//echo $nmSessao."; ".$i.";".$indice[$i][0].";".$_POST[$indice[$i][0]].";<br>";
		}
	}
	$r=0;
	foreach($indice as $i=>$v){
		if(!isset($_POST[$i])){
			removeIndiceConsulta($nmSessao,$i,$indice[$i][0],$indice[$i][1]); $r++;
			//--
			if($i=="busca_avancada"){unset($_SESSION['consultaAvancada']); unset($_SESSION['buscaAvancada']);}
			//--
		}
	}
	if($ttAr==$r){
		unset($_SESSION[$nmSessao]);
		unset($_SESSION['consultaAvancada']);
		unset($_SESSION['buscaAvancada']);
	}
	//--
}
//-------------------------------------------------------------------------------------------
?>