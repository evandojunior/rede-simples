<?php
//----------------------------------------------------------------------------------------------------------------------
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
//----------------------------------------------------------------------------------------------------------------------
	//recupera ID----------------------------------------
	settype($_POST['bbh_rel_codigo'], "integer");
	$bbh_rel_codigo = $_POST['bbh_rel_codigo'];
	//---------------------------------------------------
	
	$localizacao_documento 	= explode("web",$_SESSION['caminhoFisico']);
	$diretorioDestino 		= $localizacao_documento[0] . "database/servicos/bbhive/fluxo/fluxo_".$_POST['bbh_flu_codigo']."/documentos/".$bbh_rel_codigo."/";
	
	require_once("editor/copia_pdf.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gerando arquivo</title>
<meta http-equiv="Refresh" content="0;URL=/datafiles/servicos/bbhive/temp_transf/<?php echo $_SESSION['usuCod']; ?>/relatorio_final.pdf" />
</head>

<body>
Aguarde...
</body>
</html>
