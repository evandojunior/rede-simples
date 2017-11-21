<?php
//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbpass.php");
require_once("gerencia_perfil.php");

$usuario = new perfil();//instância classe
if(isset($_POST['atualiza'])){
	  $usuario->novaSenha 	= md5($_POST['bbp_adm_aut_senha']);
	  $usuario->atualizaDados($database_bbpass, $bbpass);//UPDATE
	  
	  //Policy=================================
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="3";
		$Evento="Alterou a senha";
		EnviaPolicy($Evento);
	  //=======================================
	  
	  $urlRetorno = "/e-solution/servicos/bbpass/home.php";//retorno após procedimento de manipulação de banco
	  echo "<var style='display:none'>
		     voltarURL('$urlRetorno');
		    </var>";
	exit;
}
require_once("index.php"); ?>
<table width="765" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:5px;margin-bottom:10px;">
  <tr>
    <td width="4" height="37" align="left" background="/e-solution/servicos/bbpass/images/canto_esquerdo.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6"><strong>Trocar senha</strong></td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="left" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;border-bottom:#DCDFE1 solid 1px;">
<form action="/e-solution/servicos/bbpass/perfil/edita.php" method="post" id="atualizaPerfil" name="atualizaPerfil">
    <table width="580" border="0" cellspacing="0" cellpadding="0" class="fonteDestaque" align="center" style="margin-top:10px;">
  <tr>
    <td height="25" colspan="2" class="legendaLabel14"><strong style="color:#06F"><?php echo $_SESSION['MM_BBpassADM_Email']; ?></strong></td>
  </tr>
  <tr>
    <td width="115" height="25" class="legendaLabel11"><strong>Nova senha</strong> :</td>
    <td width="465" height="25"><input name="senha" type="password" class="back_Campos" id="senha" size="40"/></td>
    </tr>
  <tr>
    <td height="25" class="legendaLabel11"><strong>Repetir senha</strong> :</td>
    <td height="25"><input name="bbp_adm_aut_senha" type="password" class="back_Campos" id="bbp_adm_aut_senha" size="40"/></td>
    </tr>
  <tr>
    <td height="22" colspan="2" id="resultado">&nbsp;</td>
  </tr>
  <tr>
    <td height="3" colspan="2" align="right">
    <input name="cadastrar" onclick="voltarURL('/e-solution/servicos/bbpass/home.php');" type="button" class="botaoVoltar back_input" id="cadastrar" value="&nbsp;&nbsp;&nbsp;Cancelar atualiza&ccedil;&atilde;o"/>
    
    <input name="cadastrar" onclick="if((document.getElementById('senha').value!=document.getElementById('bbp_adm_aut_senha').value)||(document.getElementById('bbp_adm_aut_senha').value=='')){alert('Informa&ccedil;&otilde;es diferentes ou vazias.');}else{enviaFORMULARIO('atualizaPerfil','resultado');}" type="button" class="botaoAvancar back_input" id="cadastrar" value="&nbsp;&nbsp;Atualizar senha"/>
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
$_SESSION['relevancia']="0";
$_SESSION['nivel']="3";
$Evento="Acessou a página de edição de senha.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
?>