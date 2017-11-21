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
	$homeDestinoII	= '/e-solution/servicos/bbhive/configuracao/detalhamento/editar.php';
	$homeDestino	= $homeDestinoII;
	
	$onClick = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')";
	
	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','cadatraModelo','Alterando dados...','loadInser','1','".$TpMens."');";
	
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

//
// Troca a ordem
//
if( isset($_GET['bbh_cam_det_pro_codigo']) && isset($_GET['ordem']) )
{
	// Pega a ordem atual
    $query = "SELECT bbh_cam_det_pro_ordem FROM bbh_campo_detalhamento_protocolo WHERE bbh_cam_det_pro_codigo = ".$_GET['bbh_cam_det_pro_codigo']." LIMIT 1";
    list($exe, $fth, $totalRows) = executeQuery($bbhive, $database_bbhive, $query);
	$atual = $fth['bbh_cam_det_pro_ordem'];
	
	// Qual a nova ordem 
	if( $_GET['ordem'] == "soma" )
		$nova = $fth['bbh_cam_det_pro_ordem'] + 1;	
	else
		$nova = $fth['bbh_cam_det_pro_ordem'] - 1;
	
	// Sqls
	$sql1 = "UPDATE bbh_campo_detalhamento_protocolo SET bbh_cam_det_pro_ordem = 0 WHERE bbh_cam_det_pro_ordem = $nova";
	$sql2 = "UPDATE bbh_campo_detalhamento_protocolo SET bbh_cam_det_pro_ordem = $nova WHERE bbh_cam_det_pro_ordem = $atual";
	$sql3 = "UPDATE bbh_campo_detalhamento_protocolo SET bbh_cam_det_pro_ordem = $atual WHERE bbh_cam_det_pro_ordem = 0";
	//exit($sql1.";".$sql2.";".$sql3);
	// Cria as query que irão far os updates
    list($res, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql1);
    list($res, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql2);
    list($res, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql3);
	
	// Volta para HOME
	echo "<var>";
	echo "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?aba=2','menuEsquerda|colCentro');";
	echo "</var>";
}



