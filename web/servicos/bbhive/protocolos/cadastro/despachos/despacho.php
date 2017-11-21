<?php
require_once("gerenciaXML.php");
$xml = new XML();//inicia xml


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
?>
<div style="max-height:200px;width:98%;overflow:auto; border-bottom:#039 solid 1px;">
     <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11">
     <?php
		if(isset($naoExibe)){
	 ?>
          <tr>
            <td height="25" colspan="2" align="center" bgcolor="#FFCCCC" class="legandaLabel11"><?php echo ($_SESSION['protNome']); ?> com informa&ccedil;&otilde;es de despacho e n&atilde;o normatizado, entre em contato com o administrador do sistema.</td>
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
<var style="display:none">document.getElementById('totDesp').innerHTML='<?php echo empty($totNo)?0:$totNo; ?>';</var>