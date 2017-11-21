<?php
 require_once("../../../includes/autentica.php");
 $bbh_rel_codigo = isset($_POST['bbh_rel_codigo']) ? $_POST['bbh_rel_codigo'] : $_GET['bbh_rel_codigo'];

	$query_relatorio = "select bbh_flu_codigo, bbh_rel_protegido, bbh_relatorio.bbh_ati_codigo from bbh_relatorio inner join bbh_atividade on bbh_relatorio.bbh_ati_codigo = bbh_atividade.bbh_ati_codigo where bbh_rel_codigo =  $bbh_rel_codigo";
    list($relatorio, $row_relatorio, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_relatorio);
	
	$bbh_flu_codigo = $row_relatorio['bbh_flu_codigo'];
	$bbh_ati_codigo = $row_relatorio['bbh_ati_codigo'];
?>
<form name="gerarpdf" id="gerarpdf" method="post" action="/corporativo/servicos/bbhive/relatorios/painel/editor/executa.php" target="_blank">
<div style="height:350px;">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_12" style="border:#A0AFC3 solid 1px;">
  <tr>
    <td width="434" height="23" align="left" background="/corporativo/servicos/bbhive/images/painel/pixelBack.jpg" style="border-bottom:#A0AFC3 solid 1px;"><span class="verdana_12">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/impressora.gif" align="absmiddle" /> <strong>Imprimir em PDF</strong></span></td>
    <td width="186" height="23" align="right" background="/corporativo/servicos/bbhive/images/painel/pixelBack.jpg" style="border-bottom:#A0AFC3 solid 1px;"><a href="#@" onclick="window.top.document.getElementById('carregaTudo').innerHTML = '&nbsp;';"><span style="color:#F60" class="verdana_12"><strong>Fechar janela</strong></span>&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/fechar.gif" width="18" height="18" border="0" align="absmiddle" /></a></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
    </tr>
  <tr>
    <td height="350" colspan="2" valign="top"><table width="610" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="344" height="200" rowspan="2" valign="top">
        	<fieldset style="border:#06C solid 1px; margin:2px;">
            	<legend>Configurações</legend>
            	<table width="340" border="0" align="right" cellpadding="0" cellspacing="0" class="verdana_11">
                  <tr>
                    <td height="25" colspan="5" align="left">
                    <div style="float:left; line-height:25px; vertical-align:text-bottom">&nbsp;Margens&nbsp;</div>
                    <div style="float:right; line-height:25px; background-image:url(/corporativo/servicos/bbhive/images/linha_separador.gif); width:80%; margin-right:3px;">&nbsp;</div>
                    </td>
                  </tr>
                  <tr>
                    <td width="36" height="25" align="left">&nbsp;</td>
                    <td width="36" height="25" align="left">Superior :</td>
                    <td width="247" align="left"><input name="superior" type="text" id="superior" value="48" size="3" class="back_Campos" style="height:15px; line-height:20px;"/>
                      mm</td>
                    <td width="72" align="left">Inferior :</td>
                    <td width="209" align="left"><input name="inferior" type="text" id="inferior" value="30" size="3" class="back_Campos" style="height:15px; line-height:20px;"/>
                      mm</td>
                  </tr>
                  <tr>
                    <td height="25" align="left">&nbsp;</td>
                    <td height="25" align="left">Esquerda:</td>
                    <td align="left"><input name="esquerda" type="text" id="esquerda" value="30" size="3" class="back_Campos" style="height:15px; line-height:20px;"/>
                      mm</td>
                    <td align="left">Direira :</td>
                    <td align="left"><input name="direita" type="text" id="direita" value="30" size="3" class="back_Campos" style="height:15px; line-height:20px;"/>
                      mm</td>
                  </tr>
                  <tr>
                    <td height="5" colspan="5" align="left">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="25" colspan="5" align="left"><label>
                      <input name="chk_cabecalho" type="checkbox" id="chk_cabecalho"  />
                    Utilizar cabe&ccedil;alho padr&atilde;o importado para o sistema</label></td>
                  </tr>
                  <tr>
                    <td height="25" colspan="5" align="left"><label><input name="chk_rodape" type="checkbox" id="chk_rodape"  />
                    Utilizar rodap&eacute; padr&atilde;o importado para o sistema</label></td>
                  </tr>
                  <tr>
                    <td height="5" colspan="5" align="left">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="129" colspan="5" align="left" valign="top">
