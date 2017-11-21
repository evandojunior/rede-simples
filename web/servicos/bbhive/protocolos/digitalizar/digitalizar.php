<?php  if(!isset($_SESSION)){ session_start(); } 
	include($_SESSION['caminhoFisico']."/servicos/bbhive/includes/autentica.php");


if(isset($_POST['addFile'])){
	include($_SESSION['caminhoFisico']."/servicos/bbhive/includes/functions.php");
	if(!empty($_FILES["nvArquivo"])){
		$bbh_pro_codigo 	= $_POST['bbh_pro_codigo'];
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
		
		$diretorio = $localizacao_documento[0] . "database/servicos/bbhive/protocolo";
		if(!file_exists($diretorio)) {	
			mkdir($diretorio, 777);
			chmod($diretorio,0777);
		}
		$diretorio.= "/protocolo_".$bbh_pro_codigo;
		if(!file_exists($diretorio)) {	
			mkdir($diretorio, 777);
			chmod($diretorio,0777);
		}
		
	   	$result = 0;
		//define nome do arquivo com informações tratadas
		$nvNome			= trataCaracteres(str_replace(".$pext" , "", strtolower($arquivo["name"]))).".$pext";
		//===============================================

		$diretorio = $localizacao_documento[0] . "database/servicos/bbhive/protocolo/protocolo_".$bbh_pro_codigo."/".$nvNome;	
		
		if(file_exists($diretorio)){
			unlink($diretorio);
		}
	
		// Faz o upload da imagem
		if(@move_uploaded_file($arquivo["tmp_name"], $diretorio)){
			$result = 1;
		}
		
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Digitalizou um documento com o nome (".$nvNome.") para o (".$_SESSION['protNome'].") (".$bbh_pro_codigo.")  - BBHive público.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
?>
    <script type="text/javascript">
		window.top.window.document.uploadFile.reset();
		window.top.window.LoadSimultaneo('protocolos/cadastro/passo2.php?confirmaDigitalizacao=true','conteudoGeral');
	</script>	
    <?php 
	exit;
	}
}

		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Acessou a página de documentos digitalizados do (".$_SESSION['protNome'].") número (".$_SESSION['idProtocolo'].")  - BBHive público.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
?><form name="uploadFile" id="uploadFile" action="/servicos/bbhive/protocolos/digitalizar/digitalizar.php" method="post" enctype="multipart/form-data" target="upload_Arquivo"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/anexos.gif" align="absmiddle" />&nbsp;<strong>Digitaliza&ccedil;&atilde;o de documentos</strong></td>
  </tr>
  <tr>
    <td height="80" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;"><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#FFFFFF solid 2px;">
      <tr>
        <td height="20" valign="top" bgcolor="#FFFFFF" class="legandaLabel11"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr></tr>
        </table>
          <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#FFFFFF solid 2px;">
            <tr>
              <td height="20" valign="top" bgcolor="#F6F6F6" class="legandaLabel11"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="1" bgcolor="#EDEDED"></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="25" align="left" class="legandaLabel11" style="color:#F60">Escolha o arquivo de um reposit&oacute;rio externo e clique em anexar</td>
                </tr>
                <tr>
                  <td height="20" align="left">Caminho:
        <input name="nvArquivo" id="nvArquivo" type="file" size="20" class="back_input" />
        &nbsp;
        <input name="cadastrar2" style="background:url(/servicos/bbhive/images/disk.gif);background-repeat:no-repeat;background-position:left;height:23px;width:90px;margin-right:1px; cursor:pointer;background-color:#FFFFFF;" type="submit" class="back_input" id="cadastrar" value="&nbsp;Enviar" /></td>
                </tr>
                <tr>
                  <td height="5" align="right"><input name="bbh_pro_codigo" type="hidden" id="bbh_pro_codigo" value="<?php echo $_SESSION['idProtocolo']; ?>">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="1" bgcolor="#EDEDED"></td>
            </tr>
          </table>
          <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          </table></td>
      </tr>
    </table></td>
  </tr>
