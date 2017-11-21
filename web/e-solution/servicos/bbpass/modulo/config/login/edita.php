<?php
//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbpass.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/modulo/gerencia_modulo.php"); 

require_once("gerencia_login.php");
$login = new Login();//instância classe
$modulo 				= new Modulo();

//verifica usuário com o mesmo nome
if(isset($_GET['verificaRepetido'])){
	$login->bbp_adm_lock_log_email	= $_GET['bbp_adm_lock_log_email'];
	$notIn = " AND bbp_adm_lock_log_codigo not in (".$_GET['bbp_adm_lock_log_codigo'].")";
	$resul = $login->verificaRepetido($database_bbpass, $bbpass, $notIn);//UPDATE
		if($resul==0){
	      //ação do formulário
		  echo "<var style='display:none'>
		  		 enviaFORMULARIO('atualizaPerfil','resultado');
				</var>";
		} else {
		  echo "<var style='display:none'>
		  		 limpaCarregando();
				 alert('Email já existente na base de dados!');
				</var>";
		}
	exit;
}

//cadastra usuário
if(isset($_POST['atualiza'])){
		$login->bbp_adm_lock_log_codigo	= $_POST['bbp_adm_lock_log_codigo'];
		$login->bbp_adm_lock_log_nome	= ($_POST['bbp_adm_lock_log_nome']);
		$login->bbp_adm_lock_log_email	= $_POST['bbp_adm_lock_log_email'];
		$login->bbh_adm_lock_log_sexo	= $_POST['bbh_adm_lock_log_sexo'];
		$login->bbp_adm_lock_log_ativo	= $_POST['bbp_adm_lock_log_ativo'];
	
		$complSenha = "";
			if(isset($_POST['chk_senha'])){
				$complSenha = ", bbp_adm_lock_log_senha='".md5($_POST['bbp_adm_lock_log_senha'])."'";
			}
		$login->atualizaDados($database_bbpass, $bbpass, $complSenha);//UPDATE
	  
		$login->dadosLogin($database_bbpass, $bbpass, $_POST['bbp_adm_lock_log_codigo']);
		$editado = $login->bbp_adm_lock_log_email;
	
	/*==================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="5";
	$_SESSION['nivel']="2.5.2.1";
	$Evento="Alterou informa&ccedil;&otilde;es do usuário ".$editado." do módulo " . $modulo->nomeAplicacao($database_bbpass, $bbpass,$_POST['bbp_adm_loc_codigo']);
	EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
	
		$login->atualizaDados($database_bbpass, $bbpass, $complSenha);//UPDATE
	  
	  
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
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6"><img src="/e-solution/servicos/bbpass/images/engrenagem.gif" width="17" height="16" align="absmiddle" />&nbsp;<strong>Edi&ccedil;&atilde;o - <?php echo $modulo->nomeAplicacao($database_bbpass, $bbpass, $_GET['bbp_adm_loc_codigo']); ?></strong></td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="left" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;border-bottom:#DCDFE1 solid 1px;">
<form action="/e-solution/servicos/bbpass/modulo/config/login/edita.php" method="post" id="atualizaPerfil" name="atualizaPerfil">
    <table width="580" border="0" cellspacing="0" cellpadding="0" class="fonteDestaque" align="center" style="margin-top:10px;">
  <tr>
    <td width="158" height="25" align="right" class="legendaLabel11"><strong>Nome do usu&aacute;rio</strong> :&nbsp;</td>
    <td width="422" height="25"><input name="bbp_adm_lock_log_nome" type="text" class="back_Campos" id="bbp_adm_lock_log_nome" value="<?php echo $login->bbp_adm_lock_log_nome; ?>" size="50"/>
      <input type="hidden" name="bbp_adm_loc_codigo" id="bbp_adm_loc_codigo" value="<?php echo $_GET['bbp_adm_loc_codigo']; ?>" />
      <input name="bbp_adm_lock_log_codigo" type="hidden" id="bbp_adm_lock_log_codigo" value="<?php echo $login->bbp_adm_lock_log_codigo; ?>" /></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Email do usu&aacute;rio</strong> :&nbsp;</td>
    <td height="25"><input name="bbp_adm_lock_log_email" type="text" class="back_Campos" id="bbp_adm_lock_log_email" value="<?php echo $login->bbp_adm_lock_log_email; ?>" size="40"/></td>
    </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Senha do usu&aacute;rio </strong>:&nbsp;</td>
    <td height="25"><input name="bbp_adm_lock_log_senha" type="password" class="back_Campos" id="bbp_adm_lock_log_senha" size="30" disabled="disabled"/>
      
        <input type="checkbox" name="chk_senha" id="chk_senha" onclick="javascript: if(this.checked==true){document.getElementById('bbp_adm_lock_log_senha').disabled=false;document.getElementById('bbp_adm_lock_log_senha').focus();}else{document.getElementById('bbp_adm_lock_log_senha').disabled=true}" />
        <label class="verdana_11">Alterar senha</label></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Usu&aacute;rio ativo</strong> :&nbsp;</td>
    <td height="25"><select name="bbp_adm_lock_log_ativo" id="bbp_adm_lock_log_ativo" class="back_Campos">
      <option value="1" <?php if($login->bbp_adm_lock_log_ativo=="1"){echo "selected='selected'";}?>>Sim</option>
      <option value="0" <?php if($login->bbp_adm_lock_log_ativo=="0"){echo "selected='selected'";}?>>N&atilde;o</option>
    </select></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Sexo do usu&aacute;rio</strong> :&nbsp;</td>
    <td height="25"><select name="bbh_adm_lock_log_sexo" id="bbh_adm_lock_log_sexo"class="back_Campos">
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
    <input name="cadastrar" onclick="voltarURL('/e-solution/servicos/bbpass/modulo/config/login/index.php?bbp_adm_loc_codigo=<?php echo $_GET['bbp_adm_loc_codigo']; ?>');" type="button" class="botaoVoltar back_input" id="cadastrar" value="&nbsp;&nbsp;&nbsp;Cancelar atualiza&ccedil;&atilde;o"/>
  <?php
  	$url 			= "/e-solution/servicos/bbpass/modulo/config/login/edita.php?verificaRepetido=true&bbp_adm_lock_log_codigo=".$login->bbp_adm_lock_log_codigo."&bbp_adm_lock_log_email=";
  	$tag 			= "resultado";
	$tagReferencia 	= "bbp_adm_lock_log_email";
  ?>
    <input name="cadastrar" type="button" class="botaoAvancar back_input" id="cadastrar" value="Atualizar usu&aacute;rio" onclick="verificaRepetido('<?php echo $url; ?>','<?php echo $tag; ?>', '<?php echo $tagReferencia; ?>')" />
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
	$_SESSION['nivel']="2.5.2";
	$Evento="Acessou a página de edição do usuário ".$login->bbp_adm_lock_log_email." do módulo ".$modulo->nomeAplicacao($database_bbpass, $bbpass, $_GET['bbp_adm_loc_codigo']).".";
	EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
?>