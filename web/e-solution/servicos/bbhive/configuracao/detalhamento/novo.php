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
	$homeDestinoII	= '/e-solution/servicos/bbhive/configuracao/detalhamento/novo.php';
	$homeDestino	= '';
	
	$onClick = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')";
	
	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','cadatraModelo','Alterando dados...','loadInser','1','".$TpMens."');";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

  //recuperando os tipos:
  	$tipo = $_POST['bbh_cam_det_pro_tipo'];
	
	switch($tipo){
		case "correio_eletronico":
			$tamanho 		= $_POST['bbh_cam_det_pro_tamanho'];
			$valor_padrao 	= $_POST['bbh_cam_det_pro_default']; 
		break;
		
		case "data":
			if($_POST['theDate'] != ""){
				$data = substr($_POST['theDate'],6,4) . "-";
				$data .= substr($_POST['theDate'],3,2) . "-";
				$data .= substr($_POST['theDate'],0,2);
			}else{
				$data = '';
			}
			$tamanho 		= '';
			$valor_padrao 	= $data; 
		
		break;
		
		case "numero":
			$tamanho 		= $_POST['bbh_cam_det_pro_tamanho'];
			$valor_padrao 	= $_POST['bbh_cam_det_pro_default']; 
		break;
		
		case "endereco_web":
			$tamanho 		= $_POST['bbh_cam_det_pro_tamanho'];
			$valor_padrao 	= $_POST['bbh_cam_det_pro_default']; 
		break;
		
		case "lista_opcoes":
			$tamanho 		= $_POST['bbh_cam_det_pro_tamanho'];
			$valor_padrao 	= $_POST['menuCriadoValores']; 
		break;
		
		case "lista_dinamica":
			$tamanho = 255;
			$valor_padrao = $_POST['menuListagemDinamica']; 
		break;
		
		case "numero_decimal":
			$tamanho = $_POST['bbh_cam_det_pro_tamanho'];
			  $valor_padrao = str_replace(".","",$_POST['bbh_cam_det_pro_default']);
  			  $valor_padrao = str_replace(",",".",$valor_padrao);
			
		break;
		
		case "texto_longo":
			if($_POST['texto_longoLinhaI'] == ""){
				$linha = 50;
			}else{
				$linha = $_POST['texto_longoLinhaI'];
			}
			
			if($_POST['texto_longoColunaI'] == ""){
				$coluna = 5;
			}else{
				$coluna = $_POST['texto_longoColunaI'];
			}
			
			$tamanho 		= $linha . "|" . $coluna;
			$valor_padrao 	= $_POST['bbh_cam_det_pro_defaultLongo']; 
		break;
		
		case "texto_simples":
			$tamanho 		= $_POST['bbh_cam_det_pro_tamanho'];
			$valor_padrao 	= $_POST['bbh_cam_det_pro_default']; 
		break;
		
		case "horario":
			$tamanho 		= '';
			$valor_padrao 	= $_POST['hh'] . ":" . $_POST['mm'] . ":" . $_POST['ss']; 
		break;
		case "time_stamp":
			$tamanho 		= '';
			$valor_padrao 	= '';		
		break;
        case "json":
		case "horario_editavel":
			$tamanho 		= '';
			$valor_padrao 	= '';
		break;
	}
	//--
		//$nome_campo = "bbh_cam_det_" . $_POST['bbh_det_pro_codigo'] . "_" . trataCaracteres(mysqli_fetch_assoc($_POST['bbh_cam_det_pro_titulo']));
		//$nome_campo = "bbh_cam_det_" . $ultimoId;// . "_" . 

	//--Ultimo ID
		$query_last_id = "SELECT max(bbh_cam_det_pro_codigo) bbh_cam_det_pro_codigo, max(bbh_cam_det_pro_ordem) bbh_cam_det_pro_ordem FROM bbh_campo_detalhamento_protocolo limit 1";
        list($last_id, $row_last_id, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_last_id);
		$proximaOrdem 	= $row_last_id['bbh_cam_det_pro_ordem'] > 0 ? $row_last_id['bbh_cam_det_pro_ordem']+1 : 1;
	//--
	
		$proximaOrdem 	= $proximaOrdem;
		$nome_campo 	= "bbh_cam_det_pro_";
		$titulo			= ($_POST['bbh_cam_det_pro_titulo']);

		$query_campo_existente = sprintf("SELECT * FROM bbh_campo_detalhamento_protocolo WHERE bbh_cam_det_pro_curinga = %s  AND bbh_cam_det_pro_titulo = %s AND bbh_cam_det_pro_codigo = %s", GetSQLValueString($bbhive, ($_POST['bbh_cam_det_pro_curinga']), "text"), GetSQLValueString($bbhive, $titulo, "text"), GetSQLValueString($bbhive, $_POST['bbh_det_pro_codigo'], "int"));
        list($campo_existente, $row_campo_existente, $totalRows_campo_existente) = executeQuery($bbhive, $database_bbhive, $query_campo_existente);
	
	if($totalRows_campo_existente > 0){
	  		 echo $Erro ="<span class='aviso' style='font-size:11;margin-left:20px;'>J&aacute; um curinga com este t&iacute;tulo e/ou curinga neste detalhamento</span>";
		exit;

	}else{
	
	$insertSQL = sprintf("INSERT INTO bbh_campo_detalhamento_protocolo (bbh_cam_det_pro_nome, bbh_cam_det_pro_titulo, bbh_cam_det_pro_tipo, bbh_cam_det_pro_curinga, bbh_cam_det_pro_apelido, bbh_cam_det_pro_descricao, bbh_cam_det_pro_tamanho, bbh_cam_det_pro_default, bbh_cam_det_pro_ordem, bbh_cam_det_pro_visivel, bbh_cam_det_pro_preencher_apos_receber) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($bbhive, $nome_campo, "text"),
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_det_pro_titulo']), "text"),
                       GetSQLValueString($bbhive, $_POST['bbh_cam_det_pro_tipo'], "text"),
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_det_pro_curinga']), "text"),
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_det_pro_apelido']), "text"),
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_det_pro_descricao']), "text"),
                       GetSQLValueString($bbhive, $tamanho, "text"),
                       GetSQLValueString($bbhive, ($valor_padrao), "text"),
					   GetSQLValueString($bbhive, $proximaOrdem, "text"),
					   GetSQLValueString($bbhive, $_POST['bbh_cam_det_pro_visivel'], "text"),
					   GetSQLValueString($bbhive, $_POST['bbh_cam_det_pro_preencher_apos_receber'], "text"));

    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
    $ultimoId= mysqli_insert_id($bbhive);
  
  	  //--Atualiza nome do campo
	  $nome_campo 	= "bbh_cam_det_pro_" . $ultimoId;
	  //--
		$updateSQL = "UPDATE bbh_campo_detalhamento_protocolo SET bbh_cam_det_pro_nome='$nome_campo' WHERE bbh_cam_det_pro_codigo=$ultimoId";
        list($res, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
  	  //--
	  
 if($_POST['cadastrado'] == 1){	  //Se a tabela já tiver sido criada, ela deve dar um ALTER TABLE ADD	

		$alterTable = "ALTER TABLE bbh_detalhamento_protocolo ADD " . descobreValorDinamico($nome_campo, $_POST['bbh_cam_det_pro_tipo'],$tamanho,0,$valor_padrao);
        list($res, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $alterTable);
	}
  }
  
	 echo "<var style='display:none'>showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?aba=2','menuEsquerda|colCentro')</var>";
	  exit;
}

	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','form1','Cadastrando dados...','loadInser','1','".$TpMens."');";
