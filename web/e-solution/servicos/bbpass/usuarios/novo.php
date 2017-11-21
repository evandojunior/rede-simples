<?php
//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbpass.php");

if(isset($_POST['atualiza'])){

	require_once("gerencia_usuario.php");
	$usuario = new usuarios();//instância classe
	$usuario->bbp_adm_aut_usuario 		= $_POST['bbp_adm_aut_usuario'];
	
	if($usuario->verificaRepetido($database_bbpass, $bbpass)==0){
		$usuario->bbp_adm_aut_usuario 	= $_POST['bbp_adm_aut_usuario'];
		$usuario->bbp_adm_aut_ip		= $_POST['bbp_adm_aut_ip'];
		$usuario->bbp_adm_aut_senha 	= $_POST['bbp_adm_aut_senha'];
		$usuario->bbp_adm_user 			= $_POST['bbp_adm_user'];
		$usuario->cadastraDados($database_bbpass, $bbpass);//UPDATE
		
	  //Policy=================================
		$_SESSION['relevancia']="10";
		$_SESSION['nivel']="1.1.1";
		$Evento="Cadastrou o usuário ".$usuario->bbp_adm_aut_usuario;
		EnviaPolicy($Evento);
	  //=======================================
	  
		  $urlRetorno = "/e-solution/servicos/bbpass/usuarios/index.php";//retorno após procedimento de manipulação de banco
		  echo "<var style='display:none'>
				 voltarURL('$urlRetorno');
				</var>";
	} else {
		echo '<label style="color:#F00" class="legendaLabel11">Já existe um usuário com este e-mail.</label>';
	}
	exit;
}
require_once("../perfil/index.php"); ?>
<table width="765" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:5px;margin-bottom:10px;">
  <tr>
    <td width="4" height="37" align="left" background="/e-solution/servicos/bbpass/images/canto_esquerdo.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6"><strong>Cadastro de usu&aacute;rios BBPASS</strong></td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="left" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;border-bottom:#DCDFE1 solid 1px;">
<form action="/e-solution/servicos/bbpass/usuarios/novo.php" method="post" id="atualizaUsuario" name="atualizaUsuario">
    <table width="580" border="0" cellspacing="0" cellpadding="0" class="fonteDestaque" align="center" style="margin-top:10px;">
  <tr>
    <td width="124" height="25" align="right" class="legendaLabel11"><strong>E-mail </strong> :&nbsp;</td>
    <td width="456" height="25"><input name="bbp_adm_aut_usuario" type="text" class="back_Campos" id="bbp_adm_aut_usuario" size="40"/></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>IP de acesso</strong> :&nbsp;</td>
    <td height="25"><input name="bbp_adm_aut_ip" type="text" class="back_Campos" id="bbp_adm_aut_ip" size="30"/> 
    <span class="verdana_11">
      Ex.: 192.168.0.125</span></td>
    </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Usu&aacute;rio adm</strong> :&nbsp;</td>
    <td height="25"><select name="bbp_adm_user" id="bbp_adm_user" class="back_Campos">
      <option value="0">N&atilde;o</option>
      <option value="1">Sim</option>
    </select></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Senha </strong>:&nbsp;</td>
    <td height="25"><input name="bbp_adm_aut_senha" type="password" class="back_Campos" id="bbp_adm_aut_senha" size="20"/></td>
  </tr>
  <tr>
    <td height="22" colspan="2" id="resultado">&nbsp;</td>
  </tr>
  <tr>
    <td height="3" colspan="2" align="right">
    <input name="cadastrar" onclick="voltarURL('/e-solution/servicos/bbpass/usuarios/index.php');" type="button" class="botaoVoltar back_input" id="cadastrar" value="&nbsp;&nbsp;&nbsp;Cancelar cadastro"/>
    
    <input name="cadastrar" type="button" class="botaoAvancar back_input" id="cadastrar" value="&nbsp;Cadastrar usu&aacute;rio" onclick="if(document.getElementById('bbp_adm_aut_usuario').value==''){alert('Informe o E-mail.');}else{enviaFORMULARIO('atualizaUsuario','resultado');}" />
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
$_SESSION['relevancia']="10";
$_SESSION['nivel']="1.1";
$Evento="Acessou a página de cadastro de usuários.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
?>