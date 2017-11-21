<?php
//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbpass.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/modulo/gerencia_modulo.php"); 

require_once("gerencia_login.php");
$login = new Login();//instância classe
$modulo 				= new Modulo();

//cadastra usuário
if(isset($_POST['atualiza'])){
			  
	  	$login->dadosLogin($database_bbpass, $bbpass, $_POST['bbp_adm_lock_log_codigo']);
		$excluido = $login->bbp_adm_lock_log_email;
	
	/*==================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="5";
	$_SESSION['nivel']="2.5.3.1";
	$Evento="Excluiu o usuário ".$excluido." do módulo " . $modulo->nomeAplicacao($database_bbpass, $bbpass,$_POST['bbp_adm_loc_codigo']);
	EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
	
	$login->excluiDados($database_bbpass, $bbpass);
	  
	  
	  
		  $urlRetorno = "/e-solution/servicos/bbpass/modulo/config/login/index.php?bbp_adm_loc_codigo=".$_POST['bbp_adm_loc_codigo'];//retorno após procedimento de manipulação de banco
		  echo "<var style='display:none'>
				 voltarURL('$urlRetorno');
				</var>";
	exit;
}
//verifica dados do módulo

$login->dadosLogin($database_bbpass, $bbpass, $_GET['bbp_adm_lock_log_codigo']);

require_once("../../../perfil/index.php"); ?>

<table width="765" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:5px;margin-bottom:10px;">
  <tr>
    <td width="4" height="37" align="left" background="/e-solution/servicos/bbpass/images/canto_esquerdo.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6"><img src="/e-solution/servicos/bbpass/images/engrenagem.gif" width="17" height="16" align="absmiddle" />&nbsp;<strong>Exclus&atilde;o - <?php echo $modulo->nomeAplicacao($database_bbpass, $bbpass, $_GET['bbp_adm_loc_codigo']); ?></strong></td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="left" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;border-bottom:#DCDFE1 solid 1px;">
<form action="/e-solution/servicos/bbpass/modulo/config/login/excluir.php" method="post" id="atualizaPerfil" name="atualizaPerfil">
    <table width="580" border="0" cellspacing="0" cellpadding="0" class="fonteDestaque" align="center" style="margin-top:10px;">
  <tr>
    <td width="158" height="25" align="right" class="legendaLabel11"><strong>Nome do usu&aacute;rio</strong> :&nbsp;</td>
    <td width="422" height="25"><input name="bbp_adm_lock_log_nome" type="text" class="back_Campos" id="bbp_adm_lock_log_nome" value="<?php echo $login->bbp_adm_lock_log_nome; ?>" size="50" disabled="disabled"/>
      <input type="hidden" name="bbp_adm_loc_codigo" id="bbp_adm_loc_codigo" value="<?php echo $_GET['bbp_adm_loc_codigo']; ?>" />
      <input name="bbp_adm_lock_log_codigo" type="hidden" id="bbp_adm_lock_log_codigo" value="<?php echo $login->bbp_adm_lock_log_codigo; ?>" /></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Email do usu&aacute;rio</strong> :&nbsp;</td>
    <td height="25"><input name="bbp_adm_lock_log_email" type="text" class="back_Campos" id="bbp_adm_lock_log_email" value="<?php echo $login->bbp_adm_lock_log_email; ?>" size="40" disabled="disabled"/></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Usu&aacute;rio ativo</strong> :&nbsp;</td>
    <td height="25"><select name="bbp_adm_lock_log_ativo" id="bbp_adm_lock_log_ativo" class="back_Campos" disabled="disabled">
      <option value="1" <?php if($login->bbp_adm_lock_log_ativo=="1"){echo "selected='selected'";}?>>Sim</option>
      <option value="0" <?php if($login->bbp_adm_lock_log_ativo=="0"){echo "selected='selected'";}?>>N&atilde;o</option>
      </select></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Sexo do usu&aacute;rio</strong> :&nbsp;</td>
    <td height="25"><select name="bbh_adm_lock_log_sexo" id="bbh_adm_lock_log_sexo"class="back_Campos" disabled="disabled">
      <option value="m" <?php if($login->bbh_adm_lock_log_sexo=="m"){echo "selected='selected'";}?>>Masculino</option>
      <option value="f" <?php if($login->bbh_adm_lock_log_sexo=="f"){echo "selected='selected'";}?>>Feminino</option>
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
    <input name="cadastrar" onclick="voltarURL('/e-solution/servicos/bbpass/modulo/config/login/index.php?bbp_adm_loc_codigo=<?php echo $_GET['bbp_adm_loc_codigo']; ?>');" type="button" class="botaoVoltar back_input" id="cadastrar" value="&nbsp;&nbsp;&nbsp;Cancelar exclus&atilde;o"/>

    <input name="cadastrar" type="button" class="botaoAvancar back_input" id="cadastrar" value="Exclu&iacute;r usu&aacute;rio" onclick="if(confirm('Tem certeza que deseja excluir este usuário?\nEm caso de confirmação clique em Ok.')){enviaFORMULARIO('atualizaPerfil','resultado');}" />
    &nbsp; </td>
  </tr>
</table>
    <input type="hidden" id="atualiza" name="atualiza" value="1" />
</form>
</td>
  </tr>
</table>
<?php
/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="5";
	$_SESSION['nivel']="2.5.3";
	$Evento="Acessou a página de exclusão do usuário ".$login->bbp_adm_lock_log_email." do módulo ".$modulo->nomeAplicacao($database_bbpass, $bbpass, $_GET['bbp_adm_loc_codigo']).".";
	EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
?>