//--
	$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
				WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_detalhamento_protocolo'";
    list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
//--
	$query_proximoId = "SELECT (COALESCE(bbh_cam_det_pro_codigo,0)+1) as id FROM bbh_campo_detalhamento_protocolo";
    list($proximoId, $row_proximoId, $totalRows_proximoId) = executeQuery($bbhive, $database_bbhive, $query_proximoId);
//--
	$proximoId = $totalRows_proximoId==0 ? 1 : $row_proximoId['id'];
?>
<var style="display:none">txtSimples('tagPerfil', 'Cadastro campos de detalhamento - protocolo')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/detalhamento.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de detalhamento - <?php echo $_SESSION['adm_protNome']; ?></td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?aba=2','menuEsquerda|colCentro');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
</table>
<div style="position:absolute; margin-left:-2px;" id="carregaTipo"></div>
<div style="position:absolute;" id="loadInser" class="legandaLabel11"></div>
<form method="POST" action="" name="form1">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="borderAlljanela" style="margin-top:20px;">
  <tr class="legandaLabel11">
    <td height="26" colspan="2" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" class="verdana_11_bold">&nbsp;Novo campo de detalhamento</td>
  </tr>
  <tr class="legandaLabel11">
    <td width="254" height="25" align="right" class="verdana_11_bold">Titulo :&nbsp;</td>
    <td align="left"><input name="bbh_cam_det_pro_titulo" type="text" class="back_Campos" id="bbh_cam_det_pro_titulo" size="60"></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Tipo :&nbsp;</td>
    <td align="left">
    <select name="bbh_cam_det_pro_tipo" id="bbh_cam_det_pro_tipo" class="back_Campos" onChange="showCamposProtocolo(this);">
      <option value="">Escolha</option>
      <option value="correio_eletronico">Correio eletr&ocirc;nico</option>
      <option value="data">Data</option>
      <option value="time_stamp">Data / Hora atual</option>
      <option value="horario_editavel">Data / Hora edit&aacute;vel</option>
      <option value="endereco_web">Endere&ccedil;o web</option>
      <option value="lista_opcoes">Lista de op&ccedil;&otilde;es</option>
      <option value="lista_dinamica">Lista din&acirc;mica</option>
      <option value="numero">N&uacute;mero</option>
      <option value="numero_decimal">N&uacute;mero decimal</option>
      <option value="texto_longo">Texto longo</option>
      <option value="texto_simples">Texto simples</option>
      <option value="json">Integração de sistemas (JSON)</option>
    </select>    </td>
  </tr>
  <tr style="display:none;background:#F7F7F7;background:#F7F7F7;" id="Tamanho">
    <td align="right" class="verdana_11_bold">*Tamanho :&nbsp; </td>
    <td align="left" class="verdana_11"><label>
      <input type="text" name="bbh_cam_det_pro_tamanho" id="bbh_cam_det_pro_tamanho" class="back_Campos" >
    </label></td>
  </tr>
  <tr style="display:none;background:#F7F7F7;" id="VlPadraoData">
    <td align="right" class="verdana_11_bold">Valor padr&atilde;o :&nbsp;</td>
    <td align="left" class="verdana_11"><input name="theDate" type="text" class="back_Campos" id="theDate" size="13" onKeyPress="MascaraData(event, this)" maxlength="10"/>
        <input type="button" style="width:23px;height:21px;" class="botao_calendar" onclick="displayCalendar(document.form1.theDate,'dd/mm/yyyy',this)"/></td>
  </tr>
  <tr style="display:none;background:#F7F7F7;" id="VlPadrao">
    <td align="right" class="verdana_11_bold">Valor padr&atilde;o :&nbsp; </td>
    <td align="left" class="verdana_11"><label>
      <input name="bbh_cam_det_pro_default" type="text" class="back_Campos" id="bbh_cam_det_pro_default" size="30">
    </label></td>
  </tr>
  <tr style="display:none;background:#F7F7F7;" id="listagem">
    <td align="right" class="verdana_11_bold" >Valor  a ser adicionado :&nbsp; </td>
    <td align="left" class="verdana_11"><label>
      <input name="listagemI" type="text" class="verdana_11" id="listagemI" size="50" maxlength="150" onKeyUp="return cadListagem();">
      </label>
      <a href="#" onClick="return AddListagem();"> <img src="/e-solution/servicos/bbhive/images/addVl.gif" alt="Adicionar na listagem" width="16" height="16" align="absmiddle" border="0"> </a> </td>
  </tr>
  <tr style="display:none;background:#F7F7F7;" id="listagemCriada">
    <td align="right" class="verdana_11_bold" ><span class="verdana_11">Lista atual :&nbsp;</span></td>
    <td align="left" class="verdana_11"><select name="menuCriado" id="menuCriado" class="back_Campos" style="position:relative;width:400px;">
        <option id="lista_vazia" value="lista_vazia">Listagem vazia</option>
      </select>
        <a href="#" onclick="return RemListagem();"> <img src="/e-solution/servicos/bbhive/images/remVl.gif" alt="Remover da listagem" align="absmiddle" border="0" style="position:relative;" /></a>
        <input type="hidden" name="menuCriadoValores" id="menuCriadoValores" /></td>
  </tr>
   <tr style="display:none;background:#F7F7F7;" id="listagemDinamica">
    <td align="right" class="verdana_11_bold" ><span class="verdana_11">Listas :&nbsp;</span></td>
    <td align="left" class="verdana_11">
    <select name="menuListagemDinamica" id="menuListagemDinamica" class="back_Campos" style="position:relative;width:200px;">
        <?PHP
		$sql = '
		SELECT bbh_cam_list_titulo
		FROM `bbh_campo_lista_dinamica`
		GROUP BY bbh_cam_list_titulo
		ORDER BY bbh_cam_list_titulo
		';

        list($exec, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql);
		while( $fetch = mysqli_fetch_assoc($exec) )
		{
			echo "<option id='lista_".$fetch['bbh_cam_list_titulo']."' value='".$fetch['bbh_cam_list_titulo']."'>".$fetch['bbh_cam_list_titulo']."</option>";	
		}
		?>
      </select>
      </td>
  </tr>

  <tr style="display:none;background:#F7F7F7;" id="texto_longoLinha">
    <td align="right" class="verdana_11_bold" >Caracteres por linha :&nbsp;</td>
    <td align="left" class="verdana_11"><input type="text" name="texto_longoLinhaI" id="texto_longoLinhaI" class="back_Campos" onkeyup="SomenteNumerico(this);"></td>
    </tr>
  <tr style="display:none;background:#F7F7F7;" id="texto_longoColuna">
    <td align="right" class="verdana_11_bold" >Caracteres por coluna :&nbsp;</td>
    <td align="left" class="verdana_11"><input type="text" name="texto_longoColunaI" id="texto_longoColunaI" class="back_Campos" onkeyup="SomenteNumerico(this);"></td>
  </tr>
  <tr style="display:none;background:#F7F7F7;" id="texto_longoDefault">
    <td align="right" valign="top" class="verdana_11_bold">Valor padr&atilde;o :&nbsp;</td>
    <td align="left" class="verdana_11"><textarea name="bbh_cam_det_pro_defaultLongo" id="bbh_cam_det_pro_defaultLongo" cols="30" rows="3" class="back_input"></textarea></td>
  </tr>
  
  
  
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Curinga :&nbsp;</td>
    <td align="left"><input type="text" name="bbh_cam_det_pro_curinga" id="bbh_cam_det_pro_curinga" class="back_Campos"></td>
  </tr>
    <tr class="legandaLabel11">
        <td height="25" align="right" class="verdana_11_bold">Apelido :&nbsp;</td>
        <td align="left"><input type="text" name="bbh_cam_det_pro_apelido" id="bbh_cam_det_pro_apelido" class="back_Campos"></td>
    </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Observa&ccedil;&atilde;o :&nbsp;</td>
    <td align="left"><textarea name="bbh_cam_det_pro_descricao" id="bbh_cam_det_pro_descricao" cols="45" rows="5" class="back_Campos"></textarea></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Vis&iacute;vel : &nbsp;</td>
    <td align="left"><select name="bbh_cam_det_pro_visivel" id="bbh_cam_det_pro_visivel" class="back_input">
    <option value="1">Sim</option>
      <option value="0">N&atilde;o</option>
    </select></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Campo obrigat&oacute;rio : &nbsp;</td>
    <td align="left"><select name="bbh_cam_det_pro_obrigatorio" id="bbh_cam_det_pro_obrigatorio" class="back_input">
    <option value="1">Sim</option>
      <option value="0">N&atilde;o</option>
    </select></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Preencher somente ap&oacute;s recebimento&nbsp; <br />
      do(a) <?php echo $_SESSION['adm_protNome']; ?>:&nbsp;</td>
    <td align="left"><select name="bbh_cam_det_pro_preencher_apos_receber" id="bbh_cam_det_pro_preencher_apos_receber" class="back_input">
      <option value="0">N&atilde;o</option>
	  <option value="1">Sim</option>
    </select></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">&nbsp;</td>
    <td align="left">
      <input name="button" type="button" class="back_input" id="button" value="Cancelar"  onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?aba=2','menuEsquerda|colCentro');" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF"/>
      
	  <?php
if($tabelaCriada == 0){
	$alerta = "return validaForm('form1', 'bbh_cam_det_pro_titulo|Escolha o t&iacute;tulo do campo, bbh_cam_det_pro_tipo|Escolha o tipo do campo', document.getElementById('acaoForm').value)";
}else{
	$alerta = "if(confirm('O tipo do campo não poderá ser alterado posteriormente. Deseja continuar?')){return validaForm('form1', 'bbh_cam_det_pro_titulo|Escolha o t&iacute;tulo do campo, bbh_cam_det_pro_tipo|Escolha o tipo do campo', document.getElementById('acaoForm').value)}";
}
	  ?>
	  <input name="cadastra" type="button" class="back_input" id="cadastra" value="Cadastrar campo" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" onclick="<?php echo $alerta; ?>"/>
	  
	  &nbsp;&nbsp;&nbsp; <input type="hidden" name="tipoCampo" id="tipoCampo" />
      <input name="bbh_det_pro_codigo" type="hidden" id="bbh_det_pro_codigo" value="<?php echo $proximoId; ?>"></td>
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
if( isset($detalhamento) )
mysqli_free_result($detalhamento);
?>
