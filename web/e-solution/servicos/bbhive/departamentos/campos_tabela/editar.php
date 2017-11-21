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
	$homeDestinoII	= '/e-solution/servicos/bbhive/departamentos/campos_tabela/editar.php';
	$homeDestino	= '/e-solution/servicos/bbhive/departamentos/campos_tabela/editar.php';
	
	$onClick = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')";
	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','cadatraModelo','Alterando dados...','loadInser','1','".$TpMens."');";
	

//
// Troca a ordem
//
if( isset($_GET['bbh_cam_ind_codigo']) && isset($_GET['ordem']) )
{
	// Pega a ordem atual
    $query = "SELECT bbh_cam_ind_ordem FROM bbh_campo_indicio WHERE bbh_cam_ind_codigo = ".$_GET['bbh_cam_ind_codigo']." LIMIT 1";
    list($exe, $fth, $totalRows) = executeQuery($bbhive, $database_bbhive, $query);
	$atual = $fth['bbh_cam_ind_ordem'];
	
	// Qual a nova ordem 
	if( $_GET['ordem'] == "soma" )
		$nova = $fth['bbh_cam_ind_ordem'] + 1;	
	else
		$nova = $fth['bbh_cam_ind_ordem'] - 1;
	
	// Sqls
	$sql1 = "UPDATE bbh_campo_indicio SET bbh_cam_ind_ordem = 0 WHERE bbh_cam_ind_ordem = $nova";
	$sql2 = "UPDATE bbh_campo_indicio SET bbh_cam_ind_ordem = $nova WHERE bbh_cam_ind_ordem = $atual";
	$sql3 = "UPDATE bbh_campo_indicio SET bbh_cam_ind_ordem = $atual WHERE bbh_cam_ind_ordem = 0";
	//exit($sql1.";".$sql2.";".$sql3);
	// Cria as query que irão far os updates
    list($res, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql1);
    list($res, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql2);
    list($res, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql3);
	
	// Volta para HOME
	echo "<var>";
	echo "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?aba=3','menuEsquerda|colCentro');";
	echo "</var>";
}
	
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

  //recuperando os tipos:
  	$tipo = $_POST['bbh_cam_ind_tipo'];
	switch($tipo)
	{
		case "correio_eletronico":
			$tamanho = $_POST['bbh_cam_ind_tamanho'];
			$valor_padrao = $_POST['bbh_cam_ind_default']; 
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
			$tamanho = $_POST['bbh_cam_ind_tamanho'];
			$valor_padrao = $_POST['bbh_cam_ind_default']; 
		break;
		
		case "endereco_web":
			$tamanho = $_POST['bbh_cam_ind_tamanho'];
			$valor_padrao = $_POST['bbh_cam_ind_default']; 
		break;
		
		case "lista_opcoes":
			$tamanho = $_POST['bbh_cam_ind_tamanho'];
			$valor_padrao = $_POST['menuCriadoValores']; 
		break;
		
		case "lista_dinamica":
			$tamanho = $_POST['bbh_cam_det_flu_tamanho'];
			$valor_padrao = $_POST['menuListagemDinamica']; 
		break;
		
		case "numero_decimal":
			$tamanho = $_POST['bbh_cam_ind_tamanho'];
			  $valor_padrao = str_replace(".","",$_POST['bbh_cam_ind_default']);
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
			$valor_padrao = $_POST['bbh_cam_ind_defaultLongo']; 
		break;
		
		case "texto_simples":
			$tamanho = $_POST['bbh_cam_ind_tamanho'];
			$valor_padrao = $_POST['bbh_cam_ind_default']; 
		break;
		
		case "horario":
			$tamanho = '';
			$valor_padrao = $_POST['hh'] . ":" . $_POST['mm'] . ":" . $_POST['ss']; 
		break;
		case "time_stamp":
			$tamanho = '';
			$valor_padrao = '';		
		break;
		case "horario_editavel":
			$tamanho = '';
			$valor_padrao = '';
		break;
		
	}
	

		$nome_campo = "bbh_cam_det_" . $_POST['bbh_cam_ind_codigo'] . "_" . trataCaracteres(mysqli_fetch_assoc($_POST['bbh_cam_ind_titulo']));

		$query_campo_existente = sprintf("SELECT * FROM bbh_campo_indicio WHERE bbh_cam_ind_nome = %s AND bbh_cam_ind_codigo != %s", GetSQLValueString($bbhive, $nome_campo, "text"),GetSQLValueString($bbhive, $_POST['bbh_cam_ind_codigo'], "int"));
        list($campo_existente, $row_campo_existente, $totalRows_campo_existente) = executeQuery($bbhive, $database_bbhive, $query_campo_existente);

	if($totalRows_campo_existente == 0){

		$query_campo_existente = sprintf("SELECT * FROM bbh_campo_indicio WHERE bbh_cam_ind_curinga = %s AND bbh_cam_ind_codigo != %s", GetSQLValueString($bbhive, ($_POST['bbh_cam_ind_curinga']), "text"),GetSQLValueString($bbhive, $_POST['bbh_cam_ind_codigo'], "int"));
        list($campo_existente, $row_campo_existente, $totalRows_campo_existente) = executeQuery($bbhive, $database_bbhive, $query_campo_existente);
	
	if($totalRows_campo_existente > 0){
	  		 echo $Erro ="<span class='aviso' style='font-size:11;margin-left:20px;;margin-top:140px;position:absolute'>J&aacute; um curinga com este nome neste detalhamento&nbsp;</span>";
		exit;

	}else{


		if($_POST['cadastrado'] == 1)
		{
		 $updateSQL = sprintf("UPDATE bbh_campo_indicio SET bbh_cam_ind_titulo=%s, bbh_cam_ind_curinga=%s, bbh_cam_ind_descricao=%s, bbh_cam_ind_default=%s, bbh_cam_ind_disponivel=%s WHERE bbh_cam_ind_codigo=%s",
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_ind_titulo']), "text"),
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_ind_curinga']), "text"),
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_ind_descricao']), "text"),
					   GetSQLValueString($bbhive, ($valor_padrao), "text"),
					   GetSQLValueString($bbhive, $_POST['bbh_cam_ind_disponivel'], "text"),
                       GetSQLValueString($bbhive, $_POST['bbh_cam_ind_codigo'], "int"));
		 list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);

		}else{
		 $updateSQL = sprintf("UPDATE bbh_campo_indicio SET bbh_cam_ind_nome=%s, bbh_cam_ind_titulo=%s, bbh_cam_ind_tipo=%s, bbh_cam_ind_curinga=%s, bbh_cam_ind_descricao=%s, bbh_cam_ind_tamanho=%s, bbh_cam_ind_default=%s, bbh_cam_ind_disponivel=%s WHERE bbh_cam_ind_codigo=%s",
                       GetSQLValueString($bbhive, $nome_campo, "text"),
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_ind_titulo']), "text"),
                       GetSQLValueString($bbhive, $_POST['bbh_cam_ind_tipo'], "text"),
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_ind_curinga']), "text"),
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_ind_descricao']), "text"),
                       GetSQLValueString($bbhive, $tamanho, "text"),
                       GetSQLValueString($bbhive, ($valor_padrao), "text"),
					   GetSQLValueString($bbhive, $_POST['bbh_cam_ind_disponivel'], "text"),
                       GetSQLValueString($bbhive, $_POST['bbh_cam_ind_codigo'], "int"));

            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
  }
 }
 }else{
 
  		 $Erro ="<span class='aviso' style='font-size:11;margin-left:20px;margin-top:140px;position:absolute'>J&aacute; existe um campo com este t&iacute;tulo neste detalhamento&nbsp;</span>";
		exit;
  }
  	 echo "<var style='display:none'>showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?aba=3','menuEsquerda|colCentro')</var>";
	  exit;
}


