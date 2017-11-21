<?php
	@error_reporting(E_ALL|E_STRICT);
	require_once dirname(__FILE__).'/asn1.php';
	$GEOTrustRootCert = base64_decode($cert);
//	echo "<pre>";
	
	//print_r(ASN1::parseASNString($GEOTrustRootCert));
	$objIntegro = ASN1::parseASNString($GEOTrustRootCert);
	
	$_SESSION['dadosCert'] = array();
	
	function verificaFilhos($obj){
		$qtFilhos = count($obj);
		
			for($a=0; $a<$qtFilhos; $a++){
				if(is_array($obj[$a])){
					verificaFilhos($obj[$a]);
				}else{
					 if($obj[$a]!=""){
						 $_SESSION['dadosCert'][$obj[$a]] = $obj[$a];
					 }
				}
			}
	}
	
	verificaFilhos($objIntegro);
	//ordena array
	ksort($_SESSION['dadosCert']);
	
	//remonta array
	$dadosTratados = array();
	$cont = 0;
		foreach($_SESSION['dadosCert'] as $indice=>$valor){
			array_push($dadosTratados, $valor);
			$cont++;
		}
	//destrói o que precisa
	unset($_SESSION['dadosCert']);
	//key
	$dadosTratados[0] = base64_encode($dadosTratados[0]);
	$dadosTratados[1] = base64_encode($dadosTratados[1]);
	
	//Nome e CPF
	$dadosPessoais			= explode(":",$dadosTratados[18]);//Tratamento para Toke SafeNet = 18
	
	if(!isset($dadosPessoais[1])){
		$dadosPessoais= explode(":",$dadosTratados[17]);//Tratamento para Toke JC = 17
	}
	
	$bbp_adm_loc_ass_nome 	= $dadosPessoais[0];
	$bbp_adm_loc_ass_cpf  	= $dadosPessoais[1];
	
	//destrói o array
	unset($dadosTratados);
?>