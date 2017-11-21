<?php
//PÁGINA PADRÃO DE RESULTADO DA BUSCA=============================================================
if( !isset($condicao) ) $condicao = '';
$destinoBusca = '/corporativo/servicos/bbhive/tarefas/index.php?Ts='.time() . $condicao;
//================================================================================================

//ESTRUTURA ASSÍNCRONA, APENAS STRING=============================================================
$chamadaAJAX	= "OpenAjaxPostCmd('".$destinoBusca."','conteudoGeral','form1','Consultando informa&ccedil;&otilde;es...','conteudoGeral','1','2');";//1-POST  2-GET
//================================================================================================
?><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="verdana_11">
    <td height="26" colspan="3" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><img src="/corporativo/servicos/bbhive/images/tarefas-pequeno.gif" width="23" height="23" align="absmiddle" /><strong> Tarefas</strong></td>
  </tr>
  <tr class="verdana_11">
    <td height="10" colspan="3"></td>
  </tr>
  <tr class="verdana_11">
    <td height="21"><a href="#@" onclick="document.getElementById('bbh_situacao').value='Novas'; document.getElementById('situacao').checked=true;<?php echo $chamadaAJAX; ?>"><span class="verdana_9"><img src="/corporativo/servicos/bbhive/images/novo.gif" width="12" height="15" border="0" align="absmiddle" /> &nbsp;&nbsp;Novas</span></a></td>
    <td><a href="#@" onclick="document.getElementById('bbh_situacao').value='Atrasadas'; document.getElementById('situacao').checked=true;<?php echo $chamadaAJAX; ?>"><img src="/corporativo/servicos/bbhive/images/bomba16.gif" width="16" height="16" border="0" align="absmiddle" /> <span class="verdana_9">Atrasadas</span></a></td>
    <td><a href="#@" onclick="document.getElementById('bbh_situacao').value='Andamento'; document.getElementById('situacao').checked=true;<?php echo $chamadaAJAX; ?>"><img src="/corporativo/servicos/bbhive/images/emandamento16.gif" width="16" height="16" border="0" align="absmiddle" /> <span class="verdana_9">Em andamento</span></a></td>
  </tr>
  <tr class="verdana_11">
    <td height="21"><a href="#@" onclick="document.getElementById('bbh_situacao').value='Aguardando'; document.getElementById('situacao').checked=true;<?php echo $chamadaAJAX; ?>"><img src="/corporativo/servicos/bbhive/images/ampulheta16.gif" width="16" height="16" border="0" align="absmiddle" /> <span class="verdana_9">Aguardando</span></a></td>
    <td height="21"><a href="#@" onclick="document.getElementById('bbh_situacao').value='Concluídas'; document.getElementById('situacao').checked=true;<?php echo $chamadaAJAX; ?>"><img src="/corporativo/servicos/bbhive/images/carimbo16.gif" width="16" height="16" border="0" align="absmiddle" /> <span class="verdana_9">Conclu&iacute;das</span></a></td>
    <td height="21"><a href="#@" onclick="document.getElementById('bbh_situacao').value='Todas'; document.getElementById('situacao').checked=false;<?php echo $chamadaAJAX; ?>"><img src="/corporativo/servicos/bbhive/images/proximoII.gif" width="14" height="15" border="0" align="absmiddle" /> Todas as tarefas</a></td>
  </tr>
  </table>
<br />