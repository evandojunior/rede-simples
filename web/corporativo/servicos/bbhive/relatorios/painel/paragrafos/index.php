<?php
foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){	$bbh_ati_codigo= $valor; } 
	if(($indice=="amp;bbh_rel_codigo")||($indice=="bbh_rel_codigo")){ 	$bbh_rel_codigo= $valor; } 
	if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ 	$bbh_flu_codigo= $valor; } 
}

	$homeDestino = "/corporativo/servicos/bbhive/relatorios/painel/paragrafos/executaParagrafos.php";
	$onclick = "OpenAjaxPostCmd('".$homeDestino."?TS=".time()."','cxLoad','addParagrafo','Carregando...','cxLoad','1','2')";
?>
<table width="620" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#FFF;border:#A0AFC3 solid 1px; ">
  <tr>
    <td height="23" colspan="2" align="left" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><span class="verdana_12">&nbsp;<img src="/corporativo/servicos/bbhive/images/para.gif" width="14" height="16" align="absmiddle"><strong>&nbsp;Adicionar par&aacute;grafos pr&eacute;-definidos</strong></span></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12">Escolha o par&aacute;grafo abaixo e clique em adicionar</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12"><strong>&nbsp;Par&aacute;grafos n&atilde;o adicionados</strong></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_12">
    <table width="580" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#E7E7E7 solid 1px;display:">
      <tr>
        <td width="27" height="25" align="center" bgcolor="#F1F1F1">&nbsp;</td>
        <td width="282" align="left" bgcolor="#F1F1F1" class="verdana_11"><b>Par&aacute;grafo</b></td>
        <td width="182" align="left" bgcolor="#F1F1F1" class="verdana_11"><strong>Autor</strong></td>
        <td width="87" align="left" bgcolor="#F1F1F1" class="verdana_11"><b>P&uacute;blico</b></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_12">
	<iframe src="/corporativo/servicos/bbhive/relatorios/painel/paragrafos/paragrafos.php?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo; ?>&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>" width="580" allowtransparency="1" frameborder="0" height="205" style="border-left:#E7E7E7 solid 1px;border-right:#E7E7E7 solid 1px;border-bottom:#E7E7E7 solid 1px;"></iframe></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" id="cxLoad" class="verdana_12 color">&nbsp;</td>
  </tr>
  <tr>
    <td width="455" height="25" align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="163" height="25" align="right" bgcolor="#FFFFFF"><input type="button" name="cancel" id="cancel" class="back_input" value="Cancelar" style="background:url(/corporativo/servicos/bbhive/images/btnUP.gif); color:#006633; cursor:pointer;" onclick="javascript: document.getElementById('carregaTudo').innerHTML='&nbsp;'" />
    <input type="button" name="send" id="send" class="back_input" value="Adicionar" style="background:url(/corporativo/servicos/bbhive/images/btnUP.gif); color:#006633; cursor:pointer;" onclick="if(document.getElementById('bbh_mod_par_codigo').value==''){ alert('Escolha o modelo acima!'); } else { <?php echo $onclick; ?>}" /></td>
  </tr>
</table>
<form name="addParagrafo" id="addParagrafo">
<input type="hidden" name="addPar" value="1" />
    <input type="hidden" name="bbh_rel_codigo" id="bbh_rel_codigo" value="<?php echo $bbh_rel_codigo; ?>" />
  	<input type="hidden" name="bbh_mod_par_codigo" id="bbh_mod_par_codigo" value="" />
	<input type="hidden" name="bbh_ati_codigo" id="bbh_ati_codigo" value="<?php echo $bbh_ati_codigo; ?>" />
  	<input type="hidden" name="bbh_par_autor" id="bbh_par_autor" value="" />
</form>
    
