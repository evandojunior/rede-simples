<?php
if(!isset($_SESSION)){session_start();}  ini_set('display_erros',true);
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
	$homeDestinoII	= '/e-solution/servicos/bbhive/configuracao/lista_dinamica/novo.php';
	
	$onClick = "OpenAjaxPostCmd('".$homeDestinoII."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')";
	
	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','cadatraModelo','Alterando dados...','loadInser','1','".$TpMens."');";

$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
				WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_campo_lista_dinamica'";
list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

  //recuperando as variáveis:
  
  		$tipo	= $_POST['bbh_cam_list_tipo'];
		$titulo	= ($_POST['bbh_cam_list_titulo']);

		$query_campo_existente = sprintf("SELECT * FROM bbh_campo_lista_dinamica WHERE bbh_cam_list_titulo = %s ", GetSQLValueString($bbhive, $titulo, "text"));
        list($campo_existente, $row_campo_existente, $totalRows_campo_existente) = executeQuery($bbhive, $database_bbhive, $query_campo_existente);
	
	if($totalRows_campo_existente > 0){
	  		 echo $Erro ="<span class='aviso' style='font-size:11;margin-left:20px;'>J&aacute; existe uma lista com este t&iacute;tulo.</span>";
		exit;

	}else{

//--
	if($totalRows_Colunas == 0){
		$createTable = "CREATE TABLE `bbh_campo_lista_dinamica` (
						`bbh_cam_list_codigo` INT(10) NULL AUTO_INCREMENT,
						`bbh_cam_list_mascara` VARCHAR(255) NULL,
						`bbh_cam_list_titulo` VARCHAR(255) NULL,
						`bbh_cam_list_valor` VARCHAR(255) NULL,
						`bbh_cam_list_ordem` INT(11) NULL,
						`bbh_cam_list_tipo` CHAR(1) NULL DEFAULT 'S',
						PRIMARY KEY (`bbh_cam_list_codigo`)
					)
					COLLATE='latin1_swedish_ci'
					ENGINE=InnoDB
					ROW_FORMAT=DEFAULT";
        list($res, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $createTable, $initResult = false);
	}
//--
  $insertSQL = sprintf("INSERT INTO bbh_campo_lista_dinamica (bbh_cam_list_titulo, bbh_cam_list_tipo) VALUES (%s, %s)",
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_list_titulo']), "text"),
                       GetSQLValueString($bbhive, $_POST['bbh_cam_list_tipo'], "text"));
  list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL, $initResult = false);
  $ultimoId= mysqli_insert_id($bbhive);
  
  
	 echo "<var style='display:none'>showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?aba=1','menuEsquerda|colCentro')</var>";
	  exit;
	}
}

	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','form1','Cadastrando dados...','loadInser','1','".$TpMens."');";

?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/detalhamento.gif" width="16" height="16" align="absmiddle" /> Gerenciamento lista din&acirc;mica</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?aba=1','menuEsquerda|colCentro');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
</table>
<div style="position:absolute; margin-left:-2px;" id="carregaTipo"></div>
<div style="position:absolute;" id="loadInser" class="legandaLabel11"></div>
<form method="POST" action="" name="form1">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="borderAlljanela" style="margin-top:20px;">
  <tr class="legandaLabel11">
    <td height="26" colspan="2" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" class="verdana_11_bold">&nbsp;Nova lista din&acirc;mica</td>
  </tr>
  <tr class="legandaLabel11">
    <td width="254" height="25" align="right" class="verdana_11_bold">T&iacute;tulo :&nbsp;</td>
    <td align="left"><input name="bbh_cam_list_titulo" type="text" class="back_Campos" id="bbh_cam_list_titulo" size="60"></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Tipo :&nbsp;</td>
    <td align="left">
        <select name="bbh_cam_list_tipo" id="bbh_cam_list_tipo" class="back_Campos" onChange="showCamposProtocolo(this);">
          <option value="">Escolha</option>
          <option value="S">Simples</option>
          <option value="A">&Aacute;rvore</option>
        </select>    
    </td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">&nbsp;</td>
    <td align="left">
      <input name="button" type="button" class="back_input" id="button" value="Cancelar"  onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?aba=1','menuEsquerda|colCentro');" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF"/>
      
<?php
if($tabelaCriada == 0){
	$alerta = "return validaForm('form1', 'bbh_cam_list_titulo|T&iacute;tulo obrigat&oacute;rio, bbh_cam_list_tipo|Escolha o tipo da lista', document.getElementById('acaoForm').value)";
}else{
	$alerta = "if(confirm('O tipo do campo não poderá ser alterado posteriormente. Deseja continuar?')){return validaForm('form1', 'bbh_cam_list_titulo|T&iacute;tulo obrigat&oacute;rio, bbh_cam_list_tipo|Escolha o tipo da lista', document.getElementById('acaoForm').value)}";
}
?>
      <input name="cadastra" type="button" class="back_input" id="cadastra" value="Cadastrar lista" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" onclick="<?php echo $alerta; ?>"/>
      
     </td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>

  <tr>
    <td height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
    <td width="640" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
 <tr class="legandaLabel11">
    <td height="22" align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="form1" />
<input type="hidden" name="acaoForm" id="acaoForm" value="<?php echo $acao; ?>" />
<input type="hidden" name="cadastrado" id="cadastrado" value="<?php echo $tabelaCriada; ?>" />

</form>
<?php
//mysqli_free_result($detalhamento);
?>
