<?php 
if(!isset($_SESSION)){ session_start(); }
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");



//EDIÇÃO DO PERFIL
if(isset($_POST['MM_update'])){
	//RECUPERA DADOS
	$bbh_usu_nome 		   		= ($_POST['bbh_usu_nome']);
	$bbh_usu_apelido	   		= ($_POST['bbh_usu_apelido']);
	$bbh_usu_sexo 		   		= $_POST['sexo'];
	$bbh_usu_tel_comercial 		= $_POST['bbh_usu_tel_comercial'];
	$bbh_usu_tel_residencial 	= $_POST['bbh_usu_tel_residencial'];
	$bbh_usu_tel_celular		= $_POST['bbh_usu_tel_celular'];
	$bbh_usu_tel_recados		= $_POST['bbh_usu_tel_recados'];
	$bbh_usu_fax				= $_POST['bbh_usu_fax'];
	$bbh_usu_email_alternativo	= $_POST['bbh_usu_email_alternativo'];
	$bbh_usu_endereco			= ($_POST['bbh_usu_endereco']);
	$bbh_usu_cidade				= ($_POST['bbh_usu_cidade']);
	$bbh_usu_estado				= ($_POST['bbh_usu_estado']);
	$bbh_usu_cep				= $_POST['bbh_usu_cep'];
	$bbh_usu_pais				= ($_POST['bbh_usu_pais']);
	$bbh_usu_codigo				= $_SESSION['usuCod'];
	
	$updateSQL = "UPDATE bbh_usuario SET bbh_usu_nome='$bbh_usu_nome', bbh_usu_apelido='$bbh_usu_apelido', bbh_usu_sexo='$bbh_usu_sexo', bbh_usu_tel_comercial= '$bbh_usu_tel_comercial', bbh_usu_tel_residencial='$bbh_usu_tel_residencial', bbh_usu_tel_celular='$bbh_usu_tel_celular', bbh_usu_tel_recados='$bbh_usu_tel_recados', bbh_usu_fax='$bbh_usu_fax', bbh_usu_email_alternativo='$bbh_usu_email_alternativo', bbh_usu_endereco='$bbh_usu_endereco', bbh_usu_cidade='$bbh_usu_cidade', bbh_usu_estado='$bbh_usu_estado', bbh_usu_cep='$bbh_usu_cep', bbh_usu_pais='$bbh_usu_pais' WHERE bbh_usu_codigo = $bbh_usu_codigo";

    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	
	require_once('busca_dados.php');
	//Atualiza Sessão
	$_SESSION['usuNome']	= $row_dados['bbh_usu_nome'];
	$_SESSION['usuApelido']	= $row_dados['bbh_usu_apelido'];
	
	echo "<var style=\"display:none\">txtSimples('nomeLogado', '".$_SESSION['usuApelido']."')</var>";
	echo "<var style=\"display:none\">txtSimples('nomeLogadoPerfil', '".$_SESSION['usuApelido']."')</var>";

	require_once('atualizados.php');
}


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
	$homeDestino	= '"/corporativo/servicos/bbhive/perfil/perfil.php?usuario='.$bbh_usu_codigo.'&Ts='.$TimeStamp.'"';
	//esquerda	
	echo "<var style=\"display:none\">OpenAjaxPostCmd($homeDestino,$idResultado,$infoGet_Post,$Mensagem,$idMensagemFinal,$Metodo,$TpMens)</var>";

	//direita
	$idResultado	= '"direita"';
	$homeDestino	= '"/corporativo/servicos/bbhive/perfil/addPerfil.php?usuario='.$bbh_usu_codigo.'&Ts='.$TimeStamp.'"';
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
	$homeDestino	= '"/corporativo/servicos/bbhive/perfil/perfil.php?usuario='.$bbh_usu_codigo.'&Ts='.$TimeStamp.'"';
		
	//esquerda	
	echo "<var style=\"display:none\">OpenAjaxPostCmd($homeDestino,$idResultado,$infoGet_Post,$Mensagem,$idMensagemFinal,$Metodo,$TpMens)</var>".chr(13).chr(10);
}
?>