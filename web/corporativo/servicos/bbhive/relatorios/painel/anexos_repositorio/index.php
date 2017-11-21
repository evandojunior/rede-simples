<?php
if(isset($_POST['addFile'])){
 if(!isset($_SESSION)){ session_start(); }
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

		$bbh_rel_codigo 	= $_POST['bbh_rel_codigo'];
		$bbh_ati_codigo		= $_POST['bbh_ati_codigo'];
		$bbh_par_momento	= $_POST['bbh_par_momento'];
		$bbh_par_titulo		= mysqli_fetch_assoc($_POST['bbh_par_titulo']);
		$bbh_par_autor		= ($_POST['bbh_par_autor']);
		$bbh_flu_codigo		= $_POST['bbh_flu_codigo'];
		$bbh_par_paragrafo	= $_POST['bbh_par_paragrafo'];
		$bbh_tipo			= $_POST['bbh_tipo'];
	
	//-----------------------------------------------------------------------------------------------
	//verifico o caminho do arquivo origem
	$query_origem = "SELECT * FROM bbh_arquivo WHERE bbh_arq_codigo =".$_POST['bbh_arq_codigo'];
    list($origem, $row_origem, $totalRows_origem) = executeQuery($bbhive, $database_bbhive, $query_origem);
	
	$nomeArquivo = $row_origem['bbh_arq_nome'];
	
	//INFORMAÇÕES DE ORIGEM
	$arquivoOrigem 			= $row_origem['bbh_arq_localizacao']."/".$row_origem['bbh_arq_nome'];
	$localizacao_documento 	= explode("web",$_SESSION['caminhoFisico']);
	$diretorioOrigem		= $localizacao_documento[0] . "database/servicos/bbhive".$arquivoOrigem;
	
	//INFORMAÇÕES DE DESTINO - COPIAR
	$diretorio = $localizacao_documento[0] . "database/servicos/bbhive/fluxo/fluxo_".$bbh_flu_codigo;
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
	$diretorio.= "/documentos";
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
	$diretorio.= "/".$bbh_rel_codigo;
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
	$diretorioDestino = $localizacao_documento[0] . "database/servicos/bbhive/fluxo/fluxo_".$bbh_flu_codigo."/documentos/".$bbh_rel_codigo."/";	

	//===================================================
		//seleciona ordenação do modelo
		$query_ordenacao_paragrafos = "SELECT MAX(bbh_par_ordem) ultimo_paragrafo FROM bbh_paragrafo WHERE bbh_rel_codigo = $bbh_rel_codigo";
        list($ordenacao_paragrafos, $row_ordenacao_paragrafos, $totalRows_ordenacao_paragrafos) = executeQuery($bbhive, $database_bbhive, $query_ordenacao_paragrafos);
		$ordenacao = $row_ordenacao_paragrafos['ultimo_paragrafo']+1;
		
		//inserção do parágrafo de fato
		$insertSQL = "INSERT INTO bbh_paragrafo (bbh_rel_codigo, bbh_par_titulo,bbh_par_paragrafo,bbh_par_ordem, bbh_par_momento, bbh_par_autor, bbh_par_tipo_anexo,bbh_par_nmArquivo) VALUES ($bbh_rel_codigo,'$bbh_par_titulo','$bbh_par_paragrafo',$ordenacao, '$bbh_par_momento', '$bbh_par_autor', '$bbh_tipo', '$nomeArquivo')";
        list($Result1, $rows, $totalRowss) = executeQuery($bbhive, $database_bbhive, $insertSQL);
		  
		//recupera código da inserção
		$query_Paragrafo = "SELECT bbh_par_codigo FROM bbh_paragrafo WHERE bbh_par_codigo = LAST_INSERT_ID()";
        list($Paragrafo, $row_Paragrafo, $totalRows_Paragrafo) = executeQuery($bbhive, $database_bbhive, $query_Paragrafo);
		$bbh_par_codigo = $row_Paragrafo['bbh_par_codigo'];
	//===================================================
	$nmModificado = $bbh_par_codigo."_".$nomeArquivo;
	
	copy($diretorioOrigem, $diretorioDestino.$nmModificado);
	
	//---------------------------------------------
		$updateSQL = "UPDATE bbh_paragrafo SET bbh_par_arquivo='$nmModificado' WHERE bbh_par_codigo = $bbh_par_codigo";
        list($Result1, $rows, $totalRowss) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	?>
    <script type="text/javascript">
	window.top.location.href='/corporativo/servicos/bbhive/index.php';
//		window.top.uploadFile.reset();
//		window.top.OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/lista.php?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo;?>&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&Ts=<?php echo time(); ?>&"','listaParagrafos','&1=1','Atualizando dados...','listaParagrafos','2','2');
	</script>	
    <?php
	exit;	
}

foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){	$bbh_ati_codigo= $valor; } 
	if(($indice=="amp;bbh_rel_codigo")||($indice=="bbh_rel_codigo")){ 	$bbh_rel_codigo= $valor; } 
	if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ 	$bbh_flu_codigo= $valor; } 
}
?><form name="uploadFile" id="uploadFile" action="/corporativo/servicos/bbhive/relatorios/painel/anexos_repositorio/index.php" method="post" enctype="multipart/form-data" target="upload_Arquivo">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#FFF;border:#A0AFC3 solid 1px; ">
  <tr>
    <td height="23" colspan="2" align="left" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><span class="verdana_12">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/anexos.gif" align="absmiddle" /> <strong>Adicionar arquivos do reposit&oacute;rio</strong></span></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12">Escolha o arquivo de um reposit&oacute;rio clique em anexar</td>
  </tr>
  <?php /*<tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12"><strong>&nbsp;Tipo do arquivo</strong></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_11"><?php require_once("../includes/icones.php"); ?></td>
  </tr>*/ ?>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF"><span class="verdana_11 color">* Somente arquivos com extens&atilde;o PDF</span></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12"><strong>&nbsp;Ser&atilde;o exibidos apenas arquivos compartilhados</strong></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_12">
    <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#E7E7E7 solid 1px;display:">
      <tr>
        <td width="27" height="25" align="center" bgcolor="#F1F1F1">&nbsp;</td>
        <td width="352" align="left" bgcolor="#F1F1F1" class="verdana_11"><strong>Nome</strong></td>
        <td width="199" align="left" bgcolor="#F1F1F1" class="verdana_11"><strong>Autor</strong></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_12">
	<iframe src="/corporativo/servicos/bbhive/relatorios/painel/anexos_repositorio/repositorio.php?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo; ?>&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>" width="98%" allowtransparency="1" frameborder="0" height="75" style="border-left:#E7E7E7 solid 1px;border-right:#E7E7E7 solid 1px;border-bottom:#E7E7E7 solid 1px;"></iframe></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12">&nbsp;T&iacute;tulo do anexo :    </td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;<input name="bbh_par_paragrafo" type="text" class="back_Campos" id="bbh_par_paragrafo" size="60" style="height:20px; line-height:20px;"></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" id="cxLoad" class="verdana_12 color">&nbsp;</td>
  </tr>
  <tr>
    <td width="478" height="25" align="left" bgcolor="#FFFFFF"><input type="hidden" name="bbh_arq_codigo" id="bbh_arq_codigo" /></td>
    <td width="145" height="25" align="right" bgcolor="#FFFFFF"><input type="button" name="cancel" id="cancel" class="back_input" value="Cancelar" style="background:url(/corporativo/servicos/bbhive/images/btnUP.gif); color:#006633; cursor:pointer;" onclick="javascript: document.getElementById('carregaTudo').innerHTML='&nbsp;'" />
      <input type="button" name="send" id="send" class="back_input" value="Enviar" style="background:url(/corporativo/servicos/bbhive/images/btnUP.gif); color:#006633; cursor:pointer;" onclick="javascript: if((document.getElementById('bbh_arq_codigo').value=='')||(document.getElementById('bbh_tipo').value=='')||(document.getElementById('bbh_par_paragrafo').value=='')){alert('Escolha o arquivo e o tipo antes ou preencha o t&iacute;tulo do anexo!')}else{ document.uploadFile.submit();document.getElementById('cxLoad').innerHTML='&nbsp;Aguarde enquando o upload &eacute; efetuado...'; }" /></td>
  </tr>
</table>
  <input name="bbh_flu_codigo"  id="bbh_flu_codigo" type="hidden" value="<?php echo $bbh_flu_codigo; ?>"/>
  <input name="bbh_rel_codigo" type="hidden" id="bbh_rel_codigo" value="<?php echo $bbh_rel_codigo; ?>" />
  <input name="bbh_ati_codigo" type="hidden" id="bbh_ati_codigo" value="<?php echo $bbh_ati_codigo; ?>" />
  <input type="hidden" name="bbh_par_momento" id="bbh_par_momento" value="<?php echo date('Y-m-d'); ?>" />
  <input type="hidden" name="bbh_par_titulo" id="bbh_par_titulo" value="Bl@ck_arquivo_ANEXO*~" />
  <input type="hidden" name="bbh_par_autor" id="bbh_par_autor" value="<?php echo $_SESSION['usuNome']; ?>" />
  <input name="addFile" id="addFile" type="hidden"/>
  <input type="hidden" name="bbh_tipo" id="bbh_tipo" value="pdf.gif" />
  <iframe id="upload_Arquivo" name="upload_Arquivo" src="#" style="width:0;height:0;border:0px solid #fff; display:none"></iframe>
</form>