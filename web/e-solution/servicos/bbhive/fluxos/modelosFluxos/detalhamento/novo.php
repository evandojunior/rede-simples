<?php require_once('../../../../../../Connections/bbhive.php'); ?>
<?php require_once('includes/functions.php'); ?>
<?php

include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


    $listFields = listDynamicFormType();
	$idMensagemFinal= 'carregaTipo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/escTipo.php';
	$homeDestinoII	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/detalhamento/novo.php';
	
	$onClick = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')";
	
	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','cadatraModelo','Alterando dados...','loadInser','1','".$TpMens."');";
	
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

    //recuperando os tipos:
  	$tipo = $_POST['bbh_cam_det_flu_tipo'];

    list($tamanho, $valor_padrao) = parseDynamicFormType();
    $nome_campo = "bbh_cam_det_" . $_POST['bbh_det_flu_codigo'] . "_" . trataCaracteres($_POST['bbh_cam_det_flu_titulo']);

    $query_campo_existente = sprintf("SELECT * FROM bbh_campo_detalhamento_fluxo WHERE bbh_cam_det_flu_nome = %s", GetSQLValueString($bbhive, $nome_campo, "text"));
    list($campo_existente, $row_campo_existente, $totalRows_campo_existente) = executeQuery($bbhive, $database_bbhive, $query_campo_existente);

	if($totalRows_campo_existente == 0){
		$query_campo_existente = sprintf("SELECT * FROM bbh_campo_detalhamento_fluxo WHERE bbh_cam_det_flu_curinga = %s AND bbh_det_flu_codigo = %s", GetSQLValueString($bbhive, ($_POST['bbh_cam_det_flu_curinga']), "text"),GetSQLValueString($bbhive, $_POST['bbh_det_flu_codigo'], "int"));
        list($campo_existente, $row_campo_existente, $totalRows_campo_existente) = executeQuery($bbhive, $database_bbhive, $query_campo_existente);
	
	    if($totalRows_campo_existente > 0){
	  		 echo $Erro ="<span class='aviso' style='font-size:11;margin-left:20px;'>J&aacute; um curinga com este nome neste ".$_SESSION['adm_FluxoNome']."&nbsp;</span>";
		exit;

	    } else {
	    $insertSQL = sprintf("INSERT INTO bbh_campo_detalhamento_fluxo (bbh_cam_det_flu_nome, bbh_cam_det_flu_titulo, bbh_cam_det_flu_tipo, bbh_cam_det_flu_curinga, bbh_cam_det_flu_apelido, bbh_cam_det_flu_descricao, bbh_det_flu_codigo, bbh_cam_det_flu_tamanho, bbh_cam_det_flu_preencher_inicio, bbh_cam_det_flu_obrigatorio, bbh_cam_det_flu_default) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($bbhive, $nome_campo, "text"),
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_det_flu_titulo']), "text"),
                       GetSQLValueString($bbhive, $_POST['bbh_cam_det_flu_tipo'], "text"),
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_det_flu_curinga']), "text"),
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_det_flu_apelido']), "text"),
                       GetSQLValueString($bbhive, ($_POST['bbh_cam_det_flu_descricao']), "text"),
                       GetSQLValueString($bbhive, $_POST['bbh_det_flu_codigo'], "int"),
                       GetSQLValueString($bbhive, $tamanho, "text"),
					   GetSQLValueString($bbhive, $_POST['bbh_cam_det_flu_preencher_inicio'], "text"),
					   GetSQLValueString($bbhive, $_POST['bbh_cam_det_flu_obrigatorio'], "text"),
                       GetSQLValueString($bbhive, ($valor_padrao), "text"));

            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);

            if($_POST['cadastrado'] == 1){	  //Se a tabela já tiver sido criada, ela deve dar um ALTER TABLE ADD

                 $codigo_modelo_fluxo = $_POST['bbh_mod_flu_codigo'];
                $nome_tabela = "bbh_modelo_fluxo_".$codigo_modelo_fluxo."_detalhado";
                $alterTable = "ALTER TABLE $nome_tabela ADD " . descobreValorDinamico($nome_campo, $_POST['bbh_cam_det_flu_tipo'],$tamanho,0,$valor_padrao);
                list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $alterTable);
            }
          }
      }else{
             echo $Erro ="<span class='aviso' style='font-size:11;margin-left:20px;'>J&aacute; existe um campo com este t&iacute;tulo neste ".$_SESSION['adm_FluxoNome']."&nbsp;</span>";
            exit;
      }
  
	 echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|fluxos/modelosFluxos/detalhamento/index.php?bbh_mod_flu_codigo=".$_POST['bbh_mod_flu_codigo']."','menuEsquerda|conteudoGeral')</var>";
	  exit;
}

