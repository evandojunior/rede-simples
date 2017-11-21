<?php
//header ("content-type: text/xml");
//Conexão com o banco de dados e classes=================================================================================
require_once("../../../../../../../../Connections/bbhive.php");
require_once("includes/gerencia_xml.php");
require_once("includes/gerencia_atividades.php");
//=======================================================================================================================

//VERIFICA SE VOU BUSCAR DETALHES DA ATIVIDADE OU MODELO DE ATIVIDADE====================================================
	if(isset($_GET['bbh_mod_flu_codigo'])){
		require_once("includes/detalhes_modelo.php");
		exit;
	} else if(isset($_GET['bbh_mod_ati_codigo'])){
		require_once("includes/atividades_modelo.php");
		exit;
	}
//=======================================================================================================================

//RECUPERA O CÓDIGO DO FLUXO PARA FAZER A BUSCA==========================================================================
$bbh_ati_codigo = $_GET['bbh_ati_codigo'];
$bbh_usu_codigo	= 20;
//=======================================================================================================================

//INSTÂNCIA A CLASSE QUE GERENCIA O XML==================================================================================
$xml 			= new GerenciaXML();
$domXML 		= $xml->criaXML("atividade_fluxo");
//=======================================================================================================================

//INSTÂNCIA A CLASSE QUE GERENCIA AS ATIVIDADES==========================================================================
$atividades 	= new GerenciaAtividades();
$strAtividades	= $atividades->listaDetalhes($bbh_ati_codigo, $database_bbhive, $bbhive, $bbh_usu_codigo);
//=======================================================================================================================
//DETALHES ESPECÍFICOS DESTA ATIVIDADE===================================================================================
$dados			= explode("|",$atividades->verificaAtiv($bbh_ati_codigo, $database_bbhive, $bbhive));
$souFluxoModelo	= $dados[0];
$codFluxoModelo	= $dados[1];
$tituloSubFluxo	= $dados[2];
$dadosAtividade	= explode("|",$atividades->dadosAtiv($bbh_ati_codigo, $database_bbhive, $bbhive));
$codigoAnterior = $dadosAtividade[0];
$tituloAnterior	= $dadosAtividade[1];
//=======================================================================================================================

//ADICIONA DETALHES NO XML CRIADO ANTERIORMENTE==========================================================================
$domXML			= $xml->adicionaDetalhes($strAtividades, $domXML, $bbh_ati_codigo, $souFluxoModelo, $codFluxoModelo, $tituloSubFluxo, $codigoAnterior, $tituloAnterior);
//=======================================================================================================================

//PUBLICA O XML==========================================================================================================
echo $domXML->saveXML();
//=======================================================================================================================
?>