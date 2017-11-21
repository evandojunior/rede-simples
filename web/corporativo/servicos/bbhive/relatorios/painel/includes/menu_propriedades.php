<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:5px; margin-top:5px;">
  <tr>
    <td width="60" height="40" align="center" onMouseOver="javascript: this.className='comFundoRel'" onMouseOut="javascript: this.className='semFundoRel'" onclick="OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/backroundJanela.php','carregaTudo','?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo; ?>&pag=/includes/atividade.php','...','carregaTudo','2','2')"><img src="/corporativo/servicos/bbhive/images/btnAtiv.gif" border="0" /></td>
    <td width="60" height="40" align="center" onMouseOver="javascript: this.className='comFundoRel'" onMouseOut="javascript: this.className='semFundoRel'" onClick="OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/backroundJanela.php','carregaTudo','?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo; ?>&pag=/includes/fluxo.php','...','carregaTudo','2','2')"><img src="/corporativo/servicos/bbhive/images/btnRelatorio.gif" border="0" /></td>
    <td width="60" height="40" align="center" <?php if($finalizado == 0){ ?>onMouseOver="javascript: this.className='comFundoRel'" onMouseOut="javascript: this.className='semFundoRel'" onClick="OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/backroundJanela.php','carregaTudo','?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo; ?>&pag=/includes/duplicar.php','...','carregaTudo','2','2')"<?php } ?>><img src="/corporativo/servicos/bbhive/images/<?php echo $finalizado > 0 ? "btnAssOFF.gif" : "btnAss.gif"; ?>" border="0" /></td>
    <td width="60" height="40" align="center" <?php if($finalizado == 0){ ?>onMouseOver="javascript: this.className='comFundoRel'" onMouseOut="javascript: this.className='semFundoRel'" onClick="OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/backroundJanela.php','carregaTudo','?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo; ?>&pag=/editor/pdf.php','...','carregaTudo','2','2')"<?php } ?>><img src="/corporativo/servicos/bbhive/images/<?php echo $finalizado > 0 ? "btnPDFOFF.gif" : "btnPDF.gif"; ?>" border="0" /></td>

    <td width="60" height="40" align="center" <?php if($finalizado == 0){ ?>onMouseOver="javascript: this.className='comFundoRel'" onMouseOut="javascript: this.className='semFundoRel'" onClick="OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/backroundJanela.php','carregaTudo','?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo; ?>&pag=/includes/apagar.php','...','carregaTudo','2','2')"<?php } ?>><img src="/corporativo/servicos/bbhive/images/painel/<?php echo $finalizado > 0 ? "lixeiraOFF.gif" : "lixeira.gif"; ?>" /></td>
    
    <?php /*<td width="60" height="40" align="center" <?php if($finalizado == 0){ ?>onMouseOver="javascript: this.className='comFundoRel'" onMouseOut="javascript: this.className='semFundoRel'" onClick="OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/backroundJanela.php','carregaTudo','?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo; ?>&pag=/ZIP/zip.php','...','carregaTudo','2','2')"<?php } ?>><img src="/corporativo/servicos/bbhive/images/painel/<?php echo $finalizado > 0 ? "compactarOFF.gif" : "compactar.gif"; ?>" width="31" height="27" /></td>*/ ?>
	<td width="60" height="40" align="center">&nbsp;</td>

    <td width="60" height="40" align="center">&nbsp;</td>
    <td width="60" height="40" align="center">&nbsp;</td>
    <td width="60" height="40" align="center">&nbsp;</td>
    <td width="60" height="40" align="center">&nbsp;</td>
    <td width="60" height="40" align="center">&nbsp;</td>
    <td width="60" height="40" align="center" onMouseOver="javascript: this.className='comFundoRel'" onMouseOut="javascript: this.className='semFundoRel'" onClick="showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|relatorios/painel/index.php?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>','menuEsquerda|colPrincipal');limpaAmbiente();"><img src="/corporativo/servicos/bbhive/images/painel/sair.gif" width="29" height="33" /></td>
  </tr>
  <tr>
    <td width="60" align="center" valign="top" class="verdana_11">Descri&ccedil;&atilde;o da atividade</td>
    <td width="60" align="center" valign="top" class="verdana_11">Descri&ccedil;&atilde;o do flluxo</td>
    <td width="60" align="center" valign="top" class="verdana_11">Duplicar relat&oacute;rio</td>
    <td width="60" align="center" valign="top" class="verdana_11">Gerar PDF</td>
    <td width="60" align="center" valign="top" class="verdana_11">Apagar relat&oacute;rio</td>
    <?php /*<td width="60" align="center" valign="top" class="verdana_11">Compactar relat&oacute;rio</td>*/ ?>
    <td width="60" align="center" valign="top" class="verdana_11">&nbsp;</td>
    <td width="60" align="center" valign="top" class="verdana_11">&nbsp;</td>
    <td width="60" align="center" valign="top" class="verdana_11">&nbsp;</td>
    <td width="60" align="center" valign="top" class="verdana_11">&nbsp;</td>
    <td width="60" align="center" valign="top" class="verdana_11">&nbsp;</td>
    <td width="60" align="center" valign="top" class="verdana_11">&nbsp;</td>
    <td width="60" align="center" valign="top" class="verdana_11">Fechar relat&oacute;rio</td>
  </tr>
</table>