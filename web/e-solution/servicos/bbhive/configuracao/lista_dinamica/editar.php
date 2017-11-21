<?php
ini_set('display_erros',true);
//var_dump($_GET);
//--
require_once("../../includes/autentica.php");
require_once("../../includes/functions.php");
require_once("../../fluxos/modelosFluxos/detalhamento/includes/functions.php");
//include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");

	$idMensagemFinal= 'carregaTipo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestinoII	= '/e-solution/servicos/bbhive/configuracao/lista_dinamica/editar.php';
	
	$onClick = "OpenAjaxPostCmd('".$homeDestinoII."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')";
	
	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','cadatraModelo','Alterando dados...','loadInser','1','".$TpMens."');";
	
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

  //recuperando os tipos:
  	$tipo	= $_POST['bbh_cam_list_tipo'];
	$titulo	= ($_POST['bbh_cam_list_titulo']);
	$oldName = $_POST['oldName'];

        $query_campo_existente = sprintf("SELECT * FROM bbh_campo_lista_dinamica WHERE bbh_cam_list_titulo = %s AND bbh_cam_list_tipo = %s AND bbh_cam_list_codigo != %s", GetSQLValueString($bbhive, $titulo, "text"),GetSQLValueString($bbhive, $tipo, "text"),GetSQLValueString($bbhive, $_POST['bbh_cam_list_codigo'], "int"));
        list($campo_existente, $row_campo_existente, $totalRows_campo_existente) = executeQuery($bbhive, $database_bbhive, $query_campo_existente);

        if($totalRows_campo_existente == 0){
            $query_campo_existente = sprintf("SELECT * FROM bbh_campo_lista_dinamica WHERE bbh_cam_list_titulo = %s AND bbh_cam_list_codigo != %s", GetSQLValueString($bbhive, ($_POST['bbh_cam_list_titulo']), "text"),GetSQLValueString($bbhive, $_POST['bbh_cam_list_codigo'], "int"));
            list($campo_existente, $row_campo_existente, $totalRows_campo_existente) = executeQuery($bbhive, $database_bbhive, $query_campo_existente);

            if($totalRows_campo_existente > 0){
                     echo $Erro ="<span class='aviso' style='font-size:11;margin-left:20px;;margin-top:140px;position:absolute'>J&aacute; existe uma lista com este t&iacute;tulo.&nbsp;</span>";
                exit;

            }

            $updateSQL = sprintf("UPDATE bbh_campo_lista_dinamica SET bbh_cam_list_titulo=%s, bbh_cam_list_tipo=%s WHERE bbh_cam_list_titulo=%s",
                   GetSQLValueString($bbhive, ($_POST['bbh_cam_list_titulo']), "text"),
                   GetSQLValueString($bbhive, ($_POST['bbh_cam_list_tipo']), "text"),
                   GetSQLValueString($bbhive, $_POST['oldName'], "text"));

            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);

            // Campos setados com lista dinâmica
            $updateSQL = sprintf("UPDATE bbh_campo_detalhamento_fluxo SET bbh_cam_det_flu_default = %s WHERE bbh_cam_det_flu_default=%s",
                GetSQLValueString($bbhive, ($_POST['bbh_cam_list_titulo']), "text"),
                GetSQLValueString($bbhive, $_POST['oldName'], "text"));

            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
        }else{
             echo $Erro ="<span class='aviso' style='font-size:11;margin-left:20px;margin-top:140px;position:absolute'>J&aacute; existe uma lista com este t&iacute;tulo.&nbsp;</span>";
            exit;
        }

    echo "<var style='display:none'>showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?aba=1','menuEsquerda|colCentro')</var>";
    exit;
}


$colname_campos_listaDinamica = "-1";
if (isset($_GET['bbh_cam_list_codigo'])) {
    $colname_campos_listaDinamica = $_GET['bbh_cam_list_codigo'];
}
$query_listaDinamica = "SELECT * FROM bbh_campo_lista_dinamica WHERE bbh_cam_list_codigo = $colname_campos_listaDinamica";
list($listaDinamica, $row_listaDinamica, $totalRows_listaDinamica) = executeQuery($bbhive, $database_bbhive, $query_listaDinamica);

	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','form1','Cadastrando dados...','loadInser','1','".$TpMens."');";
