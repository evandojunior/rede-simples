<?php
$diretorio = explode("web",str_replace("\\","/",dirname(__FILE__)));
$diretorio = $diretorio[0]."web/Connections/setup.php";
require_once($diretorio);

//Trava de segurança contra tentativa de autenticação não autorizada
//if(gethostbyname($BBP_host) != $_SERVER['REMOTE_ADDR']){  exit; }

if(gethostbyname($socket_BBPASS) != $_SERVER['REMOTE_ADDR']){ echo "0"; exit; }

//recebe parâmetros
if($_SERVER['QUERY_STRING']!=""){

	$getURL = base64_decode(base64_decode($_SERVER['QUERY_STRING']));
	$getURL = explode("|",$getURL);
	
	$email	= $getURL[0];
	$chave	= $getURL[1];
	
	//trata dados do email
	$email	= str_replace("email=","",$email);
	
	//trata dados da chave
	$chave	= str_replace("chave=","",$chave);
	
	//recupera o diretório da aplicação, sendo que não sei em qual aplicação estou
	//diretórios padrões
	$divisor = "web";
	$dirPadrao = explode($divisor,str_replace("\\","/",dirname(__FILE__)));
	$dirOnde = $dirPadrao[1];

	function devolveDiretorio($dirOnde){
		$dirOnde = str_replace("/servicos/","",$dirOnde);	//servicos
		$dirOnde = str_replace("/corporativo","",$dirOnde);	//corporativo
		$dirOnde = str_replace("/e-solution","",$dirOnde);	//e-solution
		$dirOnde = explode("/",$dirOnde);
		return $dirOnde[0];
	}
	//em qual aplicação estou======================================================================
	$apl_atual = devolveDiretorio($dirOnde);
	//monta diretório no datafiles=================================================================
	$dirDinamico = $dirPadrao[0]."web/datafiles/servicos/".$apl_atual."/cred_temp/";

	//verifica se diretório existe=================================================================
	if(!file_exists($dirDinamico)){
		mkdir($dirDinamico,777);
		chmod($dirDinamico,0777);
	}
	//=============================================================================================

	//=============================================================================================
	//cria xml=====================================================================================
		$doc = new DOMDocument("1.0", "iso-8859-1"); 
		$doc->preserveWhiteSpace = false; //descartar espacos em branco    
		$doc->formatOutput = false; //gerar um codigo bem legivel 
		$root = $doc->createElement('credencial');//cria elemento pai de todos
	//adiciona atributo============================================================================
		$root->setAttribute('email',base64_encode($email));
		$root->setAttribute('chave',base64_encode($chave));
		$doc->appendChild($root);//adiciona noh no objeto XML	
	//grava no diretório===========================================================================
		$doc->save($dirDinamico.$chave.".xml");//grava XML alterado no diretório
	//processo finalizado==========================================================================
	if(file_exists($dirDinamico.$chave.".xml")){
		echo "1";
	} else {
		echo "0";
	}
}
?>