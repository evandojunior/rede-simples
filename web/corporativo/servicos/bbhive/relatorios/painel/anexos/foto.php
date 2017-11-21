<?php
 if(!isset($_SESSION)){ session_start(); } 
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

if(isset($_POST['addFoto'])){
	if(!empty($_FILES["nvArquivo"])){
		$bbh_rel_codigo 	= $_POST['bbh_rel_codigo'];
		$bbh_ati_codigo		= $_POST['bbh_ati_codigo'];
		$bbh_par_codigo		= $_POST['bbh_par_codigo'];
		$bbh_flu_codigo		= $_POST['bbh_flu_codigo'];
		$bbh_par_legenda	= $_POST['bbh_par_legenda'];
		$arquivo 			= isset($_FILES["nvArquivo"]) ? $_FILES["nvArquivo"] : FALSE;

		$query_paragrafo = "SELECT * FROM bbh_paragrafo WHERE bbh_par_codigo = $bbh_par_codigo";
        list($paragrafo, $row_paragrafo, $totalRows_paragrafo) = executeQuery($bbhive, $database_bbhive, $query_paragrafo);
		
		if(!preg_match("/^image\/(gif|bmp|png|jpg|jpeg|pjpeg)$/i", $arquivo["type"])){
			echo '<script type="text/javascript">alert("Somente arquivos de imagem, com as seguintes extensões:\n*.gif, *.bmp, *.png, *.jpg, *.jpeg");</script>';
			exit;
		}
		
		preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
        // Gera um nome único para a imagem
        $imagem_nome = $bbh_par_codigo . "." . $ext[1];
		
	   // Edit upload location here
		$localizacao_documento = explode("web",$_SESSION['caminhoFisico']);
		
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
		
		if(file_exists($diretorio."/".$row_paragrafo['bbh_par_arquivo'])){
			@unlink($diretorio."/".$row_paragrafo['bbh_par_arquivo']);
		}
		$diretorio.= "/".$imagem_nome;
	//efetua UPLOAD do registro
		$updateSQL = "UPDATE bbh_paragrafo SET bbh_par_nmArquivo='".$imagem_nome."', bbh_par_arquivo='$imagem_nome', bbh_par_legenda='$bbh_par_legenda' WHERE bbh_par_codigo = $bbh_par_codigo";
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	
		// Faz o upload da imagem
		if(@move_uploaded_file($arquivo["tmp_name"], $diretorio)){
			$result = 1;
		}
?>
    <script type="text/javascript">
		window.top.window.uploadFile.reset();
		window.top.window.OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/lista.php?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo;?>&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&Ts=<?php echo time(); ?>&"','listaParagrafos','&1=1','Atualizando dados...','listaParagrafos','2','2');
	</script>	
    <?php
	exit;
	}

} elseif(isset($_POST['rmFoto'])){
			$bbh_rel_codigo 	= $_POST['bbh_rel_codigo'];
			$bbh_ati_codigo		= $_POST['bbh_ati_codigo'];
			$bbh_par_codigo		= $_POST['bbh_par_codigo'];
			$bbh_flu_codigo		= $_POST['bbh_flu_codigo'];
			$arquivo 			= isset($_FILES["nvArquivo"]) ? $_FILES["nvArquivo"] : FALSE;

			$query_paragrafo = "SELECT * FROM bbh_paragrafo WHERE bbh_par_codigo = $bbh_par_codigo";
            list($paragrafo, $row_paragrafo, $totalRows_paragrafo) = executeQuery($bbhive, $database_bbhive, $query_paragrafo);
			//remove o arquivo
			$localizacao_documento = explode("web",$_SESSION['caminhoFisico']);
			$diretorio = $localizacao_documento[0] . "database/servicos/bbhive/fluxo/fluxo_".$bbh_flu_codigo."/documentos/".$bbh_rel_codigo."/".$row_paragrafo['bbh_par_arquivo'];
			
			@unlink($diretorio);
			
			//update
			$updateSQL = "UPDATE bbh_paragrafo SET bbh_par_nmArquivo = NULL, bbh_par_arquivo = NULL, bbh_par_legenda = NULL WHERE bbh_par_codigo = $bbh_par_codigo";
            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
		
			//redireciona
	?>
	<script type="text/javascript">
		window.top.window.uploadFile.reset();
		window.top.window.OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/lista.php?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo;?>&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&Ts=<?php echo time(); ?>&"','listaParagrafos','&1=1','Atualizando dados...','listaParagrafos','2','2');
	</script>	
	<?php
	exit;
}

foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){	$bbh_ati_codigo= $valor; } 
	if(($indice=="amp;bbh_par_codigo")||($indice=="bbh_par_codigo")){ 	$bbh_par_codigo= $valor; } 
	if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ 	$bbh_flu_codigo= $valor; } 
	if(($indice=="amp;bbh_rel_codigo")||($indice=="bbh_rel_codigo")){ 	$bbh_rel_codigo= $valor; } 
}

	$query_paragrafo = "SELECT * FROM bbh_paragrafo WHERE bbh_par_codigo = $bbh_par_codigo";
    list($paragrafo, $row_paragrafo, $totalRows_paragrafo) = executeQuery($bbhive, $database_bbhive, $query_paragrafo);

			if(!empty($row_paragrafo['bbh_par_arquivo'])){
			  $temImagem=true;
			}
			
?><form name="uploadFile" id="uploadFile" action="/corporativo/servicos/bbhive/relatorios/painel/anexos/foto.php" method="post" enctype="multipart/form-data" target="upload_Arquivo">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" align="left" class="titPG"><strong><?php echo $row_paragrafo['bbh_par_titulo']; ?></strong></td>
    </tr>
    <tr>
      <td height="10" align="left"></td>
    </tr>
    <?php if(isset($temImagem)){ ?>
    <tr>
      <td height="25" align="left" class="verdana_12"><input type="radio" name="radio" id="excluir" value="excluir" onClick="javascript: document.getElementById('tbAdicionar').style.display='none'; document.getElementById('tbExluir').style.display='block';" <?php echo isset($temImagem) ? "checked": "";?>>
      Excluir imagem anexada</td>
    </tr>
    <?php } ?>
    <tr>
      <td height="25" align="left" class="verdana_12"><input name="radio" type="radio" id="adicionar" onClick="javascript: document.getElementById('tbExluir').style.display='none'; document.getElementById('tbAdicionar').style.display='block';" value="adicionar" <?php echo !isset($temImagem) ? "checked": "";?>>
      Adicionar ou substituir imagem</td>
    </tr>
    <tr>
      <td height="5" align="left" class="verdana_12"></td>
    </tr>
  </table>
  <div style="height:350px;">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#FFF;border:#A0AFC3 solid 1px; display:<?php echo isset($temImagem) ? "block": "none";?>" id="tbExluir">
    <tr>
        <td width="287" height="23" align="left" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><span class="verdana_12">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/anexos.gif" align="absmiddle" /> <strong>Exclu&iacute;r imagem do par&aacute;grafo</strong></span></td>
            <td width="131" height="23" align="right" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><a href="#@" onclick="document.getElementById('carregaTudo').innerHTML = '&nbsp;';"><span style="color:#F60" class="verdana_12"><strong>Fechar janela</strong></span>&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/fechar.gif" width="18" height="18" border="0" align="absmiddle" /></a></td>
    </tr>
    <tr>
      <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_12">Clique em <strong>excluir</strong> em caso de confirma&ccedil;&atilde;o.</td>
    </tr>
    <tr>
      <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_12">
        <?php if(isset($temImagem)){ ?><img src="/corporativo/servicos/bbhive/images/painel/anexo_foto.gif" border="0" align="absmiddle">&nbsp;<a href="#@" onClick="document.abreFoto.submit();"><span class="color">Visualizar imagem</span></a><?php }?></td>
    </tr>
    <tr>
      <td width="273" height="25" align="left" bgcolor="#FFFFFF">&nbsp;</td>
      <td width="145" height="25" align="right" bgcolor="#FFFFFF"><input type="button" name="002" class="back_input" value="Excluir" style="background:url(/corporativo/servicos/bbhive/images/btnUP.gif); color:#006633; float:right; cursor:pointer; margin-right:2px;" onClick="javascript: if(confirm('  Tem certeza que deseja excluir esta imagem?\n Ao clicar em OK as informa&ccedil;&otilde;es ser&atilde;o excluidas.')){ document.removeFoto.submit(); }" id="002" />
        &nbsp;</td>
    </tr>
  </table>

  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#FFF;border:#A0AFC3 solid 1px; display:<?php echo !isset($temImagem) ? "block": "none";?>" id="tbAdicionar">
    <tr>
    <td width="287" height="23" align="left" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><span class="verdana_12">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/anexos.gif" align="absmiddle" /> <strong>Adicionar imagem ao par&aacute;grafo</strong></span></td>
    <td width="131" height="23" align="right" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><a href="#@" onclick="document.getElementById('carregaTudo').innerHTML = '&nbsp;';"><span style="color:#F60" class="verdana_12"><strong>Fechar janela</strong></span>&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/fechar.gif" width="18" height="18" border="0" align="absmiddle" /></a></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12">Escolha o arquivo de um reposit&oacute;rio externo e clique em anexar</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12">&nbsp;Caminho: <input name="nvArquivo" id="nvArquivo" type="file" size="25" class="back_input" /></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12">&nbsp;Legenda :    </td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;
      <textarea name="bbh_par_legenda" cols="60" rows="4" class="back_Campos" id="bbh_par_legenda" style="height:20px; line-height:20px;"><?php echo $row_paragrafo['bbh_par_legenda']; ?></textarea></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" id="cxLoad" class="verdana_12 color">&nbsp;</td>
    </tr>
  <tr>
    <td width="273" height="25" align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="145" height="25" align="right" bgcolor="#FFFFFF"><input type="button" name="00" class="back_input" value="Enviar" style="background:url(/corporativo/servicos/bbhive/images/btnUP.gif); color:#006633; float:right; cursor:pointer; margin-right:2px;" onClick="javascript: if((document.getElementById('nvArquivo').value=='')||(document.getElementById('bbh_par_legenda').value=='')){alert('Escolha o arquivo e o tipo antes do envio ou preencha o título do anexo!')}else{ document.uploadFile.submit(); document.getElementById('cxLoad').innerHTML='&nbsp;Aguarde enquando o upload &eacute; efetuado...'; }" id="00" />&nbsp;</td>
  </tr>
