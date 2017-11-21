<?php
if(!isset($_SESSION)){ session_start(); } 

if(!isset($_SESSION['adm_titulos'])){
	//cria objeto responsáveis pelos título
	$UrlXML = "../../../datafiles/servicos/bbhive/setup/titulo.xml";
	
	//cria objeto xml
	$objXML = new DOMDocument("1.0", "iso-8859-1"); 
	$objXML->preserveWhiteSpace = false; //descartar espacos em branco    
	$objXML->formatOutput = false; //gerar um codigo bem legivel 
	$objXML->load($UrlXML); //coloca conteúdo no objeto
	
	//le url a ser consultada
		$ConfigXML	= $objXML->getElementsByTagName("titulos")->item(0);
		
		$_SESSION['adm_FluxoNome']		= ($ConfigXML->getElementsByTagName("fluxos")->item(0)->getAttribute("titulo"));
		$_SESSION['adm_FluxoLeg']		= ($ConfigXML->getElementsByTagName("fluxos")->item(0)->getAttribute("legenda"));
	
		$_SESSION['adm_MsgNome']		= ($ConfigXML->getElementsByTagName("mensagens")->item(0)->getAttribute("titulo"));
		$_SESSION['adm_MsgLeg']			= ($ConfigXML->getElementsByTagName("mensagens")->item(0)->getAttribute("legenda"));
		
		$_SESSION['adm_deptoNome']		= ($ConfigXML->getElementsByTagName("departamento")->item(0)->getAttribute("titulo"));
		$_SESSION['adm_deptoLeg']		= ($ConfigXML->getElementsByTagName("departamento")->item(0)->getAttribute("legenda"));
	
		$_SESSION['adm_usuariosNome'] 	= ($ConfigXML->getElementsByTagName("usuarios")->item(0)->getAttribute("titulo"));
		$_SESSION['adm_usuariosLeg']   	= ($ConfigXML->getElementsByTagName("usuarios")->item(0)->getAttribute("legenda"));
	
		$_SESSION['adm_admNome']		= ($ConfigXML->getElementsByTagName("administradores")->item(0)->getAttribute("titulo"));
		$_SESSION['adm_admLeg']			= ($ConfigXML->getElementsByTagName("administradores")->item(0)->getAttribute("legenda"));
		
		$_SESSION['adm_perfNome']		= ($ConfigXML->getElementsByTagName("perfis")->item(0)->getAttribute("titulo"));
		$_SESSION['adm_perfLeg']		= ($ConfigXML->getElementsByTagName("perfis")->item(0)->getAttribute("legenda"));

		$_SESSION['adm_protNome']		= ($ConfigXML->getElementsByTagName("protocolo")->item(0)->getAttribute("titulo"));
		$_SESSION['adm_protLeg']		= ($ConfigXML->getElementsByTagName("protocolo")->item(0)->getAttribute("legenda"));

		$_SESSION['adm_statusNome']		= ($ConfigXML->getElementsByTagName("status")->item(0)->getAttribute("titulo"));
		$_SESSION['adm_statusLeg']		= ($ConfigXML->getElementsByTagName("status")->item(0)->getAttribute("legenda"));

		$_SESSION['adm_dicionarioNome']	= ($ConfigXML->getElementsByTagName("dicionario")->item(0)->getAttribute("titulo"));
		$_SESSION['adm_dicionarioLeg']	= ($ConfigXML->getElementsByTagName("dicionario")->item(0)->getAttribute("legenda"));

		$_SESSION['adm_tarNome']		= ($ConfigXML->getElementsByTagName("tarefas")->item(0)->getAttribute("titulo"));
		$_SESSION['adm_tarLeg']			= ($ConfigXML->getElementsByTagName("tarefas")->item(0)->getAttribute("legenda"));

		$_SESSION['adm_ArquivoNome']	= ($ConfigXML->getElementsByTagName("arquivos")->item(0)->getAttribute("titulo"));
		$_SESSION['adm_ArquivoLeg']		= ($ConfigXML->getElementsByTagName("arquivos")->item(0)->getAttribute("legenda"));

		$_SESSION['adm_relatorioNome']	= ($ConfigXML->getElementsByTagName("relatorio")->item(0)->getAttribute("titulo"));
		$_SESSION['adm_relatorioLeg']	= ($ConfigXML->getElementsByTagName("relatorio")->item(0)->getAttribute("legenda"));

		$_SESSION['adm_equipeNome']		= ($ConfigXML->getElementsByTagName("equipe")->item(0)->getAttribute("titulo"));
		$_SESSION['adm_equipeLeg']		= ($ConfigXML->getElementsByTagName("equipe")->item(0)->getAttribute("legenda"));

		$_SESSION['adm_consultaNome']	= ($ConfigXML->getElementsByTagName("consulta")->item(0)->getAttribute("titulo"));
		$_SESSION['adm_consultaLeg']	= ($ConfigXML->getElementsByTagName("consulta")->item(0)->getAttribute("legenda"));

		/*$_SESSION['adm_avisoNome']		= ($ConfigXML->getElementsByTagName("aviso")->item(0)->getAttribute("titulo"));
		$_SESSION['adm_avisoLeg']		= ($ConfigXML->getElementsByTagName("aviso")->item(0)->getAttribute("legenda"));*/
		
		$_SESSION['adm_componentesNome']	= ($ConfigXML->getElementsByTagName("componentes")->item(0)->getAttribute("titulo"));

		$_SESSION['adm_titulos'] = "ok";
}
?>