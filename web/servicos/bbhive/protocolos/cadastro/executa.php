<?php
if (!isset($_SESSION)) { session_start(); }
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/servicos/bbhive/includes/functions.php");
//--
//POIS VOU REDIRECIONAR PARA O OK.PHP
$arquivo = "../../../../datafiles/servicos/bbhive/setup/config.xml";

//SEGUINDO A SEQUÊNCIA DAS INFORMAÇÕES
	$doc = new DOMDocument("1.0", "iso-8859-1"); 
	$doc->preserveWhiteSpace = false; //descartar espacos em branco    
	$doc->formatOutput = false; //gerar um codigo bem legivel   
	$doc->load($arquivo);
	//-----	
	$root = $doc->getElementsByTagName("config")->item(0);
	$prot = $root->getElementsByTagName("protocolo")->item(0);
	//-----
	//$detalhamento 	= $prot->getAttribute("detalhamento");
		
//**************CADASTRA PROTOCOLO E REDIRECIONA PARA O PASSO CERTO**********************************
	if(isset($_POST['insertProtocolo'])){
		//recebe todas informações via POST
		$bbh_pro_titulo			= apostrofo(($_POST['bbh_pro_titulo']));
			if(isset($_SESSION['pacoteNovoProtocolo'])){
				$bbh_pro_descricao 		= apostrofo(($_POST['bbh_pro_descricao']))."\r\n=========\r\n\r\n";
				$bbh_pro_descricao 		.= apostrofo(($_POST['descricao']));
			} else {
				$bbh_pro_descricao 		= apostrofo(($_POST['bbh_pro_descricao']));
			}

		$bbh_pro_momento		= $_POST['bbh_pro_momento'];
		$bbh_pro_identificacao	= apostrofo(($_POST['bbh_pro_identificacao']));
		$bbh_pro_autoridade		= apostrofo(($_POST['bbh_pro_autoridade']));
		$bbh_pro_email			= $_POST['bbh_pro_email'];
		$bbh_dep_codigo			= $_POST['bbh_dep_codigo'];
		$bbh_pro_data			= !empty($_POST['bbh_pro_data']) ? arrumadata($_POST['bbh_pro_data']) : "";
		$bbh_pro_flagrante		= $_POST['bbh_pro_flagrante'];
	   
		$cpData					= !empty($bbh_pro_data) ? ", bbh_pro_data" : "";
		$vrData					= !empty($bbh_pro_data) ? ", '$bbh_pro_data'" : "";	
		
		$cdPai					= isset($_POST['bbh_flu_pai']) ? ", bbh_flu_pai" : "";
		$vrPai					= isset($_POST['bbh_flu_pai']) ? ", ".$_POST['bbh_flu_pai'] : "";

		//-----INSERT
		$insertSQL = "INSERT INTO bbh_protocolos 
						(bbh_pro_status, bbh_pro_titulo, bbh_pro_descricao, bbh_pro_momento, bbh_pro_identificacao, bbh_pro_email, bbh_dep_codigo, bbh_pro_flagrante, bbh_pro_autoridade $cpData $cdPai) 
							VALUES ('1', '$bbh_pro_titulo', '$bbh_pro_descricao', '$bbh_pro_momento', '$bbh_pro_identificacao', '$bbh_pro_email', $bbh_dep_codigo, '$bbh_pro_flagrante', '$bbh_pro_autoridade' $vrData $vrPai)";
        list($Result1, $rows, $totalRows_Autor) = executeQuery($bbhive, $database_bbhive, $insertSQL);
		$ultimoId = mysqli_insert_id($bbhive);
	
	
		//-----GRAVA ID NA SESSÃO
		$_SESSION['idProtocolo'] 	= $ultimoId;
		
		//--Detalhamento
		//if($detalhamento==1){
			require_once("detalhamento/grava_dados.php");
		//}
		
		//Apaga caso senha vindo do fluxo
		 $_SESSION['pacoteNovoProtocolo'] = NULL;
		 unset($_SESSION['pacoteNovoProtocolo']);
		//--
		
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Cadastrou o(".$_SESSION['protNome'].")número (".$ultimoId.")  - BBHive público.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
		
		//-----REDIRECIONA PARA O PASSO 2
		//$carregaPagina= "showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1|protocolos/cadastro/passo2.php','menuEsquerda|colPrincipal')";
		$carregaPagina= "showHome('includes/completo.php','conteudoGeral', 'protocolos/cadastro/passo2.php','colPrincipal')";
		echo '<var style="display:none">'.$carregaPagina.'</var>';
	}
//***************************************************************************************************

//**********************CADASTRA INDÍCIOS NO PROTOCOLO**********************************************

//***************************************************************************************************

