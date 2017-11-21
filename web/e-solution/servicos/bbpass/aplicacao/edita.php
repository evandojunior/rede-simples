<?php
//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbpass.php");
require_once("gerencia_aplicacao.php");

if(isset($_POST['atualiza'])){
	$aplicacao = new aplicacao();//instância classe
	$aplicacao->bbp_adm_apl_nome 		= ($_POST['bbp_adm_apl_nome']);
	
	$aplicacao->bbp_adm_apl_codigo		= $_POST['bbp_adm_apl_codigo'];
	$aplicacao->bbp_adm_apl_apelido 	= ($_POST['bbp_adm_apl_apelido']);
	$aplicacao->bbp_adm_apl_observacao 	= ($_POST['bbp_adm_apl_observacao']);
	$aplicacao->bbp_adm_apl_url 		= $_POST['bbp_adm_apl_url'];
	$aplicacao->bbp_adm_apl_ativo		= $_POST['bbp_adm_apl_ativo'];
	$aplicacao->bbp_adm_apl_icone		= $_POST['bbp_adm_apl_icone'];
	$aplicacao->atualizaDados($database_bbpass, $bbpass);//UPDATE
  
   //Policy=================================
		$_SESSION['relevancia']="5";
		$_SESSION['nivel']="1.2.1";
		$Evento="Alterou informações da aplicação ".$aplicacao->bbp_adm_apl_apelido;
		EnviaPolicy($Evento);
	  //=======================================
  
	  $urlRetorno = "/e-solution/servicos/bbpass/aplicacao/index.php";//retorno após procedimento de manipulação de banco
	  echo "<var style='display:none'>
			 voltarURL('$urlRetorno');
			</var>";
	exit;
}
$infAplicacao = new aplicacao();
$infAplicacao->dadosAplicacao($database_bbpass, $bbpass, $_GET['bbp_adm_apl_codigo']);

require_once("../perfil/index.php"); ?>
<table width="765" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:5px;margin-bottom:10px;">
  <tr>
    <td width="4" height="37" align="left" background="/e-solution/servicos/bbpass/images/canto_esquerdo.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6"><strong>Edi&ccedil;&atilde;o de dados da aplica&ccedil;&atilde;o</strong></td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="left" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;border-bottom:#DCDFE1 solid 1px;">
<form action="/e-solution/servicos/bbpass/aplicacao/edita.php" method="post" id="atualizaPerfil" name="atualizaPerfil">
    <table width="580" border="0" cellspacing="0" cellpadding="0" class="fonteDestaque" align="center" style="margin-top:10px;">
  <tr>
    <td width="158" height="25" align="right" class="legendaLabel11"><strong>Nome da aplica&ccedil;&atilde;o</strong> :&nbsp;</td>
    <td width="422" height="25"><input name="bbp_adm_apl_nome" type="text" class="back_Campos" id="bbp_adm_apl_nome" size="50" value="<?php echo $infAplicacao->bbp_adm_apl_nome; ?>"/>
      <input type="hidden" name="bbp_adm_apl_codigo" id="bbp_adm_apl_codigo" value="<?php echo $infAplicacao->bbp_adm_apl_codigo; ?>"/></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Apelido da aplica&ccedil;&atilde;o</strong> :&nbsp;</td>
    <td height="25"><input name="bbp_adm_apl_apelido" type="text" class="back_Campos" id="bbp_adm_apl_apelido" size="40" value="<?php echo $infAplicacao->bbp_adm_apl_apelido; ?>"/></td>
    </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Url de acesso </strong>:&nbsp;</td>
    <td height="25"><input name="bbp_adm_apl_url" type="text" class="back_Campos" id="bbp_adm_apl_url" size="68" value="<?php echo $infAplicacao->bbp_adm_apl_url; ?>"/></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Aplica&ccedil;&atilde;o ativa</strong> :&nbsp;</td>
    <td height="25"><label>
      <select name="bbp_adm_apl_ativo" id="bbp_adm_apl_ativo" class="back_Campos">
        <option value="1" <?php if($infAplicacao->bbp_adm_apl_ativo=="1"){echo "selected='selected'";}?>>Sim</option>
        <option value="0" <?php if($infAplicacao->bbp_adm_apl_ativo=="0"){echo "selected='selected'";}?>>N&atilde;o</option>
      </select>
    </label></td>
  </tr>
  <tr>
    <td height="25" align="right" valign="top" class="legendaLabel11"><strong>Observa&ccedil;&atilde;o</strong> :&nbsp;</td>
    <td height="25"><textarea name="bbp_adm_apl_observacao" id="bbp_adm_apl_observacao" cols="78" rows="6" class="formulario2"><?php echo $infAplicacao->bbp_adm_apl_observacao; ?></textarea></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr>
    <td height="25" align="right" valign="top" class="legendaLabel11"><strong>&Iacute;cone padr&atilde;o</strong> :&nbsp;</td>
    <td height="22"><?php 
	$nmIcone = $infAplicacao->bbp_adm_apl_icone; 
	require_once("icones.php"); ?></td>
  </tr>
  <tr>
    <td height="22" colspan="2" id="resultado">&nbsp;</td>
  </tr>
  <tr>
    <td height="3" colspan="2" align="right">
    <input name="cadastrar" onclick="voltarURL('/e-solution/servicos/bbpass/aplicacao/index.php');" type="button" class="botaoVoltar back_input" id="cadastrar" value="&nbsp;&nbsp;&nbsp;Cancelar atualiza&ccedil;&atilde;o"/>
    
    <input name="cadastrar" type="button" class="botaoAvancar back_input" id="cadastrar" value="&nbsp;Atualizar aplica&ccedil;&atilde;o" onclick="if(document.getElementById('bbp_adm_apl_nome').value=='' || document.getElementById('bbp_adm_apl_apelido').value==''){alert('Informe o nome e apelido da aplicação.');}else{enviaFORMULARIO('atualizaPerfil','resultado');}" />
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
$_SESSION['nivel']="1.2";
$Evento="Acessou a página de edição da aplicação ".$infAplicacao->bbp_adm_apl_apelido.".";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
?>
