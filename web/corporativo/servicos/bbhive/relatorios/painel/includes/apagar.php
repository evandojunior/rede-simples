<?php if(!isset($_SESSION)){ session_start(); } 
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
	
if(isset($_POST['MM_delete'])){
	$bbh_rel_codigo = $_POST['bbh_rel_codigo'];
	$bbh_ati_codigo = $_POST['bbh_ati_codigo'];
	$bbh_flu_codigo = $_POST['bbh_flu_codigo'];
	
	//REMOVE TODOS OS ARQUIVOS DESTE DIRETÓRIOS
	$localizacao_documento 	= explode("web",$_SESSION['caminhoFisico']);
    $dirname		 		= $localizacao_documento[0] . "database/servicos/bbhive/fluxo/fluxo_".$bbh_flu_codigo."/documentos/".$bbh_rel_codigo;

     if(file_exists($dirname)){
	   $result=array();
		   if (substr($dirname,-1)!='/') {$dirname.='/';}    //Append slash if necessary
		   $handle = opendir($dirname);
		   while (false !== ($file = readdir($handle))) {
			   if ($file!='.' && $file!= '..') {    //Ignore . and ..
				   $path = $dirname.$file;
				   if (is_dir($path)) {    //Recurse if subdir, Delete if file
					   $result=array_merge($result,rmdirtree($path));
				   }else{
					   unlink($path);
					   $result[].=$path;
				   }
			   }
		   }
		   closedir($handle);
		   rmdir($dirname); 
	 }
	//=========================================
	
	//remove todos os parágrafos
	$deleteSQL = "DELETE FROM bbh_paragrafo WHERE bbh_rel_codigo = $bbh_rel_codigo";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);
	
	//remove o relatório
	$deleteSQL = "DELETE FROM bbh_relatorio WHERE bbh_rel_codigo = $bbh_rel_codigo";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);
	
	$return = "<var style='display:none'>showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|relatorios/painel/index.php?bbh_ati_codigo=".$bbh_ati_codigo."','menuEsquerda|colPrincipal');limpaAmbiente();</var>";
	echo $return;
exit;
}

	//verifica o código do fluxo
	$query_fluxo = "SELECT bbh_flu_codigo FROM bbh_atividade WHERE bbh_ati_codigo = ".$_GET['bbh_ati_codigo'];
    list($fluxo, $row_fluxo, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_fluxo);
	$bbh_flu_codigo = $row_fluxo['bbh_flu_codigo'];


	$homeDestino = "/corporativo/servicos/bbhive/relatorios/painel/includes/apagar.php";
	$onclick = "OpenAjaxPostCmd('".$homeDestino."?TS=".time()."','cxLoad','duplicar','Carregando...','cxLoad','1','2')";
?><form name="duplicar" id="duplicar"><table width="420" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#FFF;border:#A0AFC3 solid 1px; ">
  <tr>
    <td width="270" height="23" align="left" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><span class="verdana_12">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/ferramentas.gif" align="absmiddle" /> <strong>Apagar <?php echo $_SESSION['relNome']; ?></strong></span></td>
    <td width="148" height="23" align="right" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><a href="#@" onclick="window.top.document.getElementById('carregaTudo').innerHTML = '&nbsp;';"><span style="color:#F60" class="verdana_12"><strong>Fechar janela</strong></span>&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/fechar.gif" width="18" height="18" border="0" align="absmiddle" /></a></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_12">Tem certeza que deseja apagar este relat&oacute;rio?</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_11">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_12">Clique em <strong>Apagar</strong> em caso de confirma&ccedil;&atilde;o.</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_12 color" id="cxLoad">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td height="25" align="right" bgcolor="#FFFFFF"><input type="button" name="cancel" id="cancel" class="back_input" value="Cancelar" style="background:url(/corporativo/servicos/bbhive/images/btnUP.gif); color:#006633; cursor:pointer;" onclick="javascript: document.getElementById('carregaTudo').innerHTML='&nbsp;'" />
      <input type="button" name="send" id="send" class="back_input" value="Apagar" style="background:url(/corporativo/servicos/bbhive/images/btnUP.gif); color:#006633; cursor:pointer;" onclick="document.getElementById('cxLoad').innerHTML='&nbsp;Aguarde em processamento...';<?php echo $onclick; ?>" /></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" id="cxLoad" class="verdana_12 color">&nbsp;</td>
  </tr>
  </table>
  <input name="bbh_rel_codigo" type="hidden" id="bbh_rel_codigo" value="<?php echo $_GET['bbh_rel_codigo']; ?>" />
  <input name="bbh_ati_codigo" type="hidden" id="bbh_ati_codigo" value="<?php echo $_GET['bbh_ati_codigo']; ?>" />
  <input name="bbh_flu_codigo" type="hidden" id="bbh_flu_codigo" value="<?php echo $bbh_flu_codigo; ?>" />
  <input name="MM_delete" type="hidden" value="1" />
</form>