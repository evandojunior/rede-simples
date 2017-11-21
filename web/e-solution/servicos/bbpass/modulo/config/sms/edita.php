<?php
//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbpass.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/modulo/gerencia_modulo.php"); 

require_once("gerencia_sms.php");
$sms = new Sms();//instância classe
$modulo 				= new Modulo();

//verifica usuário com o mesmo nome
if(isset($_GET['verificaRepetido'])){
	$sms->bbp_adm_lock_sms_email	= $_GET['bbp_adm_lock_sms_email'];
	$notIn = " AND bbp_adm_lock_sms_codigo not in (".$_GET['bbp_adm_lock_sms_codigo'].")";
	$resul = $sms->verificaRepetido($database_bbpass, $bbpass, $notIn);//UPDATE
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
		$sms->bbp_adm_lock_sms_codigo		= $_POST['bbp_adm_lock_sms_codigo'];
		$sms->bbp_adm_lock_sms_nome			= ($_POST['bbp_adm_lock_sms_nome']);
		$sms->bbp_adm_lock_sms_email		= $_POST['bbp_adm_lock_sms_email'];
		$sms->bbp_adm_lock_sms_celular		= $_POST['bbp_adm_lock_sms_celular'];
		$sms->bbp_adm_lock_sms_observacao	= ($_POST['bbp_adm_lock_sms_observacao']);
	
		$sms->atualizaDados($database_bbpass, $bbpass);//UPDATE
		$sms->dadosSms($database_bbpass, $bbpass, $_POST['bbp_adm_lock_sms_codigo']);
		$editado = $sms->bbp_adm_lock_sms_email;
	
	/*==================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="5";
	$_SESSION['nivel']="2.5.2.1";
	$Evento="Alterou informa&ccedil;&otilde;es do usuário ".$editado." do módulo " . $modulo->nomeAplicacao($database_bbpass, $bbpass,$_POST['bbp_adm_loc_codigo']);
	EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
	  
	    $urlRetorno = "/e-solution/servicos/bbpass/modulo/config/sms/index.php?bbp_adm_loc_codigo=".$_POST['bbp_adm_loc_codigo'];//retorno após procedimento de manipulação de banco
		  echo "<var style='display:none'>
				 voltarURL('$urlRetorno');
				</var>";
	exit;
}
//verifica dados do módulo

$sms->dadosSms($database_bbpass, $bbpass, $_GET['bbp_adm_lock_sms_codigo']);
require_once("../../../perfil/index.php"); ?>

<table width="765" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:5px;margin-bottom:10px;">
  <tr>
    <td width="4" height="37" align="left" background="/e-solution/servicos/bbpass/images/canto_esquerdo.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6"><img src="/e-solution/servicos/bbpass/images/engrenagem.gif" width="17" height="16" align="absmiddle" />&nbsp;<strong>Edi&ccedil;&atilde;o de dados - <?php echo $modulo->nomeAplicacao($database_bbpass, $bbpass, $_GET['bbp_adm_loc_codigo']); ?></strong></td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="left" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;border-bottom:#DCDFE1 solid 1px;">
<form action="/e-solution/servicos/bbpass/modulo/config/sms/edita.php" method="post" id="atualizaPerfil" name="atualizaPerfil">
    <table width="580" border="0" cellspacing="0" cellpadding="0" class="fonteDestaque" align="center" style="margin-top:10px;">
  <tr>
    <td width="158" height="25" align="right" class="legendaLabel11"><strong>Nome do usu&aacute;rio</strong> :&nbsp;</td>
    <td width="422" height="25"><input name="bbp_adm_lock_sms_nome" type="text" class="back_Campos" id="bbp_adm_lock_sms_nome" size="50" value="<?php echo $sms->bbp_adm_lock_sms_nome; ?>"/>
      <input type="hidden" name="bbp_adm_loc_codigo" id="bbp_adm_loc_codigo" value="<?php echo $_GET['bbp_adm_loc_codigo']; ?>" />
      <input name="bbp_adm_lock_sms_codigo" type="hidden" id="bbp_adm_lock_sms_codigo" value="<?php echo $sms->bbp_adm_lock_sms_codigo; ?>" /></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Email do usu&aacute;rio</strong> :&nbsp;</td>
    <td height="25"><input name="bbp_adm_lock_sms_email" type="text" class="back_Campos" id="bbp_adm_lock_sms_email" size="40" value="<?php echo $sms->bbp_adm_lock_sms_email; ?>"/></td>
    </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Celular do usu&aacute;rio </strong>:&nbsp;</td>
    <td height="25"><input name="bbp_adm_lock_sms_celular" type="text" class="back_Campos" id="bbp_adm_lock_sms_celular" size="30" value="<?php echo $sms->bbp_adm_lock_sms_celular; ?>"/></td>
  </tr>
  <tr>
    <td height="25" align="right" valign="top" class="legendaLabel11"><strong>Observa&ccedil;&atilde;o</strong> :&nbsp;</td>
    <td height="25"><textarea name="bbp_adm_lock_sms_observacao" id="bbp_adm_lock_sms_observacao" cols="78" rows="6" class="formulario2"><?php echo $sms->bbp_adm_lock_sms_observacao; ?></textarea></td>
  </tr>
  <tr>
    <td height="10" colspan="2" id="resultado3"></td>
  </tr>
  <tr>
    <td height="22" colspan="2" id="resultado">&nbsp;</td>
  </tr>
  <tr>
    <td height="3" colspan="2" align="right">
    <input name="cadastrar" onclick="voltarURL('/e-solution/servicos/bbpass/modulo/config/sms/index.php?bbp_adm_loc_codigo=<?php echo $_GET['bbp_adm_loc_codigo']; ?>');" type="button" class="botaoVoltar back_input" id="cadastrar" value="&nbsp;&nbsp;&nbsp;Cancelar atualiza&ccedil;&atilde;o"/>
  <?php
  	$url 			= "/e-solution/servicos/bbpass/modulo/config/sms/edita.php?verificaRepetido=true&bbp_adm_lock_sms_codigo=".$sms->bbp_adm_lock_sms_codigo."&bbp_adm_lock_sms_email=";
  	$tag 			= "resultado";
	$tagReferencia 	= "bbp_adm_lock_sms_email";
  ?>
    <input name="cadastrar" type="button" class="botaoAvancar back_input" id="cadastrar" value="&nbsp;Atualizar usu&aacute;rio" onclick="javascript:if(document.getElementById('bbp_adm_lock_sms_email').value=='' || document.getElementById('bbp_adm_lock_sms_celular').value==''){alert('Informe o Email e Celular.');}else{verificaRepetido('<?php echo $url; ?>','<?php echo $tag; ?>', '<?php echo $tagReferencia; ?>')}" />
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
	$Evento="Acessou a página de edição do usuário ".$sms->bbp_adm_lock_sms_email." do módulo ".$modulo->nomeAplicacao($database_bbpass, $bbpass, $_GET['bbp_adm_loc_codigo']).".";
	EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
?>
