<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/administradores/novo.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'cadastraAdm';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cadastraAdm")) {

	$novoemail = $_POST['bbh_adm_identificacao'];

	$query_validacao = "SELECT * FROM bbh_administrativo WHERE bbh_adm_identificacao = '$novoemail'";
    list($validacao, $row_validacao, $totalRows_validacao) = executeQuery($bbhive, $database_bbhive, $query_validacao);

	if($totalRows_validacao==0){
	  $insertSQL = sprintf("INSERT INTO bbh_administrativo (bbh_adm_nome, bbh_adm_identificacao, bbh_adm_data_nascimento, bbh_adm_sexo, bbh_adm_ativo) VALUES (%s, %s, %s, %s, %s)",
						   GetSQLValueString($bbhive, ($_POST['bbh_adm_nome']), "text"),
						   GetSQLValueString($bbhive, ($_POST['bbh_adm_identificacao']), "text"),
						   GetSQLValueString($bbhive, dataSQL($_POST['bbh_adm_data_nascimento']), "date"),
						   GetSQLValueString($bbhive, $_POST['bbh_adm_sexo'], "text"),
						   GetSQLValueString($bbhive, $_POST['bbh_adm_ativo'], "int"));

        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
	
	  $insertGoTo = "index.php";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  
	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|administradores/index.php','menuEsquerda|conteudoGeral')</var>";
	  exit;
	  //header(sprintf("Location: %s", $insertGoTo));
	} else {
		 $Erro ="<span class='aviso' style='font-size:11;'>J&aacute; existe um administrador com o e-mail: ".$_POST['bbh_adm_identificacao']."</span>";
  		 echo "<var style='display:none'>txtSimples('erroDep', '".$Erro."')</var>";
		exit;
	}
}

?><form method="POST" name="cadastraAdm" id="cadastraAdm">
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_admNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="26" colspan="2" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-administrador-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de <?php echo $_SESSION['adm_admNome']; ?>
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

src="/e-solution/servicos/bbhive/images/apontadireita.gif" alt="" width="4" height="8" align="absmiddle" /> Cria&ccedil;&atilde;o de <?php echo strtolower($_SESSION['adm_admNome']); ?></span></td>
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
        <td width="82%" height="24">&nbsp;
          <input class="back_input" name="bbh_adm_nome" type="text" id="bbh_adm_nome" size="45" maxlength="255"></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">E-Mail :</td>
        <td height="24">&nbsp;
          <input class="back_input" name="bbh_adm_identificacao" type="text" id="bbh_adm_identificacao" size="45" maxlength="255"></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">Data de nascimento :</td>
        <td height="24">&nbsp;
          <input class="back_input" name="bbh_adm_data_nascimento" type="text" id="bbh_adm_data_nascimento" size="13" maxlength="10"> 
          <span class="verdana_11_cinza">(DD/MM/AAAA)</span></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">Sexo : </td>
        <td>&nbsp;<label><input type="radio" name="bbh_adm_sexo" value="1" id="bbh_adm_sexo_0" /> Feminino</label> <label><input name="bbh_adm_sexo" type="radio" id="bbh_adm_sexo_1" value="0" checked/> 
        Masculino</label></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="35">&nbsp;<input type="button" name="button2" id="button2" value="Cancelar" class="button" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|administradores/index.php','menuEsquerda|colCentro');" /> 
          <input type="button" name="button" id="button" value="Cadastrar" class="button" onclick="return validaForm('cadastraAdm', 'bbh_adm_nome|Preencha o campo de nome,bbh_adm_identificacao|Coloque um e-mail v&aacute;lido,bbh_adm_data_nascimento|Informe sua data de nascimento', document.getElementById('acaoForm').value)" />
          <input name="bbh_adm_ativo" type="hidden" id="bbh_adm_ativo" value="1" />
          <input name="acaoForm" id="acaoForm" type="hidden" value="<?php echo $acao; ?>" /></td>
      </tr>
      
      <tr>
        <td colspan="2" id="menLoad">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
  <input type="hidden" name="MM_insert" value="cadastraAdm" />
</form>