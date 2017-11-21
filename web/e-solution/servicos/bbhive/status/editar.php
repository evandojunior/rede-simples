<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/status/editar.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'editaStatus';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	
$codigo = -1;
if(isset($_GET['bbh_sta_ati_codigo'])){
	$codigo = $_GET['bbh_sta_ati_codigo'];
}

$query_status = "SELECT * FROM bbh_status_atividade WHERE bbh_sta_ati_codigo = '$codigo'";
list($status, $row_status, $totalRows_status) = executeQuery($bbhive, $database_bbhive, $query_status);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editaStatus")) {

	$novonome = ($_POST['bbh_sta_ati_nome']);
	$novaobs  = ($_POST['bbh_sta_ati_observacao']);
	$novocod  = $_POST['bbh_sta_ati_codigo'];
	$novopeso = $_POST['bbh_sta_ati_peso'];

	$query_validacao = "SELECT * FROM bbh_status_atividade WHERE (bbh_sta_ati_nome = '$novonome' OR bbh_sta_ati_peso = '$novopeso') AND bbh_sta_ati_codigo != $novocod";
    list($validacao, $row_validacao, $totalRows_validacao) = executeQuery($bbhive, $database_bbhive, $query_validacao);

	if($totalRows_validacao==0){
	  $updateSQL = "UPDATE bbh_status_atividade SET bbh_sta_ati_nome = '$novonome', bbh_sta_ati_observacao = '$novaobs', bbh_sta_ati_peso = '$novopeso' WHERE bbh_sta_ati_codigo = $novocod";
	  list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	
	  $updateGoTo = "index.php";
	  //if (isset($_SERVER['QUERY_STRING'])) {
		//$updateGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		//$updateGoTo .= $_SERVER['QUERY_STRING'];
	  //}
	  
	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|status/index.php','menuEsquerda|conteudoGeral')</var>";
	  exit;
	  //header(sprintf("Location: %s", $insertGoTo));
	} else {
		 $Erro = "<span class='aviso' style='font-size:11;'>J&aacute; existe um status com a denomina&ccedil;&atilde;o ".$_POST['bbh_sta_ati_nome']." ou com o peso ".$_POST['bbh_sta_ati_peso']."</span>";
  		 echo "<var style='display:none'>txtSimples('erroDep', '".$Erro."')</var>";
		exit;
	}
}

?><form method="POST" name="editaStatus" id="editaStatus">
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_statusNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="26" colspan="2" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/ger-status-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de <?php echo strtolower($_SESSION['adm_statusNome']); ?>
      <div style="float:right;"><a href="#@" 

onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|status/index.php','menuEsquerda|colCentro');"><span 


class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</div></td>
  </tr>
  <tr>
    <td height="14" colspan="2"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/apontadireita.gif" alt="" width="4" height="8" align="absmiddle" /> Edi&ccedil;&atilde;o de <?php echo strtolower($_SESSION['adm_statusNome']); ?></span></td>
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
        <td width="82%" height="23">&nbsp;<input name="bbh_sta_ati_nome" type="text" class="back_Campos" id="bbh_sta_ati_nome" value="<?php echo $row_status['bbh_sta_ati_nome'];  ?>" size="45" maxlength="255">
          <input type="hidden" name="bbh_sta_ati_codigo" id="bbh_sta_ati_codigo" value="<?php echo $row_status['bbh_sta_ati_codigo']; ?>"></td>
      </tr>
      <tr>
        <td align="right" valign="middle" class="color">Peso :</td>
        <td height="30" class="verdana_11_cinza">&nbsp;
            <input name="bbh_sta_ati_peso" type="text" class="back_Campos" id="bbh_sta_ati_peso" value="<?php echo $row_status['bbh_sta_ati_peso']; ?>" size="5" maxlength="2">
          (digite um n&uacute;mero de 1 a 99)</td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">Descri&ccedil;&atilde;o&nbsp;:</td>
        <td>&nbsp;<textarea class="formulario2" name="bbh_sta_ati_observacao" id="bbh_sta_ati_observacao" cols="44" rows="7"><?php if(isset($_POST['bbh_sta_ati_observacao'])){ echo $_POST['bbh_sta_ati_observacao']; } else { echo $row_status['bbh_sta_ati_observacao']; }?></textarea>          </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="35">&nbsp;<input type="button" name="button2" id="button2" value="Cancelar" class="button" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|status/index.php','menuEsquerda|colCentro');">
          <input type="button" name="button" id="button" value="Editar" class="button" onclick="return validaForm('editaStatus', 'bbh_sta_ati_nome|Preencha o nome do status,bbh_sta_ati_peso|Preencha o campo de peso', document.getElementById('acaoForm').value)" />
            <input name="acaoForm" id="acaoForm" type="hidden" value="<?php echo $acao; ?>" /></td>
      </tr>
      
      <tr>
        <td colspan="2" id="menLoad">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
  <input type="hidden" name="MM_update" value="editaStatus" />
</form>