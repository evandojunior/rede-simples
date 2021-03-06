<?php
if(!isset($_SESSION)){ session_start(); } 

if(!isset($_SESSION['titulos'])){
	$UrlXML = "../../../datafiles/servicos/bbhive/setup/titulo.xml";
	
	$objXML = new DOMDocument("1.0", "iso-8859-1"); 
	$objXML->preserveWhiteSpace = false; //descartar espacos em branco    
	$objXML->formatOutput = false; //gerar um codigo bem legivel 
	$objXML->load($UrlXML); //coloca conteúdo no objeto

	$ConfigXML	= $objXML->getElementsByTagName("titulos")->item(0);
	
	
	$_SESSION['FluxoNome']	= ($ConfigXML->getElementsByTagName("fluxos")->item(0)->getAttribute("titulo"));
	$_SESSION['FluxoLeg']	= ($ConfigXML->getElementsByTagName("fluxos")->item(0)->getAttribute("legenda"));
	
	$_SESSION['MsgNome']	= ($ConfigXML->getElementsByTagName("mensagens")->item(0)->getAttribute("titulo"));
	$_SESSION['MsgLeg']		= ($ConfigXML->getElementsByTagName("mensagens")->item(0)->getAttribute("legenda"));
		
	$_SESSION['EquipeNome']	= ($ConfigXML->getElementsByTagName("equipe")->item(0)->getAttribute("titulo"));
	$_SESSION['EquipeLeg']	= ($ConfigXML->getElementsByTagName("equipe")->item(0)->getAttribute("legenda"));
	
	$_SESSION['TarefasNome']= ($ConfigXML->getElementsByTagName("tarefas")->item(0)->getAttribute("titulo"));
	$_SESSION['TarefasLeg']	= ($ConfigXML->getElementsByTagName("tarefas")->item(0)->getAttribute("legenda"));
	
	$_SESSION['relNome']	= ($ConfigXML->getElementsByTagName("relatorio")->item(0)->getAttribute("titulo"));
	$_SESSION['relLeg']		= ($ConfigXML->getElementsByTagName("relatorio")->item(0)->getAttribute("legenda"));
		
	$_SESSION['arqNome']	= ($ConfigXML->getElementsByTagName("arquivos")->item(0)->getAttribute("titulo"));
	$_SESSION['arqLeg']		= ($ConfigXML->getElementsByTagName("arquivos")->item(0)->getAttribute("legenda"));
		
	$_SESSION['protNome']	= ($ConfigXML->getElementsByTagName("protocolo")->item(0)->getAttribute("titulo"));
	$_SESSION['ProtLeg']	= ($ConfigXML->getElementsByTagName("protocolo")->item(0)->getAttribute("legenda"));

		
	$_SESSION['conNome']	= ($ConfigXML->getElementsByTagName("consulta")->item(0)->getAttribute("titulo"));
	$_SESSION['conLeg']		= ($ConfigXML->getElementsByTagName("consulta")->item(0)->getAttribute("legenda"));
		
	$_SESSION['arqPublNome']= ($ConfigXML->getElementsByTagName("arquivopublico")->item(0)->getAttribute("titulo"));
	$_SESSION['arqPublLegenda']= ($ConfigXML->getElementsByTagName("arquivopublico")->item(0)->getAttribute("legenda"));
	
	$_SESSION['receberNome']= ($ConfigXML->getElementsByTagName("receberprotocolo")->item(0)->getAttribute("titulo"));
	$_SESSION['receberLegenda']= ($ConfigXML->getElementsByTagName("receberprotocolo")->item(0)->getAttribute("legenda"));
	
	$_SESSION['despachoprotNome']= ($ConfigXML->getElementsByTagName("despachoprotocolo")->item(0)->getAttribute("titulo"));
	$_SESSION['despachoprotLegenda']= ($ConfigXML->getElementsByTagName("despachoprotocolo")->item(0)->getAttribute("legenda"));	
	//--	

	$query_campos_detalhamento = "select 
				(SELECT bbh_cam_det_pro_titulo FROM bbh_campo_detalhamento_protocolo where bbh_cam_det_pro_nome ='bbh_pro_flagrante' limit 1) as bbh_pro_flagrante,
				(SELECT bbh_cam_det_pro_titulo FROM bbh_campo_detalhamento_protocolo where bbh_cam_det_pro_nome ='bbh_pro_titulo' limit 1) as bbh_pro_titulo,
				(SELECT bbh_cam_det_pro_titulo FROM bbh_campo_detalhamento_protocolo where bbh_cam_det_pro_nome ='bbh_pro_autoridade' limit 1) as bbh_pro_autoridade,
				
				(SELECT bbh_cam_det_pro_titulo FROM bbh_campo_detalhamento_protocolo where bbh_cam_det_pro_nome ='bbh_pro_identificacao' limit 1) as bbh_pro_identificacao
				 						from DUAL";
    list($campos_detalhamento, $row_campos_detalhamento, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento);
		
	$_SESSION['FlagNome']			= $row_campos_detalhamento['bbh_pro_flagrante'];
	$_SESSION['ProtOfiNome']		= $row_campos_detalhamento['bbh_pro_titulo'];
	$_SESSION['ProtSolNome']		= $row_campos_detalhamento['bbh_pro_autoridade'];
	$_SESSION['ProtIdentificacao']	= $row_campos_detalhamento['bbh_pro_identificacao'];
	//--
	$_SESSION['ProtNome']		= ($ConfigXML->getElementsByTagName("protocolo")->item(0)->getAttribute("titulo"));
	$_SESSION['componentesNome'] = ($ConfigXML->getElementsByTagName("componentes")->item(0)->getAttribute("titulo"));
	$_SESSION['titulos'] = "ok";
}
?>