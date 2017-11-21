<?php
	$cabecalho 		= "";
	$rodape			= "";
	$displayAviso 	= 'block';
	$displayInfor 	= 'none';
		if(file_exists($etiquetas)){
			$displayAviso = 'none';
			$displayInfor = 'block';
			
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
		}
	
	$homeDestino	= '/e-solution/servicos/bbhive/configuracao/index.php?aba=5';
	$acaoE = "OpenAjaxPostCmd('".$homeDestino."','loadEtiqueta','atualizaEtiqueta','Atualizando dados...','loadEtiqueta','1','2');";
?><form name="atualizaEtiqueta" id="atualizaEtiqueta" style="margin-top:-1px;"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="2" class="borderAlljanela">
  <tr class="legandaLabel11">
    <td height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Impress&atilde;o de etiquetas</strong>      <input name="updateEtiqueta" type="hidden" id="updateEtiqueta" value="1"></td>
    </tr>
  <tr class="legandaLabel11">
    <td height="25">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="100%" height="22" align="center">
            	<div id="loadEtiqueta" class="legandaLabel11" style="color:#00F">&nbsp;</div>
            	<div id="msgNovo" style="display:<?php echo $displayAviso; ?>">
                	<div align="center" style="cursor:pointer; color:#F60" onMouseMove="this.style.backgroundColor='#EFEFE7'"  onMouseOut="this.style.backgroundColor='#FFFFFF'" onClick="<?php echo $acaoE; ?>">
                    	Sistema n&atilde;o habilitado para impress&atilde;o de etiquetas<br>
            Clique aqui para habilitar.
                    </div>
                </div>
                <div id="msgCabeca" style="display:<?php echo $displayInfor; ?>">
                	<table width="600" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="114" height="25" align="right"><strong>Cabe&ccedil;alho :&nbsp;</strong></td>
                        <td colspan="2" align="left"><input class="back_Campos" name="cabecalho" type="text" id="cabecalho" size="30" maxlength="17" value="<?php echo $cabecalho; ?>"></td>
                      </tr>
                      <tr>
                        <td height="25" align="right"><strong>Rodap&eacute; :&nbsp;</strong></td>
                        <td width="326" align="left"><input class="back_Campos" name="rodape" type="text" id="rodape" size="30" maxlength="20" value="<?php echo $rodape; ?>"></td>
                        <td width="160" align="left"><input name="updateP" type="button" class="back_input" id="updateP" value="Atualizar etiquetas" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" onClick="<?php echo $acaoE; ?>"/></td>
                      </tr>
                    </table>

              </div>
            </td>
          </tr>
          
          </table>
      </td>
    </tr>
  <tr>
    <td height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
</table></form>