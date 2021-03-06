<?php
//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbpass.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/modulo/gerencia_modulo.php"); 

require_once("gerencia_assinatura.php");
$assinatura = new Assinatura();//instância classe

$modulo 				= new Modulo();// instancia Modulo

//verifica usuário com o mesmo nome
if(isset($_GET['verificaRepetido'])){
	//verifica email e CPF
	$resul = 0;
	$assinatura->bbp_adm_lock_ass_email	= $_GET['bbp_adm_lock_ass_email'];
	$assinatura->bbp_adm_lock_ass_cpf	= $_GET['bbp_adm_lock_ass_cpf'];
	$notIn = "";
	$resul = $assinatura->verificaRepetido($database_bbpass, $bbpass, $notIn);//Verifica
	
		if($resul>0){
		  echo "<var style='display:none'>
		  		 limpaCarregando();
				 alert('Email e/ou CPF já existente na base de dados!');
				</var>";
		}else{
	  //ação do formulário
	  echo "<var style='display:none'>
			 enviaFORMULARIO('atualizaPerfil','resultado');
			</var>";
	}
	exit;
}

//cadastra usuário
if(isset($_POST['atualiza'])){
		$assinatura->bbp_adm_lock_ass_nome		= ($_POST['bbp_adm_lock_ass_nome']);
		$assinatura->bbp_adm_lock_ass_email		= $_POST['bbp_adm_lock_ass_email'];
		$assinatura->bbp_adm_lock_ass_cpf		= $_POST['bbp_adm_lock_ass_cpf'];
		$assinatura->bbp_adm_lock_ass_obs		= ($_POST['bbp_adm_lock_ass_obs']);
	
		$assinatura->cadastraDados($database_bbpass, $bbpass);//UPDATE
		
	   //Policy=================================
		$_SESSION['relevancia']="10";
		$_SESSION['nivel']="2.5.1.1";
		// $Evento="Cadastrou o módulo ".$assinatura->bbp_adm_loc_nome;
		$Evento="Cadastrou o usuário ".$assinatura->bbp_adm_lock_ass_email." no módulo ".$modulo->nomeAplicacao($database_bbpass, $bbpass, $_POST['bbp_adm_loc_codigo']);
		EnviaPolicy($Evento);
	  //=======================================
			   
		  $urlRetorno = "/e-solution/servicos/bbpass/modulo/config/assinaturadigital/index.php?bbp_adm_loc_codigo=".$_POST['bbp_adm_loc_codigo'];//retorno após procedimento de manipulação de banco
		  echo "<var style='display:none'>
				 voltarURL('$urlRetorno');
				</var>";
	exit;
}
//verifica dados do módulo

require_once("../../../perfil/index.php"); ?>

<table width="765" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:5px;margin-bottom:10px;">
  <tr>
    <td width="4" height="37" align="left" background="/e-solution/servicos/bbpass/images/canto_esquerdo.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6"><img src="/e-solution/servicos/bbpass/images/engrenagem.gif" width="17" height="16" align="absmiddle" />&nbsp;<strong>Cadastro - <?php echo $modulo->nomeAplicacao($database_bbpass, $bbpass, $_GET['bbp_adm_loc_codigo']); ?></strong></td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="left" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;border-bottom:#DCDFE1 solid 1px;">
<form action="/e-solution/servicos/bbpass/modulo/config/assinaturadigital/novo.php" method="post" id="atualizaPerfil" name="atualizaPerfil">
    <table width="580" border="0" cellspacing="0" cellpadding="0" class="fonteDestaque" align="center" style="margin-top:10px;">
  <tr>
    <td width="158" height="25" align="right" class="legendaLabel11"><strong>Nome do usu&aacute;rio</strong> :&nbsp;</td>
    <td width="422" height="25"><input name="bbp_adm_lock_ass_nome" type="text" class="back_Campos" id="bbp_adm_lock_ass_nome" size="50"/>
      <input type="hidden" name="bbp_adm_loc_codigo" id="bbp_adm_loc_codigo" value="<?php echo $_GET['bbp_adm_loc_codigo']; ?>" /></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Email do usu&aacute;rio</strong> :&nbsp;</td>
    <td height="25"><input name="bbp_adm_lock_ass_email" type="text" class="back_Campos" id="bbp_adm_lock_ass_email" size="40"/></td>
    </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>CPF do usu&aacute;rio </strong>:&nbsp;</td>
    <td height="25"><input name="bbp_adm_lock_ass_cpf" type="text" class="back_Campos" id="bbp_adm_lock_ass_cpf" size="30" onkeyup="SomenteNumerico(this)"/>
      <span class="verdana_11">(somente n&uacute;meros)</span></td>
  </tr>
  <tr>
    <td height="25" align="right" valign="top" class="legendaLabel11"><strong>Observa&ccedil;&atilde;o</strong> :&nbsp;</td>
    <td height="25"><textarea name="bbp_adm_lock_ass_obs" id="bbp_adm_lock_ass_obs" cols="78" rows="6" class="formulario2"></textarea></td>
  </tr>
  <tr>
    <td height="10" colspan="2" id="resultado3"></td>
  </tr>
  <tr>
    <td height="22" colspan="2" id="resultado">&nbsp;</td>
  </tr>
  <tr>
    <td height="3" colspan="2" align="right">
    <input name="cadastrar" onclick="voltarURL('/e-solution/servicos/bbpass/modulo/config/assinaturadigital/index.php?bbp_adm_loc_codigo=<?php echo $_GET['bbp_adm_loc_codigo']; ?>');" type="button" class="botaoVoltar back_input" id="cadastrar" value="&nbsp;&nbsp;&nbsp;Cancelar cadastro"/>
  <?php
  	$url 			= "/e-solution/servicos/bbpass/modulo/config/assinaturadigital/novo.php?verificaRepetido=true&";
  	$tag 			= "resultado";
	$tagReferencia 	= "bbp_adm_lock_ass_email,bbp_adm_lock_ass_cpf";
  ?>
    <input name="cadastrar" type="button" class="botaoAvancar back_input" id="cadastrar" value="&nbsp;Cadastrar usu&aacute;rio" onclick="javascript:if(document.getElementById('bbp_adm_lock_ass_email').value=='' || document.getElementById('bbp_adm_lock_ass_cpf').value==''){alert('Informe o Email e CPF.');}else{ validaFormulario('bbp_adm_lock_ass_cpf', document.getElementById('acaoForm').value)}" />
    &nbsp; </td>
  </tr>
</table>
    <input type="hidden" id="atualiza" name="atualiza" value="1" />
    <input type="hidden" id="acaoForm" name="acaoForm" value="verificaRepetido('<?php echo $url; ?>','<?php echo $tag; ?>', '<?php echo $tagReferencia; ?>')" />
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