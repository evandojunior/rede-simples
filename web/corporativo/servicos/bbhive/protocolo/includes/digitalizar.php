<?php  if(!isset($_SESSION)){ session_start(); } 
//recuperação de variáveis do GET e SESSÃO
foreach($_GET as $indice => $valor){
	if(($indice=="amp;bbh_pro_codigo")||($indice=="bbh_pro_codigo")){ $bbh_pro_codigo = $valor; }
}

if(isset($_POST['addFile'])){
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
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
		
?>
    <script type="text/javascript">
		window.top.window.uploadFile.reset();
		window.top.window.showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|protocolo/regra.php?bbh_pro_codigo=<?php echo $bbh_pro_codigo; ?>','menuEsquerda|conteudoGeral');
	</script>	
    <?php 
	exit;
	}
}
?><form name="uploadFile" id="uploadFile" action="/corporativo/servicos/bbhive/protocolo/includes/digitalizar.php" method="post" enctype="multipart/form-data" target="upload_Arquivo"><table width="566" border="0" align="center" cellpadding="0" cellspacing="0">
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
                  <td height="5" align="right"><input name="bbh_pro_codigo" type="hidden" id="bbh_pro_codigo" value="<?php echo $bbh_pro_codigo; ?>">&nbsp;</td>
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
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99FFFF">
  <tr>
    <td height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;</td>
    <td bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;</td>
  </tr>
  <tr>
    <td width="23" height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/voltar.gif" width="14" height="15" /></td>
    <td width="577" bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;<a href="#@" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|protocolo/regra.php?bbh_pro_codigo=<?php echo $bbh_pro_codigo; ?>','menuEsquerda|conteudoGeral');">Voltar para p&aacute;gina - <?php echo($_SESSION['ProtNome']); ?></a></td>
  </tr>
</table>
    