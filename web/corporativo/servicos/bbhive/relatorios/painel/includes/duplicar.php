<?php if(!isset($_SESSION)){ session_start(); } 
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
	
if(isset($_POST['MM_insert'])){

	
	$CodRelatorio = $_POST['bbh_rel_codigo'];
	$CodAtividade = $_POST['bbh_ati_codigo'];
	$bbh_flu_codigo = $_POST['bbh_flu_codigo'];
	
	//efetua duplicação relatório
	$insertSQL = "INSERT INTO bbh_relatorio (bbh_rel_data_criacao, bbh_rel_observacao, bbh_ati_codigo, bbh_rel_finalizado, 
bbh_rel_titulo, bbh_usu_codigo) 
SELECT CURDATE() as bbh_rel_data_criacao, bbh_rel_observacao, bbh_ati_codigo, bbh_rel_finalizado, 
bbh_rel_titulo, bbh_usu_codigo FROM bbh_relatorio WHERE bbh_rel_codigo=".$CodRelatorio;
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
 
 	//recupera o código do relatório inserido
	$query_paragrafo = "SELECT bbh_rel_codigo FROM bbh_relatorio WHERE bbh_rel_codigo= LAST_INSERT_ID()";
    list($paragrafo, $row_paragrafo, $totalRows_paragrafo) = executeQuery($bbhive, $database_bbhive, $query_paragrafo);
	$nvRelatorio = $row_paragrafo['bbh_rel_codigo'];
	
	//efetua duplicação paragráfos
	$insertSQL = "INSERT INTO bbh_paragrafo (bbh_par_titulo, bbh_par_paragrafo, bbh_rel_codigo, bbh_mod_par_codigo, bbh_par_ordem, bbh_par_momento, bbh_par_autor, bbh_par_arquivo, bbh_par_nmArquivo, bbh_par_legenda, bbh_par_tipo_anexo) select bbh_par_titulo, bbh_par_paragrafo, $nvRelatorio, bbh_mod_par_codigo, bbh_par_ordem, bbh_par_momento, bbh_par_autor, bbh_par_arquivo, bbh_par_nmArquivo, bbh_par_legenda, bbh_par_tipo_anexo from bbh_paragrafo Where bbh_rel_codigo=".$CodRelatorio;
    list($Result1, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $insertSQL, $initResult = false);

	//move todos os anexos
		//verifica toda a pasta do modelo anterior
	//lista as opções de imagens para gif
	$localizacao_documento 	= explode("web",$_SESSION['caminhoFisico']);
	$diretorioOrigem 		= $localizacao_documento[0] . "database/servicos/bbhive/fluxo/fluxo_".$bbh_flu_codigo."/documentos/".$CodRelatorio."/";
	
	$diretorioDestino 		= $localizacao_documento[0] . "database/servicos/bbhive/fluxo/fluxo_".$bbh_flu_codigo."/documentos/".@$nvRelatorio;
	
	if(!file_exists($diretorioDestino)) {	
		@mkdir($diretorioDestino, 777);
		@chmod($diretorioDestino,0777);
	}
	
	if ($handle = @opendir($diretorioOrigem.".")) {
		$cont  = 0;
		$dif	= 0;
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if(strtolower($file)!="thumbs.db"){	
					//não posso copiar o laudo desta pasta
					$rel = "rel_".$CodRelatorio;
					$pos = strpos($file, $rel);

						if($pos === false){
							copy($diretorioOrigem.$file, $diretorioDestino."/".$file);
						}

					$cont++; 
					$dif = $dif + 1;
					//se chegar a 100 ele para
					if ($cont == 850) { die;}	
				}
			}
		}
		closedir($handle);
	}
	//===================

	$return = "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=1&perfis=1|relatorios/painel/propriedades.php?bbh_rel_codigo=".$nvRelatorio."&bbh_ati_codigo=".$CodAtividade."','menuEsquerda|ambienteRelatorio')</var>";
	echo $return;
exit;
}

	//verifica o código do fluxo
	$query_fluxo = "SELECT bbh_flu_codigo FROM bbh_atividade WHERE bbh_ati_codigo = ".$_GET['bbh_ati_codigo'];
    list($fluxo, $row_fluxo, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_fluxo);
	$bbh_flu_codigo = $row_fluxo['bbh_flu_codigo'];


	$homeDestino = "/corporativo/servicos/bbhive/relatorios/painel/includes/duplicar.php";
	$onclick = "OpenAjaxPostCmd('".$homeDestino."?TS=".time()."','cxLoad','duplicar','Carregando...','cxLoad','1','2')";
?><form name="duplicar" id="duplicar"><table width="420" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#FFF;border:#A0AFC3 solid 1px; ">
  <tr>
    <td width="270" height="23" align="left" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><span class="verdana_12">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/ferramentas.gif" align="absmiddle" /> <strong>Copiar <?php echo $_SESSION['relNome']; ?></strong></span></td>
    <td width="148" height="23" align="right" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><a href="#@" onclick="window.top.document.getElementById('carregaTudo').innerHTML = '&nbsp;';"><span style="color:#F60" class="verdana_12"><strong>Fechar janela</strong></span>&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/fechar.gif" width="18" height="18" border="0" align="absmiddle" /></a></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_12">Tem certeza que deseja duplicar este relat&oacute;rio?</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_11">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_12">Clique em <strong>Copiar</strong> em caso de confirma&ccedil;&atilde;o.</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_12 color" id="cxLoad">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td height="25" align="right" bgcolor="#FFFFFF"><input type="button" name="cancel" id="cancel" class="back_input" value="Cancelar" style="background:url(/corporativo/servicos/bbhive/images/btnUP.gif); color:#006633; cursor:pointer;" onclick="javascript: document.getElementById('carregaTudo').innerHTML='&nbsp;'" />
      <input type="button" name="send" id="send" class="back_input" value="Copiar" style="background:url(/corporativo/servicos/bbhive/images/btnUP.gif); color:#006633; cursor:pointer;" onclick="document.getElementById('cxLoad').innerHTML='&nbsp;Aguarde em processamento...';<?php echo $onclick; ?>" /></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" id="cxLoad" class="verdana_12 color">&nbsp;</td>
  </tr>
  </table>
  <input name="bbh_rel_codigo" type="hidden" id="bbh_rel_codigo" value="<?php echo $_GET['bbh_rel_codigo']; ?>" />
  <input name="bbh_ati_codigo" type="hidden" id="bbh_ati_codigo" value="<?php echo $_GET['bbh_ati_codigo']; ?>" />
  <input name="bbh_flu_codigo" type="hidden" id="bbh_flu_codigo" value="<?php echo $bbh_flu_codigo; ?>" />
  <input name="MM_insert" type="hidden" value="1" />
</form>