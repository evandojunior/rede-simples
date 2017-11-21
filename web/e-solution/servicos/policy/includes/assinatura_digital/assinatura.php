<?php
	$ondeJar = "http://".$_SERVER['HTTP_HOST'].str_replace("sem_tela.php","",$_SERVER['PHP_SELF']);
	$ondeJar = explode("detalhes",$ondeJar);
	$ondeJar = $ondeJar[0]."includes/assinatura_digital";
?><applet code="br/com/esec/signapplet/DefaultSignApplet.class" archive="<?php echo $ondeJar; ?>/includes/sdk-web.jar" width="1" height="1" name="assinaDigital">
	<param name="cache_version" value="1.5.1.07">
	<param name="cache_archive" value="<?php echo $ondeJar; ?>/includes/sdk-web.jar">

	<param name="sdk-base-version" value="1.5.1.07">
	<param name="viewGui" value="false">
	<param name="mode" value="1">
	<param name="userid" value="sdk-web">
	<param name="jspServer" value="<?php echo $hostAssinatura;//connections ?>/submit">
	<param name="searchCertificateURL" value="<?php echo $hostAssinatura;//connections ?>/certificates">
	<param name="autoCommit" value="true">
	<param name="nextURL" value="<?php echo $ondeJar; ?>/redireciona.php?<?php echo $_SERVER['QUERY_STRING']; ?>">
	<param name="propertiesURL" value="<?php echo $ondeJar; ?>/includes/sdk-web_pt_BR.properties">

	<param name="colCount" value="3">
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


	        <param name="Arquivo.0" value="<?php echo "relatorio".$row_detalhes['pol_aud_codigo'].".pdf"; ?>">
	        <param name="Data Envio.0" value="<?php echo date('d/m/Y'); ?>">
	        <param name="url.0" value="<?php echo $ondeJar; ?>/download.php?impressaodet=<?php echo $row_detalhes['pol_aud_codigo']; ?>">
	        <param name="ID.0" value="0">
	

	<param name="signFunction" value="true">
	<param name="encryptFunction" value="false">
    <param name="checkLibs" value="true">
</applet>