if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

  //recuperando os tipos:
  	$tipo = $_POST['bbh_cam_det_pro_tipo'];
	
	switch($tipo)
	{
		case "correio_eletronico":
			$tamanho = $_POST['bbh_cam_det_pro_tamanho'];
			$valor_padrao = $_POST['bbh_cam_det_pro_default']; 
		break;
		
		case "data":
		if($_POST['theDate'] != "")
		{
			$data = substr($_POST['theDate'],6,4) . "-";
			$data .= substr($_POST['theDate'],3,2) . "-";
			$data .= substr($_POST['theDate'],0,2);
		}else{
			$data = '';
		}
			$tamanho = '';
			$valor_padrao = $data; 
		
		break;
		
		case "numero":
			$tamanho = $_POST['bbh_cam_det_pro_tamanho'];
			$valor_padrao = $_POST['bbh_cam_det_pro_default']; 
		break;
		
		case "endereco_web":
			$tamanho = $_POST['bbh_cam_det_pro_tamanho'];
			$valor_padrao = $_POST['bbh_cam_det_pro_default']; 
		break;
		
		case "lista_opcoes":
			$tamanho = $_POST['bbh_cam_det_pro_tamanho'];
			$valor_padrao = $_POST['menuCriadoValores']; 
		break;
		
		case "lista_dinamica":
			$tamanho = $_POST['bbh_cam_det_flu_tamanho'];
			$valor_padrao = $_POST['menuListagemDinamica']; 
		break;
		
		case "numero_decimal":
			$tamanho = $_POST['bbh_cam_det_pro_tamanho'];
			  $valor_padrao = str_replace(".","",$_POST['bbh_cam_det_pro_default']);
  			  $valor_padrao = str_replace(",",".",$valor_padrao);
			
		break;
		
		case "texto_longo":
			if($_POST['texto_longoLinhaI'] == "")
			{
				$linha = 50;
			}else{
				$linha = $_POST['texto_longoLinhaI'];
			}
			
			if($_POST['texto_longoColunaI'] == "")
			{
				$coluna = 5;
			}else{
				$coluna = $_POST['texto_longoColunaI'];
			}
			
			$tamanho = $linha . "|" . $coluna;
			$valor_padrao = $_POST['bbh_cam_det_pro_defaultLongo']; 
		break;
		
		case "texto_simples":
			$tamanho = $_POST['bbh_cam_det_pro_tamanho'];
			$valor_padrao = $_POST['bbh_cam_det_pro_default']; 
		break;
		
		case "horario":
			$tamanho = '';
			$valor_padrao = $_POST['hh'] . ":" . $_POST['mm'] . ":" . $_POST['ss']; 
		break;
		case "time_stamp":
			$tamanho = '';
			$valor_padrao = '';		
		break;
        case "json":
		case "horario_editavel":
			$tamanho = '';
			$valor_padrao = '';
		break;
		
		
	}

		//$nome_campo 	= "bbh_cam_det_pro_";
		$titulo			= ($_POST['bbh_cam_det_pro_titulo']);

		$query_campo_existente = sprintf("SELECT * FROM bbh_campo_detalhamento_protocolo WHERE bbh_cam_det_pro_curinga = %s  AND bbh_cam_det_pro_titulo = %s AND bbh_cam_det_pro_codigo != %s", GetSQLValueString($bbhive, ($_POST['bbh_cam_det_pro_curinga']), "text"), GetSQLValueString($bbhive, $titulo, "text"), GetSQLValueString($bbhive, $_POST['bbh_cam_det_pro_codigo'], "int"));
        list($campo_existente, $row_campo_existente, $totalRows_campo_existente) = executeQuery($bbhive, $database_bbhive, $query_campo_existente);

	if($totalRows_campo_existente == 0){

		$query_campo_existente = sprintf("SELECT * FROM bbh_campo_detalhamento_protocolo WHERE bbh_cam_det_pro_curinga = %s AND bbh_cam_det_pro_codigo != %s", GetSQLValueString($bbhive, ($_POST['bbh_cam_det_pro_curinga']), "text"),GetSQLValueString($bbhive, $_POST['bbh_cam_det_pro_codigo'], "int"));
        list($campo_existente, $row_campo_existente, $totalRows_campo_existente) = executeQuery($bbhive, $database_bbhive, $query_campo_existente);
	
	if($totalRows_campo_existente > 0){
	  		 echo $Erro ="<span class='aviso' style='font-size:11;margin-left:20px;;margin-top:140px;position:absolute'>J&aacute; um curinga com este nome neste detalhamento&nbsp;</span>";
		exit;

	}else{


		if($_POST['cadastrado'] == 1)
		{

		$updateSQL = sprintf("UPDATE bbh_campo_detalhamento_protocolo SET bbh_cam_det_pro_titulo=%s, bbh_cam_det_pro_curinga=%s, bbh_cam_det_pro_apelido=%s, bbh_cam_det_pro_descricao=%s, bbh_cam_det_pro_default=%s, bbh_cam_det_pro_disponivel=%s, bbh_cam_det_pro_visivel=%s, bbh_cam_det_pro_preencher_apos_receber=%s, bbh_cam_det_pro_obrigatorio=%s WHERE bbh_cam_det_pro_codigo=%s",
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_det_pro_titulo']), "text"),
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_det_pro_curinga']), "text"),
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_det_pro_apelido']), "text"),
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_det_pro_descricao']), "text"),
					   GetSQLValueString($bbhive, ($valor_padrao), "text"),
					   GetSQLValueString($bbhive, $_POST['bbh_cam_det_pro_disponivel'], "text"),
					   GetSQLValueString($bbhive, $_POST['bbh_cam_det_pro_visivel'], "text"),
					   GetSQLValueString($bbhive, $_POST['bbh_cam_det_pro_preencher_apos_receber'], "text"),
					   GetSQLValueString($bbhive, $_POST['bbh_cam_det_pro_obrigatorio'], "text"),
                       GetSQLValueString($bbhive, $_POST['bbh_cam_det_pro_codigo'], "int"));

            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
		
		
		}else{
		  $updateSQL = sprintf("UPDATE bbh_campo_detalhamento_protocolo SET bbh_cam_det_pro_nome=%s, bbh_cam_det_pro_titulo=%s, bbh_cam_det_pro_tipo=%s, bbh_cam_det_pro_curinga=%s, bbh_cam_det_pro_apelido=%s, bbh_cam_det_pro_descricao=%s, bbh_cam_det_pro_tamanho=%s, bbh_cam_det_pro_default=%s, bbh_cam_det_pro_disponivel=%s, bbh_cam_det_pro_visivel=%s, bbh_cam_det_pro_preencher_apos_receber=%s, bbh_cam_det_pro_obrigatorio=%s WHERE bbh_cam_det_pro_codigo=%s",
                       GetSQLValueString($bbhive,$nome_campo, "text"),
                       GetSQLValueString($bbhive,($_POST['bbh_cam_det_pro_titulo']), "text"),
                       GetSQLValueString($bbhive,$_POST['bbh_cam_det_pro_tipo'], "text"),
                       GetSQLValueString($bbhive,($_POST['bbh_cam_det_pro_curinga']), "text"),
                       GetSQLValueString($bbhive,($_POST['bbh_cam_det_pro_apelido']), "text"),
                       GetSQLValueString($bbhive,($_POST['bbh_cam_det_pro_descricao']), "text"),
                       GetSQLValueString($bbhive,$tamanho, "text"),
                       GetSQLValueString($bbhive,($valor_padrao), "text"),
					   GetSQLValueString($bbhive,$_POST['bbh_cam_det_pro_disponivel'], "text"),
					   GetSQLValueString($bbhive,$_POST['bbh_cam_det_pro_visivel'], "text"),
					   GetSQLValueString($bbhive,$_POST['bbh_cam_det_pro_preencher_apos_receber'], "text"),
					   GetSQLValueString($bbhive,$_POST['bbh_cam_det_pro_obrigatorio'], "text"),
                       GetSQLValueString($bbhive,$_POST['bbh_cam_det_pro_codigo'], "int"));

            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
  }
 }
 }else{
 
  		 echo $Erro ="<span class='aviso' style='font-size:11;margin-left:20px;margin-top:140px;position:absolute'>J&aacute; existe um campo com este t&iacute;tulo neste detalhamento&nbsp;</span>";
		exit;
  }
  	 echo "<var style='display:none'>showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?aba=2','menuEsquerda|colCentro')</var>";
	  exit;
}


