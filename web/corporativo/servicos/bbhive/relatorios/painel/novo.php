<?php if(!isset($_SESSION)){session_start();} 

//cadastro de relatórios
if(isset($_POST['insertRel'])){
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
	
  //recupera informações
  $bbh_rel_titulo 		= ($_POST['bbh_rel_titulo']);
  $bbh_rel_observacao	= ($_POST['bbh_rel_observacao']);
  $bbh_rel_data_criacao	= date("Y-m-d");
  $bbh_ati_codigo		= $_POST['bbh_ati_codigo'];
  
  //insere dados na base
	$insertSQL = "INSERT INTO bbh_relatorio (bbh_rel_observacao, bbh_rel_titulo,bbh_ati_codigo,bbh_rel_data_criacao,bbh_usu_codigo) VALUES ('$bbh_rel_observacao', '$bbh_rel_titulo',$bbh_ati_codigo,'$bbh_rel_data_criacao',".$_SESSION['usuCod'].")";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
	 
  //recupera id inserido
	$query_ultimo_relatorio = "SELECT bbh_rel_codigo FROM bbh_relatorio WHERE bbh_rel_codigo = last_insert_id();";
    list($ultimo_relatorio, $row_ultimo_relatorio, $totalRows_ultimo_relatorio) = executeQuery($bbhive, $database_bbhive, $query_ultimo_relatorio);
  
  //cria diretório dentro de fluxo/documentos
	$query_fluxo = "SELECT bbh_flu_codigo FROM bbh_atividade WHERE bbh_ati_codigo = $bbh_ati_codigo";
    list($fluxo, $row_fluxo, $totalRows_fluxo) = executeQuery($bbhive, $database_bbhive, $query_fluxo);
	
	$localizacao_documento = explode("web",$_SESSION['caminhoFisico']);
	$diretorio = $localizacao_documento[0] . "database/servicos/bbhive/fluxo/fluxo_".$row_fluxo['bbh_flu_codigo'];
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
	$diretorio.= "/documentos";
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
	$diretorio.= "/".$row_ultimo_relatorio['bbh_rel_codigo'];
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
  //redireciona para página de paragrafos
	$carregaPagina= "LoadSimultaneo('perfil/index.php?perfil=1&perfis=1|relatorios/painel/propriedades.php?bbh_rel_codigo=".$row_ultimo_relatorio['bbh_rel_codigo']."&bbh_ati_codigo=".$bbh_ati_codigo."','menuEsquerda|ambienteRelatorio')";
	
	echo '<var style="display:none">'.$carregaPagina.'</var>';
exit;
}

foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){	$bbh_ati_codigo= $valor; } 
	if(($indice=="amp;titulo")||($indice=="titulo")){	$titulo= $valor; } 
}

	$homeDestino = "/corporativo/servicos/bbhive/relatorios/painel/novo.php";
	$onclick = "OpenAjaxPostCmd('".$homeDestino."?TS=".time()."','cxLoad','novo','Carregando...','cxLoad','1','2')";
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#FFF;">
  <tr>
    <td height="350" align="center">
		<form name="novo" id="novo"><table width="420" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#FFF;border:#A0AFC3 solid 1px; ">
  <tr>
    <td width="252" height="23" align="left" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><span class="verdana_12">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/ferramentas.gif" align="absmiddle" /> <strong>Novo <?php echo $_SESSION['relNome']; ?></strong></span></td>
    <td width="172" height="23" align="right" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><a href="#@" onclick="document.getElementById('nvDoc').innerHTML = '&nbsp;';"><span style="color:#F60" class="verdana_12"><strong>Fechar janela</strong></span>&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/fechar.gif" width="18" height="18" border="0" align="absmiddle" /></a></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12">&nbsp;T&iacute;tulo do relat&oacute;rio :</td>
    </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_11">&nbsp;&nbsp;&nbsp;
      <input name="bbh_rel_titulo" type="text" class="back_Campos" id="bbh_rel_titulo" size="60" style="height:20px; line-height:20px;" value="<?php echo @$titulo; ?>"></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12">&nbsp;Descri&ccedil;&atilde;o:</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="bbh_rel_observacao" class="formulario2" cols="68" rows="4"></textarea></td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td height="25" align="right" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right" bgcolor="#FFFFFF" class="verdana_12 color" id="cxLoad">&nbsp;</td>
    </tr>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td height="25" align="right" bgcolor="#FFFFFF"><input type="button" name="00" class="back_input" value="Adicionar" style="background:url(/corporativo/servicos/bbhive/images/btnUP.gif); color:#006633; float:right; cursor:pointer; margin-right:2px;" onclick="if(document.getElementById('bbh_rel_titulo').value==''){ alert('Campo t&iacute;tulo &eacute; obrigat&oacute;rio!'); }else{document.getElementById('cxLoad').innerHTML='&nbsp;Aguarde em processamento...';<?php echo $onclick; ?>}" id="00" />
      &nbsp;
      <input type="button" name="0" class="back_input" value="Cancelar" style="background:url(/corporativo/servicos/bbhive/images/btnUP.gif); color:#006633; cursor:pointer;" onclick="javascript: document.getElementById('nvDoc').innerHTML='&nbsp;'" id="0" /></td>
    </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" id="cxLoad" class="verdana_12 color">&nbsp;</td>
  </tr>
  </table>
  <input name="bbh_ati_codigo" type="hidden" id="bbh_ati_codigo" value="<?php echo $bbh_ati_codigo; ?>" />
  <input name="insertRel" type="hidden" value="1" />
</form>
    </td>
  </tr>
</table>
  <!-- filter:alpha(opacity=100); -moz-opacity:1.0;opacity:1.0;margin-left:1px; -->