<?php 
header ("content-type: text/xml");
//Conexão com o banco de dados e classes=================================================================================
require_once("../../../../../../../../Connections/bbhive.php");
require_once("includes/gerencia_xml.php");
require_once("includes/gerencia_atividades.php");
//=======================================================================================================================

//VERIFICA SE VOU BUSCAR DETALHES DA ATIVIDADE OU MODELO DE ATIVIDADE====================================================
	if(isset($_GET['bbh_mod_flu_codigo']) || isset($_SESSION['bbh_mod_flu_codigo'])){
		require_once("includes/fluxo_modelo.php");
		exit;
	}
//=======================================================================================================================

//RECUPERA O CÓDIGO DO FLUXO PARA FAZER A BUSCA==========================================================================
$bbh_flu_codigo = isset($_GET['bbh_flu_codigo']) ? $_GET['bbh_flu_codigo'] : $_SESSION['bbh_flu_codigo'];
$bbh_usu_codigo	= $_SESSION['usuCod'];
//=======================================================================================================================

//INSTÂNCIA A CLASSE QUE GERENCIA O XML==================================================================================
$xml 			= new GerenciaXML();
$domXML 		= $xml->criaXML("fluxo");
//=======================================================================================================================

//INSTÂNCIA A CLASSE QUE GERENCIA AS ATIVIDADES==========================================================================
$atividades 	= new GerenciaAtividades();
$strAtividades	= $atividades->listaAtividades($bbh_flu_codigo, $database_bbhive, $bbhive);
//=======================================================================================================================

//ADICIONA ATIVIDADES NO XML CRIADO ANTERIORMENTE========================================================================
$domXML			= $atividades->adicionaAtividades($strAtividades, $domXML, $database_bbhive, $bbhive);
//=======================================================================================================================

//ADICIONA PREMISSAS de ATIVIDADES NO XML CRIADO ANTERIORMENTE===========================================================
$domXML			= $xml->adicionaPremissas($atividades, $domXML, $database_bbhive, $bbhive);
//=======================================================================================================================

//ADICIONA ALTERNATIVAS de ATIVIDADES NO XML CRIADO ANTERIORMENTE========================================================
$domXML			= $xml->adicionaAlternativas($atividades, $domXML, $database_bbhive, $bbhive);
//=======================================================================================================================

//PUBLICA O XML==========================================================================================================
	$root = $domXML->getElementsByTagName('fluxo')->item(0);
	$root->setAttribute("tag", "bbh_flu_codigo");
	$root->setAttribute("valor", $bbh_flu_codigo);
	$domXML->appendChild($root);//adiciona no objeto principal

echo $domXML->saveXML();
//=======================================================================================================================
?>