$codigo_modelo_fluxo = $_GET['bbh_mod_flu_codigo'];

  //--Verifica se está na tabela de bbh_detalhamento_fluxo
	$sq = "select * from bbh_detalhamento_fluxo where bbh_mod_flu_codigo = ".$codigo_modelo_fluxo ;
    list($temRelacao, $rows, $totalRelacao) = executeQuery($bbhive, $database_bbhive, $sq, $initResult = false);
		//--
		if($totalRelacao == 0){
			$is = "INSERT INTO bbh_detalhamento_fluxo (bbh_mod_flu_codigo, bbh_det_flu_tabela_criada) values ($codigo_modelo_fluxo, 0)";
            list($rs, $rows, $totalRowns) = executeQuery($bbhive, $database_bbhive, $is, $initResult = false);
		}

$query_detalhamento = sprintf("SELECT * FROM bbh_detalhamento_fluxo WHERE bbh_mod_flu_codigo = %s", GetSQLValueString($bbhive, $codigo_modelo_fluxo, "int"));
list($detalhamento, $row_detalhamento, $totalRows_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_detalhamento);

	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','form1','Cadastrando dados...','loadInser','1','".$TpMens."');";
?>
<var style="display:none">txtSimples('tagPerfil', 'Cadastro de modelos de  <?php echo $_SESSION['adm_FluxoNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td width="55%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/detalhamento.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de detalhamento do fluxo  <?php echo $_SESSION['adm_FluxoNome']; ?></td>
    <td width="32%" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|fluxos/modelosFluxos/detalhamento/index.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>','menuEsquerda|colCentro');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="3"></td>
  </tr>
</table>
<?php require_once('../modelosAtividades/cabecaModelo.php'); ?>
<br />

<div style="position:absolute; margin-left:-2px;" id="carregaTipo"></div>
<div style="position:absolute;" id="loadInser" class="legandaLabel11"></div>
<form method="POST" action="<?php echo $editFormAction; ?>" name="form1">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="borderAlljanela" style="margin-top:50px;">
  <tr class="legandaLabel11">
    <td height="26" colspan="2" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" class="verdana_11_bold">&nbsp;Novo campo de detalhamento</td>
  </tr>
  <tr class="legandaLabel11">
    <td width="175" height="25" align="right" class="verdana_11_bold">Titulo :&nbsp;</td>
    <td align="left"><input name="bbh_cam_det_flu_titulo" type="text" class="back_Campos" id="bbh_cam_det_flu_titulo" size="60"></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Tipo :&nbsp;</td>
    <td align="left">
        <select name="bbh_cam_det_flu_tipo" id="bbh_cam_det_flu_tipo" class="back_Campos" onChange="showCampos(this);">
          <option value="">Escolha</option>
            <?php
                foreach($listFields as $type => $title) {
                    echo sprintf('<option value="%s">%s</option>', $type, $title);
                }
            ?>
        </select>
    </td>
  </tr>
  <tr style="display:none;background:#F7F7F7;background:#F7F7F7;" id="Tamanho">
    <td align="right" class="verdana_11_bold">*Tamanho :&nbsp; </td>
    <td align="left" class="verdana_11"><label>
      <input type="text" name="bbh_cam_det_flu_tamanho" id="bbh_cam_det_flu_tamanho" class="back_Campos" >
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
      <input name="bbh_cam_det_flu_default" type="text" class="back_Campos" id="bbh_cam_det_flu_default" size="30">
    </label></td>
  </tr>
  <tr style="display:none;background:#F7F7F7;" id="listagem">
    <td align="right" class="verdana_11_bold" >Valor  a ser adicionado :&nbsp; </td>
    <td align="left" class="verdana_11"><label>
      <input name="listagemI" type="text" class="back_Campos" id="listagemI" size="20" maxlength="50" onKeyUp="return cadListagem();">
      </label>
      <a href="#@" onClick="return AddListagem();"> <img src="/e-solution/servicos/bbhive/images/addVl.gif" alt="Adicionar na listagem" width="16" height="16" align="absmiddle" border="0"> </a> </td>
  </tr>
  <tr style="display:none;background:#F7F7F7;" id="listagemCriada">
    <td align="right" class="verdana_11_bold" ><span class="verdana_11">Lista atual :&nbsp;</span></td>
    <td align="left" class="verdana_11"><select name="menuCriado" id="menuCriado" class="back_Campos" style="position:relative;width:200px;">
        <option id="lista_vazia" value="lista_vazia">Listagem vazia</option>
      </select>
        <a href="#@" onclick="return RemListagem();"> <img src="/e-solution/servicos/bbhive/images/remVl.gif" alt="Remover da listagem" align="absmiddle" border="0" style="position:relative;" /></a>
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
        list($exec, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
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
    <td align="left" class="verdana_11"><textarea name="bbh_cam_det_flu_defaultLongo" id="bbh_cam_det_flu_defaultLongo" cols="30" rows="3" class="back_input"></textarea></td>
  </tr>
  
  
  
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Curinga :&nbsp;</td>
    <td align="left"><input type="text" name="bbh_cam_det_flu_curinga" id="bbh_cam_det_flu_curinga" class="back_Campos"></td>
  </tr>

    <tr class="legandaLabel11">
        <td height="25" align="right" class="verdana_11_bold">Apelido :&nbsp;</td>
        <td align="left"><input type="text" name="bbh_cam_det_flu_apelido" id="bbh_cam_det_flu_apelido" class="back_Campos"></td>
    </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Observa&ccedil;&atilde;o :&nbsp;</td>
    <td align="left"><textarea name="bbh_cam_det_flu_descricao" id="bbh_cam_det_flu_descricao" cols="45" rows="5" class="back_Campos"></textarea></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">Preencher no início : &nbsp;</td>
    <td align="left"><select name="bbh_cam_det_flu_preencher_inicio" id="bbh_cam_det_flu_preencher_inicio" class="back_input">
    <option value="1">Sim</option>
      <option value="0">N&atilde;o</option>
    </select></td>
  </tr>
    <tr class="legandaLabel11">
        <td height="25" align="right" class="verdana_11_bold">Obrigatório : &nbsp;</td>
        <td align="left"><select name="bbh_cam_det_flu_obrigatorio" id="bbh_cam_det_flu_obrigatorio" class="back_input">
                <option value="1">Sim</option>
                <option value="0">N&atilde;o</option>
            </select></td>
    </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">&nbsp;</td>
    <td align="left">
      <input name="button" type="button" class="back_input" id="button" value="Cancelar"  onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/detalhamento/index.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>','menuEsquerda|conteudoGeral');" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF"/>
      
	  <?php
if($row_detalhamento['bbh_det_flu_tabela_criada'] == 0){
	$alerta = "return validaForm('form1', 'bbh_cam_det_flu_titulo|Escolha o t&iacute;tulo do campo, bbh_cam_det_flu_tipo|Escolha o tipo do campo', document.getElementById('acaoForm').value)";
}else{
	$alerta = "if(confirm('O tipo do campo não poderá ser alterado posteriormente. Deseja continuar?')){return validaForm('form1', 'bbh_cam_det_flu_titulo|Escolha o t&iacute;tulo do campo, bbh_cam_det_flu_tipo|Escolha o tipo do campo', document.getElementById('acaoForm').value)}";
}
	  ?>
	  <input name="cadastra" type="button" class="back_input" id="cadastra" value="Cadastrar campo" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" onclick="<?php echo $alerta; ?>"/>
	  
	  &nbsp;&nbsp;&nbsp; <input type="hidden" name="tipoCampo" id="tipoCampo" />
      <input name="bbh_det_flu_codigo" type="hidden" id="bbh_det_flu_codigo" value="<?php echo $row_detalhamento['bbh_det_flu_codigo']; ?>">
      <input name="bbh_mod_flu_codigo" type="hidden" id="bbh_mod_flu_codigo" value="<?php echo $_GET['bbh_mod_flu_codigo']; ?>" /></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>

  <tr>
    <td height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
    <td width="420" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
 <tr class="legandaLabel11">
    <td height="22" align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="form1" />
<input type="hidden" name="acaoForm" id="acaoForm" value="<?php echo $acao; ?>" />
<input type="hidden" name="cadastrado" id="cadastrado" value="<?php echo $row_detalhamento['bbh_det_flu_tabela_criada']; ?>" />

</form>
<?php
mysqli_free_result($detalhamento);
?>
