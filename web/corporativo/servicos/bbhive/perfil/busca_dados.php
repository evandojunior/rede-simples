<?php 
if(!isset($_SESSION)){ session_start(); }

if (isCurrentPage("/corporativo/servicos/bbhive/perfil/executa.php")) {
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
}
		$query_dados = "SELECT DATE_FORMAT(bbh_usu_data_nascimento,'%d/%m/%Y') AS data_nascimento, bbh_departamento.bbh_dep_nome, bbh_usuario.* FROM bbh_usuario INNER JOIN bbh_departamento ON bbh_departamento.bbh_dep_codigo = bbh_usuario.bbh_dep_codigo WHERE bbh_usu_codigo =".$_SESSION['usuCod'];
        list($dados, $row_dados, $totalRows_dados) = executeQuery($bbhive, $database_bbhive, $query_dados);