//--
	$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
				WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_campo_lista_dinamica'";
    list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;

// SQL quantidade de registros
$query_quantidade = "SELECT count(*) as total
						FROM bbh_campo_lista_dinamica
						where bbh_cam_list_titulo = '".$_GET['nm']."'";
list($Quantidade, $row_quantidade, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_quantidade);

?>
<var style="display:none"></var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/detalhamento.gif" width="16" height="16" align="absmiddle" />Gerenciamento de lista din&acirc;mica</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?aba=1','menuEsquerda|colCentro')"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="2"></td>
  </tr>
</table>
<div style="position:absolute; margin-left:-2px;" id="carregaTipo"></div>
<div style="position:absolute;" id="loadInser" class="legandaLabel11"></div>
   
<br />
<form method="POST" action="" name="form1">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="borderAlljanela" style="margin-top:20px;">
  <tr class="legandaLabel11">
    <td height="26" colspan="2" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" class="verdana_11_bold">Edi&ccedil;&atilde;o de lista din&acirc;mica</td>
  </tr>
  <tr class="legandaLabel11">
    <td height="26" colspan="2" class="color">&nbsp;</td>
  </tr>
  <tr class="legandaLabel11">
    <td width="254" height="25" align="right" class="verdana_11_bold">T&iacute;tulo :&nbsp;</td>
    <td align="left"><input name="bbh_cam_list_titulo" type="text" class="back_Campos" id="bbh_cam_list_titulo" value="<?php echo $row_listaDinamica['bbh_cam_list_titulo']; ?>" size="60"></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Tipo :&nbsp;</td>
    <td align="left">
    <select name="bbh_cam_list_tipo" id="bbh_cam_list_tipo" class="back_Campos" onChange="showCamposProtocolo(this);" disabled>
      <option value="" <?php if (!(strcmp("", $row_listaDinamica['bbh_cam_list_tipo']))) {echo "selected=\"selected\"";} ?>>Escolha</option>
      <option value="S" <?php if (!(strcmp("S", $row_listaDinamica['bbh_cam_list_tipo']))) {echo "selected=\"selected\"";} ?>>Simples</option>
      <option value="A" <?php if (!(strcmp("A", $row_listaDinamica['bbh_cam_list_tipo']))) {echo "selected=\"selected\"";} ?>>&Aacute;rvore</option>
    </select>    </td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">&nbsp;</td>
    <td align="left">
      <input name="button" type="button" class="back_input" id="button" value="Cancelar"  onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?aba=1','menuEsquerda|colCentro');" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF"/>

      <input name="cadastra" type="button" class="back_input" id="cadastra" value="Editar lista" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" onClick="if(confirm('H&aacute; <?php echo $row_quantidade['total']; ?> registro(s). Tem certeza que deseja editar esta lista?')){return validaForm('form1', 'bbh_cam_list_titulo|Escolha o t&iacute;tulo do campo, bbh_cam_list_tipo|Escolha o tipo do campo', document.getElementById('acaoForm').value)}"/>
     
      <input type="hidden" name="tipoCampo" id="tipoCampo" />
      <input type="hidden" name="bbh_cam_list_codigo" id="bbh_cam_list_codigo" value="<?php echo $_GET['bbh_cam_list_codigo']; ?>" readonly/>
      <input type="hidden" name="oldName" id="oldName" value="<?php echo $row_listaDinamica['bbh_cam_list_titulo']; ?>" readonly/>

    </td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>

  <tr>
    <td height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
    <td width="607" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
 <tr class="legandaLabel11">
    <td height="22" align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="form1" />
<input type="hidden" name="acaoForm" id="acaoForm" value="<?php echo $acao; ?>" />
</form>
<?php
mysqli_free_result($listaDinamica);
?>
