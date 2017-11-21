<?php
$raiz = preg_split('@(WEB|web)@', __FILE__, -1, PREG_SPLIT_DELIM_CAPTURE);
$raiz = (string) rtrim( $raiz[0], '\\/').'/'.$raiz[1];
$raiz = strtr( $raiz, '\\','/');
//--
$connections_blackbee = array("bbpass.php", "bbhive.php", "bi.php", "cbr.php", "cidadao.php", "guia_baixada.php", "peoplerank.php", "policy.php");
//--
if(isset($_POST['grava_ini'])){
    $socket					= addslashes($_POST['socket']);
	$bbpass					= addslashes($_POST['bbpass']);
	$policy					= addslashes($_POST['policy']);
	$biometria				= addslashes($_POST['biometria']);
	$assinatura_digital		= addslashes($_POST['assinatura_digital']);
	$cm_assinatura_digital	= addslashes($_POST['cm_assinatura_digital']);
	$sms					= addslashes($_POST['sms']);
		
	# Instancia do objeto XMLWriter
	$xml = new XMLWriter;
	
	# Cria memoria para armazenar a saida
	$xml->openMemory();
	
	# Inicia o cabeçalho do documento XML
	$xml->startDocument( '1.0' , 'iso-8859-1' );
	
	# Adiciona/Inicia um Elemento / Nó Pai <item>
	$xml->startElement("config");
	
	
	# Adiciona/Inicia um Elemento / Nó Filho <item>
	$xml->startElement("setup");
	
		$xml->writeElement("socket", $socket);
		$xml->writeElement("bbpass", $bbpass);
		$xml->writeElement("policy", $policy);
		$xml->writeElement("biometria", $biometria);
		$xml->writeElement("assinatura_digital", $assinatura_digital);
		$xml->writeElement("cm_assinatura_digital", $cm_assinatura_digital);
		$xml->writeElement("sms", $sms);
	
	# Fecha o nó Filho
	$xml->endElement();

	//--Variáveis dos connections
	foreach($connections_blackbee as $i=>$v){
		$apl = str_replace(".php","",$v);
		//--
		$hostname		= addslashes(utf8_encode($_POST['hostname_'.$apl]));
		$database		= addslashes(utf8_encode($_POST['database_'.$apl]));
		$username 		= addslashes(utf8_encode($_POST['username_'.$apl]));
		$pwd			= addslashes(utf8_encode($_POST['pwd_'.$apl]));
		$id_policy		= addslashes(utf8_encode($_POST['id_policy_'.$apl]));
		//--
		$id_lock_padrao	= "";
		$id_bbpass_adm	= "";
		$id_bbpass_corp	= "";
		$id_bbpass_publ	= "";
		//--
		if($apl=='bbpass'){
			$id_lock_padrao	= addslashes(utf8_encode($_POST['id_lock_padrao_'.$apl]));
		}
		if($apl!='bbpass'){
			$id_bbpass_adm	= addslashes(utf8_encode($_POST['id_bbpass_adm_'.$apl]));
			$id_bbpass_corp	= addslashes(utf8_encode($_POST['id_bbpass_corp_'.$apl]));
			$id_bbpass_publ	= addslashes(utf8_encode($_POST['id_bbpass_publ_'.$apl]));
		}
		//--GRAVA XML
		# Adiciona/Inicia um Elemento / Nó Filho <item>
		$xml->startElement($apl);
		
			$xml->writeElement("hostname", utf8_encode($hostname));
			$xml->writeElement("database", utf8_encode($database));
			$xml->writeElement("username", utf8_encode($username));
			$xml->writeElement("pwd", utf8_encode($pwd));
			$xml->writeElement("id_lock_padrao", utf8_encode($id_lock_padrao));
			$xml->writeElement("id_policy", utf8_encode($id_policy));
			$xml->writeElement("id_bbpass_adm", utf8_encode($id_bbpass_adm));
			$xml->writeElement("id_bbpass_corp", utf8_encode($id_bbpass_corp));
			$xml->writeElement("id_bbpass_publ", utf8_encode($id_bbpass_publ));
		
		# Fecha o nó Filho
		$xml->endElement();

		//--REDIRECIONA PARA PÁGINA PRINCIPAL DO SISTEMA /index.php
	}
		
	# Fecha o nó pai
	$xml->endElement();
	
	# Salvando o arquivo em disco
	# retorna erro se outputMemory já foi chamado
	$file = fopen($raiz."/../database/servicos/bbpass/ini.xml",'w+');
	fwrite($file,$xml->outputMemory(true));
	fclose($file);
	
	echo '<meta http-equiv="refresh" content="0" />';
	exit;
}