<table width="350" border="0" align="right" cellpadding="0" cellspacing="0" class="verdana_11">
      <tr>
        <td height="25" colspan="2" align="left"><label>
          <input name="chk_numpages" type="radio" id="chk_n_pages" onclick="javascript: document.getElementById('opData1').style.display='none';document.getElementById('opData2').style.display='none';" checked="checked" value="chk_n_pages" />
        &nbsp;N&atilde;o exibir n&uacute;mero de p&aacute;ginas</label></td>
      </tr>
      <tr>
        <td height="25" colspan="2" align="left"><label>
          <input name="chk_numpages" type="radio" id="chk_numpages" onclick="javascript: document.getElementById('opData1').style.display='none';document.getElementById('opData2').style.display='none';" value="chk_numpages" />
        &nbsp;Exibir n&uacute;mero de p&aacute;ginas</label></td>
        </tr>
      <tr>
        <td height="25" colspan="2" align="left"><label>
          <input type="radio" name="chk_numpages" id="chk" value="chk_data" onclick="javascript: if(this.checked==false){ document.getElementById('opData1').style.display='none';document.getElementById('opData2').style.display='none';} else {document.getElementById('opData1').style.display='block';document.getElementById('opData2').style.display='block';}"/>
        &nbsp;Exibir n&uacute;mero de p&aacute;ginas e data</label></td>
        </tr>
      <tr id="opData1" style="display:none">
        <td width="32" height="25" align="center">&nbsp;</td>
        <td align="left"><label><span class="verdana_12" style="color:#F60">
          <input type="radio" name="dtRel" id="dtRel_2" value="1" onclick="document.getElementById('dtHora').value = this.value;" />
Data autom&aacute;tica</span></label></td>
      </tr>
      <tr id="opData2" style="display:none">
        <td height="25" align="center">&nbsp;</td>
        <td align="left"><label><span class="verdana_12" style="color:#F60">
          <input name="dtRel" type="radio" id="dtRel_1" value="2" checked="checked" onclick="document.getElementById('dtHora').value = this.value;" />
Data de cria&ccedil;&atilde;o do relat&oacute;rio</span></label>
          
          <input type="hidden" name="dtHora" id="dtHora" value="2" /></td>
      </tr>
      <tr>
        <td height="25" align="center">&nbsp;</td>
        <td align="left">&nbsp;</td>
      </tr>
    </table>
                    </td>
                  </tr>
                </table>
        	</fieldset>
        </td>
        <td width="266" valign="top">
<fieldset style="border:#06C solid 1px; margin:2px;">
            	<legend>Orienta&ccedil;&atilde;o</legend>
                <table width="240" border="0" align="right" cellpadding="0" cellspacing="0" class="verdana_11">
                  <tr>
                    <td height="25" colspan="2" align="left"><label>
                      <input name="orientacao_1" type="radio" id="retrato" value="P" checked="checked" onclick="document.getElementById('pas').style.display='none'; document.getElementById('ret').style.display='block';document.getElementById('orientacao').value=this.value" />
                      Retrato</label>
                      &nbsp;&nbsp;<br />
                      <label>
                        <input type="radio" name="orientacao_1" value="L" id="retrato" onclick="document.getElementById('ret').style.display='none'; document.getElementById('pas').style.display='block';document.getElementById('orientacao').value=this.value" />
                        Paisagem</label>
                      <input type="hidden" value="P" name="orientacao" id="orientacao" /></td>
                    <td width="116" height="82" colspan="2" rowspan="2" align="left" valign="middle"><div style="line-height:107px; height:107px;"> <img src="/corporativo/servicos/bbhive/images/retrato.gif" width="82" height="107" align="absmiddle" id="ret" style="display:block" /><img src="/corporativo/servicos/bbhive/images/paisagem.gif" width="115" height="85" align="absmiddle" id="pas" style="display:none" /></div></td>
                  </tr>
                  <tr>
                    <td width="24" height="57" align="left">&nbsp;</td>
                    <td width="100" height="57" align="left">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="10" colspan="4" align="left"><label for="infAnexo"><input name="infAnexo" type="checkbox" id="infAnexo" />&nbsp;Exibir t&iacute;tulo(s) do(s) anexo(s) </label> </td>
                    </tr>
                  <tr>
                    <td height="10" colspan="4" align="left"><label for="impVisivel"><input name="impVisivel" type="checkbox" id="impVisivel" <?php if($row_relatorio['bbh_rel_protegido']=='0') { echo 'checked="checked"'; } ?> />
                    Tornar impress&atilde;o vis&iacute;vel </label> </td>
                    </tr>
                </table>
        	</fieldset>
        </td>
      </tr>
      <tr>
        <td valign="top">
