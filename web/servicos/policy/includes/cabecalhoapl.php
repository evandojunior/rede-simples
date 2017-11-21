<?php 
//Faz a conexão com o banco de dados.
require_once('../../../../Connections/policy.php');

//Recordset que pega as informações exibidas na tabela.
$colname_aplicacoes = "-1";
if (isset($_GET['pol_apl_codigo'])) {
  $colname_aplicacoes = $_GET['pol_apl_codigo'];
}
mysql_select_db($database_policy, $policy);
$query_aplicacoes = "
SELECT pol_apl_codigo, pol_apl_nome, pol_apl_descricao, pol_apl_relevancia, pol_apl_url, pol_apl_icone FROM pol_aplicacao 
WHERE pol_aplicacao.pol_apl_codigo = $colname_aplicacoes 
ORDER BY pol_apl_nome ASC
";
$aplicacoes = mysql_query($query_aplicacoes, $policy) or die(mysql_error());
$row_aplicacoes = mysql_fetch_assoc($aplicacoes);
$totalRows_aplicacoes = mysql_num_rows($aplicacoes);

 
$openAjax = "";
$cd = $row_aplicacoes['pol_apl_codigo']; 
 //--AJAX
			 $openAjax.= 'OpenAjaxPostCmd("../aplicacoes/dados.php","ip_'.$cd.'","?pol_apl_codigo='.$cd.'","Aguarde carregando...","ip_'.$cd.'",2,2);';
			 //--
			 
			 
 ?>
 
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr class="verdana_12" style="background-image:url(/e-solution/servicos/policy/images/barra_horizontal.jpg)">
   	  <td height="24" colspan="3" class="verdana_12"><strong>&nbsp;&nbsp;&nbsp;<?php echo $row_aplicacoes['pol_apl_nome']; ?></strong>
      
      <div class="verdana_11_bold" style="float:right; margin-top:-15px; margin-right:25px;"><a href='javascript:history.go(-1);'>.: Voltar :.</a></div>      </td>
  </tr>
    <tr bgcolor="#FFFFFF">
   	  <td height="4" colspan="3"></td>
	</tr>
    <tr bgcolor="#FFFFFF">
   	  <td colspan="3"><strong><?php echo $row_aplicacoes['pol_apl_descricao']; ?></strong></td>
	</tr>
    <tr bgcolor="#FFFFFF">
   	  <td colspan="3">&nbsp;</td>
	</tr>
    <tr class="verdana_11_cinza" bgcolor="#FFFFFF">
      <td width="14%" rowspan="3"><img src="/datafiles/servicos/policy/aplicacoes/<?php echo $row_aplicacoes['pol_apl_icone']; ?>" width="130" height="70" /></td>
      
      
   	  <td width="19%"><strong><img src="/e-solution/servicos/policy/images/ip.gif" alt=" " width="16" height="16" align="absmiddle" /> IP da aplica&ccedil;&atilde;o</strong></td>
	  <td width="67%">:&nbsp;&nbsp;<span id="ip_<?php echo $row_aplicacoes['pol_apl_codigo']; ?>">Aguarde, carregando informações...</span></td>
  </tr>
    <tr class="verdana_11_cinza" bgcolor="#FFFFFF">
      <td><strong><img src="/e-solution/servicos/policy/images/numeroacessos.gif" alt="" width="16" height="16" align="absmiddle" /> N&ordm; de acessos</strong></td>
	  <td>:&nbsp;&nbsp;<span id="acessos_<?php echo $row_aplicacoes['pol_apl_codigo']; ?>">Aguarde, carregando informações..</span></td>
  </tr>
    <tr class="verdana_11_cinza" bgcolor="#FFFFFF">
      <td><strong><img src="../images/ultimoacesso.gif" alt="" width="16" height="16" align="absmiddle" /> &Uacute;ltimo acesso</strong></td>
	  <td>:&nbsp;&nbsp;<span id="ultimo_<?php echo $row_aplicacoes['pol_apl_codigo']; ?>">Aguarde, carregando informações...</span></td>
  </tr>
    <tr>
      <td valign="top" class="verdana_11_cinza">&nbsp;</td>
      <td height="18" class="verdana_11_cinza"><img src="/e-solution/servicos/policy/images/url.gif" alt="" border="0" align="absmiddle" /> <strong>URL da aplica&ccedil;&atilde;o</strong></td>
      <td class="verdana_11_cinza">:&nbsp;&nbsp;<a href="<?php echo $row_aplicacoes['pol_apl_url']; ?>" target="_blank"><?php echo $row_aplicacoes['pol_apl_url']; ?></a></td>
  </tr>
  <tr>
      <td valign="top" class="verdana_11_cinza">&nbsp;</td>
      <td height="18" class="verdana_11_cinza"><img src="/e-solution/servicos/policy/images/relevancia_menor2.gif" alt="" border="0" align="absmiddle" /> <strong>Relev&acirc;ncia</strong></td>
      <td class="verdana_11_cinza">:&nbsp;&nbsp;<?php 
	  if ( $row_aplicacoes['pol_apl_relevancia'] == -1 ) { echo 'N&atilde;o determinada'; } else { echo $row_aplicacoes['pol_apl_relevancia']; } ?></td>
  </tr>
    <tr bgcolor="#FFFFFF">
   	  <td colspan="3">&nbsp;</td>
	</tr>
</table>
<script type="text/javascript">
	function coletaDados(){
		<?php echo $openAjax; ?>	
	}
</script>