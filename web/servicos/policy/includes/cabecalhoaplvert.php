<?php 
//Faz a conexão com o banco de dados.
if ($_SERVER['PHP_SELF'] != '/e-solution/servicos/policy/grafico/pizza/passo2.php' && $_SERVER['PHP_SELF'] != '/e-solution/servicos/policy/grafico/pizza/passo3.php' ) {
require_once('../../../../Connections/policy.php');
}
//Recordset que pega as informações exibidas na tabela.
$colname_aplicacoes = "-1";
if (isset($_GET['pol_apl_codigo'])) {
  $colname_aplicacoes = $_GET['pol_apl_codigo'];
}
mysql_select_db($database_policy, $policy);
$query_aplicacoes = "SELECT pol_apl_nome, pol_apl_url, pol_apl_descricao, pol_apl_icone, pol_apl_codigo FROM pol_aplicacao WHERE pol_aplicacao.pol_apl_codigo = $colname_aplicacoes";
$aplicacoes = mysql_query($query_aplicacoes, $policy) or die(mysql_error());
$row_aplicacoes = mysql_fetch_assoc($aplicacoes);
$totalRows_aplicacoes = mysql_num_rows($aplicacoes);
?>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="25" align="left" background="../images/barra_horizontal.jpg" class="verdana_12"><strong><?php echo $row_aplicacoes['pol_apl_nome']; ?></strong></td>
  </tr>
  <tr>
    <td height="75" align="center"><a href="/e-solution/servicos/policy/detalhes/index.php?pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>"><img src="/datafiles/servicos/policy/aplicacoes/<?php echo $row_aplicacoes['pol_apl_icone'];?>" width="130" height="70" border="0" /></a></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="0" class="verdana_11_cinza"><strong>&nbsp;IP da aplica&ccedil;&atilde;o</strong><br /></td>
  </tr>
  <tr>
    <td height="0" class="verdana_11_cinza">&nbsp;<img src="/e-solution/servicos/policy/images/ip.gif" alt=" " width="16" height="16" align="absmiddle" />&nbsp;<span id="ip_<?php echo $row_aplicacoes['pol_apl_codigo']; ?>">Aguarde, carregando informações...</span></td>
  </tr>
  <tr>
    <td height="5">&nbsp;</td>
  </tr>
  <tr>
    <td class="verdana_11_cinza">&nbsp;<strong>N&ordm; de acessos</strong></td>
  </tr>
  <tr>
    <td height="15" class="verdana_11_cinza">&nbsp;<img src="/e-solution/servicos/policy/images/numeroacessos.gif" width="16" height="16" align="absmiddle" />&nbsp;<span id="acessos_<?php echo $row_aplicacoes['pol_apl_codigo']; ?>">Aguarde, carregando informações..</span></td>
  </tr>
  <tr>
    <td height="5">&nbsp;</td>
  </tr>
  <tr>
    <td height="15" class="verdana_11_cinza"><strong>&nbsp;&Uacute;ltimo acesso</strong></td>
  </tr>
  <tr>
    <td height="0" class="verdana_11_cinza">&nbsp;<img src="/e-solution/servicos/policy/images/ultimoacesso.gif" width="16" height="16" align="absmiddle" />&nbsp;<span id="ultimo_<?php echo $row_aplicacoes['pol_apl_codigo']; ?>">Aguarde, carregando informações...</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="verdana_11_cinza">&nbsp;<img src="/e-solution/servicos/policy/images/url.gif" alt="" border="0" align="absmiddle" /></span>&nbsp;<a href="<?php echo $row_aplicacoes['pol_apl_url']; ?>" target="_blank">URL da aplica&ccedil;&atilde;o</a></td>
  </tr>
</table>
