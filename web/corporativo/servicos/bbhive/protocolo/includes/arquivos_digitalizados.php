<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99FFFF">
  <tr>
    <td height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="legandaLabel12">&nbsp;<img src="/corporativo/servicos/bbhive/images/clipes.gif" alt="" border="0" align="absmiddle" />&nbsp;<strong>(<label id="totArq">0</label>) Arquivo(s) digitalizado(s)</strong></td>
  </tr>
  </table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="border-left:#E6E6E6 solid 1px;border-right:#E6E6E6 solid 1px;border-bottom:#E6E6E6 solid 1px;" class="legandaLabel11">
  <tr>
    <td width="475" height="25" align="left" bgcolor="#F0F0F0"><strong>&nbsp;Nome do arquivo</strong><strong></strong></td>
    <td width="90" align="center" bgcolor="#F0F0F0"><strong>Tamanho</strong></td>
    <td width="33" align="center" bgcolor="#F0F0F0">&nbsp;</td>
  </tr>
  <tr>
    <td height="1" colspan="3" align="center" bgcolor="#CCCCCC"></td>
  </tr>
  
<?php
$cm = $dirPacote[0]."database/servicos/bbhive/protocolo/protocolo_".$bbh_pro_codigo;

 if ($handle = @opendir($cm."/.")) {
  $cont = 0;
	while (false !== ($file = readdir($handle))) {
	  if ($file != "." && $file != "..") { 
	  
	  	$onClick = "onClick='javascript: document.getElementById(\"bbh_pro_arquivo\").value=\"".$file."\"; document.abreArquivo.bbh_pro_codigo.value=\"".$bbh_pro_codigo."\"; document.abreArquivo.submit();'";
		if(empty($bbh_flu_codigo) && (isset($codSta) && $codSta==1)){
			$onRemove= "onClick=\"document.removeArquivo.bbh_pro_arquivo.value='".$file."'; document.removeArquivo.bbh_pro_codigo.value='".$bbh_pro_codigo."'; document.removeArquivo.submit();\"";
		} else {
			$onRemove= "";
		}
		
				$onMouseMove 	= "listaArquivos(1, 3, 1, ".$cont.")";
				$onMouseOut 	= "listaArquivos(1, 3, 0, ".$cont.")";	
			if(empty($bbh_flu_codigo) && isset($codSta) && ($codSta==1 || $codSta==2)){
				$onMouseMove 	= "listaArquivos(1, 3, 3, ".$cont.")";
				$onMouseOut 	= "listaArquivos(1, 3, 0, ".$cont.")";	
			}
	  ?>
  
  <tr style="cursor:pointer;">
    <td onMouseMove="listaArquivos(1, 3, 1, <?php echo $cont; ?>)" onMouseOut="listaArquivos(1, 3, 0, <?php echo $cont; ?>)" id="td<?php echo $cont; ?>1" title="Clique para fazer o download deste arquivo" <?php echo $onClick; ?>><span class="legandaLabel12">&nbsp;<img src="/corporativo/servicos/bbhive/images/protocolo.gif" alt="" border="0" align="absmiddle" /></span>&nbsp;<?php echo $file; ?></td>
    <td onMouseMove="listaArquivos(1, 3, 1, <?php echo $cont; ?>)" onMouseOut="listaArquivos(1, 3, 0, <?php echo $cont; ?>)" align="right" id="td<?php echo $cont; ?>2" title="Clique para fazer o download deste arquivo" <?php echo $onClick; ?>><? echo TamanhoArquivo($cm."/".$file); ?>&nbsp;</td>
    <td onMouseMove="<?php echo $onMouseMove; ?>" onMouseOut="<?php echo $onMouseOut; ?>" height="25" align="center" id="td<?php echo $cont; ?>3" title="Excluir arquivo" <?php echo $onRemove; ?>><img src="/corporativo/servicos/bbhive/images/<?php if(empty($bbh_flu_codigo) && isset($codSta) && ($codSta==1)){ echo "excluir.gif"; } else { echo "excluir-negado.gif"; } ?>" alt="Excluir arquivo" width="17" height="17" border="0" align="absmiddle" /></td>
  </tr>
<?php 
		$cont++; 
		if ($cont == 300) {
		die;
		}
     }
  }
 closedir($handle);
}
  if($cont==0){
?>
  <tr>
    <td height="25" colspan="3" align="center" style="color:#F60">N&atilde;o existem arquivos digitalizados!</td>
  </tr>
  <?php } ?>
</table>
<var style="display:none">document.getElementById('totArq').innerHTML='<?php echo $cont; ?>';</var>
<form id="abreArquivo" name="abreArquivo" action="/corporativo/servicos/bbhive/protocolo/download/anexos.php" method="post" style="position:absolute" target="_blank">
	<input name="bbh_pro_arquivo" id="bbh_pro_arquivo" type="hidden" value="0" />
	<input name="bbh_pro_codigo" id="bbh_pro_codigo" type="hidden" value="0" />
</form>
<form id="removeArquivo" name="removeArquivo" action="/corporativo/servicos/bbhive/protocolo/download/remove.php" method="post" style="position:absolute" target="delete_Arquivo">
	<input name="bbh_pro_arquivo" id="bbh_pro_arquivo" type="hidden" value="0" />
	<input name="bbh_pro_codigo" id="bbh_pro_codigo" type="hidden" value="0" />
</form>
<iframe id="delete_Arquivo" name="delete_Arquivo" src="#" style="width:0;height:0;border:0px solid #fff; display:none"></iframe>