<?php
//PÁGINA PADRÃO DE RESULTADO DA BUSCA=============================================================
if( !isset($condicao) ) $condicao = '';
$destinoBusca = '/corporativo/servicos/bbhive/arquivos/index.php?Ts='.time() . $condicao;
//================================================================================================

//ESTRUTURA ASSÍNCRONA, APENAS STRING=============================================================
$chamadaAJAX	= "OpenAjaxPostCmd('".$destinoBusca."','conteudoGeral','buscaArquivo','Consultando informa&ccedil;&otilde;es...','conteudoGeral','1','2');";//1-POST  2-GET
//================================================================================================
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="verdana_11">
    <td height="26" colspan="3" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><img src="/corporativo/servicos/bbhive/images/anexos-pequeno.gif" width="23" height="23" align="absmiddle" /> <strong><?php echo $_SESSION['arqNome']; ?></strong></td>
  </tr>
  <tr class="verdana_11">
    <td height="10" colspan="3"></td>
  </tr>
  <tr class="verdana_11">
    <td height="21"><a href="#@" onclick="document.getElementById('bbh_situacao').value='Meus arquivos'; document.getElementById('situacao').checked=true;<?php echo $chamadaAJAX; ?>"><img src="/corporativo/servicos/bbhive/images/arquivos16px.gif" title="Ver meus próprios arquivos" alt="Ver meus pr&oacute;prios arquivos" width="16" height="16" border="0" align="absmiddle" />&nbsp;Meus arquivos</a></td>
    <td><a href="#@" onclick="document.getElementById('bbh_situacao').value='Arquivos da equipe'; document.getElementById('situacao').checked=true;<?php echo $chamadaAJAX; ?>"><img src="/corporativo/servicos/bbhive/images/arquivosequipe.gif" title="Ver todos os arquivos da equipe" alt="Ver todos os arquivos da equipe" width="16" height="16" border="0" align="absmiddle" /> Arquivos da equipe</a></td>
    <td><?php /*<a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;arquivos=1|arquivos/busca.php|includes/colunaDireita.php?fluxosDireita=1&amp;arquivos=1&amp;equipeArquivos=1','menuEsquerda|colCentro|colDireita');"><img src="/corporativo/servicos/bbhive/images/busca.gif" title="Busque um arquivo por filtros" alt="Busque um arquivo por filtros" width="16" height="16" border="0" align="absmiddle" /> Procurar arquivos</a>*/ ?></td>
  </tr>
  </table>
<br />