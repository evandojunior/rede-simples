<?php
$query_contador_msg = "SELECT bbh_usu_codigo_destin FROM bbh_mensagens WHERE bbh_usu_codigo_destin = ".$_SESSION['usuCod']." AND bbh_mensagens.bbh_men_exclusao_destinatario = '0' AND (bbh_men_data_leitura = '0000-00-00 00:00:00' OR bbh_men_data_leitura IS NULL)";
list($contador_msg, $row_contador_msg, $totalRows_contador_msg) = executeQuery($bbhive, $database_bbhive, $query_contador_msg);
?><table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr class="verdana_11">
    <td height="26" colspan="2" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><img src="/corporativo/servicos/bbhive/images/mensagens-pequeno.gif" width="23" height="23" align="absmiddle" /><strong> Mensagens</strong></td>
  </tr>
  <tr class="verdana_11">
    <td height="10" colspan="2">&nbsp;</td>
  </tr>
  <tr class="verdana_11">
    <td width="39%" height="21"><a href="#" onClick="showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&equipe=1|equipe/index.php?chefe=0&subordinados=0&tomadores=0&prestadores=0&todosEmpresa=1|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&exibeMensagem=true&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');"><span class="verdana_9"><img src="/corporativo/servicos/bbhive/images/escrever-email.gif" width="16" height="16" border="0" align="absmiddle" /> Escrever</span></a></td>
    <td width="61%"><a href="#" onclick="return LoadSimultaneo('perfil/index.php?perfil=1&mensagens=1|mensagens/index.php?caixaSaida=True|includes/colunaDireita.php?fluxosDireita=1&equipeMensagens=1&eventos=1','menuEsquerda|colCentro|colDireita');"><img src="/corporativo/servicos/bbhive/images/caixasaida.gif" width="16" height="16" border="0" align="absmiddle" /> <span class="verdana_9">Sa&iacute;da</span></a></td>
  </tr>
  <tr class="verdana_11">
    <td height="21"><a href="#" onClick="return LoadSimultaneo('perfil/index.php?perfil=1&mensagens=1|mensagens/index.php?caixaEntrada=True|includes/colunaDireita.php?fluxosDireita=1&equipeMensagens=1&eventos=1','menuEsquerda|colCentro|colDireita');"><img src="/corporativo/servicos/bbhive/images/caixaentrada.gif" width="16" height="16" border="0" align="absmiddle" /> <span class="verdana_9"><?php if($totalRows_contador_msg!=0){ echo "<strong>"; }?> Entrada <?php if($totalRows_contador_msg!=0){ ?><strong>(<?php echo $totalRows_contador_msg;?>)</strong><?php } ?></span></a></td>
    <td height="21"><a href="#" onclick="return LoadSimultaneo('perfil/index.php?perfil=1&mensagens=1|mensagens/index.php?caixaLixeira=True|includes/colunaDireita.php?fluxosDireita=1&equipeMensagens=1&eventos=1','menuEsquerda|colCentro|colDireita');"><img src="/corporativo/servicos/bbhive/images/lixeira16px.gif" alt="" width="16" height="16" border="0" align="absmiddle" /> <span class="verdana_9">Lixeira</span></a></td>
  </tr>
</table>
<br />
<?php
mysqli_free_result($contador_msg);
?>
