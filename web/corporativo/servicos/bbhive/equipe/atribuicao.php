<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");

//GERENCIA PERFIS
if(isset($_GET['del'])){
	$bbh_usu_codigo = $_GET['bbh_usu_codigo'];
	$bbh_per_codigo = $_GET['bbh_per_codigo'];
	
	$deleteSQL = "DELETE FROM bbh_usuario_perfil WHERE bbh_per_codigo=$bbh_per_codigo and bbh_usu_codigo=$bbh_usu_codigo";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);
	
	$TimeStamp 		= time();
	$idMensagemFinal= '"loadPerfil"';
	$infoGet_Post	= '"&1=1"';//Se envio for POST, colocar nome do formulário
	$Mensagem		= '"Atualizando dados..."';
	$idResultado	= '"esquerda"';
	$Metodo			= '"2"';//1-POST, 2-GET
	$TpMens			= '"1"';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '"/corporativo/servicos/bbhive/equipe/adicionados.php?bbh_per_codigo='.$bbh_per_codigo.'&Ts='.$TimeStamp.'"';
	//esquerda	
	echo "<var style=\"display:none\">OpenAjaxPostCmd($homeDestino,$idResultado,$infoGet_Post,$Mensagem,$idMensagemFinal,$Metodo,$TpMens)</var>";

	//direita
	$idResultado	= '"direita"';
	$homeDestino	= '"/corporativo/servicos/bbhive/equipe/adicionados.php?bbh_per_codigo='.$bbh_per_codigo.'&Ts='.$TimeStamp.'"';
	echo "<var style=\"display:none\">OpenAjaxPostCmd($homeDestino,$idResultado,$infoGet_Post,$Mensagem,$idMensagemFinal,$Metodo,$TpMens)</var>";
}

//ADICIONA PERFIL
if(isset($_GET['add'])){
	$bbh_usu_codigo = $_GET['bbh_usu_codigo'];
	$bbh_per_codigo = $_GET['bbh_per_codigo'];
	
	$insertSQL = "INSERT INTO bbh_usuario_perfil (bbh_usu_codigo, bbh_per_codigo) VALUES ($bbh_usu_codigo, $bbh_per_codigo)";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
	
	$TimeStamp 		= time();
	$idMensagemFinal= '"loadPerfil"';
	$infoGet_Post	= '"&1=1"';//Se envio for POST, colocar nome do formulário
	$Mensagem		= '"Atualizando dados..."';
	$idResultado	= '"esquerda"';
	$Metodo			= '"2"';//1-POST, 2-GET
	$TpMens			= '"1"';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '"/corporativo/servicos/bbhive/equipe/adicionados.php?bbh_per_codigo='.$bbh_per_codigo.'&Ts='.$TimeStamp.'"';
		
	//esquerda	
	echo "<var style=\"display:none\">OpenAjaxPostCmd($homeDestino,$idResultado,$infoGet_Post,$Mensagem,$idMensagemFinal,$Metodo,$TpMens)</var>".chr(13).chr(10);
}
?>