</table>
  </div>
  <input name="bbh_flu_codigo"  id="bbh_flu_codigo" type="hidden" value="<?php echo $bbh_flu_codigo; ?>"/>
  <input name="bbh_rel_codigo" type="hidden" id="bbh_rel_codigo" value="<?php echo $bbh_rel_codigo; ?>" />
  <input name="bbh_ati_codigo" type="hidden" id="bbh_ati_codigo" value="<?php echo $bbh_ati_codigo; ?>" />
  <input name="bbh_par_codigo" type="hidden" id="bbh_par_codigo" value="<?php echo $bbh_par_codigo; ?>" />
  <input name="addFoto" id="addFoto" type="hidden"/>
  <iframe id="upload_Arquivo" name="upload_Arquivo" src="#" style="width:0;height:0;border:0px solid #fff; display:none"></iframe>
</form>

<form action="/corporativo/servicos/bbhive/relatorios/painel/anexos/foto.php" method="post" enctype="multipart/form-data" target="upload_Arquivo" name="removeFoto" id="removeFoto">
  <input name="bbh_flu_codigo"  id="bbh_flu_codigo" type="hidden" value="<?php echo $bbh_flu_codigo; ?>"/>
  <input name="bbh_rel_codigo" type="hidden" id="bbh_rel_codigo" value="<?php echo $bbh_rel_codigo; ?>" />
  <input name="bbh_ati_codigo" type="hidden" id="bbh_ati_codigo" value="<?php echo $bbh_ati_codigo; ?>" />
  <input name="bbh_par_codigo" type="hidden" id="bbh_par_codigo" value="<?php echo $bbh_par_codigo; ?>" />
  <input name="rmFoto" id="rmFoto" type="hidden"/>
</form>

<form method="get" name="abreFoto" id="abreFoto" action="/corporativo/servicos/bbhive/relatorios/painel/download/anexos.php" target="_blank">
  <input name="file" type="hidden" id="file" value="<?php echo $bbh_par_codigo; ?>" />
  <input name="bbh_flu_codigo"  id="bbh_flu_codigo" type="hidden" value="<?php echo $bbh_flu_codigo; ?>"/>
</form>