<?php
//RECUPERA O CÓDIGO DO FLUXO PARA FAZER A BUSCA==========================================================================
$bbh_mod_ati_codigo 	= $_GET['bbh_mod_ati_codigo'];
//=======================================================================================================================

//INSTÂNCIA A CLASSE QUE GERENCIA O XML==================================================================================
$xml 			= new GerenciaXML();
$domXML 		= $xml->criaXML("atividade_fluxo");
//=======================================================================================================================

//INSTÂNCIA A CLASSE QUE GERENCIA AS ATIVIDADES==========================================================================
$atividades 	= new GerenciaAtividades();
$strModelo		= $atividades->listaModeloAtividades($bbh_mod_ati_codigo, $database_bbhive, $bbhive);
//=======================================================================================================================

//DETALHES ESPECÍFICOS DESTE MODELO======================================================================================
$souFluxoModelo	= "-1";
$codFluxoModelo	= "0";
$tituloSubFluxo	= "";
$codigoAnterior = "";
$tituloAnterior	= "";
//=======================================================================================================================

//ADICIONA DETALHES NO XML CRIADO ANTERIORMENTE==========================================================================
$domXML			= $xml->adicionaDetalhes($strModelo, $domXML, $bbh_mod_ati_codigo, $souFluxoModelo, $codFluxoModelo, $tituloSubFluxo, $codigoAnterior, $tituloAnterior);
//=======================================================================================================================

//PUBLICA O XML==========================================================================================================
echo $domXML->saveXML();
//=======================================================================================================================
?>