<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


	$onClick = "LoadSimultaneo('perfil/index.php?perfil=2|mensagens/index.php','menuEsquerda|conteudoGeral');";
	
	if(isset($_GET['back'])){
		$cdg = isset($_GET['cdg'])?$_GET['cdg']:0;
		$voltar  = substr($_GET['back'],28)."?".$cdg;
		$onClick = "LoadSimultaneo('perfil/index.php?perfil=2|".$voltar."','menuEsquerda|conteudoGeral');";
	}

	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/mensagens/mensagem.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'formMSG';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	

if ((isset($_POST['bbh_men_codigo'])) && ($_POST['bbh_men_codigo'] != "")) {
	  $deleteSQL = "DELETE FROM bbh_mensagens WHERE bbh_men_codigo = ".$_POST['bbh_men_codigo'];
	  list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);
	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|mensagens/index.php','menuEsquerda|conteudoGeral')</var>";
		  exit;
}

$codMens = -1;
if(isset($_GET['bbh_men_codigo'])){
	$codMens = $_GET['bbh_men_codigo'];
}

$query_mensagens = "SELECT bbh_fluxo.bbh_flu_titulo, bbh_usuario.bbh_usu_nome, bbh_usuario.bbh_usu_codigo, bbh_mensagens.* FROM bbh_mensagens INNER JOIN bbh_usuario ON bbh_usuario.bbh_usu_codigo = bbh_mensagens.bbh_usu_codigo_destin LEFT JOIN bbh_fluxo ON bbh_fluxo.bbh_flu_codigo = bbh_mensagens.bbh_flu_codigo WHERE bbh_men_codigo = $codMens";
list($mensagens, $row_mensagens, $totalRows_mensagens) = executeQuery($bbhive, $database_bbhive, $query_mensagens);

$query_remet = "SELECT bbh_usuario.bbh_usu_nome, bbh_usuario.bbh_usu_codigo, bbh_mensagens.* FROM bbh_mensagens INNER JOIN bbh_usuario ON bbh_usuario.bbh_usu_codigo = bbh_mensagens.bbh_usu_codigo_remet WHERE bbh_men_codigo = $codMens";
list($remet, $row_remet, $totalRows_remet) = executeQuery($bbhive, $database_bbhive, $query_remet);
$codDestin = $row_mensagens['bbh_usu_codigo'];

$query_deptoDestin = "SELECT bbh_dep_nome FROM bbh_departamento INNER JOIN bbh_usuario ON bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo WHERE bbh_usu_codigo = $codDestin";
list($deptoDestin, $row_deptoDestin, $totalRows_deptoDestin) = executeQuery($bbhive, $database_bbhive, $query_deptoDestin);

$codRemet = $row_remet['bbh_usu_codigo'];

$query_deptoRemet = "SELECT bbh_dep_nome FROM bbh_departamento INNER JOIN bbh_usuario ON bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo WHERE bbh_usu_codigo = $codRemet";
list($deptoRemet, $row_deptoRemet, $totalRows_deptoRemet) = executeQuery($bbhive, $database_bbhive, $query_deptoRemet);
?>
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_MsgNome']; ?>')</var>
<form id="formMSG" name="formMSG">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td width="75%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-mensagens-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de <?php echo $_SESSION['adm_MsgNome']; ?></td>
    <td width="21%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onclick="<?php echo $onClick; ?>"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="2"></td>
  </tr>
  <tr>
    <td height="21" colspan="2"><img src="/e-solution/servicos/bbhive/images/marcador.gif" alt="" width="4" height="6" align="absmiddle" /> <strong>Informa&ccedil;&otilde;es sobre a mensagem:</strong></td>
  </tr>
  <tr>
    <td colspan="2">-  Mensagem de <strong class="color"><?php echo $row_remet['bbh_usu_nome']; ?></strong> para <strong class="color"><?php echo $row_mensagens['bbh_usu_nome']; ?></strong>, &agrave;s <?php echo substr($row_mensagens['bbh_men_data_recebida'],10)." no dia ". arrumadata(substr($row_mensagens['bbh_men_data_recebida'],0,10)); ?></td>
  </tr>
  <tr>
    <td height="18" colspan="2">- <?php echo $row_remet['bbh_usu_nome']; ?> do depto. <strong class="color"><?php echo $row_deptoRemet['bbh_dep_nome']; ?></strong> e <?php echo $row_mensagens['bbh_usu_nome']; ?> do depto. <strong class="color"><?php echo $row_deptoDestin['bbh_dep_nome']; ?></strong></td>
  </tr>
  <?php if($row_mensagens['bbh_flu_codigo']>0){ ?>
  <tr>
    <td colspan="2">-  Mensagem referente ao <?php echo $_SESSION['adm_FluxoNome']; ?> <strong class="color"><?php echo $row_mensagens['bbh_flu_titulo']; ?></strong></td>
  </tr>
  <?php } ?>
  <tr>
    <td height="21" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="76%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px solid #999999">
      <tr style="background-image:url(/e-solution/servicos/bbhive/images/barra_horizontal2.jpg)">
        <td width="3%">&nbsp;</td>
        <td width="94%"><span style="font-weight:bold; font-size:15px; margin-left:20px;"><span class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/msgs.gif" alt="" width="11" height="11" align="absmiddle" /></span> <?php echo $row_mensagens['bbh_men_assunto']; ?></span></td>
        <td width="3%" height="30">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td id="menLoad"><input name="bbh_men_codigo" type="hidden" id="bbh_men_codigo" value="<?php echo $row_mensagens['bbh_men_codigo']; ?>" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="250" valign="top"><?php echo nl2br($row_mensagens['bbh_men_mensagem']); ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style="border-top:1px solid #EFEFDE;">&nbsp;</td>
        <td height="26" align="right" style="border-top:1px solid #EFEFDE;"><input style="background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" type="button" class="button" name="button" id="button" value="Excluir definitivamente" onclick="javascript: if(confirm('Essa a&ccedil;&atilde;o n&atilde;o poder&aacute; ser desfeita! Quer mesmo excluir?')){ return <?php echo $acao; ?> };" /></td>
        <td style="border-top:1px solid #EFEFDE;">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
</form>
