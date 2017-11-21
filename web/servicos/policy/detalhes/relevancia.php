<?php 	require_once("../includes/autentica.php"); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
$colname_relevancia = "-1";
if (isset($_GET['pol_apl_codigo'])) {
  $colname_relevancia = $_GET['pol_apl_codigo'];
}
mysql_select_db($database_policy, $policy);
$query_relevancia = "SELECT date_format(MAX(pol_aud_momento),'%d/%m/%Y %H:%i:%s') AS momento, pol_aud_relevancia, COUNT(pol_aud_codigo) AS acessos, pol_apl_nome FROM pol_auditoria RIGHT JOIN pol_aplicacao ON pol_auditoria.pol_apl_codigo = pol_aplicacao.pol_apl_codigo WHERE pol_aplicacao.pol_apl_codigo = $colname_relevancia GROUP BY pol_aud_relevancia ORDER BY pol_aud_relevancia DESC";
$relevancia = mysql_query($query_relevancia, $policy) or die(mysql_error());
$row_relevancia = mysql_fetch_assoc($relevancia);
$totalRows_relevancia = mysql_num_rows($relevancia);
?>
<table width="97%" border="0" align="center" cellpadding="6" cellspacing="0">
<tr class="verdana_11_bold">
                <td width="26%" height="0" align="left" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">Relev&acirc;ncia</td>
    <td width="32%" height="0" align="center" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">N&ordm; de acessos</td>
    <td width="26%" height="0" align="center" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">&Uacute;ltimo acesso</td>
  </tr>
  <?php if ($totalRows_relevancia > 0) { // Show if recordset not empty ?>
<?php 
			  do { ?>
                <tr <?php if($row_relevancia['pol_aud_relevancia']!=NULL){ ?> id="linha_<?php echo $row_relevancia['pol_aud_relevancia']; ?>" class="verdana_11" onmouseover="return Popula('linha_<?php echo $row_relevancia['pol_aud_relevancia']; ?>')" onclick="location.href='regra.php?pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>&detalhes=true&relevanciadet=<?php echo $row_relevancia['pol_aud_relevancia']; ?>'" onmouseout="return Desativa('linha_<?php echo $row_relevancia['pol_aud_relevancia']; ?>')" title="header=[<span class='verdana_11'>Informa&ccedil;&otilde;es adicionais</span>] body=[<span class='verdana_11'><?php echo "Clique e veja detalhes das a&ccedil;&otilde;es por relev&acirc;ncia."; ?></span>]"<?php } ?>>
			<?php if($row_relevancia['pol_aud_relevancia']==NULL){ ?>
			<td align="left" style="border-bottom:dotted 1px #333333;"><img src="../images/apontador.gif" width="4" height="6" align="absmiddle" />&nbsp;Essa aplica&ccedil;&atilde;o nunca foi acessada.</td>
            <?php }else{ ?>
			<td align="left" style="border-bottom:dotted 1px #333333;"><img border="0" align="absmiddle" src="../images/relevancia_menor2.gif" />&nbsp;&nbsp;N&iacute;vel de relev&acirc;ncia <strong><?php echo $row_relevancia['pol_aud_relevancia']; ?></strong></td>
			<?php } ?>
                  <td align="center" style="border-bottom:dotted 1px #333333;"><?php if($row_relevancia['acessos']==0){echo "---";}else{echo $row_relevancia['acessos']; }?></td>
                  <td width="16%" align="center" style="border-bottom:dotted 1px #333333;"><?php if($row_relevancia['momento']==0){echo "---";}else{echo $row_relevancia['momento']; }?></td>
      </tr>
      <?php } while ($row_relevancia = mysql_fetch_assoc($relevancia)); ?>
  <?php } // Show if recordset not empty ?>
                <tr class="verdana_11">
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
</table>
<?php
mysql_free_result($relevancia);
?>