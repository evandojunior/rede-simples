<?php
	//Quem
	if(isset($_GET['chk_quem'])){
		$Conteudo = utf8_encode($_GET['pol_quem']);
		$Condicao = $_GET['condicao_quem'];
		$doc = $xml->atualizaFilhos($doc, "condicao", "quem",$Condicao, $Conteudo, "1");
	} else {//Confirma a não publicação deste item
		$doc = $xml->atualizaFilhos($doc, "condicao", "quem","", "", "0");
	}
	
	//Quando
	if(isset($_GET['chk_quando'])){
		$Conteudo = $_GET['data_inicio']."|".$_GET['data_fim'];
		$doc = $xml->atualizaFilhos($doc, "condicao", "quando",$Condicao, $Conteudo, "1");
	} else {//Confirma a não publicação deste item
		$doc = $xml->atualizaFilhos($doc, "condicao", "quando","", "", "0");
	}
	
	//Onde
	if(isset($_GET['chk_onde'])){
		$Conteudo = utf8_encode($_GET['pol_onde']);
		$Condicao = $_GET['condicao_onde'];
		$doc = $xml->atualizaFilhos($doc, "condicao", "onde",$Condicao, $Conteudo, "1");
	} else {//Confirma a não publicação deste item
		$doc = $xml->atualizaFilhos($doc, "condicao", "onde","", "", "0");
	}
	
	//Oque
	if(isset($_GET['chk_oque'])){
		$Conteudo = utf8_encode($_GET['pol_oque']);
		$Condicao = $_GET['condicao_oque'];
		$doc = $xml->atualizaFilhos($doc, "condicao", "oque",$Condicao, $Conteudo, "1");
	} else {//Confirma a não publicação deste item
		$doc = $xml->atualizaFilhos($doc, "condicao", "oque","", "", "0");
	}
	//Relevancia
	if(isset($_GET['chk_relevancia'])){
		$Conteudo = utf8_encode($_GET['pol_relevancia']);
		$Condicao = $_GET['condicao_relevancia'];
		$doc = $xml->atualizaFilhos($doc, "condicao", "relevancia",$Condicao, $Conteudo, "1");
	} else {//Confirma a não publicação deste item
		$doc = $xml->atualizaFilhos($doc, "condicao", "relevancia","", "", "0");
	}
?>