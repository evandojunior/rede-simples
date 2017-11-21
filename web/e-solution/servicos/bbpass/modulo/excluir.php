<?php
//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbpass.php");
require_once("gerencia_modulo.php");

if(isset($_POST['atualiza'])){
	$modulo = new Modulo();//instância classe

	$modulo->bbp_adm_loc_codigo		= $_POST['bbp_adm_loc_codigo'];
	$modulo->excluiDados($database_bbpass, $bbpass);//DELETE
	
	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="5";
	$_SESSION['nivel']="2.3.1";
	$Evento="Excluiu o módulo ".$_POST['bbp_adm_loc_nome'];
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/
	
		  $urlRetorno = "/e-solution/servicos/bbpass/modulo/index.php";//retorno após procedimento de manipulação de banco
		  echo "<var style='display:none'>
				 voltarURL('$urlRetorno');
				</var>";
	/*} else {
		echo '<label style="color:#F00" class="legendaLabel11">Já existe uma aplicação com este nome</label>';
	}*/
	exit;
}
$infModulo = new Modulo();
$infModulo->dadosModulo($database_bbpass, $bbpass, $_GET['bbp_adm_loc_codigo']);
require_once("../perfil/index.php"); ?>
<table width="765" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:5px;margin-bottom:10px;">
  <tr>
    <td width="4" height="37" align="left" background="/e-solution/servicos/bbpass/images/canto_esquerdo.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6"><strong>Exclus&atilde;o do m&oacute;dulo</strong></td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="left" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;border-bottom:#DCDFE1 solid 1px;">
<form action="/e-solution/servicos/bbpass/modulo/excluir.php" method="post" id="atualizaPerfil" name="atualizaPerfil">
    <table width="580" border="0" cellspacing="0" cellpadding="0" class="fonteDestaque" align="center" style="margin-top:10px;">
  <tr>
    <td width="158" height="25" align="right" class="legendaLabel11"><strong>Nome do m&oacute;dulo</strong> :&nbsp;</td>
    <td width="422" height="25"><input name="bbp_adm_loc_nome" type="text" class="back_Campos" id="bbp_adm_loc_nome" size="50" value="<?php echo $infModulo->bbp_adm_loc_nome; ?>" disabled="disabled"/><input type="hidden" name="bbp_adm_loc_codigo" id="bbp_adm_loc_codigo" value="<?php echo $infModulo->bbp_adm_loc_codigo; ?>"/></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Nome do arquivo</strong> :&nbsp;</td>
    <td height="25"><input name="bbp_adm_loc_arquivo" type="text" class="back_Campos" id="bbp_adm_loc_arquivo" size="40" value="<?php echo $infModulo->bbp_adm_loc_arquivo; ?>" disabled="disabled"/></td>
    </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Diret&oacute;rio de acesso </strong>:&nbsp;</td>
    <td height="25"><input name="bbp_adm_loc_diretorio" type="text" class="back_Campos" id="bbp_adm_loc_diretorio" size="30" value="<?php echo $infModulo->bbp_adm_loc_diretorio; ?>" disabled="disabled"/></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>M&oacute;dulo ativo</strong> :&nbsp;</td>
    <td height="25"><label>
      <select name="bbp_adm_loc_ativo" id="bbp_adm_loc_ativo" class="back_Campos" disabled="disabled">
        <option value="1" <?php if($infModulo->bbp_adm_loc_ativo=="1"){echo "selected='selected'";}?>>Sim</option>
        <option value="0" <?php if($infModulo->bbp_adm_loc_ativo=="0"){echo "selected='selected'";}?>>N&atilde;o</option>
      </select>
    </label></td>
  </tr>
  <tr>
    <td height="25" align="right" valign="top" class="legendaLabel11"><strong>Observa&ccedil;&atilde;o</strong> :&nbsp;</td>
    <td height="25"><textarea name="bbp_adm_loc_observacao" id="bbp_adm_loc_observacao" cols="78" rows="6" class="formulario2" disabled="disabled"> <?php echo $infModulo->bbp_adm_loc_observacao; ?></textarea></td>
  </tr>
  <tr>
    <td height="10" colspan="2" id="resultado3"></td>
  </tr>
  <tr>
    <td height="25" align="right" valign="top" class="legendaLabel11"><strong>&Iacute;cone padr&atilde;o</strong> :&nbsp;</td>
    <td height="22" id="resultado2"><?php 
	$nmIcone = $infModulo->bbp_adm_loc_icone; 
	require_once("icones.php"); ?></td>
  </tr>
  <tr>
    <td height="22" colspan="2" id="resultado">&nbsp;</td>
  </tr>
  <tr>
    <td height="3" colspan="2" align="right">
    <input name="cadastrar" onclick="voltarURL('/e-solution/servicos/bbpass/modulo/index.php');" type="button" class="botaoVoltar back_input" id="cadastrar" value="&nbsp;&nbsp;&nbsp;Cancelar exclus&atilde;o"/>
    
    <input name="cadastrar" type="button" class="botaoAvancar back_input" id="cadastrar" value="&nbsp;Excluir m&oacute;dulo"  onclick="if(confirm('Tem certeza que deseja excluir este módulo?\nEm caso de confirmação clique em Ok.')){enviaFORMULARIO('atualizaPerfil','resultado');}" />
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
	$_SESSION['nivel']="2.3";
	$Evento="Acessou a página de exclusão do módulo ".$infModulo->bbp_adm_loc_nome.".";
	EnviaPolicy($Evento);

/*===============================FIM AUDITORIA POLICY============================================*/
?>