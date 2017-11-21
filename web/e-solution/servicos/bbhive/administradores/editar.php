<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/administradores/editar.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'editaAdm';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	
$codigo = -1;
if(isset($_GET['bbh_adm_codigo'])){
	$codigo = $_GET['bbh_adm_codigo'];
}

$query_administrativo = "SELECT * FROM bbh_administrativo WHERE bbh_adm_codigo = '$codigo'";
list($administrativo, $row_administrativo, $totalRows_administrativo) = executeQuery($bbhive, $database_bbhive, $query_administrativo);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editaAdm")) {

	$novonome   = ($_POST['bbh_adm_nome']);
	$novoemail  = ($_POST['bbh_adm_identificacao']);
	$novadata   = dataSQL($_POST['bbh_adm_data_nascimento']);
	$novosexo   = $_POST['bbh_adm_sexo'];
	$novocod	= $_POST['bbh_adm_codigo'];

	$query_validacao = "SELECT * FROM bbh_administrativo WHERE (bbh_adm_identificacao = '$novoemail') AND bbh_adm_codigo != $novocod";
    list($validacao, $row_validacao, $totalRows_validacao) = executeQuery($bbhive, $database_bbhive, $query_administrativo);

	if($totalRows_validacao==0){
	  $updateSQL = "UPDATE bbh_administrativo SET bbh_adm_nome = '$novonome', bbh_adm_identificacao = '$novoemail', bbh_adm_data_nascimento = '$novadata', bbh_adm_sexo = '$novosexo' WHERE bbh_adm_codigo = '$novocod'";
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	
	  $updateGoTo = "index.php";
	  
	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|administradores/index.php','menuEsquerda|conteudoGeral')</var>";
	  exit;
	  //header(sprintf("Location: %s", $insertGoTo));
	} else {
		 $Erro ="<span class='aviso' style='font-size:11;'>J&aacute; existe um administrador com o e-mail: ".$_POST['bbh_adm_identificacao']."</span>";
  		 echo "<var style='display:none'>txtSimples('erroDep', '".$Erro."')</var>";
		exit;
	}
}

?><form method="POST" name="editaAdm" id="editaAdm">
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_admNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="26" colspan="2" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/ger-administrador-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de <?php echo $_SESSION['adm_admNome']; ?>
      <div style="float:right;"><a href="#@" 

onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|administradores/index.php','menuEsquerda|colCentro');"><span 


class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</div></td>
  </tr>
  <tr>
    <td height="14" colspan="2"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/apontadireita.gif" alt="" width="4" height="8" align="absmiddle" /> Edi&ccedil;&atilde;o de <?php echo strtolower($_SESSION['adm_admNome']); ?></span></td>
  </tr>
  <tr>
    <td width="7%">&nbsp;</td>
    <td width="93%" id="erroDep">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="18%" align="right" class="color">Nome&nbsp;:</td>
        <td width="82%" height="23">&nbsp;<input name="bbh_adm_nome" type="text" class="back_input" id="bbh_adm_nome" value="<?php echo $row_administrativo['bbh_adm_nome'];  ?>" size="45" maxlength="255">
          <input type="hidden" name="bbh_adm_codigo" id="bbh_adm_codigo" value="<?php echo $row_administrativo['bbh_adm_codigo']; ?>"></td>
      </tr>
      <tr>
        <td align="right" valign="middle" class="color">E-Mail :</td>
        <td height="30" class="verdana_11_cinza">&nbsp;<input name="bbh_adm_identificacao" type="text" class="back_input" id="bbh_adm_identificacao" value="<?php echo $row_administrativo['bbh_adm_identificacao']; ?>" size="45" maxlength="255"></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">Data de nascimento :</td>
        <td height="24">&nbsp;<input name="bbh_adm_data_nascimento" type="text" class="back_input" id="bbh_adm_data_nascimento" value="<?php echo arrumadata($row_administrativo['bbh_adm_data_nascimento']); ?>" size="13" maxlength="10">
            <span class="verdana_11_cinza">(DD/MM/AAAA)</span></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">Sexo : </td>
        <td>&nbsp;<label>
              <input type="radio" name="bbh_adm_sexo" value="1" id="bbh_adm_sexo_0" <?php if($row_administrativo['bbh_adm_sexo']==1){ echo "checked "; } ?> />
              Feminino</label>
            <label>
              <input name="bbh_adm_sexo" type="radio" id="bbh_adm_sexo_1" value="0" <?php if($row_administrativo['bbh_adm_sexo']==0){ echo "checked "; } ?>/>
              Masculino</label></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="35">&nbsp;<input type="button" name="button2" id="button2" value="Cancelar" class="button" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|administradores/index.php','menuEsquerda|colCentro');">
          <input type="button" name="button" id="button" value="Editar" class="button" onclick="return validaForm('editaAdm', 'bbh_adm_nome|Preencha o campo de nome,bbh_adm_identificacao|Coloque um e-mail v&aacute;lido,bbh_adm_data_nascimento|Informe sua data de nascimento', document.getElementById('acaoForm').value)" />
            <input name="acaoForm" id="acaoForm" type="hidden" value="<?php echo $acao; ?>" />
            <input name="bbh_adm_ativo" type="hidden" id="bbh_adm_ativo" value="1" /></td>
      </tr>
      
      <tr>
        <td colspan="2" id="menLoad">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
  <input type="hidden" name="MM_update" value="editaAdm" />
</form>