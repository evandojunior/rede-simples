<?php
foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){	$bbh_ati_codigo= $valor; } 
	if(($indice=="amp;bbh_rel_codigo")||($indice=="bbh_rel_codigo")){ 	$bbh_rel_codigo= $valor; } 
	if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ 	$bbh_flu_codigo= $valor; } 
}
?><form name="uploadFile" id="uploadFile" action="/corporativo/servicos/bbhive/relatorios/painel/anexos_repositorio/adiciona_indicios.php" method="post" target="add_Indicio">
<table width="98%" border="0" align="right" cellpadding="0" cellspacing="0" style="background:#FFF;border:#A0AFC3 solid 1px; ">
  <tr>
    <td height="23" colspan="2" align="left" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><span class="verdana_12">&nbsp;<img src="/corporativo/servicos/bbhive/images/caixa.gif" border="0" align="absmiddle" /> <strong>Ind&iacute;cios</strong></span></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="verdana_12">
      <iframe src="/corporativo/servicos/bbhive/relatorios/painel/anexos_repositorio/lista_indicios.php?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo; ?>&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>" allowtransparency="1" frameborder="0" width="100%" height="240" style="border-left:#E7E7E7 solid 1px;border-right:#E7E7E7 solid 1px;border-bottom:#E7E7E7 solid 1px;"></iframe></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF" class="verdana_12">&nbsp;T&iacute;tulo do par&aacute;grafo :    </td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;<input name="bbh_par_titulo" type="text" class="back_Campos" id="bbh_par_titulo" style="height:20px; line-height:20px;" value="Resultado de análise dos <?php echo $_SESSION['componentesNome']; ?>" size="60"></td>
  </tr>
  <tr>
    <td width="441" height="24" align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="177" height="24" align="right" bgcolor="#FFFFFF"><input type="button" name="cancel" id="cancel" class="back_input" value="Cancelar" style="background:url(/corporativo/servicos/bbhive/images/btnUP.gif); color:#006633; cursor:pointer;" onclick="javascript: document.getElementById('carregaTudo').innerHTML='&nbsp;'" />
      <input type="button" name="send" id="send" class="back_input" value="Adicionar" style="background:url(/corporativo/servicos/bbhive/images/btnUP.gif); color:#006633; cursor:pointer;" onclick="javascript: if((document.getElementById('bbh_par_titulo').value=='')){alert('Informe t&iacute;tulo!')}else{ document.uploadFile.submit(); }" /></td>
  </tr>
</table>
  <input name="bbh_flu_codigo"  id="bbh_flu_codigo" type="hidden" value="<?php echo $bbh_flu_codigo; ?>"/>
  <input name="bbh_rel_codigo" type="hidden" id="bbh_rel_codigo" value="<?php echo $bbh_rel_codigo; ?>" />
  <input name="bbh_ati_codigo" type="hidden" id="bbh_ati_codigo" value="<?php echo $bbh_ati_codigo; ?>" />
  <input type="hidden" name="bbh_par_momento" id="bbh_par_momento" value="<?php echo date('Y-m-d'); ?>" />
  <input type="hidden" name="bbh_par_autor" id="bbh_par_autor" value="<?php echo $_SESSION['usuNome']; ?>" />
  
  <input name="addInd" type="hidden" id="addInd" value="1">
  <iframe id="add_Indicio" name="add_Indicio" src="#" style="width:0;height:0;border:0px solid #fff; display:none"></iframe>
</form>