if(isset($_POST['gerProt'])){
	//-----GRAVA ID NA SESSÃO
	$_SESSION['idProtocolo'] 	= $_POST['bbh_pro_cod'];
	
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Acessou informações do (".$_SESSION['protNome'].") número (".$_SESSION['idProtocolo'].")  - BBHive público.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
	//-----REDIRECIONA PARA O PASSO 2
	//$carregaPagina= "showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1|protocolos/cadastro/ok.php?consulta=true','menuEsquerda|colPrincipal')";
	$carregaPagina= "showHome('includes/completo.php','conteudoGeral', 'protocolos/cadastro/ok.php?consulta=true','colPrincipal')";
	echo '<var style="display:none">'.$carregaPagina.'</var>';
exit;
}

if(isset($_POST['alteraProtocolo'])){
	//recebe todas informações via POST
		$bbh_pro_titulo			= apostrofo(($_POST['bbh_pro_titulo']));
		$bbh_pro_descricao 		= apostrofo(($_POST['bbh_pro_descricao']));
		$bbh_pro_identificacao	= apostrofo(($_POST['bbh_pro_identificacao']));
		$bbh_pro_autoridade		= apostrofo(($_POST['bbh_pro_autoridade']));
		$bbh_dep_codigo			= $_POST['bbh_dep_codigo'];
		$bbh_pro_data			= !empty($_POST['bbh_pro_data']) ? arrumadata($_POST['bbh_pro_data']) : "";
		$bbh_pro_flagrante		= $_POST['bbh_pro_flagrante'];
		$vrData					= !empty($bbh_pro_data) ? ", bbh_pro_data='$bbh_pro_data'" : "";
		//---
		$insertSQL = "UPDATE bbh_protocolos SET bbh_pro_titulo='$bbh_pro_titulo', bbh_pro_descricao='$bbh_pro_descricao', bbh_pro_identificacao='$bbh_pro_identificacao', bbh_dep_codigo='$bbh_dep_codigo', bbh_pro_flagrante='$bbh_pro_flagrante', bbh_pro_autoridade='$bbh_pro_autoridade' $vrData where bbh_pro_codigo=".$_POST['bbh_pro_codigo'];
		//---
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
		//-----GRAVA ID NA SESSÃO
		$_SESSION['idProtocolo'] 	= $_POST['bbh_pro_codigo'];
		
		//--Detalhamento
		require_once("detalhamento/grava_dados.php");
		
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Atualizou informações do (".$_SESSION['protNome'].") número (".$_SESSION['idProtocolo'].")  - BBHive público.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
		
		//-----REDIRECIONA PARA O PASSO 2
		//$carregaPagina= "showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1|protocolos/cadastro/passo2.php?edita=true','menuEsquerda|colPrincipal')";
		$carregaPagina= "showHome('includes/completo.php','conteudoGeral', 'protocolos/cadastro/passo2.php?edita=true','colPrincipal')";
		echo '<var style="display:none">'.$carregaPagina.'</var>';
 exit;	
}

if(isset($_POST['searchProtocolo'])){
	$pro = isset($_POST['ck_prot']) ?  $_SESSION['protNome'] .":". $_POST['bbh_pro_codigo'] : "";
	$pro.= isset($_POST['ck_data']) ? " Data: ".$_POST['bbh_pro_data'] : "";
	$pro.= isset($_POST['ck_tit']) ? " Título: ".($_POST['bbh_pro_titulo']) : "";
	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1";
	$Evento="Efetuou uma busca de (".$_SESSION['protNome'].") ($pro) - BBHive público.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/
		
   $stringAnd			= " 1=1 ";
   $stringAnd			.= isset($_POST['ck_prot']) ? " AND bbh_pro_codigo=".$_POST['bbh_pro_codigo'] : "";
   $stringAnd			.= isset($_POST['ck_data']) ? " AND bbh_pro_momento BETWEEN '".arrumadata($_POST['bbh_pro_data'])." 00:00:00' AND '".arrumadata($_POST['bbh_pro_data'])." 23:59:59'" : "";
   $stringAnd			.= isset($_POST['ck_tit']) ? " AND bbh_pro_titulo LIKE '%".($_POST['bbh_pro_titulo'])."%'" : "";

	$query_strProtocolo = "SELECT * FROM bbh_protocolos WHERE $stringAnd";
    list($strProtocolo, $rows, $totalRows_strProtocolo) = executeQuery($bbhive, $database_bbhive, $query_strProtocolo, $initResult = false);

	if($totalRows_strProtocolo >0){
	 if(!isset($_SESSION)){ session_start(); } 
	   $lista = 0;
	 	//recupera todos os protocolos
		while($row_strProtocolo = mysqli_fetch_assoc($strProtocolo)){
			$lista.= ",".$row_strProtocolo['bbh_pro_codigo'];
		}
	 
		$destino = "LoadSimultaneo(\"protocolos/regra.php?busca=".$lista."\",\"conteudoGeral\");";
		echo '<var style="display:none">'.$destino.'</var>';
		exit;
	} else {
		echo "<span style='color:#FF0000'>" .$_SESSION['protNome'] ." n&atilde;o encontrado!</span>";
		exit;
	}
}
?>