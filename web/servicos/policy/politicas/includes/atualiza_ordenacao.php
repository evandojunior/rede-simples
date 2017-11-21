<?php

	//Quem
	if(isset($_GET['chk_quem'])){
		$Conteudo = $_GET['estr_quem'];
		$Condicao = $_GET['order_quem'];
		$doc = $xml->atualizaFilhos($doc, "ordenacao", "quem",$Condicao, $Conteudo, "1");
	} else {//Confirma a não publicação deste item
		$doc = $xml->atualizaFilhos($doc, "ordenacao", "quem","", "", "0");
	}
	
	//Quando
	if(isset($_GET['chk_quando'])){
		$Conteudo = $_GET['estr_quando'];
		$Condicao = $_GET['order_quando'];
		$doc = $xml->atualizaFilhos($doc, "ordenacao", "quando",$Condicao, $Conteudo, "1");
	} else {//Confirma a não publicação deste item
		$doc = $xml->atualizaFilhos($doc, "ordenacao", "quando","", "", "0");
	}
	
	//Onde
	if(isset($_GET['chk_onde'])){
		$Conteudo = $_GET['estr_onde'];
		$Condicao = $_GET['order_onde'];
		$doc = $xml->atualizaFilhos($doc, "ordenacao", "onde",$Condicao, $Conteudo, "1");
	} else {//Confirma a não publicação deste item
		$doc = $xml->atualizaFilhos($doc, "ordenacao", "onde","", "", "0");
	}
	
	//Oque
	if(isset($_GET['chk_oque'])){
		$Conteudo = $_GET['estr_oque'];
		$Condicao = $_GET['order_oque'];
		$doc = $xml->atualizaFilhos($doc, "ordenacao", "oque",$Condicao, $Conteudo, "1");
	} else {//Confirma a não publicação deste item
		$doc = $xml->atualizaFilhos($doc, "ordenacao", "oque","", "", "0");
	}
	
	//Relevancia
	if(isset($_GET['chk_relevancia'])){
		$Conteudo = $_GET['estr_relevancia'];
		$Condicao = $_GET['order_relevancia'];
		$doc = $xml->atualizaFilhos($doc, "ordenacao", "relevancia",$Condicao, $Conteudo, "1");
	} else {//Confirma a não publicação deste item
		$doc = $xml->atualizaFilhos($doc, "ordenacao", "relevancia","", "", "0");
	}
	
?>