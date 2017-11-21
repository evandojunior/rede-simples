<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_12" style="margin-top:5px; border:#A0AFC3 solid 1px;">
  <tr>
    <td height="23" colspan="3" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)" class="verdana_12">&nbsp;<a href="#@" onClick="return  showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=<?php echo $row_CabFluxo['bbh_flu_codigo']; ?>|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=<?php echo $row_CabFluxo['bbh_flu_codigo']; ?>&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');" title="Clique para visualizar detalhes do fluxo"><strong><?php echo $numeroNomeProcesso; ?></strong></a></td>
  </tr>
  <tr>
    <td width="10%" rowspan="3" align="center" bgcolor="#F3F2F4"><img src="/corporativo/servicos/bbhive/images/painel/info.jpg" width="47" height="45" /></td>
    <td height="23" colspan="2" bgcolor="#F3F2F4">&nbsp;<strong><?php echo $n= $row_CabFluxo['bbh_flu_titulo']; ?></strong></td>
  </tr>
  <tr>
    <td height="23" colspan="2" bgcolor="#F3F2F4">&nbsp;<img src="/corporativo/servicos/bbhive/images/setaII.gif" border="0" align="absmiddle" />&nbsp;<?php echo $atividade->nome; ?></td>
  </tr>
  <tr>
    <td width="45%" height="23" align="center" bgcolor="#F3F2F4"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr class="legandaLabel">
        <td width="43%" height="15" align="left">Inicio previsto</td>
        <td width="57%" align="left">&nbsp; T&eacute;rmino previsto</td>
      </tr>
      <tr class="legandaLabel">
        <td height="15" align="left">&nbsp;<img src="/corporativo/servicos/bbhive/images/calendarioII.gif" border="0" align="absmiddle" />&nbsp;<?php echo arrumadata($atividade->inicioPrevisto); ?></td>
        <td height="15" align="left">&nbsp;<img src="/corporativo/servicos/bbhive/images/calendario.gif" border="0" align="absmiddle" />&nbsp;<?php echo arrumadata($atividade->finalPrevisto); ?></td>
      </tr>
    </table></td>
    <td width="45%" align="center" bgcolor="#F3F2F4"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr class="legandaLabel">
        <td width="43%" height="15" align="left">&nbsp;Iniciado real</td>
        <td width="57%" align="left">&nbsp;T&eacute;rmino real</td>
      </tr>
      <tr class="legandaLabel">
        <td height="15" align="left">&nbsp;<img src="/corporativo/servicos/bbhive/images/calendarioII.gif" border="0" align="absmiddle" />&nbsp;<?php echo arrumadata($atividade->inicioReal); ?></td>
        <td height="15" align="left">&nbsp;<img src="/corporativo/servicos/bbhive/images/calendario.gif" border="0" align="absmiddle" />&nbsp;<?php echo arrumadata($atividade->finalReal); ?></td>
      </tr>
    </table></td>
  </tr>
</table>