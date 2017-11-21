<?php
//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbpass.php");

if(isset($_POST['atualiza'])){

	require_once("gerencia_aplicacao.php");
	$aplicacao = new aplicacao();//instância classe
	$aplicacao->bbp_adm_apl_nome 		= ($_POST['bbp_adm_apl_nome']);
	
	//if($aplicacao->verificaRepetida($database_bbpass, $bbpass)==0){
		$aplicacao->bbp_adm_apl_apelido 	= ($_POST['bbp_adm_apl_apelido']);
		$aplicacao->bbp_adm_apl_observacao 	= ($_POST['bbp_adm_apl_observacao']);
		$aplicacao->bbp_adm_apl_url 		= $_POST['bbp_adm_apl_url'];
		$aplicacao->bbp_adm_apl_ativo		= $_POST['bbp_adm_apl_ativo'];
		$aplicacao->bbp_adm_apl_icone		= $_POST['bbp_adm_apl_icone'];
		$aplicacao->cadastraDados($database_bbpass, $bbpass);//UPDATE
		
	  //Policy=================================
		$_SESSION['relevancia']="10";
		$_SESSION['nivel']="1.1.1";
		$Evento="Cadastrou a aplicação ".$aplicacao->bbp_adm_apl_apelido;
		EnviaPolicy($Evento);
	  //=======================================
	  
		  $urlRetorno = "/e-solution/servicos/bbpass/aplicacao/index.php";//retorno após procedimento de manipulação de banco
		  echo "<var style='display:none'>
				 voltarURL('$urlRetorno');
				</var>";
	/*} else {
		echo '<label style="color:#F00" class="legendaLabel11">Já existe uma aplicação com este nome</label>';
	}*/
	exit;
}
require_once("../perfil/index.php"); ?>

<table width="765" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:5px;margin-bottom:10px;">
  <tr>
    <td width="4" height="37" align="left" background="/e-solution/servicos/bbpass/images/canto_esquerdo.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6"><strong>Cadastro de aplica&ccedil;&otilde;es</strong></td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="left" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;border-bottom:#DCDFE1 solid 1px;">
<form action="/e-solution/servicos/bbpass/aplicacao/novo.php" method="post" id="atualizaPerfil" name="atualizaPerfil">
    <table width="580" border="0" cellspacing="0" cellpadding="0" class="fonteDestaque" align="center" style="margin-top:10px;">
  <tr>
    <td width="158" height="25" align="right" class="legendaLabel11"><strong>Nome da aplica&ccedil;&atilde;o</strong> :&nbsp;</td>
    <td width="422" height="25"><input name="bbp_adm_apl_nome" type="text" class="back_Campos" id="bbp_adm_apl_nome" size="50"/></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Apelido da aplica&ccedil;&atilde;o</strong> :&nbsp;</td>
    <td height="25"><input name="bbp_adm_apl_apelido" type="text" class="back_Campos" id="bbp_adm_apl_apelido" size="40"/></td>
    </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Url de acesso </strong>:&nbsp;</td>
    <td height="25"><input name="bbp_adm_apl_url" type="text" class="back_Campos" id="bbp_adm_apl_url" size="68"/></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Aplica&ccedil;&atilde;o ativa</strong> :&nbsp;</td>
    <td height="25"><label>
      <select name="bbp_adm_apl_ativo" id="bbp_adm_apl_ativo" class="back_Campos">
        <option value="1">Sim</option>
        <option value="0">N&atilde;o</option>
      </select>
    </label></td>
  </tr>
  <tr>
    <td height="25" align="right" valign="top" class="legendaLabel11"><strong>Observa&ccedil;&atilde;o</strong> :&nbsp;</td>
    <td height="25"><textarea name="bbp_adm_apl_observacao" id="bbp_adm_apl_observacao" cols="78" rows="6" class="formulario2"></textarea></td>
  </tr>
  <tr>
    <td height="10" colspan="2" id="resultado3"></td>
  </tr>
  <tr>
    <td height="25" align="right" valign="top" class="legendaLabel11"><strong>&Iacute;cone padr&atilde;o</strong> :&nbsp;</td>
    <td height="22" id="resultado2"><?php require_once("icones.php"); ?></td>
  </tr>
  <tr>
    <td height="22" colspan="2" id="resultado">&nbsp;</td>
  </tr>
  <tr>
    <td height="3" colspan="2" align="right">
    <input name="cadastrar" onclick="voltarURL('/e-solution/servicos/bbpass/aplicacao/index.php');" type="button" class="botaoVoltar back_input" id="cadastrar" value="&nbsp;&nbsp;&nbsp;Cancelar cadastro"/>
    
    <input name="cadastrar" type="button" class="botaoAvancar back_input" id="cadastrar" value="&nbsp;Cadastrar aplica&ccedil;&atilde;o" onclick="if(document.getElementById('bbp_adm_apl_nome').value=='' || document.getElementById('bbp_adm_apl_apelido').value==''){alert('Informe o nome e apelido da aplicação.');}else{enviaFORMULARIO('atualizaPerfil','resultado');}" />
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
$Evento="Acessou a página de cadastro de aplicações.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
?>