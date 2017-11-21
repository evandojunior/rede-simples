<?php
$nmSessao = $_SESSION['nomeBuscaSessao'] = 'pct_consulta_tarefas';
//--
//-------------------------------------------------------------------------------------------
if(isset($_POST['web'])){

	$indice = array();
	$indice['ck_prot'] 			= array("bbh_pro_codigo"," AND bbh_pro_codigo='@sub#Var@Black'");
	$indice['ck_data'] 			= array("bbh_pro_momento"," AND bbh_pro_momento BETWEEN '@sub#Var@Black 00:00:00' AND '@sub#Var@Black 23:59:59'");
	$indice['ck_tit']			= array("bbh_pro_titulo"," AND bbh_pro_titulo LIKE '%@sub#Var@Black%'");

	$indice['busca_nome']		= array("bbh_flu_titulo"," AND bbh_flu_titulo LIKE '%@sub#Var@Black%'");
	$indice['busca_tarefa']		= array("bbh_mod_ati_nome"," AND bbh_mod_ati_nome LIKE LIKE '%@sub#Var@Black%'");
	$indice['busca_data']		= array("bbh_ati_inicio_previsto"," AND bbh_ati_inicio_previsto BETWEEN '@subDtInicial@ 00:00:00' AND '@subDtFinal@ 23:59:59'");
	$indice['busca_prof']		= array("bbh_usu_codigo"," AND bbh_atividade.bbh_usu_codigo='@sub#Var@Black'");
	$indice['inicia']			= array("bbh_inicia"," AND bbh_mod_ati_nome LIKE '@sub#Var@Black%'");
	$indice['busca_avancada']	= array("bscAvc"," AND bbh_fluxo.bbh_flu_codigo in(@sub#Var@Black)");
	$indice['situacao']			= array("bbh_situacao","");
	
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
/*echo "<pre>";
print_r($_SESSION[$nmSessao]);
echo "</pre>";*/
?>