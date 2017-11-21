<?php
//verifica quantas TAGS XMl tem no campo.
$doc 	= @$xml->leXML($row_strProtocolo['bbh_pro_obs']);
$totNo 	= 0;

if($doc->getElementsByTagName("despacho")){
	$totNo = @$doc->getElementsByTagName("despacho")->item(0)->childNodes->length;
}

	 	if(!empty($row_strProtocolo['bbh_pro_obs'])){
			$pos = strpos($row_strProtocolo['bbh_pro_obs'],"<?xml version");
			 if($pos === false){ $naoExibe = true;}
		}

if (!in_array($row_strProtocolo['bbh_pro_status'], [5,6,1])) {
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99FFFF">
  <tr>
    <td height="26" colspan="2" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="legandaLabel12">&nbsp;<img src="/corporativo/servicos/bbhive/images/05_.gif" align="absmiddle" />&nbsp;<strong><?php echo ($_SESSION['despachoprotNome']); ?></strong></td>
  </tr>
  <?php if(!isset($naoExibe)){?>
  <tr id="bloco-padrao-despacho-protocolo" style="">
    <td width="98%" height="26" align="center" bgcolor="#F0F0F0" class="legandaLabel12"><textarea class="formulario2" name="bbh_pro_obs" id="bbh_pro_obs" cols="80" rows="3"></textarea></td>
    <td width="90" bgcolor="#F0F0F0" class="legandaLabel12"><input name="cadastrar2" style="background:url(/servicos/bbhive/images/pesquisar.gif);background-repeat:no-repeat;background-position:left;height:23px;width:auto;cursor:pointer;background-color:#FFFFFF;" type="button" class="back_input" id="cadastrar" value="&nbsp;&nbsp;Adicionar <?php echo strtolower(($_SESSION['despachoprotNome'])); ?>" onclick="document.getElementById('pro_obs').value = document.getElementById('bbh_pro_obs').value; <?php echo $acao; ?>"/></td>
  </tr>
  <?php } ?>
</table>
<?php } ?>

<table width="98%" height="52" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:10px;">
  <tr>
    <td height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="legandaLabel12">&nbsp;<img src="/corporativo/servicos/bbhive/images/historico.gif" alt="" border="0" align="absmiddle" />&nbsp;<strong>(<label id="totDesp">0</label>) Histórico - <?php echo ($_SESSION['despachoprotLegenda']); ?></strong></td>
  </tr>
  <tr>
    <td height="26">
    <div style="max-height:200px;width:98%;overflow:auto; border-bottom:#039 solid 1px;">
     <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11">
     <?php
		if(isset($naoExibe)){
	 ?>
          <tr style="cursor:pointer" onclick="document.getElementById('acao').value='-2'; <?php echo $acao; ?>">
            <td height="25" colspan="2" align="center" bgcolor="#FFCCCC" class="legandaLabel11"><?php echo($_SESSION['ProtNome']); ?> com informa&ccedil;&otilde;es de despacho e n&atilde;o normatizado, clique aqui para normatizar.</td>
         </tr>
      <?php }

        $elemento = $doc->getElementsByTagName("despacho")->item(0); 
         for($a = ($totNo-1); $a>=0; $a--){ 
          ?> 
          <tr>
            <td width="131" height="25" class="legandaLabel11"><img src="/corporativo/servicos/bbhive/images/seta_verdePeq.gif" border="0" align="absmiddle" /><?php echo $elemento->childNodes->item($a)->getAttribute('momento'); ?></td>
            <td width="449" class="legandaLabel11"><?php echo ($elemento->childNodes->item($a)->getAttribute('profissional')); ?></td>
          </tr>
          <tr>
            <td height="25" colspan="2" valign="top" class="legandaLabel11">
              <div style="margin-left:15px; margin-right:5px; margin-bottom:0px; color:#390">
              <em><?php echo ($elemento->childNodes->item($a)->getAttribute('mensagem')); ?></em></div>
            </td>
          </tr>
          <?php } ?>
          <?php if($totNo==0 && !isset($naoExibe)) { ?>
          <tr>
            <td height="25" colspan="2" align="center" style="color:#F60">N&atilde;o existem despachos cadastrados!</td>
          </tr>
          <?php } ?>
     </table>
    </div>
    </td>
  </tr>
</table>
<?php if(!isset($naoExibe)){?><var style="display:none">document.getElementById('bbh_pro_obs').focus();</var><?php } ?>
<var style="display:none">document.getElementById('totDesp').innerHTML='<?php echo empty($totNo)?0:$totNo; ?>';</var>