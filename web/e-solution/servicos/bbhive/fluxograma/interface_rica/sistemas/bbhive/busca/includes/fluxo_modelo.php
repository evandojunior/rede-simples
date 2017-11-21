<?php
//RECUPERA O CÓDIGO DO MODELO PARA FAZER A BUSCA=========================================================================
$bbh_mod_flu_codigo = !isset($_GET['bbh_mod_flu_codigo']) ? $_SESSION['bbh_mod_flu_codigo'] : $_GET['bbh_mod_flu_codigo'];
//=======================================================================================================================

//INSTÂNCIA A CLASSE QUE GERENCIA O XML==================================================================================
$xml 			= new GerenciaXML();
$domXML 		= $xml->criaXML("fluxo");
//=======================================================================================================================

//INSTÂNCIA A CLASSE QUE GERENCIA AS ATIVIDADES==========================================================================
$atividades 	= new GerenciaAtividades();
$strAtividades	= $atividades->atividadesModelo($bbh_mod_flu_codigo, $database_bbhive, $bbhive);
//=======================================================================================================================

//ADICIONA ATIVIDADES NO XML CRIADO ANTERIORMENTE========================================================================
$domXML			= $atividades->adicionaAtividadesModelo($strAtividades, $domXML, $database_bbhive, $bbhive);
//=======================================================================================================================

//ADICIONA PREMISSAS de MODELO NO XML CRIADO ANTERIORMENTE===============================================================
$domXML			= $xml->adicionaPremissas($atividades, $domXML, $database_bbhive, $bbhive);
//=======================================================================================================================

//ADICIONA ALTERNATIVAS de MODELO NO XML CRIADO ANTERIORMENTE============================================================
$domXML			= $xml->adicionaAlternativas($atividades, $domXML, $database_bbhive, $bbhive);
//=======================================================================================================================

	$root = $domXML->getElementsByTagName('fluxo')->item(0);
	$root->setAttribute("tag", "bbh_mod_flu_codigo");
	$root->setAttribute("valor", $bbh_mod_flu_codigo);
	$domXML->appendChild($root);//adiciona no objeto principal
	
//PUBLICA O XML==========================================================================================================
echo $domXML->saveXML();
//=======================================================================================================================

exit;
	echo '<?xml version="1.0" encoding="iso-8859-1"?>';
	require_once("fluxo6.xml");
?>