<?php
//RECUPERA O CÓDIGO DO FLUXO PARA FAZER A BUSCA==========================================================================
$bbh_ati_codigo 	= "-1";//$_GET['bbh_ati_codigo_pai'];
$bbh_mod_flu_codigo	= $_GET['bbh_mod_flu_codigo'];//, 0, strlen($_GET['bbh_mod_flu_codigo'])-3);
//=======================================================================================================================

//INSTÂNCIA A CLASSE QUE GERENCIA O XML==================================================================================
$xml 			= new GerenciaXML();
$domXML 		= $xml->criaXML("atividade_fluxo");
//=======================================================================================================================

//INSTÂNCIA A CLASSE QUE GERENCIA AS ATIVIDADES==========================================================================
$atividades 	= new GerenciaAtividades();
$strModelo		= $atividades->listaModelo($bbh_mod_flu_codigo, $database_bbhive, $bbhive);
//=======================================================================================================================

//DETALHES ESPECÍFICOS DESTE MODELO======================================================================================
$souFluxoModelo	= "0";
$codFluxoModelo	= $bbh_mod_flu_codigo;
$tituloSubFluxo	= "";
$dadosAtividade	= explode("|",$atividades->dadosAtiv($bbh_ati_codigo, $database_bbhive, $bbhive));
$codigoAnterior = $dadosAtividade[0];
$tituloAnterior	= $dadosAtividade[1];
//=======================================================================================================================

//ADICIONA DETALHES NO XML CRIADO ANTERIORMENTE==========================================================================
$domXML			= $xml->adicionaDetalhes($strModelo, $domXML, $bbh_ati_codigo, $souFluxoModelo, $codFluxoModelo, $tituloSubFluxo, $codigoAnterior, $tituloAnterior);
//=======================================================================================================================

//PUBLICA O XML==========================================================================================================
echo $domXML->saveXML();
//=======================================================================================================================

?>