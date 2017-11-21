<?php  if (!isset($_SESSION)) { session_start(); }

require_once("includes/autentica.php");	
require_once("includes/config.php");

unset($_SESSION['MM_BBhive_Administrativo']);
//--VERIFICA SE POSSO ACESSAR ESTE AMBIENTE
if(isset($_SESSION['MM_Email_Padrao'])){
  $LoginRS__query=sprintf("SELECT bbh_adm_codigo, bbh_adm_identificacao, bbh_adm_nivel, bbh_adm_nome, bbh_adm_ultimoAcesso, bbh_adm_sexo FROM bbh_administrativo WHERE bbh_adm_identificacao=%s and bbh_adm_nivel=484 and bbh_adm_ativo='1'", GetSQLValueString($bbhive, $_SESSION['MM_Email_Padrao'], "text"));
  list($LoginRS, $row_LoginRS, $loginFoundUser) = executeQuery($bbhive, $database_bbhive, $LoginRS__query);
  
  if ($loginFoundUser) {
		  $_SESSION['MM_BBhive_Administrativo'] = $row_LoginRS['bbh_adm_codigo'];
		  $_SESSION['MM_UserGroup']=484;
		  //--
		$_SESSION['MM_Email_Padrao']	= $_SESSION['MM_Email_Padrao'];
		$_SESSION['MM_BBhive_name']  	= $_SESSION['MM_Email_Padrao'];
	
		$_SESSION['MM_BBhive_Codigo'] 			= $row_LoginRS['bbh_adm_codigo'];
		$_SESSION['MM_BBhive_Aministrativo'] 	= $row_LoginRS['bbh_adm_codigo'];	
		$_SESSION['MM_BBhive_Email'] 			= $row_LoginRS['bbh_adm_identificacao'];	
		
		$_SESSION['es_acesso'] 			= 1;
		$_SESSION['es_usuNome']			= $row_LoginRS['bbh_adm_nome'];
		$_SESSION['es_usuCod']			= $row_LoginRS['bbh_adm_codigo'];
		$_SESSION['es_ultimoAcesso']	= $row_LoginRS['bbh_adm_ultimoAcesso'];
		$_SESSION['es_sexoUsuario']		= $row_LoginRS['bbh_adm_sexo'];
		$_SESSION['MM_Username'] 		= "1";
		$_SESSION['MM_UserGroup'] 		= "1";
		$_SESSION['MM_User_email'] 		= "ok";
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BBHive</title>
<script type="text/javascript" src="/e-solution/servicos/bbhive/includes/bbhive.js"></script>
<script type="text/javascript" src="/e-solution/servicos/bbhive/includes/functions.js"></script>
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/bbhive/includes/bbhive.css">

<!-- Inclusões para o drag and drop-->
<script src="/e-solution/servicos/bbhive/includes/spryassets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="/e-solution/servicos/bbhive/includes/spryassets/SpryTabbedPanels.css" rel="stylesheet" type="text/css">

<script language="javascript" src="/e-solution/servicos/bbhive/includes/drag_and_drop/dom-drag.js"></script>
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/bbhive/includes/drag_and_drop/drag.css">

<link type="text/css" rel="stylesheet" href="/e-solution/servicos/bbhive/includes/formulario_data/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
    <script type="text/javascript" src="/e-solution/servicos/bbhive/includes/formulario_data/dhtmlgoodies_calendar.js">
    </script>

<!-- fim -->
</head>
<?php 
//Isso para buscar a pagina certa quando o usuário aperta o botao voltar do navegador
if(isset($_GET['upload']))
{

	 $url = "e-solution/servicos/bbhive/arquivos/index.php";
 $onload = "onload=\"return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1|principal.php','menuEsquerda|colCentro');\"";
}else{
if(isset($_SESSION['urlEnviaAnteriorAdm'])){
	if(isset($_SESSION['F5_OK'])){
		$onload="onload='return showHome(\"".$_SESSION['urlEnviaAnteriorAdm']."\",\"".$_SESSION['exPaginaAnteriorAdm']."\", \"".$_SESSION['urlEnviaAdm']."\", \"".$_SESSION['exPaginaAdm']."\");'";
		
	} else {
		$onload="onload='return showHome(\"".$_SESSION['urlEnviaAnteriorAdm']."\",\"".$_SESSION['exPaginaAnteriorAdm']."\", \"perfil/index.php|".$_SESSION['urlEnviaAdm']."\", \"menuEsquerda|".$_SESSION['exPaginaAdm']."\");'";
		$_SESSION['F5_OK'] = "1";
	}
	
}else{
	$onload="onload='return LoadSimultaneo(\"perfil/index.php?perfil=1|principal.php\",\"menuEsquerda|conteudoGeral\");'";
}
}

$_SESSION['virtual_onload']=$onload;
?>
<body <?php if(isset($_SESSION['MM_BBhive_Administrativo']) && $_SESSION['MM_BBhive_Administrativo']>0){  echo $onload; } ?>>
<div name="url" id="url" style="display:none;position:absolute; margin-top:-500px;"></div>
<div style="position:absolute;display:none;" id="resultTransp"></div>
<table width="992" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:25px;">
  <tr>
    <td align="center" valign="top"><?php require_once('includes/cabecalho.php'); ?></td>
  </tr>
  <tr>
    <td height="20" bgcolor="#FFFFFF"><?php require_once('includes/menu_horizontal.php'); ?></td>
  </tr>
  <tr>
    <td height="22" align="right" valign="top" bgcolor="#FFFFFF" class="verdana_9">
    <div style="float:right">
    <?php if($_SERVER['HTTP_HOST']=='projeto12.backsite.com.br'){?>
    	<select name="ambiente" id="ambiente" onchange="location.href=this.value;" class="arial_11">
        	<option value="/e-solution/servicos/bbhive/index.php" selected="selected">Acesso Administrativo</option>
			<option value="/corporativo/servicos/bbhive/index.php">Acesso Corporativo</option>
        	<option value="/servicos/bbhive/index.php">Acesso P&uacute;blico</option>
        </select>
        <?php } ?>
    </div>
    <div style="float:right; margin-top:5px;">
    <?php if(isset($_SESSION['MM_BBhive_Administrativo']) && $_SESSION['MM_BBhive_Administrativo']>0){ ?>
    	Ol&aacute; <strong><span id="nomeLogado"><?php echo $_SESSION['MM_Email_Padrao']; ?></span></strong>, seja bem vindo ao BBHive&nbsp;&nbsp;
    <?php } ?> 
    </div>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="5" style="padding-right:10px;" bgcolor="#FFFFFF">
      <tr>
        <td width="16%" height="450" align="left" valign="top" <?php if(isset($_SESSION['MM_BBhive_Administrativo']) && $_SESSION['MM_BBhive_Administrativo']>0){ ?> style="border-right:dashed 1px #999999;" <?php } ?> id="menuEsquerda">&nbsp;</td>
        <td width="84%" align="left" valign="top" id="conteudoGeral">
<span class="aviso">
     <?php if(!isset($_SESSION['MM_BBhive_Administrativo'])){ 
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Tentou acessar o sistema na qual não tem perfil criado no ambiente administrativo - BBHive.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
	 ?>
     	<div class="aviso" align="center">Voc&ecirc; n&atilde;o tem perfil criado para o ambiente <br>administrativo ou suas credenciais não permite o acesso, entre em contato com o Administrador!</div>
     <?php } ?>
</span>
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><?php require_once('includes/rodape.php'); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body></html>