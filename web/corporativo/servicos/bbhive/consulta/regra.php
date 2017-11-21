<?php if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

//Interface rica
if(isset($_GET['bbh_interface_codigo'])){
	$_SESSION['bbh_flu_codigo'] = $_GET['bbh_interface_codigo'];
	//--Monta caminho padrão para croqui
	//recupera o diretório da aplicação, sendo que não sei em qual aplicação estou
	$divisor = "web";//padrão letra minuscula
	$dirPadrao 	= explode($divisor,str_replace("\\","/",(dirname(__FILE__))));
	$path 		= $dirPadrao[0];
	
	$diretorio = $path . "database";
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
	$diretorio.= "/servicos";
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
		$diretorio.= "/bbhive";
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
	$diretorio.= "/fluxo";
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
	$diretorio.= "/fluxo_".$_SESSION['bbh_flu_codigo'];
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
	$diretorio.= "/arquivos";
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
	$_SESSION['caminhoPadraoCroquiBBHIVE'] = $diretorio."/croqui_XXXXXX.jpg";
	?>
	<form name="executaInterfaceRica" id="executaInterfaceRica" method="get" action="/corporativo/servicos/bbhive/fluxograma/interface_rica/index.php" target="_blank">
</form>
	<var style="display:none">
		document.executaInterfaceRica.submit();
	</var>
	<?php
	exit;
}

//recuperação de variáveis do GET e SESSÃO
foreach($_GET as $indice => $valor){
	if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ $bbh_flu_codigo=$valor; }
}
$compl = "";
//anexar fluxo
foreach($_GET as $indice => $valor){
	if(($indice=="amp;bbh_flu_codigo_p")||($indice=="bbh_flu_codigo_p")){ $bbh_flu_codigo_p=$valor; }
	if(($indice=="amp;bbh_pro_codigo")||($indice=="bbh_pro_codigo")){ $bbh_pro_codigo=$valor; }
}
 if(isset($bbh_flu_codigo_p)){ $compl = "&bbh_flu_codigo_p=".$bbh_flu_codigo_p; }
 if(isset($bbh_pro_codigo)){ 
	require_once("../protocolo/includes/anexar_distribuido.php");
 	exit;
 }

 if(isset($bbh_flu_codigo_p)){ 
 	$compl 			= "&bbh_flu_codigo_p=".$bbh_flu_codigo_p; 
	$bbhCompl 		= $bbh_flu_codigo;
	$bbh_flu_codigo = $bbh_flu_codigo_p;
	include("includes/cabecaFluxo.php");
	include("includes/detalheResumo.php");
	require_once("includes/cabecaResumo.php");
		//verifica se estes fluxos já tem relação
		$sql = "select count(*) as total from bbh_fluxo_relacionado
  where (bbh_flu_codigo_p=$bbh_flu_codigo AND bbh_flu_codigo_f=$bbhCompl) OR (bbh_flu_codigo_p=$bbhCompl AND bbh_flu_codigo_f=$bbh_flu_codigo)";

     list($confRel, $row_confRel, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql);
		//--
	$bbh_flu_codigo	= $bbhCompl;
 }
 
include("includes/cabecaFluxo.php");
require_once("includes/resumo.php"); ?>