<?php if (!isset($_SESSION)) { session_start(); }

include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

//estou buscando informações a partir da consulta
if(isset($_POST['searchProtocolo'])){
	$v_prot				= isset($_POST['ck_prot']) ? "&bbh_pro_codigo=".$_POST['bbh_pro_codigo'] : "";
	$v_ofi				= isset($_POST['ck_tit']) ? "&bbh_pro_titulo=".mysqli_fetch_assoc($_POST['bbh_pro_titulo']) : "";
	$v_dt				= isset($_POST['ck_data']) ? "&bbh_pro_data=".$_POST['bbh_pro_data'] : "";

   $stringAnd			= " 1=1 ";
   $stringAnd			.= isset($_POST['ck_prot']) ? " AND bbh_pro_codigo=".$_POST['bbh_pro_codigo'] : "";
   $stringAnd			.= isset($_POST['ck_data']) ? " AND bbh_pro_momento BETWEEN '".arrumadata($_POST['bbh_pro_data'])." 00:00:00' AND '".arrumadata($_POST['bbh_pro_data'])." 23:59:59'" : "";
   $stringAnd			.= isset($_POST['ck_tit']) ? " AND bbh_pro_titulo LIKE '%".mysqli_fetch_assoc($_POST['bbh_pro_titulo'])."%'" : "";

	//$query_strProtocolo = "SELECT * FROM bbh_protocolos WHERE bbh_pro_email='$bbh_pro_email' and bbh_pro_senha='$bbh_pro_senha' and bbh_pro_codigo= $bbh_pro_codigo";
	$query_strProtocolo = "SELECT * FROM bbh_protocolos WHERE $stringAnd";
    list($strProtocolo, $rows, $totalRows_strProtocolo) = executeQuery($bbhive, $database_bbhive, $query_strProtocolo, $initResult = false);

	if($totalRows_strProtocolo >0){
	 if(!isset($_SESSION)){ session_start(); } 
	   $lista = 0;
	 	//recupera todos os protocolos
		while($row_strProtocolo = mysqli_fetch_assoc($strProtocolo)){
			$lista.= ",".$row_strProtocolo['bbh_pro_codigo'];
		}
	 
		$destino = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|protocolo/index.php?busca=".$lista.$v_prot.$v_ofi.$v_dt."','menuEsquerda|conteudoGeral');";
		echo '<var style="display:none">'.$destino.'</var>';
		exit;
	} else {
		echo "<span style='color:#FF0000'>Protocolo n&atilde;o encontrado!</span>";
		exit;
	}
}
?>