</table><input name="addFile" id="addFile" type="hidden"/></form><iframe id="upload_Arquivo" name="upload_Arquivo" src="#" style="width:0;height:0;border:0px solid #fff; display:none"></iframe>

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;">
  <tr>
    <td height="28" colspan="3" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/anexos.gif" align="absmiddle" />&nbsp;<strong>Arquivos digitalizados</strong></td>
  </tr>
  <?php $cont = 0;
if ($handle = @opendir(str_replace("web","database",$_SESSION['caminhoFisico'])."/servicos/bbhive/protocolo/protocolo_".$_SESSION['idProtocolo']."/.")) {


while (false !== ($file = readdir($handle))) {
  if ($file != "." && $file != "..") {

		$excluir ="&nbsp;";
		  if(empty($bbh_flu_codigo)){ 
		  	$excluir = "<a href='#@' onClick=\"document.removeArquivo.bbh_pro_arquivo.value='".$file."'; document.removeArquivo.bbh_pro_codigo.value='".$_SESSION['idProtocolo']."'; document.removeArquivo.submit();\"><img src='/corporativo/servicos/bbhive/images/excluir.gif' alt='Excluir arquivo' width='17' height='17' border='0'></a>";
		  }

		echo "<tr class='verdana_12'>
                <td width='5%' height='25' align='center' bgcolor='#FFFFFF' style='border-left:#cccccc solid 1px; border-bottom:#cccccc solid 1px;'><a href='#@' onClick='javascript: document.getElementById(\"bbh_pro_arquivo\").value=\"".$file."\"; document.abreArquivo.bbh_pro_codigo.value=\"".$_SESSION['idProtocolo']."\"; document.abreArquivo.submit();'><img src='/corporativo/servicos/bbhive/images/download.gif' alt='Download do arquivo' width='17' height='17' border='0'></a></td>
                <td width='90%' align='left' bgcolor='#FFFFFF' class='verdana_11' style='border-bottom:#cccccc solid 1px;'>&nbsp;".$file."</td>
                <td width='5%' height='25' align='center' bgcolor='#FFFFFF' style='border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;'>".$excluir."</td>
              </tr>
              <tr>
                <td height='1' colspan='3' align='right' background='/servicos/bbhive/images/separador.gif'></td>
              </tr>";
$cont++; 
		if ($cont == 300) {
		die;
		}
     }
  }
 closedir($handle);
}
?> 
<?php if($cont==0){?>
  <tr>
    <td height="20" colspan="3" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">Não existe arquivos digitalizados</td>
  </tr>
<?php } ?>  
  <tr>
    <td height="25" colspan="3" align="right" valign="bottom" class="legandaLabel11"><input name="cadastrar" style="background:url(/corporativo/servicos/bbhive/images/05_.gif);background-repeat:no-repeat;background-position:left;height:23px;width:100px;margin-right:5px; cursor:pointer;background-color:#FFFFFF;" type="button" class="back_input" id="cadastrar2" value="&nbsp;Prosseguir" onclick="LoadSimultaneo('protocolos/cadastro/passo2.php?naoDigitalizacao=true','conteudoGeral');"/></td>
  </tr>

</table>
<form id="abreArquivo" name="abreArquivo" action="/servicos/bbhive/protocolos/download/anexos.php" method="post" style="position:absolute" target="_blank">
<input name="bbh_pro_arquivo" id="bbh_pro_arquivo" type="hidden" value="0" />
<input name="bbh_pro_codigo" id="bbh_pro_codigo" type="hidden" value="0" />
</form>
<form id="removeArquivo" name="removeArquivo" action="/servicos/bbhive/protocolos/download/remove.php" method="post" style="position:absolute" target="delete_Arquivo">
<input name="bbh_pro_arquivo" id="bbh_pro_arquivo" type="hidden" value="0" />
<input name="bbh_pro_codigo" id="bbh_pro_codigo" type="hidden" value="0" />
</form>
<iframe id="delete_Arquivo" name="delete_Arquivo" src="#" style="width:0;height:0;border:0px solid #fff; display:none"></iframe>