$bbh_cam_ind_codigo = "-1";
if (isset($_GET['bbh_cam_ind_codigo'])) {
  $bbh_cam_ind_codigo = $_GET['bbh_cam_ind_codigo'];
}
$query_campos_detalhamento ="SELECT date_format(bbh_cam_ind_default,'%d/%m/%Y') as data, bbh_campo_indicio.* FROM bbh_campo_indicio WHERE bbh_cam_ind_codigo = $bbh_cam_ind_codigo";
list($campos_detalhamento, $row_campos_detalhamento, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento);

	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','form1','Cadastrando dados...','loadInser','1','".$TpMens."');";
//--
	$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
				WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_indicio'";
    list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
?>
<var style="display:none">txtSimples('tagPerfil', 'Cadastro campos de detalhamento - protocolo')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/detalhamento.gif" width="16" height="16" align="absmiddle" />Gerenciamento de detalhamento - <?php echo $_SESSION['adm_componentesNome']; ?></td>
  </tr>
  <tr>
    <td height="8"></td>
  </tr>
</table>
<div style="position:absolute; margin-left:-2px;" id="carregaTipo"></div>
<div style="position:absolute;" id="loadInser" class="legandaLabel11"></div>
    <?php 
		//Isse bloco verifica se os campos que possuem o atributo tamanho mostra ao iniciar ou não
		$is_float = false;	
		$is_number = false;	
		switch($row_campos_detalhamento['bbh_cam_ind_tipo'])
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
				$opcoesHidden = $row_campos_detalhamento['bbh_cam_ind_default'];					
			break;
			
			case "lista_dinamica":
				$tamanho = "none";	
				$valor_padrao = "none";
				$data = "none";
				$lista = "none";
				$dinamico = "";
				$hora = "none";	
				$longo = "none";
				$opcoesHidden = $row_campos_detalhamento['bbh_cam_ind_default'];					
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
    <td width="170" height="25" align="right" class="verdana_11_bold">Titulo :&nbsp;</td>
    <td align="left"><input name="bbh_cam_ind_titulo" type="text" class="back_Campos" id="bbh_cam_ind_titulo" value="<?php echo $row_campos_detalhamento['bbh_cam_ind_titulo']; ?>" size="60"></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Tipo :&nbsp;</td>
    <td align="left">
    <select name="bbh_cam_ind_tipo" id="bbh_cam_ind_tipo" class="back_Campos" onChange="showCamposProtocolo(this);" <?php echo $disabled; ?>>
      <option value="" <?php if (!(strcmp("", $row_campos_detalhamento['bbh_cam_ind_tipo']))) {echo "selected=\"selected\"";} ?>>Escolha</option>
      <option value="correio_eletronico" <?php if (!(strcmp("correio_eletronico", $row_campos_detalhamento['bbh_cam_ind_tipo']))) {echo "selected=\"selected\"";} ?>>Correio eletr&ocirc;nico</option>
      <option value="data" <?php if (!(strcmp("data", $row_campos_detalhamento['bbh_cam_ind_tipo']))) {echo "selected=\"selected\"";} ?>>Data</option>
      <option value="time_stamp" <?php if (!(strcmp("time_stamp", $row_campos_detalhamento['bbh_cam_ind_tipo']))) {echo "selected=\"selected\"";} ?>>Data / Hora atual</option>
      <option value="horario_editavel" <?php if (!(strcmp("horario_editavel", $row_campos_detalhamento['bbh_cam_ind_tipo']))) {echo "selected=\"selected\"";} ?>>Data / Hora edit&aacute;vel</option>
      <option value="endereco_web" <?php if (!(strcmp("endereco_web", $row_campos_detalhamento['bbh_cam_ind_tipo']))) {echo "selected=\"selected\"";} ?>>Endere&ccedil;o web</option>
      <option value="lista_opcoes" <?php if (!(strcmp("lista_opcoes", $row_campos_detalhamento['bbh_cam_ind_tipo']))) {echo "selected=\"selected\"";} ?>>Lista de op&ccedil;&otilde;es</option>
      <option value="lista_dinamica" <?php if (!(strcmp("lista_dinamica", $row_campos_detalhamento['bbh_cam_ind_tipo']))) {echo "selected=\"selected\"";} ?>>Lista din&acirc;mica</option>
      <option value="numero" <?php if (!(strcmp("numero", $row_campos_detalhamento['bbh_cam_ind_tipo']))) {echo "selected=\"selected\"";} ?>>N&uacute;mero</option>
      <option value="numero_decimal" <?php if (!(strcmp("numero_decimal", $row_campos_detalhamento['bbh_cam_ind_tipo']))) {echo "selected=\"selected\"";} ?>>N&uacute;mero decimal</option>
      <option value="texto_longo" <?php if (!(strcmp("texto_longo", $row_campos_detalhamento['bbh_cam_ind_tipo']))) {echo "selected=\"selected\"";} ?>>Texto longo</option>
      <option value="texto_simples" <?php if (!(strcmp("texto_simples", $row_campos_detalhamento['bbh_cam_ind_tipo']))) {echo "selected=\"selected\"";} ?>>Texto simples</option>
    </select>    </td>
  </tr>
  <tr style="display:none;background:#F7F7F7;background:#F7F7F7;" id="Tamanho">
    <td align="right" class="verdana_11_bold">*Tamanho :&nbsp; </td>
    <td align="left" class="verdana_11"><label>
      <input name="bbh_cam_ind_tamanho" type="text" class="back_Campos" id="bbh_cam_ind_tamanho" value="<?php echo $row_campos_detalhamento['bbh_cam_ind_tamanho']; ?>" <?php echo $disabled; ?>>
    </label></td>
  </tr>
  
