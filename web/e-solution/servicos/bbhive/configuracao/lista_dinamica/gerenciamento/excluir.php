<?php
if(!isset($_SESSION)){session_start();}  

ini_set('display_erros',true);

//--
require_once("../../../includes/autentica.php");
require_once("../../../includes/functions.php");
require_once("../../../fluxos/modelosFluxos/detalhamento/includes/functions.php");
//include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");

	$idMensagemFinal= 'carregaTipo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestinoII	= '/e-solution/servicos/bbhive/configuracao/lista_dinamica/gerenciamento/excluir.php';
	$homeDestino	= $homeDestinoII;

	$onClick = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')";
	
	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','cadatraModelo','Alterando dados...','loadInser','1','".$TpMens."');";
	
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

  $deleteSQL = sprintf("DELETE FROM bbh_campo_lista_dinamica 
  							WHERE bbh_cam_list_codigo=%s",
                       		GetSQLValueString($bbhive, $_POST['bbh_cam_list_codigo'], "int"));
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
	
	$titulo 		= mysqli_fetch_assoc($_POST['bbh_cam_list_titulo']);
	$homeDestino 	= "/e-solution/servicos/bbhive/configuracao/lista_dinamica/gerenciamento/index.php";
	echo "<var style='display:none'>OpenAjaxPostCmd('".$homeDestino."?bbh_cam_list_titulo=".$titulo."','conteudoGeral','&1=1','Atualizando dados...','conteudoGeral','2','2');</var>";
}

$colname_listaDinamica = "-1";
if (isset($_GET['bbh_cam_list_codigo'])) {
  $colname_listaDinamica = $_GET['bbh_cam_list_codigo'];
}
$query_listaDinamica = "SELECT * FROM bbh_campo_lista_dinamica WHERE bbh_cam_list_codigo = $colname_listaDinamica";
list($listaDinamica, $row_listaDinamica, $totalRows_listaDinamica) = executeQuery($bbhive, $database_bbhive, $query_listaDinamica);

	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','form1','Excluindo dados...','loadInser','1','".$TpMens."');";
?>
<var style="display:none"></var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/detalhamento.gif" width="16" height="16" align="absmiddle" />Gerenciamento de op&ccedil;&otilde;es de lista din&acirc;mica</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/lista_dinamica/gerenciamento/index.php?bbh_cam_list_titulo=<?php echo $_GET['nm'];?>','menuEsquerda|colCentro');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="2"></td>
  </tr>
</table>
<div style="position:absolute; margin-left:-2px;" id="carregaTipo"></div>
<div style="position:absolute;" id="loadInser" class="legandaLabel11"></div>

<form method="POST" action="<?php echo $editFormAction; ?>" name="form1">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="borderAlljanela">
  <tr class="legandaLabel11">
    <td height="26" colspan="2" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" class="verdana_11_bold">Excluir op&ccedil;&atilde;o</td>
  </tr>
  <tr class="legandaLabel11">
    <td width="264" height="25" align="right" class="verdana_11_bold">Valor :&nbsp;</td>
    <td align="left"><input name="bbh_cam_list_valor" type="text" class="back_Campos" id="bbh_cam_list_valor" value="<?php echo $row_listaDinamica['bbh_cam_list_valor']; ?>" size="60" disabled></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">&nbsp;</td>
    <td align="left">
      <input name="button" type="button" class="back_input" id="button" value="Cancelar"  onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/lista_dinamica/gerenciamento/index.php?bbh_cam_list_titulo=<?php echo $_GET['nm'];?>','menuEsquerda|colCentro');" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF"/>
      <input name="cadastra" type="button" class="back_input" id="cadastra" value="Excluir op&ccedil;&atilde;o" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" onClick="if(confirm('Tem certeza que deseja excluir esta op&ccedil;&atilde;o?')){validaForm('form1', 'bbh_cam_list_valor|Valor obrigatório.', document.getElementById('acaoForm').value)}"/>
      &nbsp;&nbsp;&nbsp; <input type="hidden" name="tipoCampo" id="tipoCampo" />
      <input type="hidden" name="bbh_cam_list_codigo" id="bbh_cam_list_codigo" value="<?php echo $_GET['bbh_cam_list_codigo']; ?>" readonly/>
      <input type="hidden" name="bbh_cam_list_titulo" id="bbh_cam_list_titulo" value="<?php echo $_GET['nm']; ?>" readonly/></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>

  <tr>
    <td height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
    <td width="684" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
 <tr class="legandaLabel11">
    <td height="22" align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="form1" /><input type="hidden" name="acaoForm" id="acaoForm" value="<?php echo $acao; ?>" readonly /></form>
<?php
mysqli_free_result($listaDinamica);
?>