$socket					= "";
$bbpass					= "";
$policy					= "";
$biometria				= "";
$assinatura_digital		= "";
$cm_assinatura_digital	= "";
$sms					= "";

	if( file_exists($raiz."/../database/servicos/bbpass/ini.xml") ){
		$xml_configuracao = simplexml_load_file($raiz."/../database/servicos/bbpass/ini.xml");
		//--
		$socket					= ((string)$xml_configuracao->setup->socket);
		$bbpass					= ((string)$xml_configuracao->setup->bbpass);
		$policy					= ((string)$xml_configuracao->setup->policy);
		$biometria				= ((string)$xml_configuracao->setup->biometria);
		$assinatura_digital		= ((string)$xml_configuracao->setup->assinatura_digital);
		$cm_assinatura_digital	= ((string)$xml_configuracao->setup->cm_assinatura_digital);
		$sms					= ((string)$xml_configuracao->setup->sms);
		//--
		$xml_ini				= true;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pacote Blackbee</title>
<style type="text/css">
.verdana_16{
	font-family:Verdana, Geneva, sans-serif;
	font-size:16px;
	color:#FFF	
}
.verdana_12{
	font-family:Verdana, Geneva, sans-serif;
	font-size:12px;
}
.titulo{
	background:#50617F;	
}
</style>
</head>

<body>
<form name="frm" id="frm" action="" method="post">
<table width="990" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#F0F0F0">
  <tr>
    <td height="35" colspan="2" align="center" class="verdana_16 titulo"><strong>CONFIGURA&Ccedil;&Otilde;ES PACOTE BLACKBEE</strong></td>
  </tr>
  <tr>
    <td width="264" height="25" align="right" bgcolor="#FFFFFF" class="verdana_12">Verifica&ccedil;&atilde;o socket :&nbsp;</td>
    <td width="724" height="25" bgcolor="#FFFFFF"><label for="socket"></label>
      <input name="socket" type="text" id="socket" value="<?php echo $socket; ?>" size="60" maxlength="255" /></td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF" class="verdana_12">Endere&ccedil;o BBPASS :&nbsp;</td>
    <td height="25" bgcolor="#FFFFFF"><input name="bbpass" value="<?php echo $bbpass; ?>" type="text" id="bbpass" size="60" maxlength="255" /></td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF" class="verdana_12">Endere&ccedil;o POLICY :&nbsp;</td>
    <td height="25" bgcolor="#FFFFFF"><input name="policy" value="<?php echo $policy; ?>" type="text" id="policy" size="60" maxlength="255" /></td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF" class="verdana_12">Acesso biometria :&nbsp;</td>
    <td height="25" bgcolor="#FFFFFF"><input name="biometria" value="<?php echo $biometria; ?>" type="text" id="biometria" size="60" maxlength="255" /></td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF" class="verdana_12">Acesso assinatura digital :&nbsp;</td>
    <td height="25" bgcolor="#FFFFFF"><input name="assinatura_digital" value="<?php echo $assinatura_digital; ?>" type="text" id="assinatura_digital" size="60" maxlength="255" /></td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF" class="verdana_12">Caminho assinatura digital :&nbsp;</td>
    <td height="25" bgcolor="#FFFFFF"><input name="cm_assinatura_digital" value="<?php echo $cm_assinatura_digital; ?>" type="text" id="cm_assinatura_digital" size="60" maxlength="255" /></td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF" class="verdana_12"> Acesso SMS :&nbsp;</td>
    <td height="25" bgcolor="#FFFFFF"><input name="sms" value="<?php echo $sms; ?>" type="text" id="sms" size="60" maxlength="255" /></td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF" class="verdana_12">&nbsp;</td>
    <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
<br />

<?php foreach($connections_blackbee as $i=>$v){
	$apl = str_replace(".php","",$v);
	//--
	$hostname = isset($xml_ini)? ((string)$xml_configuracao->$apl->hostname):"";
	$database = isset($xml_ini)? utf8_encode((string)$xml_configuracao->$apl->database):"";
	$username = isset($xml_ini)? utf8_encode((string)$xml_configuracao->$apl->username):"";
	$password = isset($xml_ini)? ((string)$xml_configuracao->$apl->pwd):"";
	$policy   = isset($xml_ini)? utf8_encode((string)$xml_configuracao->$apl->id_policy):"";
	//--
	$lockPadrao	= isset($xml_ini)? utf8_encode((string)$xml_configuracao->$apl->id_lock_padrao):"";
	$idAdm		= isset($xml_ini)? utf8_encode((string)$xml_configuracao->$apl->bbpass_adm):"";
	$idCorp		= isset($xml_ini)? utf8_encode((string)$xml_configuracao->$apl->bbpass_corp):"";
	$idPubl		= isset($xml_ini)? utf8_encode((string)$xml_configuracao->$apl->bbpass_publ):"";
	//--
	?>
<table width="990" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#F0F0F0">
  <tr>
    <td height="35" colspan="2" align="left" class="verdana_16 titulo" style="background:#9FBBDB; color:#333">&nbsp;<strong><?php echo strtoupper($apl);?> </strong></td>
  </tr>
  <tr>
    <td width="262" height="25" align="right" bgcolor="#FFFFFF" class="verdana_12">hostname :&nbsp;</td>
    <td width="725" height="25" bgcolor="#FFFFFF"><input name="hostname_<?php echo $apl; ?>" type="text" id="hostname_<?php echo $apl; ?>" value="<?php echo $hostname; ?>" size="40" maxlength="255" /></td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF" class="verdana_12">database :&nbsp;</td>
    <td height="25" bgcolor="#FFFFFF"><input name="database_<?php echo $apl; ?>" type="text" id="database_<?php echo $apl; ?>" value="<?php echo $database; ?>" size="30" maxlength="255" /></td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF" class="verdana_12">username :&nbsp;</td>
    <td height="25" bgcolor="#FFFFFF"><input name="username_<?php echo $apl; ?>" type="text" id="username_<?php echo $apl; ?>" value="<?php echo $username; ?>" size="30" maxlength="255" /></td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF" class="verdana_12">password&nbsp;:&nbsp;</td>
    <td height="25" bgcolor="#FFFFFF"><input name="pwd_<?php echo $apl; ?>" type="password" id="pwd_<?php echo $apl; ?>" value="<?php echo $password; ?>" size="30" maxlength="255" /></td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF" class="verdana_12">ID no policy :&nbsp;</td>
    <td height="25" bgcolor="#FFFFFF"><input name="id_policy_<?php echo $apl; ?>" type="text" id="id_policy_<?php echo $apl; ?>" value="<?php echo $policy; ?>" size="8" maxlength="255" /></td>
  </tr>
  <?php if($apl=="bbpass"){ ?>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF" class="verdana_12">ID Lock Padrão - Público :&nbsp;</td>
    <td height="25" bgcolor="#FFFFFF"><input name="id_lock_padrao_<?php echo $apl; ?>" type="text" id="id_lock_padrao_<?php echo $apl; ?>" value="<?php echo $lockPadrao; ?>" size="8" maxlength="255" /></td>
  </tr>
  <?php } ?>
  <?php if($apl!="bbpass"){ ?>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF" class="verdana_12">ID no BBPASS - Administrativo :&nbsp;</td>
    <td height="25" bgcolor="#FFFFFF"><input name="id_bbpass_adm_<?php echo $apl; ?>" type="text" id="id_bbpass_adm_<?php echo $apl; ?>" value="<?php echo $idAdm; ?>" size="8" maxlength="255" /></td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF" class="verdana_12">ID no BBPASS - Corporativo :&nbsp;</td>
    <td height="25" bgcolor="#FFFFFF"><input name="id_bbpass_corp_<?php echo $apl; ?>" type="text" id="id_bbpass_corp_<?php echo $apl; ?>" value="<?php echo $idCorp; ?>" size="8" maxlength="255" /></td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF" class="verdana_12">ID no BBPASS - P&uacute;blico :&nbsp;</td>
    <td height="25" bgcolor="#FFFFFF"><input name="id_bbpass_publ_<?php echo $apl; ?>" type="text" id="id_bbpass_publ_<?php echo $apl; ?>" value="<?php echo $idPubl; ?>" size="8" maxlength="255" /></td>
  </tr>
  <?php } ?>
</table>
<br />
<?php } ?>
<table width="990" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#F0F0F0">
  <tr>
    <td height="35" colspan="2" align="center" class="verdana_16 titulo">
    	<input name="salvar" type="button" value="Salvar informações" onclick="if(confirm('Tem certeza que deseja gravar estas informações? Após a confirmação não será possível alterar nenhuma informação. Clique em OK e caso de confirmação')){document.frm.submit();}" />
    </td>
  </tr>
</table><input name="grava_ini" type="hidden" value="1" />
</form>
</body>
</html>