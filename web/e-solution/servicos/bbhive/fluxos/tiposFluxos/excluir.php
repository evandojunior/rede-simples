<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/fluxos/tiposFluxos/excluir.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'excluiTipo';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	
$codigo = -1;
if(isset($_GET['bbh_tip_flu_codigo'])){
	$codigo = $_GET['bbh_tip_flu_codigo'];
}

$query_tipofluxo = "SELECT * FROM bbh_tipo_fluxo WHERE bbh_tip_flu_codigo = '$codigo'";
list($tipofluxo, $row_tipofluxo, $totalRows_tipofluxo) = executeQuery($bbhive, $database_bbhive, $query_tipofluxo);

if ((isset($_POST['bbh_tip_flu_codigo'])) && ($_POST['bbh_tip_flu_codigo'] != "")) {

	$query_valida = "SELECT bbh_tipo_fluxo.bbh_tip_flu_codigo FROM bbh_modelo_fluxo INNER JOIN bbh_tipo_fluxo ON bbh_tipo_fluxo.bbh_tip_flu_codigo = bbh_modelo_fluxo.bbh_tip_flu_codigo WHERE bbh_tipo_fluxo.bbh_tip_flu_codigo = ".$_POST['bbh_tip_flu_codigo'];
    list($valida, $row_valida, $totalRows_valida) = executeQuery($bbhive, $database_bbhive, $query_valida);

	  if($totalRows_valida==0){
	  $deleteSQL = "DELETE FROM bbh_tipo_fluxo WHERE bbh_tip_flu_codigo = ".$_POST['bbh_tip_flu_codigo'];
	  list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);
	  
	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|fluxos/tiposFluxos/tipos.php','menuEsquerda|conteudoGeral')</var>";
		  exit;
		  }else{
		 $Erro ="<span class='aviso' style='font-size:11;'>N&atilde;o &eacute; poss&iacute;vel excluir um Tipo se h&aacute; um modelo utilizando-o.</span>";
  		echo "<var style='display:none'>txtSimples('erroDep', '".$Erro."')</var>";
		exit;
	}
	}
?>
<form method="POST" name="excluiTipo" id="excluiTipo">
<var style="display:none">txtSimples('tagPerfil', 'Tipos de Fluxo')</var>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
  <tr>
    <td height="26" colspan="2" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/ger-tipofluxo-16px.gif" width="14" height="16" align="absmiddle" /> Gerenciamento de <?php echo $_SESSION['adm_FluxoNome']; ?>
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

src="/e-solution/servicos/bbhive/images/apontadireita.gif" alt="" width="4" height="8" align="absmiddle" /> Exclus&atilde;o do Tipo de <?php echo $_SESSION['adm_FluxoNome']; ?></span></td>
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
        <td height="15">&nbsp;
            <input disabled class="back_Campos" name="bbh_tip_flu_identificacao" type="text" id="bbh_tip_flu_identificacao" size="25" maxlength="255" value="<?php echo $row_tipofluxo['bbh_tip_flu_identificacao']; ?>"></td>
      </tr>
      <tr>
        <td width="18%" align="right" class="color">Nome&nbsp;:</td>
        <td width="82%" height="30">&nbsp;
            <input name="bbh_tip_flu_nome" type="text" class="back_Campos" id="bbh_tip_flu_nome" value="<?php echo $row_tipofluxo['bbh_tip_flu_nome'];  ?>" size="45" maxlength="255" disabled>
              <input type="hidden" name="bbh_tip_flu_codigo" id="bbh_tip_flu_codigo" value="<?php echo $row_tipofluxo['bbh_tip_flu_codigo']; ?>"></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">Descri&ccedil;&atilde;o&nbsp;:</td>
        <td>&nbsp;
            <textarea disabled class="formulario2" name="bbh_tip_flu_observacao" id="bbh_tip_flu_observacao" cols="44" rows="7"><?php if(isset($_POST['bbh_tip_flu_observacao'])){ echo $_POST['bbh_tip_flu_observacao']; } else { echo $row_tipofluxo['bbh_tip_flu_observacao']; }?>
  </textarea>        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="35">&nbsp;
              <input type="button" name="button2" id="button2" value="Cancelar" class="button" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|fluxos/tiposFluxos/tipos.php','menuEsquerda|colCentro');">
            <input type="button" name="button" id="button" value="Excluir" class="button" onClick="return validaForm('excluiTipo', 'bbh_tip_flu_nome|Preencha o nome do departamento', document.getElementById('acaoForm').value)"> <input name="acaoForm" id="acaoForm" type="hidden" value="<?php echo $acao; ?>" /></td>
      </tr>
      <tr>
        <td colspan="2" id="menLoad">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>