<?php
    require_once("includes/autentica.php"); 
	require_once("includes/functions.php");
	require_once("includes/config.php");

unset($_SESSION['MM_BBhive_Corporativo']);
//--VERIFICA SE O USUÁRIO ESTÁ LOGADO OU VEIO COM AUTENTICAÇÃO DE OUTRA APLICAÇÃO
	if(isset($_SESSION['MM_Email_Padrao'])){
		//--verifica se tem acesso a este ambiente
		  $LoginRS__query=sprintf("SELECT COALESCE(MAX(p.bbh_per_corp),0) as corp,
			u.bbh_usu_codigo, u.bbh_usu_identificacao, u.bbh_usu_nivel, u.bbh_usu_apelido, u.bbh_usu_nome, u.bbh_usu_sexo, u.bbh_usu_ultimoAcesso, u.bbh_dep_codigo
			FROM bbh_usuario as u
			 LEFT JOIN bbh_usuario_perfil as up on u.bbh_usu_codigo = up.bbh_usu_codigo
			 LEFT JOIN bbh_perfil as p on up.bbh_per_codigo = p.bbh_per_codigo
			  WHERE bbh_usu_identificacao=%s AND bbh_usu_ativo='1' and bbh_usu_nivel=584
				 GROUP BY u.bbh_usu_codigo
				  HAVING corp = 0", GetSQLValueString($bbhive, $_SESSION['MM_Email_Padrao'], "text"));

            list($LoginRS, $row_LoginRS, $loginFoundUser) = executeQuery($bbhive, $database_bbhive, $LoginRS__query);
		  //--Se tiver acesso continua senão veta
		  if ($loginFoundUser) {
			  $_SESSION['MM_BBhive_Corporativo'] = $row_LoginRS['bbh_usu_codigo'];
			  $_SESSION['MM_UserGroup']=584;
			  //--
				$_SESSION['MM_Email_Padrao']	= $_SESSION['MM_Email_Padrao'];
				$_SESSION['MM_BBhive_name']  	= $_SESSION['MM_Email_Padrao'];
				$_SESSION['MM_BBhive_Codigo'] 	= $row_LoginRS['bbh_usu_codigo'];	
				$_SESSION['MM_BBhive_Email'] 	= $row_LoginRS['bbh_usu_identificacao'];	
				
				$_SESSION['acesso'] 		= 1;
				$_SESSION['MM_User_email']	= $_SESSION['MM_Email_Padrao'];
				$_SESSION['usuNome']		= $row_LoginRS['bbh_usu_nome'];
				$_SESSION['usuApelido']		= $row_LoginRS['bbh_usu_apelido'];
				$_SESSION['usuCod']			= $row_LoginRS['bbh_usu_codigo'];
				$_SESSION['ultimoAcesso'] 	= $row_LoginRS['bbh_usu_ultimoAcesso'];
				$_SESSION['sexoUsuario']	= $row_LoginRS['bbh_usu_sexo'];
				$_SESSION['MM_BBhive_dpto']	= $row_LoginRS['bbh_dep_codigo'];
		  }
	}

//--
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BBHive</title>
<link rel="stylesheet" type="text/css" href="/corporativo/servicos/bbhive/includes/bbhive.css">
<link rel="stylesheet" type="text/css" href="/corporativo/servicos/bbhive/includes/tooltip.css">
<link type="text/css" rel="stylesheet" href="/corporativo/servicos/bbhive/includes/formulario_data/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/formulario_data/dhtmlgoodies_calendar.js"></script>
<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/bbhive.js"></script>
<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/functions.js"></script>
<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/boxover.js"></script>
<!-- editor -->
<?php /*<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/editor/editor.js"></script>*/ ?>
<link rel="stylesheet" href="/corporativo/servicos/bbhive/includes/js_css/css/prettyCheckboxes.css" type="text/css" media="screen" charset="utf-8" />

<link rel="stylesheet" type="text/css" href="/corporativo/servicos/bbhive/includes/style/style.css" />
<?php /*<script src="/corporativo/servicos/bbhive/includes/js_css/js/jquery-1.2.6.min.js" type="text/javascript"></script>*/?>
<?php /*<script src="/corporativo/servicos/bbhive/includes/js_css/js/common.js" type="text/javascript" charset="utf-8"></script>*/ ?>
<?php /*<script src="/corporativo/servicos/bbhive/includes/js_css/js/prettyCheckboxes.js" type="text/javascript" charset="utf-8"></script>*/ ?>

<!-- Prototiper -->
<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/prototype.js"></script>
<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/prototip.js"></script>
<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/styles.js"></script>
<link rel="stylesheet" type="text/css" href="/corporativo/servicos/bbhive/includes/prototip.css" />
<style type="text/css">
.ckeckbox{
	background:url(/corporativo/servicos/bbhive/includes/js_css/css/checkbox.gif) 0 -1px no-repeat;
	height:17px;
}
.sombra{
	background:url(/corporativo/servicos/bbhive/includes/js_css/css/checkbox.gif) 0 -22px no-repeat;
	height:17px;
}
.checado{
	background:url(/corporativo/servicos/bbhive/includes/js_css/css/checkbox.gif) 0 -43px no-repeat;
	height:17px;
}
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
function trocaClasse(btn, classe){
	document.getElementById(btn).className = classe;
}

function atualizaFoto(){
		var TimeStamp 	= new Date().getTime();
		var idMensagemFinal = 'url';
		var infoGet_Post	= '&1=1';//Se envio for POST, colocar nome do formulário
		var Mensagem		= "Carregando...";
		var idResultado		= 'imgNovaFoto';
		var Metodo			= "2";//1-POST, 2-GET
		var TpMens			= "1";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
		OpenAjaxPostCmd("/corporativo/servicos/bbhive/perfil/imagem.php?Ts="+TimeStamp,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
		
      document.getElementById('f1_upload_process').style.visibility = 'hidden';
      document.getElementById('arquivo').value = '';
	  document.getElementById('upload').innerHTML='';
}

function alerta(valor){
	  document.getElementById('f1_upload_process').style.visibility = 'hidden';
      document.getElementById('arquivo').value = '';
	  
	  alert(valor);
}

function caminhoArquivo(valor){
	document.getElementById('caminhoArquivo').innerHTML = "Arquivo Ok";
}
function limpaAmbiente(){
	document.getElementById('editorTexto').innerHTML = '&nbsp;';
	document.getElementById('ambienteRelatorio').innerHTML = '&nbsp;';	
}
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
				 alert('Informe o protocolo.');	
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
</script>

</head>
<?php 
if(isset($_SESSION['ligacaoAmbientePublico'])){
	$_SESSION['F5_OK'] = true;
	$_SESSION['urlEnviaPub'] 			= $_SESSION['ligacaoAmbientePublico'];
	$_SESSION['exPaginaPub'] 			= $_SESSION['ligacaoAmbientePublicoEnvia'];
	
	$_SESSION['urlEnviaAnteriorPub']	= $_SESSION['ligacaoAmbientePublicoAnt'];
	$_SESSION['exPaginaAnteriorPub']	= $_SESSION['ligacaoAmbientePublicoExPag'];
	
 	unset($_SESSION['ligacaoAmbientePublico']);
 }
 /*$_SESSION['pacoteNovoProtocolo'] 			= $nvVetor;
 $_SESSION['ligacaoAmbientePublico']		= $_SESSION['urlEnvia'];
 $_SESSION['ligacaoAmbientePublicoEnvia']	= $_SESSION['exPagina'];*/

//Isso para buscar a pagina certa quando o usuário aperta o botao voltar do navegador
if(isset($_GET['upload']))
{

	 $url = "corporativo/servicos/bbhive/arquivos/index.php";
 $onload = "onload=\"return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&arquivos=1|arquivos/index.php|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&equipeArquivos=1','menuEsquerda|colCentro|colDireita');\"";
}else{
if(isset($_SESSION['urlEnviaAnteriorCop'])){
	if(isset($_SESSION['F5_OK'])){
		$onload="onload='return showHome(\"".$_SESSION['urlEnviaAnteriorCop']."\",\"".$_SESSION['exPaginaAnteriorCop']."\", \"".$_SESSION['urlEnviaCop']."\", \"".$_SESSION['exPaginaCop']."\");'";
		
	} else {
		$onload="onload='return showHome(\"".$_SESSION['urlEnviaAnteriorCop']."\",\"".$_SESSION['exPaginaAnteriorCop']."\", \"perfil/index.php|".$_SESSION['urlEnviaCop']."\", \"menuEsquerda|".$_SESSION['exPaginaCop']."\");'";
		$_SESSION['F5_OK'] = "1";
	}
	
}else{
	$onload="onload='return LoadSimultaneo(\"perfil/index.php?perfil=1&perfis=1|principal.php\",\"menuEsquerda|conteudoGeral\");'";
}
}

$_SESSION['virtual_onload']=$onload;
?>
<body <?php if(isset($_SESSION['MM_BBhive_Corporativo']) && $_SESSION['MM_BBhive_Corporativo']>0){ echo $onload; } ?>>
<div name="url" id="url" style="display:none;position:absolute; margin-top:-500px;"></div>
<div style="position:absolute;display:none;" id="resultTransp"></div>
<table width="992" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:#CCC solid 1px; margin-top:10px;">
  <tr>
    <td align="center" valign="top"><?php require_once('includes/cabecalho.php'); ?></td>
  </tr>
  <tr>
    <td height="20" bgcolor="#F2F2F2"><?php require_once('includes/menu_horizontal.php'); ?>
<div id="ambienteRelatorio" style="position:absolute; margin-top:15px; z-index:5001; width:992px;">&nbsp;</div>
		<div id="editorTexto" style="position:absolute; margin-top:15px; z-index:5000">&nbsp;</div>
   </td>
  </tr>
  <tr>
    <td height="22" align="right" valign="top" bgcolor="#F2F2F2" class="verdana_9">
    <div style="float:right">
     <?php if($_SERVER['HTTP_HOST']=='projeto12.backsite.com.br'){?>
    	<select name="ambiente" id="ambiente" onchange="location.href=this.value;" class="arial_11">
        	<option value="/e-solution/servicos/bbhive/index.php">Acesso Administrativo</option>
			<option value="/corporativo/servicos/bbhive/index.php" selected="selected">Acesso Corporativo</option>
        	<option value="/servicos/bbhive/index.php">Acesso P&uacute;blico</option>
        </select>
        <?php } ?>
    </div>
    <div style="float:right; margin-top:5px;">
    <?php if(isset($_SESSION['MM_BBhive_Corporativo']) && $_SESSION['MM_BBhive_Corporativo']>0){ ?>
    	Ol&aacute; <strong><span id="nomeLogado"><?php echo $_SESSION['usuApelido']; ?></span></strong>, seja bem vindo ao BBHive&nbsp;&nbsp;
    <?php } ?>
    </div>
   </td>
  </tr>
  <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="5" bgcolor="#FFFFFF">
      <tr>
        <td width="137" height="142" align="left" valign="top" bgcolor="#F2F2F2" style="border-bottom:#728094 solid 1px;">
		<?php if(isset($_SESSION['MM_BBhive_Corporativo']) && $_SESSION['MM_BBhive_Corporativo']>0){ ?>
	        <?php require_once("perfil/imagem.php"); ?>
		<?php } ?>
        </td>
        <td width="833" align="left" valign="top" bgcolor="#F2F2F2" style="border-bottom:#728094 solid 1px;"><?php if(isset($_SESSION['MM_BBhive_Corporativo']) && $_SESSION['MM_BBhive_Corporativo']>0){ ?><div class="verdana_12"><?php require_once("fluxo_processos.php"); ?></div>
			<div><?php require_once("includes/resumo_fluxo.php"); ?></div>
			<?php /*<div><?php require_once("includes/adicionar.php"); ?></div>*/?>
            <div class="verdana_11" id="menuEsquerda"></div>
        <?php } ?>    
        </td>
      </tr>
      <tr>
        <td height="200" colspan="2" align="left" valign="top" id="conteudoGeral">
     <?php if(!isset($_SESSION['MM_BBhive_Corporativo'])){ 
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Tentou acessar o sistema na qual não tem perfil criado no ambiente corporativo ou credenciais não permitem acesso - BBHive.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
	 ?>
     <span class="aviso">
     	<div class="aviso" align="center">Voc&ecirc; n&atilde;o tem perfil criado para o ambiente corporativo ou suas credenciais não permite o acesso, entre em contato com o Administrador!</div>
     </span>
     	<?php } else { ?>
     	<?php } ?>
        </td>
        </tr>
    </table>
    
    </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><?php require_once('includes/rodape.php'); ?></td>
  </tr>
</table>
<form name="redirecionaForm" id="redirecionaForm" action="/corporativo/servicos/bbhive/index.php" method="get" style="position:absolute"></form>
</body>
</html>