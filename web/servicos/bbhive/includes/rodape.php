<?php if(isset($_SESSION['MM_BBhive_Publico']) && $_SESSION['MM_BBhive_Publico']>0){ ?>
<?php
$dirEt 		= explode("web",str_replace("\\","/", strtolower(dirname(__FILE__))));
$etiquetas 	= $dirEt[0]."database/servicos/bbhive/etiqueta.xml";
?><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr style="cursor:pointer;">
    <td width="388" height="30" valign="top" class="legandaLabel11" style="background-image:url(/corporativo/servicos/bbhive/images/barra_vertical.jpg); background-repeat:repeat-x; border-top:1px solid #CCCCCC;color:#00F" <?php if($_SESSION['MM_BBhive_Group']!="-1"){?>onclick="location.href='/datafiles/servicos/bbhive/etiqueta/pacote_impressora.rar'" title="Clique para fazer o baixar o arquivo"<?php } ?>>&nbsp;<?php if($_SESSION['MM_BBhive_Group']!="-1"){?><img src='/corporativo/servicos/bbhive/images/download.gif' alt='Download do arquivo' width='17' height='17' border='0' align="absmiddle">&nbsp;Baixar pacote da impressora de c&oacute;digo de barras<?php } ?></td>
    <td width="389" align="right" valign="top" class="legandaLabel11" style="background-image:url(/corporativo/servicos/bbhive/images/barra_vertical.jpg); background-repeat:repeat-x; border-top:1px solid #CCCCCC;color:#00F">
    <?php if(file_exists($etiquetas) && ($_SESSION['MM_BBhive_Group']!="-1")){ 
			$doc = new DOMDocument("1.0", "iso-8859-1"); 
			$doc->preserveWhiteSpace = false; //descartar espacos em branco    
			$doc->formatOutput = false; //gerar um codigo bem legivel   
			$doc->load($etiquetas);
			//-----	
			$root = $doc->getElementsByTagName("etiqueta")->item(0);
			$et = $root->getElementsByTagName("info")->item(0);
			//-----
			$cabecalho 		= $et->getAttribute("cabecalho");
			$rodape			= $et->getAttribute("rodape");
			
			$homeDestino	= '/servicos/bbhive/includes/etiqueta.php';
			$acaoP = "OpenAjaxPostCmd('".$homeDestino."','loadMsg','enviaFormEtiqueta','Atualizando dados...','loadMsg','1','2');";
	   ?>
    <div>
      <label style="cursor:pointer" onclick="exibeEtiqueta('block')">
    &nbsp;<img src='/servicos/bbhive/images/codigo_barras.png' alt='Download do arquivo' width='16' height='16' border='0' align="absmiddle" />&nbsp;<strong>Imprimir etiquetas</strong>&nbsp;
      </label>
    <form action="http://127.0.0.1:8094" name="enviaFormEtiqueta" id="enviaFormEtiqueta" method="get" style="display:none" target="enviaEtiqueta">
		<input type="hidden" name="titulo" id="titulo" value="<?php echo $cabecalho; ?>">
		<input type="hidden" name="inicio" id="inicio">
		<input type="hidden" name="rodape" id="rodape" value="<?php echo $rodape; ?>">
    <label>Quantidade:<input name="quantidade" type="text" class="back_Campos"  id="quantidade" onkeypress="SomenteNumerico(this)" onkeyup="SomenteNumerico(this)" size="5" maxlength="2"></label>
    <input type="button" class="back_input" name="envia" id="envia" value="Imprimir" onclick="if(confirm('A impressora está instalada nesta estação de trabalho?\n          Clique em OK em caso de confirmação.')){<?php echo $acaoP; ?>}">&nbsp;
    <input name="ex" style="background:url(/servicos/bbhive/images/erro.gif);background-repeat:no-repeat;background-position:left;width:100px;margin-right:5px; cursor:pointer;background-color:#FFFFFF;" type="button" class="back_input" id="ex" value="&nbsp;Fechar" onClick="exibeEtiqueta('none')"/>&nbsp;
    </form>
    <div id="loadMsg">&nbsp;</div>
    <iframe name="enviaEtiqueta" id="enviaEtiqueta" style="display:none"></iframe>
    </div>
    <?php } else { echo "&nbsp;"; }  ?>
    </td>
  </tr>
</table>
<?php } ?>