<?php
 //responsável pela conexao com banco, autenticaçao, logoff
 require_once("../../../../includes/autenticacao/index.php");
 //
//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbpass.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/modulo/gerencia_modulo.php"); 
 if(isset($_POST['bbp_adm_loc_codigo'])){$_GET['lock'] = $_POST['bbp_adm_loc_codigo']; }
 $_GET['bbp_adm_loc_codigo'] = (int)$_GET['lock'];
 
 //
require_once("../gerencia_login.php");
$login = new Login();//instância classe
$modulo 				= new Modulo();

//verifica usuário com o mesmo nome
if(isset($_POST['verificaRepetido'])){
	$login->bbp_adm_lock_log_email	= $_POST['bbp_adm_lock_log_email'];
	$notIn = "";
	$resul = $login->verificaRepetido($database_bbpass, $bbpass, $notIn);//UPDATE
		if($resul==0){
	      //ação do formulário
		  $_POST['atualiza'] = true;
		} else {
		  echo "<script>
				 alert('Email já existente na base de dados!');
				</script>";
		  unset($_POST['atualiza']);
		}
	
}

//cadastra usuário
if(isset($_POST['atualiza'])){
		$login->bbp_adm_lock_log_nome	= ($_POST['bbp_adm_lock_log_nome']);
		$login->bbp_adm_lock_log_email	= $_POST['bbp_adm_lock_log_email'];
		$login->bbp_adm_lock_log_senha	= md5($_POST['bbp_adm_lock_log_senha']);
		$login->bbh_adm_lock_log_sexo	= $_POST['bbh_adm_lock_log_sexo'];
		$login->bbp_adm_lock_log_ativo	= $_POST['bbp_adm_lock_log_ativo'];
	
		$login->cadastraDados($database_bbpass, $bbpass);//UPDATE
	  
	  	//Policy=================================
		$_SESSION['relevancia']="10";
		$_SESSION['nivel']="2.5.1.1";
		// $Evento="Cadastrou o módulo ".$assinatura->bbp_adm_loc_nome;
		$Evento="Cadastrou o usuário ".$login->bbp_adm_lock_log_email." no módulo ".$modulo->nomeAplicacao($database_bbpass, $bbpass, $_POST['bbp_adm_loc_codigo']);
		EnviaPolicy($Evento);
	  //=======================================
	  
		  $urlRetorno = "index.php?lock=".$_POST['bbp_adm_loc_codigo'];//retorno após procedimento de manipulação de banco
		  echo "<script>
				 location.href='".$urlRetorno."';
				</script>";
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BBPASS - Central de Autentica&ccedil;&atilde;o</title>
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/bbpass/includes/layout/bbpass.css">
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/bbpass/includes/layout/login.css">
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/bbpass/includes/layout/menu.css">
<!-- GERAL DE TODOS OS LOCKS-->
	<script type="text/javascript" src="/e-solution/servicos/bbpass/includes/geral.js"></script>
<!-- FIM GERAL DE TODOS OS LOCKS-->
<!-- AJAX -->
	<script type="text/javascript" src="/e-solution/servicos/bbpass/includes/javascript_backsite/ajax/ajax.js"></script>
	<script type="text/javascript" src="/e-solution/servicos/bbpass/includes/javascript_backsite/ajax/projeto.js"></script>
<!-- AJAX-->
<!-- TRATAMENTO DE IMAGENS -->
<script type="text/javascript" src="/e-solution/servicos/bbpass/includes/javascript_backsite/historico/jquery.js"></script>
<!-- FIM TRATAMENTO DE IMAGENS -->
</head>

<body>
    <table width="777" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="margin-top:25px;">
      <tr>
        <td><?php require_once("../../../../includes/layout/cabLogin.php"); ?></td>
      </tr>
      <tr>
        <td height="25" valign="middle" bgcolor="#FFFBF4" style="font-family:arial;text-align:left;font-weight:bold;padding:5 0;border-bottom:1px solid #FFECC7; ">&nbsp;&nbsp;<img src="../../../../images/key.gif" width="16" height="16" align="absmiddle" />&nbsp;&nbsp;Central de autentica&ccedil;&atilde;o</td>
      </tr>
      <tr>
        <td height="490" valign="top" style="border-left:#EDDD92 solid 1px; border-bottom:#EDDD92 solid 1px;">
          
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/bbpass/includes/layout/bbpass.css">
<table width="765" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:5px;margin-bottom:10px;">
  <tr>
    <td width="4" height="37" align="left" background="/e-solution/servicos/bbpass/images/canto_esquerdo.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6"><img src="/e-solution/servicos/bbpass/images/engrenagem.gif" width="17" height="16" align="absmiddle" />&nbsp;<strong>Cadastro - <?php echo $modulo->nomeAplicacao($database_bbpass, $bbpass, $_GET['bbp_adm_loc_codigo']); ?></strong></td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="left" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;border-bottom:#DCDFE1 solid 1px;">
<form action="novo.php" method="post" id="atualizaPerfil" name="atualizaPerfil">
    <table width="580" border="0" cellspacing="0" cellpadding="0" class="fonteDestaque" align="center" style="margin-top:10px;">
  <tr>
    <td width="158" height="25" align="right" class="legendaLabel11"><strong>Nome do usu&aacute;rio</strong> :&nbsp;</td>
    <td width="422" height="25"><input name="bbp_adm_lock_log_nome" type="text" class="back_Campos" id="bbp_adm_lock_log_nome" size="50"/>
      <input type="hidden" name="bbp_adm_loc_codigo" id="bbp_adm_loc_codigo" value="<?php echo $_GET['bbp_adm_loc_codigo']; ?>" />
      </td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Email do usu&aacute;rio</strong> :&nbsp;</td>
    <td height="25"><input name="bbp_adm_lock_log_email" type="text" class="back_Campos" id="bbp_adm_lock_log_email" size="40"/></td>
    </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Senha do usu&aacute;rio </strong>:&nbsp;</td>
    <td height="25"><input name="bbp_adm_lock_log_senha" type="password" class="back_Campos" id="bbp_adm_lock_log_senha" size="30"/></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Usu&aacute;rio ativo</strong> :&nbsp;</td>
    <td height="25"><select name="bbp_adm_lock_log_ativo" id="bbp_adm_lock_log_ativo" class="back_Campos">
      <option value="1">Sim</option>
      <option value="0">N&atilde;o</option>
    </select></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Sexo do usu&aacute;rio</strong> :&nbsp;</td>
    <td height="25"><select name="bbh_adm_lock_log_sexo" id="bbh_adm_lock_log_sexo"class="back_Campos">
      <option value="m">Masculino</option>
      <option value="f">Feminino</option>
    </select></td>
  </tr>
  <tr>
    <td height="10" colspan="2" id="resultado3"></td>
  </tr>
  <tr>
    <td height="22" colspan="2" id="resultado">&nbsp;</td>
  </tr>
  <tr>
    <td height="3" colspan="2" align="right">
    <input name="cadastrar" onclick="javascript: location.href='index.php?lock=<?php echo $_GET['lock'];?>'" type="button" class="botaoVoltar back_input" id="cadastrar" value="&nbsp;&nbsp;&nbsp;Cancelar cadastro"/>
  <?php
  	$url 			= "/e-solution/servicos/bbpass/modulo/config/login/novo.php?verificaRepetido=true&bbp_adm_lock_log_email=";
  	$tag 			= "resultado";
	$tagReferencia 	= "bbp_adm_lock_log_email";
  ?>
    <input name="cadastrar" type="submit" class="botaoAvancar back_input" id="cadastrar" value="&nbsp;Cadastrar usu&aacute;rio" />
    &nbsp; </td>
  </tr>
</table>
    <input type="hidden" id="atualiza" name="atualiza" value="1" />
    <input type="hidden" id="verificaRepetido" name="verificaRepetido" value="1" />
</form>
</td>
  </tr>
</table>
<?php
/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="5";
	$_SESSION['nivel']="2.5.1";
	$Evento="Acessou a página de cadastro de usuários do módulo ".$modulo->nomeAplicacao($database_bbpass, $bbpass, $_GET['bbp_adm_loc_codigo']).".";
	EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
?>
          
        </td>
      </tr>
</table>