<?php
 if(!isset($_SESSION)){ session_start(); } 
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

if(isset($_POST['addFile'])){
	if(!empty($_FILES["nvArquivo"])){
		$bbh_rel_codigo 	= $_POST['bbh_rel_codigo'];
		$bbh_ati_codigo		= $_POST['bbh_ati_codigo'];
		$bbh_par_momento	= $_POST['bbh_par_momento'];
		$bbh_par_titulo		= mysqli_fetch_assoc($_POST['bbh_par_titulo']);
		$bbh_par_autor		= ($_POST['bbh_par_autor']);
		$bbh_flu_codigo		= $_POST['bbh_flu_codigo'];
		$bbh_par_paragrafo	= $_POST['bbh_par_paragrafo'];
		$bbh_tipo			= $_POST['bbh_tipo'];
		
		$arquivo 			= isset($_FILES["nvArquivo"]) ? $_FILES["nvArquivo"] : FALSE;
		
		function getFileExtension($str) {
		
				$i = strrpos($str,".");
				if (!$i) { return ""; }
		
				$l = strlen($str) - $i;
				$ext = substr($str,$i+1,$l);
		
				return $ext;
		}
	   // Edit upload location here
		$localizacao_documento = explode("web",$_SESSION['caminhoFisico']);
	
		// Pega extens&atilde;o do arquivo			
		$pext = getFileExtension($arquivo["name"]);
		
		$codigo_usuario = $_SESSION['usuCod'];
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
		
	   	$result = 0;
		//define nome do arquivo com informações tratadas
		$nvNome			= trataCaracteres(str_replace(".$pext" , "", strtolower($arquivo["name"]))).".$pext";
		//===============================================
		
		//INSERE UM PARÁGRAFO COM O TÍTULO DE ANEXO
	
		//seleciona ordenação do modelo
		$query_ordenacao_paragrafos = "SELECT MAX(bbh_par_ordem) ultimo_paragrafo FROM bbh_paragrafo WHERE bbh_rel_codigo = $bbh_rel_codigo";
        list($ordenacao_paragrafos, $row_ordenacao_paragrafos, $totalRows_ordenacao_paragrafos) = executeQuery($bbhive, $database_bbhive, $query_ordenacao_paragrafos);

		$ordenacao = $row_ordenacao_paragrafos['ultimo_paragrafo']+1;
		
		//inserção do parágrafo de fato
		 $insertSQL = "INSERT INTO bbh_paragrafo (bbh_rel_codigo, bbh_par_titulo,bbh_par_paragrafo,bbh_par_ordem, bbh_par_momento, bbh_par_autor, bbh_par_tipo_anexo) VALUES ($bbh_rel_codigo,'$bbh_par_titulo','$bbh_par_paragrafo',$ordenacao, '$bbh_par_momento', '$bbh_par_autor', '$bbh_tipo')";
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
		
		//recupera código da inserção
		$query_Paragrafo = "SELECT bbh_par_codigo FROM bbh_paragrafo WHERE bbh_par_codigo = LAST_INSERT_ID()";
        list($Paragrafo, $row_Paragrafo, $totalRows_Paragrafo) = executeQuery($bbhive, $database_bbhive, $query_Paragrafo);
		$bbh_par_codigo = $row_Paragrafo['bbh_par_codigo'];
		//===============================================
		$nmArquivo 		= $bbh_par_codigo."_".$nvNome;
		//===============================================
		$diretorio = $localizacao_documento[0] . "database/servicos/bbhive/fluxo/fluxo_".$bbh_flu_codigo."/documentos/".$bbh_rel_codigo."/". $nmArquivo;	
		
		if(file_exists($diretorio)){
			unlink($diretorio);
		}

	//efetua UPLOAD do registro
		$updateSQL = "UPDATE bbh_paragrafo SET bbh_par_nmArquivo='".$nvNome."', bbh_par_arquivo='$nmArquivo' WHERE bbh_par_codigo = $bbh_par_codigo";
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
}
?><form name="uploadFile" id="uploadFile" action="/corporativo/servicos/bbhive/relatorios/painel/anexos/index.php" method="post" enctype="multipart/form-data" target="upload_Arquivo" onSubmit="checkFileUpload(this,'');checkFileUpload(this,'PDF');return document.MM_returnValue"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#FFF;border:#A0AFC3 solid 1px; ">
  <tr>
    <td height="23" colspan="2" align="left" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><span class="verdana_12">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/anexos.gif" align="absmiddle" /> <strong>Adicionar arquivos externos</strong></span></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12">Escolha o arquivo de um reposit&oacute;rio externo e clique em anexar</td>
  </tr>
  <?php /*<tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12"><strong>&nbsp;Tipo do arquivo</strong></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_11"><?php //require_once("../includes/icones.php"); ?></td>
  </tr> */ ?>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12">&nbsp;Caminho: <input name="nvArquivo" id="nvArquivo" type="file" size="25" class="back_input" /></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12">&nbsp;T&iacute;tulo do anexo :    </td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;<input name="bbh_par_paragrafo" type="text" class="back_Campos" id="bbh_par_paragrafo" size="60" style="height:20px; line-height:20px;"></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" id="cxLoad" class="verdana_11 color">* Somente arquivos com extens&atilde;o PDF</td>
  </tr>
  <tr>
    <td width="273" height="25" align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="145" height="25" align="right" bgcolor="#FFFFFF">
      <input type="button" name="cancel" id="cancel" class="back_input" value="Cancelar" style="background:url(/corporativo/servicos/bbhive/images/btnUP.gif); color:#006633; cursor:pointer;" onClick="javascript: document.getElementById('carregaTudo').innerHTML='&nbsp;'" />
      
      <input type="button" name="send" id="send" class="back_input" value="Enviar" style="background:url(/corporativo/servicos/bbhive/images/btnUP.gif); color:#006633; cursor:pointer;" onClick="javascript: if((document.getElementById('nvArquivo').value=='')||(document.getElementById('bbh_tipo').value=='')||(document.getElementById('bbh_par_paragrafo').value=='')){alert('Escolha o arquivo e o tipo antes do envio ou preencha o título do anexo!')}else{ checkFileUpload(document.uploadFile,'');checkFileUpload(document.uploadFile,'PDF');return document.MM_returnValue; document.getElementById('00').disabled='1';  document.getElementById('0').disabled='1'; document.getElementById('cxLoad').innerHTML='&nbsp;Aguarde enquando o upload &eacute; efetuado...'; }" /></td>
  </tr>
    </table>
  <input name="bbh_flu_codigo"  id="bbh_flu_codigo" type="hidden" value="<?php echo $_GET['bbh_flu_codigo']; ?>"/>
  <input name="bbh_rel_codigo" type="hidden" id="bbh_rel_codigo" value="<?php echo $_GET['bbh_rel_codigo']; ?>" />
  <input name="bbh_ati_codigo" type="hidden" id="bbh_ati_codigo" value="<?php echo $_GET['bbh_ati_codigo']; ?>" />
  <input type="hidden" name="bbh_par_momento" id="bbh_par_momento" value="<?php echo date('Y-m-d'); ?>" />
  <input type="hidden" name="bbh_par_titulo" id="bbh_par_titulo" value="Bl@ck_arquivo_ANEXO*~" />
  <input type="hidden" name="bbh_par_autor" id="bbh_par_autor" value="<?php echo $_SESSION['usuNome']; ?>" />
  <input name="addFile" id="addFile" type="hidden"/>
  <input type="hidden" name="bbh_tipo" id="bbh_tipo" value="pdf.gif" />
</form>  
<iframe id="upload_Arquivo" name="upload_Arquivo" src="#" style="width:0;height:0;border:0px solid #fff; display:none"></iframe>