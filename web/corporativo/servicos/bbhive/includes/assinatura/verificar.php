<?php 
if(!isset($_SESSION)){ session_start(); }
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

	$ondeJar = "http://".$_SERVER['HTTP_HOST'].str_replace("sem_tela.php","",getCurrentPage());

	$diretorio = explode("web",str_replace("\\","/",dirname(__FILE__)));
	$diretorio = $diretorio[0]."database/servicos/bbhive/fluxo";

$query_arquivo = "SELECT * FROM bbh_relatorio WHERE bbh_rel_codigo = ".$_GET['id'];
list($arquivo, $row_arquivo, $totalRows_arquivo) = executeQuery($bbhive, $database_bbhive, $query_arquivo);

$localizacao_documento =  explode("web",$_SESSION['caminhoFisico']);
$path = $localizacao_documento[0];

$codigo_usuario = $_SESSION['usuCod'];

$file = $row_arquivo['bbh_rel_caminho'] ."/". $row_arquivo['bbh_rel_nmArquivo']; 
$nome_arquivo = $row_arquivo['bbh_rel_nmArquivo'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Central de assinaturas - BBHive</title>
<link rel="stylesheet" type="text/css" href="/corporativo/servicos/bbhive/includes/bbhive.css">
<script type="text/javascript" src="assinatura.js"></script>
</head>
<body>
<div name="url" id="url" style="display:none;position:absolute; margin-top:-500px;"></div>
<div style="position:absolute;display:none;" id="resultTransp"></div>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top">
    <table width="777" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:25px;">
      <tr>
        <td align="center" valign="top"><?php require_once('../cabecalho.php'); ?></td>
      </tr>
      
      <tr>
        <td height="22" align="left" valign="middle" bgcolor="#FFFBF4" style="font-family:arial;text-align:left;font-weight:bold;padding:5 0;border-bottom:1px solid #FFECC7;">&nbsp;Verifica&ccedil;&atilde;o e Decripta&ccedil;&atilde;o</td>
      </tr>
 
      <tr>
        <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="5" style="padding-right:10px;" bgcolor="#FFFFFF">
          <tr>
            <td height="300" align="left" valign="top">
            
<center>
        <br>
<applet code="br/com/esec/signapplet/DefaultVerifyApplet.class" archive="<?php echo str_replace("verificar.php","",$ondeJar); ?>includes/sdk-web.jar" width="600" height="315">
	<param name="cache_version" value="1.5.1.07">
	<param name="cache_archive" value="<?php echo str_replace("verificar.php","",$ondeJar); ?>includes/sdk-web.jar">
	<param name="sdk-base-version" value="1.5.1.07">        
	<param name="mode" value="4">
	<param name="userid" value="sdk-web">
	<param name="propertiesURL" value="<?php echo str_replace("verificar.php","",$ondeJar); ?>includes/sdk-web_pt_BR.properties">
	<param name="certificateField" value="CERTIFICATE">
	<param name="certificateVerifyURL" value="<?php echo $hostAssinatura;//connections ?>/verifycertificate">
	<param name="certificateDateField" value="DATE">
	<param name="certificateDateFormatField" value="DATE_FORMAT">
	<param name="recursiveDecode" value="false">
	<param name="colCount" value="3">
	<param name="config.type" value="local">
	<param name="colName.0" value="Arquivo">
	<param name="colAlias.0" value="#arquivo">
	<param name="colName.1" value="Data Documento">
	<param name="colAlias.1" value="dataEnv">
	<param name="colName.2" value="ID">
	<param name="colAlias.2" value="#idArq">
    <param name="checkLibs" value="true">

	
	        <param name="Arquivo.0" value="<?php echo $nome_arquivo.".p7s"; ?>">
	        <param name="Data Documento.0" value="<?php echo date("d/m/Y H:i", filemtime(str_replace("fluxo","",$diretorio).$file.".p7s")); ?>">
	        <param name="url.0" value="<?php echo str_replace("verificar.php","",$ondeJar); ?>donwload.php?id=<?php echo $file.".p7s"; ?>&arquivo=<?php echo $nome_arquivo.".p7s"; ?>">
	        <param name="ID.0" value="0">
	
</applet><input type="button"  onClick="showSignatures()" value="Assinaturas" class="botao" style="display:none">
<form name="form1" id="form1" method="post" style="display:none">
<input type="checkbox" name="fileIndex" id="fileIndex" onClick="markDocument(0, checked)" checked value="0">

</form>
</center>
            <br />
              <a href="#" onclick="javascript: location.href='<?php echo str_replace("verificar.php","",$ondeJar); ?>donwload.php?id=<?php echo $file.".p7s"; ?>&arquivo=<?php echo $nome_arquivo.".p7s"; ?>'" class="verdana_11" style="cursor:pointer"><label class="color">Clique
            para fazer download deste documento</label></a></td>
            </tr>
          
          </table>
          
          </td>
      </tr>
      
      <tr>
        <td bgcolor="#FFFFFF"><?php require_once('../rodape.php'); ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>