<fieldset style="border:#390 solid 1px; margin:2px; margin-top:5px; display:none" id="progresso">
            	<legend>Situação da impressão</legend>
                <table width="240" border="0" cellspacing="0" cellpadding="0" class="verdana_9">
                  <tr class="faltaProcessar" id="tr1">
                    <td width="24" height="22" align="center"><img src="/corporativo/servicos/bbhive/images/excluir.gif" width="17" height="17" /></td>
                    <td width="160" align="left">Removendo arquivo anterior</td>
                    <td width="27" align="center" id="td1"><img src="/corporativo/servicos/bbhive/images/cancelar.gif" alt="" width="16" height="16" /></td>
                  </tr>
                  <tr class="faltaProcessar" id="tr2">
                    <td height="22" align="center" id="td1"><img src="/corporativo/servicos/bbhive/images/painel/engrenagem.gif" alt="" width="16" height="16" /></td>
                    <td align="left">Gerando laudo</td>
                    <td align="center" id="td2"><img src="/corporativo/servicos/bbhive/images/cancelar.gif" alt="" width="16" height="16" /></td>
                  </tr>
                  <tr class="faltaProcessar" id="tr3">
                    <td height="22" align="center"><img src="/corporativo/servicos/bbhive/images/painel/anexo.gif" alt="" width="16" height="16" /></td>
                    <td align="left">Inclu&iacute;ndo arquivos PDF's</td>
                    <td align="center" id="td3"><img src="/corporativo/servicos/bbhive/images/cancelar.gif" alt="" width="16" height="16" /></td>
                  </tr>
                  <?php /*<tr class="faltaProcessar" id="tr4">
                    <td height="22" align="center"><img src="/corporativo/servicos/bbhive/images/painel/zip.gif" alt="" width="16" height="16" /></td>
                    <td align="left">Compactando arquivos</td>
                    <td align="center" id="td4"><img src="/corporativo/servicos/bbhive/images/cancelar.gif" alt="" width="16" height="16" /></td>
                  </tr>*/ ?>
                  <tr class="faltaProcessar" id="tr4">
                    <td height="22" align="center"><img src="/corporativo/servicos/bbhive/images/painel/analise.gif" alt="" width="16" height="16" /></td>
                    <td align="left">Prepadando para download</td>
                    <td align="center" id="td4"><img src="/corporativo/servicos/bbhive/images/cancelar.gif" alt="" width="16" height="16" /></td>
                  </tr>
                  <tr class="faltaProcessar" id="tr5">
                    <td height="22" align="center"><img src="/corporativo/servicos/bbhive/images/painel/redirect.gif" alt="" width="16" height="16" /></td>
                    <td align="left">Redirecionando</td>
                    <td align="center" id="td5"><img src="/corporativo/servicos/bbhive/images/cancelar.gif" alt="" width="16" height="16" /></td>
                  </tr>
                </table>
        </fieldset>
        </td>
      </tr>
          <td height="10" colspan="2" valign="middle" class="verdana_9"9 style="color:#06C">*Caso tenha problemas em baixar o arquivo para o seu computador, desabilite o bloqueador de popup.</td>
        </tr>
      <tr>
        <td height="25" colspan="2" class="verdana_11">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="53%" height="25" id="loadImpressao" style="color:#06C">&nbsp;</td>
            <td width="47%">
          <input name="voltar" type="button" id="voltar" style="background-image:url(/corporativo/servicos/bbhive/images/painel/bt_atividade.gif); width:131px; height:22px;cursor:pointer; border:none; background-repeat:no-repeat; font-family:Verdana, Geneva, sans-serif; font-size:11px;" onclick="showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|tarefas/acao/regra.php?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&','menuEsquerda|colPrincipal');limpaAmbiente();"/>
          <input type="button" name="cancelar" id="cancelar" style="background-image:url(/corporativo/servicos/bbhive/images/painel/bt_cancelar.gif); width:74px; height:22px;cursor:pointer; border:none; background-repeat:no-repeat" onclick="window.top.document.getElementById('carregaTudo').innerHTML = '&nbsp;';"/>
          <input type="button" name="salvar" id="salvar" style="background-image:url(/corporativo/servicos/bbhive/images/painel/ok.gif); width:74px; height:22px;cursor:pointer; border:none; background-repeat:no-repeat" onclick="document.getElementById('progresso').style.display='block';reiniciaImpressao();" />
          &nbsp;
            </td>
          </tr>
        </table>
		</td>
      </tr>
      </table>

    </td>
  </tr>
</table>
</div>

  <input type="button" name="button" id="button" value="ok" onclick="document.getElementById('atual').value='2';document.gerarpdf.submit();"  style="display:none"/>
  <input name="limite" type="hidden" id="limite" value="5" size="2" />
  <input name="atual" type="hidden" id="atual" value="1" size="2" />
<input name="id" type="hidden" id="id" value="<?php echo $bbh_rel_codigo; ?>" />
<input name="bbh_flu_codigo" type="hidden" id="bbh_flu_codigo" value="<?php echo $bbh_flu_codigo; ?>" />
</form>
<form name="downloadPDF" id="downloadPDF" action="/datafiles/servicos/bbhive/temp_transf/<?php echo $_SESSION['usuCod']; ?>/relatorio_final.pdf" target="_new" method="get"></form>