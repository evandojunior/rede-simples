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

$codigo_usuario = $_SESSION['usuCod'];
$file = $row_arquivo['bbh_rel_caminho'] ."/". $row_arquivo['bbh_rel_nmArquivo']; 
$nome_arquivo = $row_arquivo['bbh_rel_nmArquivo'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Central de assinaturas - BBHive</title>
<link rel="stylesheet" type="text/css" href="/corporativo/servicos/bbhive/includes/bbhive.css">
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
        <td height="22" align="left" valign="middle" bgcolor="#FFFBF4" style="font-family:arial;text-align:left;font-weight:bold;padding:5 0;border-bottom:1px solid #FFECC7;">&nbsp;Central de assinaturas</td>
      </tr>
 
      <tr>
        <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="5" style="padding-right:10px;" bgcolor="#FFFFFF">
          <tr>
            <td height="300" align="left" valign="top">
            
<center>
<applet code="br.com.esec.signapplet.DefaultSignApplet" codebase="/assinatura_digital" archive="<?php echo str_replace("form_assinatura.php","",$ondeJar); ?>includes/sdk-web.jar" width="700" height="275" style="margin-top:10px;">
	<param name="cache_version" value="1.5.1.07">
	<param name="cache_archive" value="<?php echo str_replace("form_assinatura.php","",$ondeJar); ?>includes/sdk-web.jar">
	<param name="sdk-base-version" value="1.5.1.07">
	<param name="mode" value="1">
	<param name="userid" value="sdk-web">

	<param name="jspServer" value="<?php echo $hostAssinatura;//connections ?>/submit">
	<param name="searchCertificateURL" value="<?php echo $hostAssinatura;//connections ?>/certificates">
	<param name="autoCommit" value="true">
	<param name="nextURL" value="<?php echo str_replace("form_assinatura.php","",$ondeJar); ?>mensagem.php?id=<?php echo $_GET['id']; ?>">
	<param name="propertiesURL" value="<?php echo str_replace("form_assinatura.php","",$ondeJar); ?>includes/sdk-web_pt_BR.properties">
	<param name="colCount" value="3">
	<param name="addCertificatePath" value="false">
	<param name="encodedFileParam" value="ENCDATA">
	<param name="encodedFileCount" value="QTYDATA">
	<param name="encodedFileId" value="IDDATA">
	<param name="recipientNameParam" value="RECIPIENT_NAME">
	<param name="config.type" value="local">
	<param name="signButton" value="Assinar">
	<param name="signButtonHelp" value="Assinar arquivos selecionados">
	<param name="sendButton" value="Enviar">
	<param name="sendButtonHelp" value="Enviar arquivos assinados">
	<param name="viewButton" value="Visualizar">
	<param name="viewButtonHelp" value="Visualizar arquivos a serem assinados">
	<param name="allowAddFiles" value="false">
	<param name="allowViewFiles" value="true">
	<param name="colName.0" value="Arquivo">
	<param name="colAlias.0" value="#arquivo">
	<param name="colName.1" value="Data Envio">
	<param name="colAlias.1" value="dataEnv">
	<param name="colName.2" value="ID">
	<param name="colAlias.2" value="#idArq">
	<param name="globalField.0" value="sessionID=j0t4qtbaj1">
	<param name="globalField.1" value="UseCase=RecArqRemessaTab">
	<param name="globalField.2" value="command=EnviarProtocoloAssinado">

    <param name="Arquivo.0" value="<?php echo $nome_arquivo; ?>">
    <param name="Data Envio.0" value="<?php echo date("d/m/Y H:i", filemtime(str_replace("fluxo","",$diretorio).$file)); ?>">
    <param name="url.0" value="<?php echo str_replace("form_assinatura.php","",$ondeJar); ?>donwload.php?id=<?php echo $file; ?>&arquivo=<?php echo $nome_arquivo; ?>">
    <param name="ID.0" value="0">
						

	<param name="signFunction" value="true">
	<param name="encryptFunction" value="false">
    <param name="checkLibs" value="true">
</applet>
</center>
            
            </td>
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