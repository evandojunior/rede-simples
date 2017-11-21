<?php
	//--
	$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
				WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_detalhamento_protocolos'";
    list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
	//--
	$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
	//--

	//recupera o diretório da aplicação, sendo que não sei em qual aplicação estou
	$dirXML 	= explode("web",str_replace("\\","/",dirname(__FILE__)));
	$dirOndeX 	= $dirXML[0]."web";
	
	//POIS VOU REDIRECIONAR PARA O OK.PHP
	$arquivoXML = $dirOndeX."/datafiles/servicos/bbhive/setup/config.xml";
	
	//SEGUINDO A SEQUÊNCIA DAS INFORMAÇÕES
		$config = new DOMDocument("1.0", "iso-8859-1"); 
		$config->preserveWhiteSpace = false; //descartar espacos em branco    
		$config->formatOutput = false; //gerar um codigo bem legivel   
		$config->load($arquivoXML);
		//-----	
		$root = $config->getElementsByTagName("config")->item(0);
		$prot = $root->getElementsByTagName("protocolo")->item(0);
		//-----
		$digitalizar 	= $prot->getAttribute("digitalizar");
		$indicios 		= $prot->getAttribute("indicios");
		$imprimir 		= $prot->getAttribute("imprimir");
		$detalhamento 	= $prot->getAttribute("detalhamento");
?>