<?php
	$homeDestino	= '/e-solution/servicos/bbhive/configuracao/index.php';
	$acaoP = "OpenAjaxPostCmd('".$homeDestino."','loadMsg','atualizaProtocolo','Atualizando dados...','loadMsg','1','2');";
	
$digitalizar 		= "";
$indicios 			= "";
$imprimir 			= "";
$mensagens_com_fluxo= "";
//$detalhamento		= "";
$aposReceber		= "";


	if(file_exists($arquivo."config.xml")){
		$doc = new DOMDocument("1.0", "iso-8859-1"); 
		$doc->preserveWhiteSpace = false; //descartar espacos em branco    
		$doc->formatOutput = false; //gerar um codigo bem legivel   
		$doc->load($arquivo."config.xml");
		//-----	
		$root = $doc->getElementsByTagName("config")->item(0);
		$prot = $root->getElementsByTagName("protocolo")->item(0);
		//-----
		$digitalizar 		= $prot->getAttribute("digitalizar");
		$indicios 			= $prot->getAttribute("indicios");
		$imprimir 			= $prot->getAttribute("imprimir");
		$mensagens_com_fluxo= $prot->getAttribute("mensagens_com_fluxo");
		//$detalhamento		= $prot->getAttribute("detalhamento");
		$aposReceber		= $prot->getAttribute("aposreceber");
	}

$dirKey = __DIR__ . "/../../../../../database/keys/urbem-cmp.pem";
?>
<form name="atualizaProtocolo" id="atualizaProtocolo" style="margin-top:-1px;" enctype="multipart/form-data"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="2" class="borderAlljanela">
  <tr class="legandaLabel11">
    <td height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><strong><?php echo $_SESSION['adm_protNome']; ?></strong></td>
    <td align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><input name="updateProtocolo" type="hidden" id="updateProtocolo" value="1">      <input name="updateP" type="button" class="back_input" id="updateP" value="Atualizar <?php echo $_SESSION['adm_protNome']; ?>" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" onclick="<?php echo $acaoP; ?>"/></td>
  </tr>
  <tr class="legandaLabel11">
    <td width="433" height="25">
    	<fieldset>
        	<legend>Digitalizar</legend>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="11%" height="22" align="center"><input type="radio" name="digitalizar" id="digitalizar" value="dig_nunca" <?php if($digitalizar == "dig_nunca"){ echo "checked"; }?>></td>
                <td width="89%">Nunca digitalizar</td>
              </tr>
              <tr>
                <td height="22" align="center"><input name="digitalizar" type="radio" id="digitalizar" value="dig_sempre" <?php if($digitalizar == "dig_sempre"){ echo "checked"; } if(empty($digitalizar)){ echo "checked";} ?>></td>
                <td>Sempre digitalizar</td>
              </tr>
              <tr>
                <td height="22" align="center"><input type="radio" name="digitalizar" id="digitalizar" value="dig_perguntar"<?php if($digitalizar == "dig_perguntar"){ echo "checked"; }?>></td>
                <td>Perguntar</td>
              </tr>
          </table>
    	</fieldset>
    </td>
    <td width="433">
    	<fieldset>
        	<legend>Cadastro de ind&iacute;cios</legend>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="11%" height="22" align="center"><input type="radio" name="indicios" id="indicios" value="ind_nunca" <?php if($indicios == "ind_nunca"){ echo "checked"; } ?>></td>
                <td width="89%">Nunca cadastrar ind&iacute;cios</td>
              </tr>
              <tr>
                <td height="22" align="center"><input name="indicios" type="radio" id="indicios" value="ind_sempre" <?php if($indicios == "ind_sempre"){ echo "checked"; } if(empty($indicios)){ echo "checked";} ?>></td>
                <td>Sempre cadastrar ind&iacute;cios</td>
              </tr>
              <tr>
                <td height="22" align="center"><input type="radio" name="indicios" id="indicios" value="ind_perguntar"  <?php if($indicios == "ind_perguntar"){ echo "checked"; } ?>></td>
                <td>Perguntar</td>
              </tr>
          </table>
    	</fieldset>
    </td>
  </tr>
  <tr>
    <td valign="top" height="25" class="legandaLabel11">
      <fieldset>
        <legend>Imprimir</legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="11%" height="22" align="center"><input type="radio" name="imprimir" id="imprimir" value="imp_nunca" <?php if($imprimir == "imp_nunca"){ echo "checked"; } ?>></td>
            <td width="89%">Nunca imprimir</td>
            </tr>
          <tr>
            <td height="22" align="center"><input name="imprimir" type="radio" id="imprimir" value="imp_sempre" <?php if($imprimir == "imp_sempre"){ echo "checked"; } if(empty($imprimir)){ echo "checked";} ?>></td>
            <td>Sempre imprimir</td>
            </tr>
          <tr>
            <td height="22" align="center"><input type="radio" name="imprimir" id="imprimir" value="imp_perguntar" <?php if($imprimir == "imp_perguntar"){ echo "checked"; } ?>></td>
            <td>Perguntar</td>
            </tr>
          </table>
        </fieldset>
    </td>
    <td valign="top" class="legandaLabel11"><fieldset>
        <legend>Mensagens</legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="5%" height="22" align="center">&nbsp;</td>
            <td width="95%">Enviar mensagens com fluxo anexado :
              <label for="mensagens_com_fluxo"></label>
              <select name="mensagens_com_fluxo" id="mensagens_com_fluxo" class="verdana_11">
                <option value="1" <?php echo $mensagens_com_fluxo=="1"?"selected":"";?>>Sim</option>
                <option value="0" <?php echo $mensagens_com_fluxo=="0"?"selected":"";?>>N&atilde;o</option>
              </select></td>
            </tr>
          </table>
        </fieldset>
        
        <fieldset>
        <legend>Após receber fazer:</legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="5%" height="22" align="center">&nbsp;</td>
            <td width="95%"><?php
				require_once("apos_receber_protocolo.php");
			?>
            <label for="aposreceber"></label>
              <select name="aposreceber" id="aposreceber" class="verdana_11" onchange="listenerOptionSelected(this)">
                <option value="" <?php echo $aposReceber=="" ? "selected" : ""?>>Nada</option>
                <?php foreach($arquivosExecucao as $i=>$v){?>
	                <option value="<?php echo $i; ?>" <?php echo $aposReceber==$i ? "selected" : ""?>><?php echo $v; ?></option>
                <?php } ?>
              </select></td>
            </tr>
          </table>
        </fieldset>

        <fieldset id="securityKeyRedeSimples" style="display: none">
            <legend>Chave acesso Rede Simples:</legend>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="5%" height="22" align="center">&nbsp;</td>
                    <td width="95%">
                        <div style="font-size: 12px; color: blue;">
                            <?php if(file_exists($dirKey)) { echo sprintf("Chave de acesso <strong>%s</strong>", basename($dirKey)); }?>
                        </div>
                        <input type="file" name="securityKey" id="securityKey" />
                        <input name="uploadFile" type="button" class="back_input" id="uploadFile" value="Enviar chave" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" onclick="sendFileSecurityKey();">

                        <?php if(file_exists($dirKey)) { ?>
                            <div style="font-size: 15px; margin-top: 15px; text-align: center">
                                <a href="#@" style="color: blue;" onclick="listenerTestarComunicacaoRedeSimples()">[Testar comunicação com Rede Simples]</a>
                            </div>
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </fieldset>
        </td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
</table></form>

<div id="resComunicacaoRedeSimples" style="font-size: 13px; text-align: center"></div>
<var style="display:none">listenerOptionSelected(document.getElementById("aposreceber"));</var>