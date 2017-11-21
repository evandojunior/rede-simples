<?php
if (!isset($_SESSION)) { session_start(); }
require_once("includes/autentica.php");
require_once("includes/functions.php");
require_once("includes/config.php");

unset($_SESSION['MM_BBhive_Publico']);
//--VERIFICA SE O USUÁRIO ESTÁ LOGADO OU VEIO COM AUTENTICAÇÃO DE OUTRA APLICAÇÃO
	if(isset($_SESSION['MM_Email_Padrao'])){
		//--verifica se tem acesso a este ambiente
		  $LoginRS__query=sprintf("SELECT COALESCE(MAX(p.bbh_per_pub),0) as pub,
			u.bbh_usu_codigo, u.bbh_usu_identificacao, u.bbh_usu_nivel, u.bbh_usu_apelido 
			FROM bbh_usuario as u
			 LEFT JOIN bbh_usuario_perfil as up on u.bbh_usu_codigo = up.bbh_usu_codigo
			 LEFT JOIN bbh_perfil as p on up.bbh_per_codigo = p.bbh_per_codigo
			  WHERE bbh_usu_identificacao=%s AND bbh_usu_ativo='1' and bbh_usu_nivel=584
				 GROUP BY u.bbh_usu_codigo
				  HAVING pub = 0", GetSQLValueString($bbhive, $_SESSION['MM_Email_Padrao'], "text"));

            list($LoginRS, $row_LoginRS, $loginFoundUser) = executeQuery($bbhive, $database_bbhive, $LoginRS__query);

		  //--Se tiver acesso continua senão veta
		  if ($loginFoundUser) {
			  $_SESSION['MM_BBhive_Publico'] 	= $row_LoginRS['bbh_usu_codigo'];
			    $_SESSION['MM_UserGroup']		= 584;
				$_SESSION['MM_Email_Padrao']	= $_SESSION['MM_Email_Padrao'];
				$_SESSION['MM_BBhive_name']  	= $_SESSION['MM_Email_Padrao'];
				$_SESSION['MM_BBhive_Codigo'] 	= $row_LoginRS['bbh_usu_codigo'];
				$_SESSION['MM_BBhive_Publico'] 	= $row_LoginRS['bbh_usu_codigo'];	
				$_SESSION['MM_BBhive_Email'] 	= $row_LoginRS['bbh_usu_identificacao'];	

				$_SESSION['pub_acesso'] 		= 1;
				$_SESSION['pub_usuNome']		= $_SESSION['MM_Email_Padrao'];
				$_SESSION['pub_usuApelido']		= $row_LoginRS['bbh_usu_apelido'];
				$_SESSION['pub_usuCod']			= 0;
				$_SESSION['pub_ultimoAcesso']	= 0;
				$_SESSION['pub_sexoUsuario']	= 1;
				$_SESSION['MM_Username'] 		= $_SESSION['MM_BBhive_Email'];
				$_SESSION['MM_UserGroup'] 		= $_SESSION['MM_UserGroup'];
				$_SESSION['MM_User_email'] 		= $_SESSION['pub_usuNome'];
		  }
	}

//--
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BBHive</title>
<script type="text/javascript" src="/servicos/bbhive/includes/bbhive.js"></script>
<script type="text/javascript" src="/servicos/bbhive/includes/functions.js"></script>
<script type="text/javascript" src="/servicos/bbhive/includes/campo_backsite/functions.js"></script>
<link rel="stylesheet" type="text/css" href="/servicos/bbhive/includes/bbhive.css">

<!-- Prototiper -->
<script type="text/javascript" src="/servicos/bbhive/includes/prototype.js"></script>
<script type="text/javascript" src="/servicos/bbhive/includes/prototip.js"></script>
<script type="text/javascript" src="/servicos/bbhive/includes/styles.js"></script>
<link rel="stylesheet" type="text/css" href="/servicos/bbhive/includes/prototip.css" />


<link type="text/css" rel="stylesheet" href="/corporativo/servicos/bbhive/includes/formulario_data/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/formulario_data/dhtmlgoodies_calendar.js"></script>
<style type="text/css">
.btAceso{
	border:#D0D5DA solid 1px;;
	background:#E0FFDD;
}
.btApagado{
	border:#D0D5DA solid 1px;
	background:#F7F7F7;
}
</style>
<script type="text/javascript">
function pesquisaProtocolo(){
	//no mínimo um selecionado
	var ck_prot	= document.getElementById('ck_prot');
	var ck_data	= document.getElementById('ck_data');
	var ck_tit	= document.getElementById('ck_tit');
	
	var vr_prot	= document.getElementById('bbh_pro_codigo');
	var vr_data	= document.getElementById('bbh_pro_data');
	var vr_tit	= document.getElementById('bbh_pro_titulo');
	
		if((ck_prot.checked==false) && (ck_data.checked==false) &&(ck_tit.checked==false)){
			 alert('Escolha uma opção de busca!');	
			 return false;
		} else {
			//validações por pares
			if((ck_prot.checked==true) && (vr_prot.value=='')){
				 alert('Informe o <?php echo $_SESSION['protNome']; ?>.');	
				 return false;
			} else if((ck_data.checked==true) && (vr_data.value=='')){
				 alert('Informe a data.');	
				 return false;
			} else if((ck_tit.checked==true) && (vr_tit.value=='')){
				 alert('Informe o ofício.');	
				 return false;
			} else {
					validaForm('consultaProtocolo','searchProtocolo|...',document.getElementById('acaoBusca').value);
			}
		}
}
function exibeEtiqueta(valor){
	document.getElementById('enviaFormEtiqueta').style.display= valor;
}
</script>
<!-- fim -->
</head>
<?php 
//Isso para buscar a pagina certa quando o usuário aperta o botao voltar do navegador
if(isset($_GET['upload'])){
 //$onload = "onload=\"return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1|protocolo/regra.php','menuEsquerda|colCentro');\"";
 $onload = "onload=\"return showHome('includes/home.php','conteudoGeral', 'protocolos/regra.php','colCentro');\"";
}else{
if(isset($_SESSION['urlEnviaAnteriorPub'])){
	if(isset($_SESSION['F5_OK'])){
		$onload="onload='return showHome(\"".$_SESSION['urlEnviaAnteriorPub']."\",\"".$_SESSION['exPaginaAnteriorPub']."\", \"".$_SESSION['urlEnviaPub']."\", \"".$_SESSION['exPaginaPub']."\");'";
		
	} else {
		//$onload="onload='return showHome(\"".$_SESSION['urlEnviaAnterior']."\",\"".$_SESSION['exPaginaAnterior']."\", \"perfil/index.php|".$_SESSION['urlEnvia']."\", \"menuEsquerda|".$_SESSION['exPagina']."\");'";
		$onload="onload='return showHome(\"".$_SESSION['urlEnviaAnteriorPub']."\",\"".$_SESSION['exPaginaAnteriorPub']."\", \"".$_SESSION['urlEnviaPub']."\", \"".$_SESSION['exPaginaPub']."\");'";
		$_SESSION['F5_OK'] = "1";
	}
	
}else{
	//preciso verifica se vou criar protocolo a partir do fluxo corporativo
	if(isset($_SESSION['pacoteNovoProtocolo'])){
		$onload="onload='return showHome(\"includes/completo.php\",\"conteudoGeral\", \"protocolos/cadastro/passo1.php\",\"colPrincipal\");'";	
		//$onload="onload='return showHome(\"includes/completo.php\",\"conteudoGeral\", \"perfil/index.php?perfil=1|protocolo/cadastro/passo1.php\",\"menuEsquerda|colPrincipal\");'";
	//--	
	} else {
		$onload="onload='return LoadSimultaneo(\"protocolos/regra.php\",\"conteudoGeral\");'";
		//$onload="onload='return LoadSimultaneo(\"perfil/index.php?perfil=1|protocolo/regra.php\",\"menuEsquerda|conteudoGeral\");'";
	}
}
}

$_SESSION['virtual_onload']=$onload;
?>
<body  <?php if(isset($_SESSION['MM_BBhive_Publico']) && $_SESSION['MM_BBhive_Publico']>0){  echo $onload; } ?>>
<div name="url" id="url" style="display:none;position:absolute; margin-top:-500px;"></div>
<div style="position:absolute;display:none;" id="resultTransp"></div>
<table width="992" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:#CCC solid 1px; margin-top:10px;">
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
        	<option value="/e-solution/servicos/bbhive/index.php">Acesso Administrativo</option>
			<option value="/corporativo/servicos/bbhive/index.php">Acesso Corporativo</option>
        	<option value="/servicos/bbhive/index.php" selected="selected">Acesso P&uacute;blico</option>
        </select>
        <?php } ?>
    </div>
    <div style="float:right; margin-top:5px;">
    <?php if(isset($_SESSION['MM_BBhive_Publico']) && $_SESSION['MM_BBhive_Publico']>0){ ?>
    	Ol&aacute; <strong><span id="nomeLogado"><?php echo $_SESSION['pub_usuApelido']; ?></span></strong>, seja bem vindo ao BBHive&nbsp;&nbsp;
    <?php } ?>
    </div>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="5" style="padding-right:10px;" bgcolor="#FFFFFF">
      <tr>
        <td width="142" height="142" align="left" valign="middle" id="menuEsquerda">
		<?php if(isset($_SESSION['MM_BBhive_Publico']) && $_SESSION['MM_BBhive_Publico']>0){ ?>
			<?php require_once("perfil/index.php"); ?>
        <?php } ?>
        </td>
        <td width="831" align="left" valign="middle" id="areaLivre">
		<?php if(isset($_SESSION['MM_BBhive_Publico']) && $_SESSION['MM_BBhive_Publico']>0){ ?>
			<?php require_once("perfil/form_busca.php"); ?>
        <?php } ?>
        </td>
      </tr>
      <tr>
        <td height="370" colspan="2" align="left" valign="top" id="conteudoGeral" class="verdana_12">
<span class="aviso">
     <?php if(!isset($_SESSION['MM_BBhive_Publico'])){ 
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Tentou acessar o sistema na qual não tem perfil criado no ambiente público ou credenciais não permitem acesso - BBHive.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
	 ?>
     	<div class="aviso" align="center">Voc&ecirc; n&atilde;o tem perfil criado para o ambiente público ou suas credenciais não permite o acesso, entre em contato com o Administrador!</div>
     <?php } ?>
</span>
        </td>
        </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body></html>