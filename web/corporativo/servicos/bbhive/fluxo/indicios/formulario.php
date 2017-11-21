<?php
 if(!isset($_SESSION)){ session_start(); } 
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/servicos/bbhive/includes/functions.php");
	//--Código do tipo de indicios
	$codigo = $_POST['codigo'];
	
	//--Selecionar as colunas disponíveis para este tipo de indício
	require_once("detalhamento/regra.php");
?>