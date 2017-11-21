<?php
if(!isset($_SESSION)){ session_start(); }
	$_SESSION['bbh_flu_codigo'] 			= ($_POST['bbh_flu_codigo']);
	$_SESSION['bbh_arq_compartilhado'] 		= isset($_POST['bbh_arq_compartilhado']) ? "true" : "false";
	$_SESSION['bbh_arq_publico'] 			= isset($_POST['bbh_arq_publico']) ? "true" : "false";
	$_SESSION['bbh_arq_obs_publico'] 		= nl2br(mysqli_fetch_assoc($_POST['bbh_arq_obs_publico']));
	$_SESSION['bbh_arq_autor'] 				= ($_POST['bbh_arq_autor']);
	$_SESSION['MM_insert'] 					= 'insert';
	
	$nm = time();
	$var = $_SESSION['bbh_flu_codigo'] . '&' . $_SESSION['bbh_arq_compartilhado'] . '&' . $_SESSION['bbh_arq_autor'] . '&insert&' . $_SESSION['caminhoFisico'] . '&' . ($_SESSION['usuCod']) . '&' . $_SESSION['bbh_arq_publico'] . '&' . $_SESSION['bbh_arq_obs_publico'];
	
	$localizacao_documento = explode("web",$_SESSION['caminhoFisico']);
	//--
	$diretorio = $localizacao_documento[0] . "web/datafiles/servicos/bbhive/sessao";
	if(!file_exists($diretorio)) {
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
	$log = fopen($diretorio = $localizacao_documento[0] . "web/datafiles/servicos/bbhive/sessao/$nm.txt",'w');
	$conteudo = fwrite($log,base64_encode($var));
	fclose($log);
	
  	foreach($_POST as $indice => $valor){
		if(($indice=="amp;bbh_flu_codigo_sel")||($indice=="bbh_flu_codigo_sel")){ $bbh_flu_codigo_sel=$valor; }
		if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){ $bbh_ati_codigo=$valor; }
	}
	
	$compl = '';
	if(isset($bbh_flu_codigo_sel)){
		$compl .= "&bbh_flu_codigo_sel=".$bbh_flu_codigo_sel;
	}
	if(isset($bbh_ati_codigo)){
		$compl .= "&bbh_ati_codigo=".$bbh_ati_codigo;
	}
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Upload de Imagens</title>
</head>

<body>
<div style="background-color:#FFF; width:980px; height:575px;" align="center" id="hmGerencia">
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:10px;">
  <tr>
    <td height="23" align="left" bgcolor="#FFFFFF" style="background-image:url(/corporativo/servicos/bbhive/images/painel/dividos.gif); background-repeat:no-repeat; background-position:bottom;" class="verdana_11 color">&nbsp;<strong>Upload de arquivos</strong></td>
  </tr>
  <tr>
    <td height="520" align="left" bgcolor="#FFFFFF"class="verdana_11 color">
<iframe src="/corporativo/servicos/bbhive/arquivos/gerencia.php?bbh_flu_codigo=<?php echo($_POST['bbh_flu_codigo'] . $compl); ?>&mi=true&ts=<?php echo $nm; ?>" name="fotos" id="fotos" width="100%" height="100%" allowtransparency="1" frameborder="0" scrolling="auto"></iframe>
    </td>
  </tr>
</table>
</div>
</body>
</html>