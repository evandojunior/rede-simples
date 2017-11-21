<?php
//SOMENTE PARA BUSCA===================================
$SelectAnd="";
	if(isset($_GET['chkNmArquivo'])){
		if($_GET['selectBBhArquivo']=="inicio"){ 
			$condicao = " LIKE '".$_GET['bbh_arq_nome_logico']."%'";
			
		} elseif($_GET['selectBBhArquivo']=="fim"){
			$condicao = " LIKE '%".$_GET['bbh_arq_nome_logico']."'";
			
		} elseif($_GET['selectBBhArquivo']=="contenha"){
			$condicao = " LIKE '%".$_GET['bbh_arq_nome_logico']."%'";
			
		} else {
			$condicao = "='".$_GET['bbh_arq_nome_logico']."'";
			
		}
		$SelectAnd.=" AND bbh_arq_titulo $condicao";
	}
//======================================================

//======================================================
	if(isset($_GET['chkTituloArquivo'])){
		if($_GET['selectTituloArquivo']=="inicio"){ 
			$condicao = " LIKE '".$_GET['bbh_arq_titulo']."%'";
			
		} elseif($_GET['selectTituloArquivo']=="fim"){
			$condicao = " LIKE '%".$_GET['bbh_arq_titulo']."'";
			
		} elseif($_GET['selectTituloArquivo']=="contenha"){
			$condicao = " LIKE '%".$_GET['bbh_arq_titulo']."%'";
			
		} else {
			$condicao = "='".$_GET['bbh_arq_titulo']."'";
			
		}

		$SelectAnd.=" AND bbh_arq_titulo $condicao";
	}
//======================================================

//======================================================
	if(isset($_GET['chkAutorArquivo'])){
		$variavel = $_GET['bbh_arq_autor'];
		if($_GET['selectAutorArquivo']=="inicio"){ 
			$condicao = " LIKE '$variavel%'";
			
		} elseif($_GET['selectAutorArquivo']=="fim"){
			$condicao = " LIKE '%$variavel'";
			
		} elseif($_GET['selectAutorArquivo']=="contenha"){
			$condicao = " LIKE '%$variavel%'";
			
		} else {
			$condicao = "='$variavel'";
			
		}

		$SelectAnd.=" AND bbh_arq_autor $condicao AND bbh_arq_compartilhado=1";
	}
//======================================================

//======================================================
	if(isset($_GET['chkFluxoArquivo'])){
		$variavel = $_GET['bbh_flu_titulo'];
		if($_GET['selectFluxoArquivo']=="inicio"){ 
			$condicao = " LIKE '$variavel%'";
			
		} elseif($_GET['selectFluxoArquivo']=="fim"){
			$condicao = " LIKE '%$variavel'";
			
		} elseif($_GET['selectFluxoArquivo']=="contenha"){
			$condicao = " LIKE '%$variavel%'";
			
		} else {
			$condicao = "='$variavel'";
			
		}

		$SelectAnd.=" AND bbh_flu_titulo $condicao";
	}
//======================================================

//======================================================
	if(isset($_GET['chkDtArquivo'])){
		$DataInicio = explode("/",$_GET['bbh_dtInicio']);
			$DInicio = $DataInicio[2]."-".$DataInicio[1]."-".$DataInicio[0];
		$DataFim	= explode("/",$_GET['bbh_dtFim']);
			$DFim	= $DataFim[2]."-".$DataFim[1]."-".$DataFim[0];
			
		$SelectAnd.=" AND bbh_arq_data_modificado>='$DInicio 00:00:00' and bbh_arq_data_modificado<='$DFim 23:59:59'";
	}
//======================================================
?>