<?php 
  if($row_campos_detalhamento['bbh_cam_ind_fixo']=="1" && $row_campos_detalhamento['bbh_cam_ind_nome']=="bbh_ind_sigilo"){
	//
	// Lê as confirgurações
	$xmlParse = simplexml_load_file( $_SESSION['caminhoFisico']."/../database/servicos/bbhive/nivel_informacao.xml" );
	foreach( $xmlParse as $value ){ $values[ (int) $value['nivel'] ] = (string) $value['valor']; }
	// Fim das configurações
	//
?>
  <tr style="background:#F7F7F7;" id="VlPadraoData">
    <td align="right" class="verdana_11_bold">Valor padr&atilde;o :&nbsp;</td>
    <td align="left" class="verdana_11">
    <select name="codDepartamento" id="codDepartamento" onchange="document.getElementById('menuCriadoValores').value = this.value;" class="verdana_11">
    <?PHP //
	reset( $values );
					
	//
	foreach( $values as $indice => $value )
	{
		$select = ($indice==$row_campos_detalhamento['bbh_cam_ind_default'])?' selected':'';
		echo sprintf( "<option value='%s'%s>%s</option>", $indice, $select, $value);
	}
	?>
    </select>
    <input name="menuCriadoValores" type="hidden" class="back_Campos" id="menuCriadoValores" size="30" value="<?php echo $row_campos_detalhamento['bbh_cam_ind_default']; ?>" readonly="readonly"/>
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
				$valor_default = Real($row_campos_detalhamento['bbh_cam_ind_default']); ?>
				      <input name="bbh_cam_ind_default" type="text" class="back_Campos" id="bbh_cam_ind_default" size="30" value="<?php echo $valor_default; ?>" onKeyPress="return(MascaraMoeda(this,'.',',',event))" <?php echo $disabled; ?>>

 		 <?php }else if($is_number == true){ 
         	$valor_default = $row_campos_detalhamento['bbh_cam_ind_default']; ?>
          <input name="bbh_cam_ind_default" type="text" class="back_Campos" id="bbh_cam_ind_default" size="30" value="<?php echo $valor_default; ?>" onkeyup="SomenteNumerico(this);" <?php echo $disabled; ?>/>

			<?php }else{
				$valor_default = $row_campos_detalhamento['bbh_cam_ind_default']; ?>
                      <input name="bbh_cam_ind_default" type="text" class="back_Campos" id="bbh_cam_ind_default" size="30" value="<?php echo $valor_default; ?>" <?php echo $disabled; ?>/>

			<?php }
	?>
    </label></td>
  </tr>
  
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
      		$options = explode("|",$row_campos_detalhamento['bbh_cam_ind_default']); 
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
        <input type="hidden" name="menuCriadoValores" id="menuCriadoValores" value="<?php echo $row_campos_detalhamento['bbh_cam_ind_default']; ?>" /></td>
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
        list($exec, $fetch, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
		while( $fetch = mysqli_fetch_assoc($exec) )
		{	$selected = '';
			if( $row_campos_detalhamento['bbh_cam_det_flu_default'] == $fetch['bbh_cam_list_titulo']) $selected = ' selected';
			echo "<option id='lista_".$fetch['bbh_cam_list_titulo']."' value='".$fetch['bbh_cam_list_titulo']."'$selected>".$fetch['bbh_cam_list_titulo']."</option>";	
		}
		?>
      </select>
      </td>
  </tr>
      <?php 
		$linhaColuna = explode("|",$row_campos_detalhamento['bbh_cam_ind_tamanho']);
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
    
  <?php } ?>
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
    <td align="left" class="verdana_11"><textarea name="bbh_cam_ind_defaultLongo" id="bbh_cam_ind_defaultLongo" cols="30" rows="3" class="back_Campos" <?php echo $disabled; ?>><?php echo $row_campos_detalhamento['bbh_cam_ind_default']; ?></textarea></td>
  </tr>
  
  
  
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Curinga :&nbsp;</td>
    <td align="left"><input type="text" name="bbh_cam_ind_curinga" id="bbh_cam_ind_curinga" class="back_Campos" value="<?php echo $row_campos_detalhamento['bbh_cam_ind_curinga']; ?>"></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Observa&ccedil;&atilde;o :&nbsp;</td>
    <td align="left"><textarea name="bbh_cam_ind_descricao" id="bbh_cam_ind_descricao" cols="45" rows="5" class="back_Campos"><?php echo $row_campos_detalhamento['bbh_cam_ind_descricao']; ?></textarea></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Ativado : &nbsp;</td>
    <td align="left"><select name="bbh_cam_ind_disponivel" id="bbh_cam_ind_disponivel" class="back_input">
    <option value="1" <?php echo $row_campos_detalhamento['bbh_cam_ind_disponivel'] == '1' ? 'selected' : ''; ?>>Sim</option>
      <option value="0" <?php echo $row_campos_detalhamento['bbh_cam_ind_disponivel'] == '0' ? 'selected' : ''; ?>>N&atilde;o</option>
    </select></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">&nbsp;</td>
    <td align="left">
      <input name="button" type="button" class="back_input" id="button" value="Cancelar"  onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?aba=3','menuEsquerda|colCentro');" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF"/>
      <input name="cadastra" type="button" class="back_input" id="cadastra" value="Editar campo" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" onClick="return validaForm('form1', 'bbh_cam_ind_titulo|Escolha o t&iacute;tulo do campo, bbh_cam_ind_tipo|Escolha o tipo do campo', document.getElementById('acaoForm').value)"/>
      &nbsp;&nbsp;&nbsp; <input type="hidden" name="tipoCampo" id="tipoCampo" />
      <input type="hidden" name="bbh_cam_ind_codigo" id="bbh_cam_ind_codigo" value="<?php echo $_GET['bbh_cam_ind_codigo']; ?>" readonly/></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>

  <tr>
    <td height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
    <td width="644" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
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
