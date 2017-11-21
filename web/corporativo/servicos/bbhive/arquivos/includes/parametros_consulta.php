<?php
$nmSessao = $_SESSION['nomeBuscaSessao'] = 'pct_consulta_arquivo';
//--
//-------------------------------------------------------------------------------------------
if(isset($_POST['web'])){

	$indice = array();
	$indice['chkNmArquivo'] 	= array("bbh_arq_nome_logico"," AND bbh_arq_titulo LIKE '%@sub#Var@Black%'");
	$indice['chkTituloArquivo'] = array("bbh_arq_titulo"," AND bbh_arq_titulo LIKE '%@sub#Var@Black%'");
	$indice['chkAutorArquivo']	= array("bbh_arq_autor"," AND bbh_arq_autor LIKE '%@sub#Var@Black%'");
	$indice['chkFluxoArquivo']	= array("bbh_flu_titulo"," AND bbh_flu_titulo LIKE '%@sub#Var@Black%'");

	$indice['busca_data']		= array("bbh_arq_data_modificado"," AND bbh_arq_data_modificado BETWEEN '@subDtInicial@ 00:00:00' AND '@subDtFinal@ 23:59:59'");
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
?>