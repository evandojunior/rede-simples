<?php //if($Permissao==0){ ?><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="verdana_11">
    <td height="26" colspan="3" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><img src="/corporativo/servicos/bbhive/images/equipe-pequeno.gif" width="23" height="23" align="absmiddle" /><strong> Equipe</strong></td>
  </tr>
  <tr class="verdana_11">
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td height="21"><a href="#@" onclick="return LoadSimultaneo('perfil/index.php?perfil=1&amp;equipe=1|equipe/index.php?chefe=1&amp;subordinados=1&amp;tomadores=1&amp;prestadores=1|includes/colunaDireita.php?fluxosDireita=1&amp;arquivos=1&amp;tarefasDireita=1','menuEsquerda|colCentro|colDireita');"><img src="/corporativo/servicos/bbhive/images/equipe-todos.gif" width="16" height="16" border="0" align="absmiddle" /> <span class="verdana_9">Todos</span></a></td>
    <td><a href="#@" onclick="return LoadSimultaneo('perfil/index.php?perfil=1&equipe=1|equipe/index.php?chefe=1&chefes=1&todosChefes=1&subordinados=0&tomadores=0&prestadores=0|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&tarefasDireita=1','menuEsquerda|colCentro|colDireita');"><span class="verdana_9"><img src="/corporativo/servicos/bbhive/images/equipe-chefia.gif" width="16" height="16" border="0" align="absmiddle" />&nbsp;Chefia</span></a></td>
    <td><a href="#@" onclick="return LoadSimultaneo('perfil/index.php?perfil=1&equipe=1|equipe/index.php?chefe=0&subordinados=1&subTodos=1&tomadores=0&prestadores=0|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&tarefasDireita=1','menuEsquerda|colCentro|colDireita');"><img src="/corporativo/servicos/bbhive/images/equipe-operacional.gif" width="16" height="16" border="0" align="absmiddle" /> <span class="verdana_9">Operacional</span></a></td>
  </tr>
  
  <tr class="verdana_11">
    <td height="21"><a href="#@" onclick="return LoadSimultaneo('perfil/index.php?perfil=1&equipe=1|equipe/index.php?chefe=0&subordinados=0&tomadores=0&prestadores=0&todosEmpresa=1|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&tarefasDireita=1','menuEsquerda|colCentro|colDireita');"><span class="verdana_9"><img src="/corporativo/servicos/bbhive/images/empresa.gif" width="16" height="16" border="0" align="absmiddle" /> &nbsp;Empresa</span></a></td>
    <td height="21"><a href="#@" onclick="return LoadSimultaneo('perfil/index.php?perfil=1&amp;equipe=1|equipe/perfil.php|includes/colunaDireita.php?fluxosDireita=1&amp;arquivos=1&amp;tarefasDireita=1','menuEsquerda|colCentro|colDireita');"><span class="verdana_9"><img src="/corporativo/servicos/bbhive/images/perfil.gif" alt="" width="14" height="14" border="0" align="absmiddle" /> &nbsp;Perfis</span></a></td>
    <td height="21">&nbsp;</td>
  </tr>
  <!--
  <tr class="verdana_11">
    <td height="21"><a href="#@" onClick="return LoadSimultaneo('perfil/index.php?perfil=1&equipe=1|equipe/index.php?chefe=0&subordinados=0&tomadores=0&prestadores=1&subPrestadores=1|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&tarefasDireita=1','menuEsquerda|colCentro|colDireita');"><img src="/corporativo/servicos/bbhive/images/equipe-cliente.gif" width="16" height="16" border="0" align="absmiddle" /> <span class="verdana_9">Prestadores servi&ccedil;os</span></a></td>
  </tr>
  <tr>
    <td height="21"><a href="#@" onClick="return LoadSimultaneo('perfil/index.php?perfil=1&equipe=1|equipe/index.php?chefe=0&subordinados=0&tomadores=1&subTomadores=1&prestadores=0|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&tarefasDireita=1','menuEsquerda|colCentro|colDireita');"><img src="/corporativo/servicos/bbhive/images/equipe-fornecedor.gif" width="16" height="16" border="0" align="absmiddle" /> <span class="verdana_9">Tomadores servi&ccedil;os</span></a></td>
  </tr>
  -->
</table>
<br />
<?php //} ?>