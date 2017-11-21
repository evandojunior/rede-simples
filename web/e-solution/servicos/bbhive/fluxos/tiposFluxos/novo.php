<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/fluxos/tiposFluxos/novo.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'cadastraTipo';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cadastraTipo")) {

	$novoid   = ($_POST['bbh_tip_flu_identificacao']);
	$novonome = ($_POST['bbh_tip_flu_nome']);

	$query_validacao = "SELECT * FROM bbh_tipo_fluxo WHERE bbh_tip_flu_identificacao = '$novoid'";
    list($validacao, $row_validacao, $totalRows_validacao) = executeQuery($bbhive, $database_bbhive, $query_validacao);

	if($totalRows_validacao==0){
	  $insertSQL = sprintf("INSERT INTO bbh_tipo_fluxo (bbh_tip_flu_identificacao, bbh_tip_flu_nome, bbh_tip_flu_observacao) VALUES (%s, %s, %s)",
						   GetSQLValueString($bbhive, ($_POST['bbh_tip_flu_identificacao']), "text"),
						   GetSQLValueString($bbhive, ($_POST['bbh_tip_flu_nome']), "text"),
						   GetSQLValueString($bbhive, ($_POST['bbh_tip_flu_observacao']), "text"));
	  list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
	
	  $insertGoTo = "index.php";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  
	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|fluxos/tiposFluxos/tipos.php','menuEsquerda|conteudoGeral')</var>";
	  exit;
	  //header(sprintf("Location: %s", $insertGoTo));
	} else {
		 $Erro ="<span class='aviso' style='font-size:11;'>J&aacute; existe um tipo de fluxo com a denomina&ccedil;&atilde;o: ".$_POST['bbh_tip_flu_identificacao']."</span>";
		 		 
  		 echo "<var style='display:none'>txtSimples('erroDep', '".$Erro."')</var>";
		exit;
	}
}

?><form method="POST" name="cadastraTipo" id="cadastraTipo">
<var style="display:none">txtSimples('tagPerfil', 'Tipos de Fluxos')</var>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
  <tr>
    <td height="26" colspan="2" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/ger-tipofluxo-16px.gif" width="14" height="16" align="absmiddle" /> Gerenciamento de Tipo de <?php echo $_SESSION['adm_FluxoNome']; ?>
      <div style="float:right;"><a href="#" 

onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|fluxos/tiposFluxos/tipos.php','menuEsquerda|colCentro');"><span 

class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</div></td>
  </tr>
  <tr>
    <td height="14" colspan="2"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/apontadireita.gif" alt="" width="4" height="8" align="absmiddle" /> Cria&ccedil;&atilde;o de Tipos de <?php echo $_SESSION['adm_FluxoNome']; ?></span></td>
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
        <td align="right" class="color">N. de Identifica&ccedil;&atilde;o :</td>
        <td height="15">&nbsp;<input class="back_Campos" name="bbh_tip_flu_identificacao" type="text" id="bbh_tip_flu_identificacao" size="25" maxlength="255"> 
        <span class="verdana_9_cinza">Ex: 01 ou 02.03 ou 25.03</span></td>
      </tr>
      <tr>
        <td width="18%" align="right" class="color">Nome&nbsp;:</td>
        <td width="82%" height="30">&nbsp;<input class="back_Campos" name="bbh_tip_flu_nome" type="text" id="bbh_tip_flu_nome" size="45" maxlength="255"></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">Descri&ccedil;&atilde;o&nbsp;:</td>
        <td>&nbsp;<textarea class="formulario2" name="bbh_tip_flu_observacao" id="bbh_tip_flu_observacao" cols="44" rows="7"><?php if(isset($_POST['bbh_tip_flu_observacao'])){ echo $_POST['bbh_tip_flu_observacao']; }?></textarea>          </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="35">&nbsp;<input type="button" name="button2" id="button2" value="Cancelar" class="button" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|fluxos/tiposFluxos/tipos.php','menuEsquerda|colCentro');" /> 
          <input type="button" name="button" id="button" value="Cadastrar" class="button" onClick="return validaForm('cadastraTipo', 'bbh_tip_flu_nome|Preencha um nome,bbh_tip_flu_identificacao|Preencha um n&uacute;mero de identifica&ccedil;&atilde;o.', document.getElementById('acaoForm').value)"><input name="acaoForm" id="acaoForm" type="hidden" value="<?php echo $acao; ?>" /></td>
      </tr>
      
      <tr>
        <td colspan="2" id="menLoad">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
  <input type="hidden" name="MM_insert" value="cadastraTipo" />
</form>
