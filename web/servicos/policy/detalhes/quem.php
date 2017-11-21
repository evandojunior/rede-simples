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

$currentPage = $_SERVER["PHP_SELF"];
$maxRows_quem = 50;
$pageNum_quem = 0;
if (isset($_GET['pageNum_quem'])) {
  $pageNum_quem = $_GET['pageNum_quem'];
}
$startRow_quem = $pageNum_quem * $maxRows_quem;

$colname_quem = "-1";
if (isset($_GET['pol_apl_codigo'])) {
  $colname_quem = $_GET['pol_apl_codigo'];
}
mysql_select_db($database_policy, $policy);
$query_quem = "
SELECT date_format(MAX(pol_aud_momento),'%d/%m/%Y %H:%i:%s') AS momento, pol_aud_usuario, COUNT(pol_aud_codigo) AS acessos, pol_apl_nome 
FROM pol_auditoria 
RIGHT JOIN pol_aplicacao ON pol_auditoria.pol_apl_codigo = pol_aplicacao.pol_apl_codigo 
	WHERE pol_aplicacao.pol_apl_codigo = $colname_quem 
	GROUP BY pol_aud_usuario 
	ORDER BY acessos DESC";
$query_limit_quem = sprintf("%s LIMIT %d, %d", $query_quem, $startRow_quem, $maxRows_quem);
$quem = mysql_query($query_limit_quem, $policy) or die(mysql_error());
$row_quem = mysql_fetch_assoc($quem);

if (isset($_GET['totalRows_quem'])) {
  $totalRows_quem = $_GET['totalRows_quem'];
} else {
  $all_quem = mysql_query($query_quem);
  $totalRows_quem = mysql_num_rows($all_quem);
}
$totalPages_quem = ceil($totalRows_quem/$maxRows_quem)-1;

$queryString_quem = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_quem") == false && 
        stristr($param, "totalRows_quem") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_quem = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_quem = sprintf("&totalRows_quem=%d%s", $totalRows_quem, $queryString_quem);
?>
<div class="verdana_11">
Exibindo <?php echo ($startRow_quem + 1) ?> at&eacute; <?php echo min($startRow_quem + $maxRows_quem, $totalRows_quem) ?> de  <?php echo $totalRows_quem ?> registros
</div>
<table width="97%" border="0" align="center" cellpadding="6" cellspacing="0">
<tr class="verdana_11_bold">
                <td width="55%" height="0" align="left" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">Usu&aacute;rio</td>
    <td width="20%" height="0" align="center" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">N&ordm; de acessos</td>
    <td width="24%" height="0" align="center" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">&Uacute;ltimo acesso</td>
    <td width="1%" height="0" align="center" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">&nbsp;</td>
  </tr>
  <?php if ($totalRows_quem > 0) { // Show if recordset not empty ?>
<?php 
			  do { ?>
                <tr>
			<td align="left" style="border-bottom:dotted 1px #333333;" id="linha_<?php echo $row_quem['pol_aud_usuario']; ?>" class="verdana_11" onmouseover="return Popula('linha_<?php echo $row_quem['pol_aud_usuario']; ?>')" onclick="location.href='regra.php?pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>&detalhes=true&quemdet=<?php echo $row_quem['pol_aud_usuario']; ?>'" onmouseout="return Desativa('linha_<?php echo $row_quem['pol_aud_usuario']; ?>')" title="header=[<span class='verdana_11'>Informa&ccedil;&otilde;es adicionais</span>] body=[<span class='verdana_11'><?php echo "Clique e veja detalhes sobre este usu&aacute;rio."; ?></span>]"><img border="0" align="absmiddle" src="../images/quem_menor.gif" />&nbsp;&nbsp;<?php echo $row_quem['pol_aud_usuario']; ?></td>
                  <td align="center" style="border-bottom:dotted 1px #333333;"><?php if($row_quem['acessos']==0){echo "---";}else{echo $row_quem['acessos']; }?></td>
                  <td align="center" style="border-bottom:dotted 1px #333333;"><?php if($row_quem['momento']==0){echo "---";}else{echo $row_quem['momento']; }?></td>
                  <td align="center" style="border-bottom:dotted 1px #333333;"><a href="controlar.php?<?php echo $_SERVER['QUERY_STRING']; ?>&quemdet=<?php echo $row_quem['pol_aud_usuario']; ?>"><img border="0" align="absmiddle" src="../images/grafico.png" title="Controlar" /></a></td>
                </tr>
              <?php } while ($row_quem = mysql_fetch_assoc($quem)); ?>
<?php } // Show if recordset not empty ?>
                <tr class="verdana_11">
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td colspan="2" align="center">&nbsp;</td>
                </tr>
</table>

<br/>
<table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="verdana_11_bold">
    <td width="80" height="20" align="center" valign="middle" ><?php if ($pageNum_quem > 0) { // Show if first page ?>
      <a href="<?php printf("%s?pageNum_acao=%d%s", $currentPage, 0, $queryString_acao); ?>"><img src="/e-solution/servicos/policy/images/FIRST.GIF" alt="Primeira" border="0" align="absmiddle" /></a>        <a href="<?php printf("%s?pageNum_quem=%d%s", $currentPage, 0, $queryString_quem); ?>">Primeira</a>
        <?php } // Show if not first page ?></td>
    <td width="80" align="center" valign="middle"><?php if ($pageNum_quem > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_acao=%d%s", $currentPage, max(0, $pageNum_acao - 1), $queryString_acao); ?>"><img src="/e-solution/servicos/policy/images/PREVIOUS.GIF" alt="Anterior" border="0" align="absmiddle" /></a><a href="<?php printf("%s?pageNum_quem=%d%s", $currentPage, max(0, $pageNum_quem - 1), $queryString_quem); ?>">&nbsp;Anterior</a>
          <?php } // Show if not first page ?></td>
    <td width="80" align="center" valign="middle"><?php if ($pageNum_quem < $totalPages_quem) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_quem=%d%s", $currentPage, min($totalPages_quem, $pageNum_quem + 1), $queryString_quem); ?>">Pr&oacute;xima&nbsp;<img src="/e-solution/servicos/policy/images/NEXT.GIF" alt="Pr&oacute;xima" border="0" align="absmiddle" /></a>
        <?php } // Show if not last page ?>
    <a href="<?php printf("%s?pageNum_acao=%d%s", $currentPage, min($totalPages_acao, $pageNum_acao + 1), $queryString_acao); ?>"></a></td>
    <td align="center" valign="middle"><?php if ($pageNum_quem < $totalPages_quem) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_quem=%d%s", $currentPage, $totalPages_quem, $queryString_quem); ?>">&Uacute;ltima&nbsp;<img src="/e-solution/servicos/policy/images/Last.gif" alt="&Uacute;ltima" border="0" align="absmiddle" /></a>
        <?php } // Show if not last page ?>
    <a href="<?php printf("%s?pageNum_acao=%d%s", $currentPage, $totalPages_acao, $queryString_acao); ?>"></a></td>
  </tr>
  
</table>

<?php
mysql_free_result($quem);
?>