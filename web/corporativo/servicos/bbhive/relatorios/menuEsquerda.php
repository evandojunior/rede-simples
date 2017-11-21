<?php
//PÁGINA PADRÃO DE RESULTADO DA BUSCA=============================================================
if( !isset($condicao) ) $condicao = '';
$destinoBusca = '/corporativo/servicos/bbhive/relatorios/index.php?Ts='.time() . $condicao;
//================================================================================================

//ESTRUTURA ASSÍNCRONA, APENAS STRING=============================================================
$chamadaAJAX	= "OpenAjaxPostCmd('".$destinoBusca."','conteudoGeral','form1','Consultando informa&ccedil;&otilde;es...','conteudoGeral','1','2');";//1-POST  2-GET
//================================================================================================
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="verdana_11">
    <td height="26" colspan="4" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><img src="/corporativo/servicos/bbhive/images/relatorio-pequeno.gif" width="23" height="23" align="absmiddle" /><strong> Relat&oacute;rios</strong></td>
  </tr>
  <tr class="verdana_11">
    <td colspan="4">&nbsp;</td>
  </tr>
  
  
 <tr class="verdana_11" id="cadPar">
    <td width="34%" height="25" style="border-bottom:#F4F4F4 solid 1px;"><a href="#@" onclick="return showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&relatorios=1|relatorios/paragrafos/regra.php','menuEsquerda|colPrincipal');"><span class="verdana_11"><img src="/corporativo/servicos/bbhive/images/rotina11.gif" border="0" align="absmiddle" /> &nbsp;Cadastro de Par&aacute;grafos</span></a></td>
    <td width="21%" style="border-bottom:#F4F4F4 solid 1px;"><a href="#@" onclick="document.getElementById('bbh_situacao').value='Abertos'; document.getElementById('situacao').checked=true;<?php echo $chamadaAJAX; ?>"><img src="/corporativo/servicos/bbhive/images/relatorio-aberto.gif" width="16" height="16" border="0" align="absmiddle" /> <span class="verdana_9">Em aberto</span></a></td>
    <td width="19%" style="border-bottom:#F4F4F4 solid 1px;"><a href="#@" onclick="document.getElementById('bbh_situacao').value='Fechados'; document.getElementById('situacao').checked=true;<?php echo $chamadaAJAX; ?>"><img src="/corporativo/servicos/bbhive/images/relatorio-fechado.gif" width="16" height="16" border="0" align="absmiddle" /> <span class="verdana_9">Fechado</span></a></td>
    <td width="26%" style="border-bottom:#F4F4F4 solid 1px;"><a href="#@" onclick="document.getElementById('bbh_situacao').value='Todos'; document.getElementById('situacao').checked=false;<?php echo $chamadaAJAX; ?>"><img src="/corporativo/servicos/bbhive/images/proximoII.gif" width="14" height="15" border="0" align="absmiddle" />&nbsp;Todos</a></td>
  </tr>
  
  </table>
<br />
