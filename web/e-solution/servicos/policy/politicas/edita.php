<?php require_once("../../../../Connections/policy.php");
require_once("includes/gerencia_xml.php");
require_once("../includes/functions.php");

//recebe dado via GET
$pol_apl_codigo = $_GET['pol_apl_codigo'];
$pol_pol_codigo = $_GET['pol_pol_codigo'];

//le arquivo xml do banco e cria sessão temporária
mysqli_select_db($policy, $database_policy);
$query_politica = "SELECT * FROM pol_politica WHERE pol_pol_codigo = $pol_pol_codigo";
$politica = mysqli_query($policy, $query_politica) or die(mysql_error());
$row_politica = mysqli_fetch_assoc($politica);
$totalRows_politica = mysqli_num_rows($politica);

	//altera sessão
	session_regenerate_id();
	//cria arquivo xml
	$xml 	= new gerenciaXML();
	$nmFile  = session_id();
	$file 	 = fopen($xml->diretorio().$nmFile.".xml", "w");//abre o arquivo
	$escreve = fwrite($file, $row_politica['pol_pol_xml']); //escreve no arquivo com a Hora
	fclose($file);//fecha o arquivo
	
	if(!isset($_GET['exclui'])){
		//redireciona para página do regra.php
		header("Location: regra.php?pol_apl_codigo=$pol_apl_codigo&pol_pol_codigo=$pol_pol_codigo");
	}else{
		header("Location: exclui.php?pol_apl_codigo=$pol_apl_codigo&pol_pol_codigo=$pol_pol_codigo&id_file=$nmFile");
	}
mysqli_free_result($politica);
?>