$colname_campos_detalhamento = "-1";
if (isset($_GET['bbh_cam_det_pro_codigo'])) {
  $colname_campos_detalhamento = $_GET['bbh_cam_det_pro_codigo'];
}
$query_campos_detalhamento ="SELECT date_format(bbh_cam_det_pro_default,'%d/%m/%Y') as data,bbh_campo_detalhamento_protocolo.* FROM bbh_campo_detalhamento_protocolo WHERE bbh_cam_det_pro_codigo = $colname_campos_detalhamento";
list($campos_detalhamento, $row_campos_detalhamento, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento);

	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','form1','Cadastrando dados...','loadInser','1','".$TpMens."');";
//--
	$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
				WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_detalhamento_protocolo'";
    list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
?>
<var style="display:none">txtSimples('tagPerfil', 'Detalhamento - <?php echo $_SESSION['adm_protNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/detalhamento.gif" width="16" height="16" align="absmiddle" />Gerenciamento de detalhamento - <?php echo $_SESSION['adm_protNome']; ?></td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?aba=2','menuEsquerda|colCentro')"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="2"></td>
  </tr>
</table>
<div style="position:absolute; margin-left:-2px;" id="carregaTipo"></div>
<div style="position:absolute;" id="loadInser" class="legandaLabel11"></div>
    <?php 
		//Isse bloco verifica se os campos que possuem o atributo tamanho mostra ao iniciar ou não
		$is_float = false;	
		$is_number = false;	
		switch($row_campos_detalhamento['bbh_cam_det_pro_tipo'])
		{
			case "correio_eletronico":
				$tamanho = "";	
				$valor_padrao = "";
				$data = "none";
				$lista = "none";
				$dinamico = "none";
				$hora = "none";
				$longo = "none";
				$opcoesHidden = "";
			break;

			case "data":
				$tamanho = "none";
				$valor_padrao = "none";			
				$data = "";
				$lista = "none";
				$dinamico = "none";
				$hora = "none";
				$longo = "none";
				$opcoesHidden = "";
			break;
			
			case "lista_opcoes":
				$tamanho = "none";	
				$valor_padrao = "none";
				$data = "none";
				$lista = "";
				$dinamico = "none";
				$hora = "none";	
				$longo = "none";
				$opcoesHidden = $row_campos_detalhamento['bbh_cam_det_pro_default'];
			break;
			
			case "lista_dinamica":
				$tamanho = "none";	
				$valor_padrao = "none";
				$data = "none";
				$lista = "none";
				$dinamico = "";
				$hora = "none";	
				$longo = "none";
				$opcoesHidden = $row_campos_detalhamento['bbh_cam_det_pro_default'];
			break;
			
			case "texto_longo":
				$longo = "";
				$tamanho = "none";	
				$valor_padrao = "none";
				$data = "none";	
				$lista = "none";
				$dinamico = "none";
				$hora = "none";
				$opcoesHidden = "";
			break;
			
			case "horario":
				$tamanho = "none";	
				$valor_padrao = "none";
				$data = "none";	
				$lista = "none";	
				$dinamico = "none";	
				$hora = "";	
				$longo = "none";
				$opcoesHidden = "";
						
			break;
			
			case "endereco_web":
				$tamanho = "";	
				$valor_padrao = "";
				$data = "none";	
				$lista = "none";
				$dinamico = "none";
				$hora = "none";	
				$longo = "none";
				$opcoesHidden = "";	
			break;
			
			case "numero":
				$tamanho = "";
				$valor_padrao = "";
				$data = "none";
				$lista = "none";
				$dinamico = "none";
				$hora = "none";	
				$longo = "none";
				$opcoesHidden = "";
				$is_number = true;
			break;
			
			case "numero_decimal":
				$tamanho = "";
				$valor_padrao = "";
				$data = "none";	
				$lista = "none";
				$dinamico = "none";
				$hora = "none";
				$longo = "none";
				$opcoesHidden = "";
				$is_float = true;
			break;

			case "texto_simples":
				$tamanho = "";
				$valor_padrao = "";
				$data = "none";	
				$lista = "none";
				$dinamico = "none";
				$hora = "none";
				$longo = "none";
				$opcoesHidden = "";
			break;
			
			default:
				$tamanho = "none";
				$valor_padrao = "none";
				$data = "none";
				$lista = "none";
				$dinamico = "none";
				$hora = "none";	
				$longo = "none";
				$opcoesHidden = "";
				$opcoesHidden = "";
			break;		
		}
	$cadastrado = $tabelaCriada;
	if($cadastrado == 0){
		$disabled = '';
	}else{
		$disabled = 'disabled="disabled"';
	}
?>
<br />
<form method="POST" action="" name="form1">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="borderAlljanela" style="margin-top:20px;">
  <tr class="legandaLabel11">
    <td height="26" colspan="2" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" class="verdana_11_bold">Edi&ccedil;&atilde;o do campo de detalhamento</td>
  </tr>
  <?php if($cadastrado == 1) { ?>
  <tr class="legandaLabel11">
    <td height="26" colspan="2" class="color"><img src="/e-solution/servicos/bbhive/images/alerta.gif" align="absmiddle"/>&nbsp;Para campos cadastrados definitivamente, apenas alguns valores podem ser alterados.</td>
  </tr>
 <?php } ?>
  <tr class="legandaLabel11">
    <td width="254" height="25" align="right" class="verdana_11_bold">Titulo :&nbsp;</td>
    <td align="left"><input name="bbh_cam_det_pro_titulo" type="text" class="back_Campos" id="bbh_cam_det_pro_titulo" value="<?php echo $row_campos_detalhamento['bbh_cam_det_pro_titulo']; ?>" size="60"></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Tipo :&nbsp;</td>
    <td align="left">
    <select name="bbh_cam_det_pro_tipo" id="bbh_cam_det_pro_tipo" class="back_Campos" onChange="showCamposProtocolo(this);" <?php echo $disabled; ?>>
      <option value="" <?php if (!(strcmp("", $row_campos_detalhamento['bbh_cam_det_pro_tipo']))) {echo "selected=\"selected\"";} ?>>Escolha</option>
      <option value="correio_eletronico" <?php if (!(strcmp("correio_eletronico", $row_campos_detalhamento['bbh_cam_det_pro_tipo']))) {echo "selected=\"selected\"";} ?>>Correio eletr&ocirc;nico</option>
      <option value="data" <?php if (!(strcmp("data", $row_campos_detalhamento['bbh_cam_det_pro_tipo']))) {echo "selected=\"selected\"";} ?>>Data</option>
      <option value="time_stamp" <?php if (!(strcmp("time_stamp", $row_campos_detalhamento['bbh_cam_det_pro_tipo']))) {echo "selected=\"selected\"";} ?>>Data / Hora atual</option>
      <option value="horario_editavel" <?php if (!(strcmp("horario_editavel", $row_campos_detalhamento['bbh_cam_det_pro_tipo']))) {echo "selected=\"selected\"";} ?>>Data / Hora edit&aacute;vel</option>
      <option value="endereco_web" <?php if (!(strcmp("endereco_web", $row_campos_detalhamento['bbh_cam_det_pro_tipo']))) {echo "selected=\"selected\"";} ?>>Endere&ccedil;o web</option>
      <option value="lista_opcoes" <?php if (!(strcmp("lista_opcoes", $row_campos_detalhamento['bbh_cam_det_pro_tipo']))) {echo "selected=\"selected\"";} ?>>Lista de op&ccedil;&otilde;es</option>
      <option value="lista_dinamica" <?php if (!(strcmp("lista_dinamica", $row_campos_detalhamento['bbh_cam_det_pro_tipo']))) {echo "selected=\"selected\"";} ?>>Lista din&acirc;mica</option>
      <option value="numero" <?php if (!(strcmp("numero", $row_campos_detalhamento['bbh_cam_det_pro_tipo']))) {echo "selected=\"selected\"";} ?>>N&uacute;mero</option>
      <option value="numero_decimal" <?php if (!(strcmp("numero_decimal", $row_campos_detalhamento['bbh_cam_det_pro_tipo']))) {echo "selected=\"selected\"";} ?>>N&uacute;mero decimal</option>
      <option value="texto_longo" <?php if (!(strcmp("texto_longo", $row_campos_detalhamento['bbh_cam_det_pro_tipo']))) {echo "selected=\"selected\"";} ?>>Texto longo</option>
      <option value="texto_simples" <?php if (!(strcmp("texto_simples", $row_campos_detalhamento['bbh_cam_det_pro_tipo']))) {echo "selected=\"selected\"";} ?>>Texto simples</option>
      <option value="json" <?php if (!(strcmp("json", $row_campos_detalhamento['bbh_cam_det_pro_tipo']))) {echo "selected=\"selected\"";} ?>>Integração de sistemas (JSON)</option>
    </select>    </td>
  </tr>
  <tr style="display:none;background:#F7F7F7;background:#F7F7F7;" id="Tamanho">
    <td align="right" class="verdana_11_bold">*Tamanho :&nbsp; </td>
    <td align="left" class="verdana_11"><label>
      <input name="bbh_cam_det_pro_tamanho" type="text" class="back_Campos" id="bbh_cam_det_pro_tamanho" value="<?php echo $row_campos_detalhamento['bbh_cam_det_pro_tamanho']; ?>" <?php echo $disabled; ?>>
    </label></td>
  </tr>
  <?php 
  if($row_campos_detalhamento['bbh_cam_det_pro_fixo']=="1" && $row_campos_detalhamento['bbh_cam_det_pro_nome']=="bbh_dep_codigo"){
	  //Departamentos cadastrados
	$query_departamentos ="SELECT bbh_dep_codigo, bbh_dep_nome FROM bbh_departamento order by bbh_dep_nome asc";
      list($departamentos, $rows, $totalRows_departamentos) = executeQuery($bbhive, $database_bbhive, $query_departamentos, $initResult = false);
	  ?>
  <tr style="background:#F7F7F7;" id="VlPadraoData">
    <td align="right" class="verdana_11_bold">Valor padr&atilde;o :&nbsp;</td>
    <td align="left" class="verdana_11">
    <select name="codDepartamento" id="codDepartamento" onchange="document.getElementById('bbh_cam_det_pro_default').value = this.value;" class="verdana_11">
    	<option value="">Nenhum departamento padrão</option>
    	<?php while($row_departamentos = mysqli_fetch_assoc($departamentos)){?>
        	<option value="<?php echo $row_departamentos['bbh_dep_codigo']; ?>"><?php echo $row_departamentos['bbh_dep_nome']; ?></option>
        <?php } ?>
    </select>
    <input name="bbh_cam_det_pro_default" type="hidden" class="back_Campos" id="bbh_cam_det_pro_default" size="30" value="<?php echo $row_campos_detalhamento['bbh_cam_det_pro_default']; ?>" readonly="readonly"/>
    <var style="display:none">
     <?php if($row_campos_detalhamento['bbh_cam_det_pro_default']>0){?>
    	document.getElementById('codDepartamento').value = '<?php echo $row_campos_detalhamento['bbh_cam_det_pro_default']; ?>';
     <?php } ?>   
    </var>
    </td>
  </tr>
  <?php } else { ?>
  <tr style="display:<?php echo $data; ?>;background:#F7F7F7;" id="VlPadraoData">
    <td align="right" class="verdana_11_bold">Valor padr&atilde;o :&nbsp;</td>
    <td align="left" class="verdana_11"><input name="theDate" type="text" class="back_Campos" id="theDate" value="<?php echo $row_campos_detalhamento['data']; ?>" size="13" onKeyPress="MascaraData(event, this)" maxlength="10" <?php echo $disabled; ?>/>
        <input type="button" style="width:23px;height:21px;" class="botao_calendar" onClick="displayCalendar(document.form1.theDate,'dd/mm/yyyy',this)" <?php echo $disabled; ?>/></td>
  </tr>
  <tr style="display:<?php echo $valor_padrao; ?>;background:#F7F7F7;" id="VlPadrao">
    <td align="right" class="verdana_11_bold">Valor padr&atilde;o :&nbsp; </td>
    <td align="left" class="verdana_11"><label>
    <?php
			if($is_float == true)
			{
				$valor_default = Real($row_campos_detalhamento['bbh_cam_det_pro_default']); ?>
				      <input name="bbh_cam_det_pro_default" type="text" class="back_Campos" id="bbh_cam_det_pro_default" size="30" value="<?php echo $valor_default; ?>" onKeyPress="return(MascaraMoeda(this,'.',',',event))" <?php echo $disabled; ?>>

 		 <?php }else if($is_number == true){ 
         	$valor_default = $row_campos_detalhamento['bbh_cam_det_pro_default']; ?>
          <input name="bbh_cam_det_pro_default" type="text" class="back_Campos" id="bbh_cam_det_pro_default" size="30" value="<?php echo $valor_default; ?>" onkeyup="SomenteNumerico(this);" <?php echo $disabled; ?>/>

			<?php }else{
				$valor_default = $row_campos_detalhamento['bbh_cam_det_pro_default']; ?>
                      <input name="bbh_cam_det_pro_default" type="text" class="back_Campos" id="bbh_cam_det_pro_default" size="30" value="<?php echo $valor_default; ?>" <?php echo $disabled; ?>/>

			<?php }
	?>
    </label></td>
  </tr>
  <?php } ?>
  <tr style="display:<?php echo $lista; ?>;background:#F7F7F7;" id="listagem">
    <td align="right" class="verdana_11_bold" >Valor  a ser adicionado :&nbsp; </td>
    <td align="left" class="verdana_11"><label>
      <input name="listagemI" type="text" class="verdana_11" id="listagemI" size="50" maxlength="150" onKeyUp="return cadListagem();" <?php //echo $disabled; ?>>
      </label>
      <a href="#" onClick="<?php if(!empty($disabled)){ ?>if(confirm('Atenção, antes de adicionar verifique se a opções é a correta, pois após a inclusão e confirmação do cadastro a mesma não poderá ser removida! Clique em OK em caso de confirmação.')){AddListagem();}<?php } else {?>return AddListagem();<?php } ?>"> <img src="/e-solution/servicos/bbhive/images/addVl.gif" alt="Adicionar na listagem" width="16" height="16" align="absmiddle" border="0"> </a> </td>
  </tr>
  <tr style="display:<?php echo $lista; ?>;background:#F7F7F7;" id="listagemCriada">
    <td align="right" class="verdana_11_bold" ><span class="verdana_11">Lista atual :&nbsp;</span></td>
    <td align="left" class="verdana_11"><select name="menuCriado" id="menuCriado" class="back_Campos" style="position:relative;width:400px;" <?php //echo $disabled; ?>>
      <?php
      		$options = explode("|",$row_campos_detalhamento['bbh_cam_det_pro_default']); 
			if(count($options) > 1)
			{
				for($x = 0; $x < count($options); $x++)
				{
					echo "<option>".$options[$x]."</option>";
				}
			}else{
      
      ?>
       <option id="lista_vazia" value="lista_vazia">Listagem vazia</option>
      <?php } ?>
      </select>
      <?php if($disabled == ""){ ?>
        <a href="#" onClick="return RemListagem();"> <img src="/e-solution/servicos/bbhive/images/remVl.gif" alt="Remover da listagem" align="absmiddle" border="0" style="position:relative;" /></a>
		<?php } ?>
        <input type="hidden" name="menuCriadoValores" id="menuCriadoValores" value="<?php echo $row_campos_detalhamento['bbh_cam_det_pro_default']; ?>" /></td>
  </tr>
  <tr style="display:<?PHP echo $dinamico; ?>;background:#F7F7F7;" id="listagemDinamica">
    <td align="right" class="verdana_11_bold">Listas :&nbsp; </td>
    </td>
    <td align="left" class="verdana_11">
    <select name="menuListagemDinamica" id="menuListagemDinamica" class="back_Campos" style="position:relative;width:200px;" <?php echo $disabled; ?>>
        <?PHP
		$sql = '
		SELECT bbh_cam_list_titulo
		FROM `bbh_campo_lista_dinamica`
		GROUP BY bbh_cam_list_titulo
		ORDER BY bbh_cam_list_titulo
		';
        list($exec, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
		while( $fetch = mysqli_fetch_assoc($exec) )
		{	$selected = '';
			if( $row_campos_detalhamento['bbh_cam_det_flu_default'] == $fetch['bbh_cam_list_titulo']) $selected = ' selected';
			echo "<option id='lista_".$fetch['bbh_cam_list_titulo']."' value='".$fetch['bbh_cam_list_titulo']."'$selected>".$fetch['bbh_cam_list_titulo']."</option>";	
		}
		?>
      </select>
      </td>
  </tr>
  </tr>
      <?php 
		$linhaColuna = explode("|",$row_campos_detalhamento['bbh_cam_det_pro_tamanho']);
		$linha = 0;
		$coluna = 0;
		if(isset($linhaColuna[0]))
		{
			$linha = $linhaColuna[0];
		}
		
		if(isset($linhaColuna[1]))
		{
			$coluna = $linhaColuna[1];
		}


	?>
  <tr style="display:<?php echo $longo; ?>;background:#F7F7F7;" id="texto_longoLinha">
    <td align="right" class="verdana_11_bold" >Caracteres por linha :&nbsp;</td>
    <td align="left" class="verdana_11"><input type="text" name="texto_longoLinhaI" id="texto_longoLinhaI" class="back_Campos" onKeyUp="SomenteNumerico(this);" value="<?php echo $linha; ?>" <?php echo $disabled; ?>></td>
    </tr>
  <tr style="display:<?php echo $longo; ?>;background:#F7F7F7;" id="texto_longoColuna">
    <td align="right" class="verdana_11_bold" >Caracteres por coluna :&nbsp;</td>
    <td align="left" class="verdana_11"><input type="text" name="texto_longoColunaI" id="texto_longoColunaI" class="back_Campos" onKeyUp="SomenteNumerico(this);" value="<?php echo $coluna; ?>" <?php echo $disabled; ?>/></td>
  </tr>
  <tr style="display:<?php echo $longo; ?>;background:#F7F7F7;" id="texto_longoDefault">
    <td align="right" valign="top" class="verdana_11_bold">Valor padr&atilde;o :&nbsp;</td>
    <td align="left" class="verdana_11"><textarea name="bbh_cam_det_pro_defaultLongo" id="bbh_cam_det_pro_defaultLongo" cols="30" rows="3" class="back_Campos" <?php echo $disabled; ?>><?php echo $row_campos_detalhamento['bbh_cam_det_pro_default']; ?></textarea></td>
  </tr>
  
  
  
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Curinga :&nbsp;</td>
    <td align="left"><input type="text" name="bbh_cam_det_pro_curinga" id="bbh_cam_det_pro_curinga" class="back_Campos" value="<?php echo $row_campos_detalhamento['bbh_cam_det_pro_curinga']; ?>"></td>
  </tr>

    <tr class="legandaLabel11">
        <td height="25" align="right" class="verdana_11_bold">Apelido :&nbsp;</td>
        <td align="left"><input type="text" name="bbh_cam_det_pro_apelido" id="bbh_cam_det_pro_apelido" class="back_Campos" value="<?php echo $row_campos_detalhamento['bbh_cam_det_pro_apelido']; ?>"></td>
    </tr>

  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Observa&ccedil;&atilde;o :&nbsp;</td>
    <td align="left"><textarea name="bbh_cam_det_pro_descricao" id="bbh_cam_det_pro_descricao" cols="45" rows="5" class="back_Campos"><?php echo $row_campos_detalhamento['bbh_cam_det_pro_descricao']; ?></textarea></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Ativado : &nbsp;</td>
    <td align="left">
    <?php if($row_campos_detalhamento['bbh_cam_det_pro_fixo']=="1"){?>
    	<input type="hidden" name="bbh_cam_det_pro_disponivel" id="bbh_cam_det_pro_disponivel" value="1" readonly="readonly" />Sim
    <?php } else { ?>
        <select name="bbh_cam_det_pro_disponivel" id="bbh_cam_det_pro_disponivel" class="back_input">
        <option value="1" <?php echo $row_campos_detalhamento['bbh_cam_det_pro_disponivel'] == '1' ? 'selected' : ''; ?>>Sim</option>
          <option value="0" <?php echo $row_campos_detalhamento['bbh_cam_det_pro_disponivel'] == '0' ? 'selected' : ''; ?>>N&atilde;o</option>
        </select>
    <?php } ?>
    </td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Vis&iacute;vel : &nbsp;</td>
    <td align="left"><select name="bbh_cam_det_pro_visivel" id="bbh_cam_det_pro_visivel" class="back_input">
    <option value="1" <?php echo $row_campos_detalhamento['bbh_cam_det_pro_visivel'] == '1' ? 'selected' : ''; ?>>Sim</option>
      <option value="0" <?php echo $row_campos_detalhamento['bbh_cam_det_pro_visivel'] == '0' ? 'selected' : ''; ?>>N&atilde;o</option>
    </select></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Campo obrigat&oacute;rio : &nbsp;</td>
    <td align="left"><select name="bbh_cam_det_pro_obrigatorio" id="bbh_cam_det_pro_obrigatorio" class="back_input">
    <option value="1" <?php echo $row_campos_detalhamento['bbh_cam_det_pro_obrigatorio'] == '1' ? 'selected' : ''; ?>>Sim</option>
      <option value="0" <?php echo $row_campos_detalhamento['bbh_cam_det_pro_obrigatorio'] == '0' ? 'selected' : ''; ?>>N&atilde;o</option>
    </select></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Preencher somente ap&oacute;s recebimento&nbsp; <br />
      do(a) <?php echo $_SESSION['adm_protNome']; ?>:&nbsp;</td>
    <td align="left">
    <?php if($row_campos_detalhamento['bbh_cam_det_pro_fixo'] == "0"){?><select name="bbh_cam_det_pro_preencher_apos_receber" id="bbh_cam_det_pro_preencher_apos_receber" class="back_input">
    <option value="1" <?php echo $row_campos_detalhamento['bbh_cam_det_pro_preencher_apos_receber'] == '1' ? 'selected' : ''; ?>>Sim</option>
      <option value="0" <?php echo $row_campos_detalhamento['bbh_cam_det_pro_preencher_apos_receber'] == '0' ? 'selected' : ''; ?>>N&atilde;o</option>
    </select>
	<?php } else { ?>
    	<input name="bbh_cam_det_pro_preencher_apos_receber" id="bbh_cam_det_pro_preencher_apos_receber" type="hidden" value="0" readonly="readonly" />Não
    <?php } ?>  
    </td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">&nbsp;</td>
    <td align="left">
      <input name="button" type="button" class="back_input" id="button" value="Cancelar"  onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?aba=2','menuEsquerda|colCentro');" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF"/>
      <?php if($row_campos_detalhamento['bbh_cam_det_pro_fixo']=="1" && $row_campos_detalhamento['bbh_cam_det_pro_nome']=="bbh_dep_codigo"){
		  if($totalRows_departamentos==0){
			  echo "Não há departamentos cadastrados!";
		  } else { ?>
      		<input name="cadastra" type="button" class="back_input" id="cadastra" value="Editar campo" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" onClick="return validaForm('form1', 'bbh_cam_det_pro_titulo|Escolha o t&iacute;tulo do campo, bbh_cam_det_pro_tipo|Escolha o tipo do campo', document.getElementById('acaoForm').value)"/>
           <?php
		  }
      } else { ?>
      <input name="cadastra" type="button" class="back_input" id="cadastra" value="Editar campo" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" onClick="return validaForm('form1', 'bbh_cam_det_pro_titulo|Escolha o t&iacute;tulo do campo, bbh_cam_det_pro_tipo|Escolha o tipo do campo', document.getElementById('acaoForm').value)"/>
      <?php } ?>
      &nbsp;&nbsp;&nbsp; <input type="hidden" name="tipoCampo" id="tipoCampo" />
      <input type="hidden" name="bbh_cam_det_pro_codigo" id="bbh_cam_det_pro_codigo" value="<?php echo $_GET['bbh_cam_det_pro_codigo']; ?>" readonly/></td>
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
<input type="hidden" name="cadastrado" id="cadastrado" value="<?php echo $tabelaCriada; ?>" />
</form>
<?php
if( isset($detalhamento) )
mysqli_free_result($detalhamento);

if( isset($campos_detalhamento) )
mysqli_free_result($campos_detalhamento);
?>
