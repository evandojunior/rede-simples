<?php if(!isset($_SESSION)){ session_start(); }
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){	$bbh_ati_codigo= $valor; } 
	if(($indice=="amp;bbh_rel_codigo")||($indice=="bbh_rel_codigo")){ 	$bbh_rel_codigo= $valor; } 
	if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ 	$bbh_flu_codigo= $valor; } 
}
	//--
	$query_protocolo = "select bbh_pro_codigo from bbh_protocolos where bbh_flu_codigo = $bbh_flu_codigo";
    list($protocolo, $row_protocolo, $totalRows_protocolo) = executeQuery($bbhive, $database_bbhive, $query_protocolo);

	$codProtocolo = $row_protocolo['bbh_pro_codigo'];
	//--
	$semAnexo = true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Repositório <?php echo $_SESSION['componentesNome'];?></title>
<link href="../../../includes/relatorio.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
	require_once('../../../fluxo/indicios/complProtocolo.php');
?>
</body>
</html>