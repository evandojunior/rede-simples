<?php
//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
require_once("../includes/autenticacao/index.php");
include($_SESSION['caminhoFisico']."/Connections/bbpass.php");
include($_SESSION['caminhoFisico']."/servicos/bbpass/includes/function.php");
require_once("gerencia_perfil.php");

$usuario = new perfil();//instância classe
if(isset($_POST['atualiza'])){
	  $usuario->nomeUsuario 	= ($_POST['bbp_adm_lock_log_nome']);
	  $usuario->nascUsuario 	= arrumadata($_POST['bbp_adm_lock_log_nasc']);
	  $usuario->cargoUsuario 	= ($_POST['bbp_adm_lock_log_cargo']);
	  $usuario->sexoUsuario 	= $_POST['bbh_adm_lock_log_sexo'];
	  $usuario->obsUsuario		= ($_POST['bbp_adm_lock_log_obs']);
	  $usuario->atualizaDados($database_bbpass, $bbpass);//UPDATE
	  
	  //Policy=================================
		$_SESSION['relevancia']="5";
		$_SESSION['nivel']="1.1";
		$Evento="Alterou seus dados (Ambiente Público)";
		EnviaPolicy($Evento);
	  //=======================================
	  
	  
	  $urlRetorno = "/servicos/bbpass/home.php?foto=true";//retorno após procedimento de manipulação de banco
	  echo "<var style='display:none'>
		     voltarURL('$urlRetorno');
		    </var>";
	exit;
}
$usuario->dadosPerfil($database_bbpass, $bbpass);//chama método responsável pela atribuição das variáveis*/
?>
<form action="/servicos/bbpass/perfil/edita.php" method="post" id="atualizaPerfil" name="atualizaPerfil">
<table width="580" border="0" cellspacing="0" cellpadding="0" class="fonteDestaque" align="center">
  <tr>
    <td width="51" height="25" class="legendaLabel11"><strong>Nome</strong> :</td>
    <td width="309" height="25"><input name="bbp_adm_lock_log_nome" type="text" class="back_Campos" id="bbp_adm_lock_log_nome" value="<?php echo $usuario->nomeUsuario; ?>" size="49"/></td>
    <td width="100" height="25" align="right"  class="legendaLabel11"><strong>Sexo</strong> :      </td>
    <td width="117" align="left"  class="legendaLabel11"><select name="bbh_adm_lock_log_sexo" id="bbh_adm_lock_log_sexo"class="back_Campos">
      <option value="m" <?php if($usuario->sexoUsuario=="m") { echo 'selected="selected"';} ?>>Masculino</option>
      <option value="f" <?php if($usuario->sexoUsuario=="f") { echo 'selected="selected"';} ?>>Feminino</option>
    </select></td>
  </tr>
  <tr>
    <td height="25" class="legendaLabel11"><strong>Cargo</strong> :</td>
    <td height="25"><input name="bbp_adm_lock_log_cargo" type="text" class="back_Campos" id="bbp_adm_lock_log_cargo" value="<?php echo $usuario->cargoUsuario; ?>" size="40"/></td>
    <td height="25" align="right" class="legendaLabel11"><strong>Nascimento </strong>: </td>
    <td height="25" class="legendaLabel11"><input name="bbp_adm_lock_log_nasc" type="text" class="formulario2" id="bbp_adm_lock_log_nasc" value="<?php echo arrumadata($usuario->nascUsuario); ?>" size="13" onkeypress="MascaraData(event, this)" maxlength="10"/>
      <input type="button" style="width:23px;height:21px;" class="botao_calendar" onclick="displayCalendar(document.atualizaPerfil.bbp_adm_lock_log_nasc,'dd/mm/yyyy',this)"/></td>
  </tr>
  <tr>
    <td height="25" colspan="4" class="legendaLabel11"><strong><?php echo $_SESSION['MM_BBpass_Email']; ?></strong></td>
  </tr>
  <tr>
    <td height="2" colspan="4"></td>
  </tr>
  <tr>
    <td height="22" colspan="4" class="legendaLabel11"><strong>Descri&ccedil;&atilde;o</strong>:
<div style="color:#03C;margin-left:15px;">
      <textarea name="bbp_adm_lock_log_obs" id="bbp_adm_lock_log_obs" cols="90" rows="10" class="formulario2"><?php echo htmlentities($usuario->obsUsuario); ?></textarea>
      </div></td>
	<td width="3"></td>
  </tr>
  <tr>
    <td height="22" colspan="4" id="resultado">&nbsp;</td>
  </tr>
  <tr>
    <td height="3" colspan="4" align="right">
    <input name="cadastrar" onclick="voltarURL('/servicos/bbpass/home.php');" type="button" class="botaoVoltar back_input" id="cadastrar" value="&nbsp;&nbsp;&nbsp;Cancelar atualiza&ccedil;&atilde;o"/>
    
    <input name="cadastrar" onclick="enviaFORMULARIO('atualizaPerfil','resultado');" type="button" class="botaoAvancar back_input" id="cadastrar" value="&nbsp;&nbsp;&nbsp;Atualizar informa&ccedil;&otilde;es"/>
    &nbsp; </td>
  </tr>
</table>
    <input type="hidden" id="atualiza" name="atualiza" value="1" />
</form>
<?php 
/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1";
$Evento="Acessou a página de atualização de informações (Ambiente público).";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
?>