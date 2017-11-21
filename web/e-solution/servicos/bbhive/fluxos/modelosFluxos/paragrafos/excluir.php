<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/paragrafos/excluir.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'excluiTit';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";

	$query_administrador = "SELECT bbh_adm_codigo, bbh_adm_nome FROM bbh_administrativo WHERE bbh_adm_codigo = '".$_SESSION['es_usuCod']."'";
    list($administrador, $row_administrador, $totalRows_administrador) = executeQuery($bbhive, $database_bbhive, $query_administrador);
	
	if ((isset($_POST['bbh_mod_par_codigo'])) && ($_POST['bbh_mod_par_codigo'] != "")) {

	  $deleteSQL = "DELETE FROM bbh_modelo_paragrafo WHERE bbh_mod_par_codigo = ".$_POST['bbh_mod_par_codigo'];
	  list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);

	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|fluxos/modelosFluxos/paragrafos/index.php?bbh_mod_flu_codigo=".$_POST['bbh_mod_flu_codigo']."','menuEsquerda|conteudoGeral')</var>";
	  exit;
	  //header(sprintf("Location: %s", $insertGoTo));
	}else{
	
	$codPar = -1;
	if(isset($_GET['bbh_mod_par_codigo'])){
		$codPar = $_GET['bbh_mod_par_codigo'];
	}

	$query_modFluxos = "select count(bbh_mod_ati_codigo) as total FROM bbh_modelo_atividade Where bbh_mod_flu_codigo = ".$_GET['bbh_mod_flu_codigo'];
	list($modFluxos, $row_modFluxos, $totalRows_modFluxos) = executeQuery($bbhive, $database_bbhive, $query_modFluxos);

	$query_paragrafos = "SELECT * FROM bbh_modelo_paragrafo WHERE bbh_mod_par_codigo = $codPar";
	list($paragrafos, $row_paragrafos, $totalRows_paragrafos) = executeQuery($bbhive, $database_bbhive, $query_paragrafos);

	$query_administrador = "SELECT bbh_adm_nome FROM bbh_modelo_paragrafo
INNER JOIN bbh_administrativo ON bbh_administrativo.bbh_adm_codigo = bbh_modelo_paragrafo.bbh_adm_codigo WHERE bbh_mod_par_codigo = $codPar";
	list($administrador, $row_administrador, $totalRows_administrador) = executeQuery($bbhive, $database_bbhive, $query_administrador);

	$query_usuautor = "SELECT bbh_usu_nome FROM bbh_modelo_paragrafo INNER JOIN bbh_usuario ON bbh_usuario.bbh_usu_codigo = bbh_modelo_paragrafo.bbh_usu_autor WHERE bbh_mod_par_codigo = $codPar";
	list($usuautor, $row_usuautor, $totalRows_usuautor) = executeQuery($bbhive, $database_bbhive, $query_usuautor);
	
	if($totalRows_usuautor==0){
		$Erro = "&nbsp;<span class='aviso'>Aten&ccedil;&atilde;o! S&oacute; exclua o par&aacute;grafo se estiver certo disso! Essa a&ccedil;&atilde;o n&atilde;o poder&aacute; ser desfeita!</span>";
	}else{
		$Erro = "&nbsp;<span class='aviso'>Voc&ecirc; n&atilde;o pode excluir este par&aacute;grafo porque ele &eacute; privado.</span>";
	}
  	echo "<var style='display:none'>txtSimples('erroTit', '".$Erro."')</var>";
}

?>
<var style="display:none">txtSimples('tagPerfil', 'Modelos de par&aacute;grafos')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td width="55%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-fluxo-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de textos pr&eacute;-definidos</td>
    <td width="32%" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/paragrafos/index.php?bbh_mod_flu_codigo=<?php if(!isset($_POST['bbh_mod_flu_codigo'])){echo $_GET['bbh_mod_flu_codigo']; }else{ echo $_POST['bbh_mod_flu_codigo']; } ?>','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="3"></td>
  </tr>
</table>
<?php require_once('../modelosAtividades/cabecaModelo.php'); ?>
<form id="excluiTit" name="excluiTit" method="post">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10" style="border:1px outset #999999; margin-top:6px">
  <tr>
    <td height="24" colspan="2" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><strong>&nbsp;Exclus&atilde;o de textos pr&eacute;-definidos</strong></td>
    </tr>
    <tr>
      <td height="24" colspan="2" id="erroTit">&nbsp;</td>
  </tr>
    <tr>
      <td height="18" align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="18" align="right"><strong>Autor :</strong></td>
      <td>&nbsp;&nbsp;<?php if($totalRows_usuautor!=0){ echo $row_usuautor['bbh_usu_nome']; }else{ echo $row_administrador['bbh_adm_nome']; } ?></td>
    </tr>
    <tr>
      <td width="50" align="right"><strong>Nome :</strong></td>
      <td width="543">&nbsp; <input disabled name="bbh_mod_par_nome" type="text" class="back_Campos" id="bbh_mod_par_nome" value="<?php echo $row_paragrafos['bbh_mod_par_nome']; ?>" size="40">
      <input name="bbh_mod_par_codigo" type="hidden" id="bbh_mod_par_codigo" value="<?php echo $row_paragrafos['bbh_mod_par_codigo']; ?>"></td>
  </tr>
    <tr>
      <td height="24" align="right"><strong>T&iacute;tulo :</strong></td>
      <td>&nbsp; <input disabled name="bbh_mod_par_titulo" type="text" class="back_Campos" id="bbh_mod_par_titulo" value="<?php echo $row_paragrafos['bbh_mod_par_titulo']; ?>" size="55"></td>
    </tr>
    <tr>
      <td height="24" align="right" valign="top"><strong>Texto :</strong></td>
      <td height="24">&nbsp;</td>
    </tr>
    <tr>
      <td height="24" colspan="2" align="left" valign="top">
      	<div style="margin:10px;"><?php echo $row_paragrafos['bbh_mod_par_paragrafo']; ?></div>
      </td>
    </tr>
    <tr>
      <td height="24" align="right" valign="top">&nbsp;</td>
      <td height="24">&nbsp; <input style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/paragrafos/index.php?bbh_mod_flu_codigo=<?php if(!isset($_POST['bbh_mod_flu_codigo'])){echo $_GET['bbh_mod_flu_codigo']; }else{ echo $_POST['bbh_mod_flu_codigo']; } ?>','menuEsquerda|conteudoGeral');" class="button" type="button" name="button" id="button" value="Cancelar">
      &nbsp;
      <input <?php if($totalRows_usuautor!=0){ echo "disabled"; } ?> style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" type="button" name="button2" id="button2" value="Excluir" class="button" onClick="<?php echo $acao; ?>">
      <input name="acaoForm" id="acaoForm" type="hidden" value="<?php echo $acao; ?>" />
      <input name="bbh_mod_flu_codigo" id="bbh_mod_flu_codigo" type="hidden" value="<?php if(!isset($_POST['bbh_mod_flu_codigo'])){echo $_GET['bbh_mod_flu_codigo']; }else{ echo $_POST['bbh_mod_flu_codigo']; } ?>" />      </td>
    </tr>
    <tr>
      <td height="24" colspan="2" id="menLoad">&nbsp;</td>
    </tr>
    <tr>
    <td height="24" colspan="2">&nbsp;</td>
  </tr>
</table>
</form>