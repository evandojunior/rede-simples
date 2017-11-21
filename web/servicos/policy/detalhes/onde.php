<?php require_once("../includes/autentica.php"); ?>
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
$maxRows_ip = 50;
$pageNum_ip = 0;
if (isset($_GET['pageNum_ip'])) {
  $pageNum_ip = $_GET['pageNum_ip'];
}
$startRow_ip = $pageNum_ip * $maxRows_ip;

$colname_ip = "-1";
if (isset($_GET['pol_apl_codigo'])) {
  $colname_ip = $_GET['pol_apl_codigo'];
}
mysql_select_db($database_policy, $policy);
$query_ip = "SELECT date_format(MAX(pol_aud_momento),'%%d/%%m/%%Y %%H:%%i:%s') AS momento, pol_aud_ip, COUNT(pol_aud_codigo) AS acessos, pol_apl_nome FROM pol_auditoria RIGHT JOIN pol_aplicacao ON pol_auditoria.pol_apl_codigo = pol_aplicacao.pol_apl_codigo WHERE pol_aplicacao.pol_apl_codigo = $colname_ip GROUP BY pol_aud_ip ORDER BY acessos DESC";
$query_limit_ip = sprintf("%s LIMIT %d, %d", $query_ip, $startRow_ip, $maxRows_ip);
$ip = mysql_query($query_limit_ip, $policy) or die(mysql_error());
$row_ip = mysql_fetch_assoc($ip);

if (isset($_GET['totalRows_ip'])) {
  $totalRows_ip = $_GET['totalRows_ip'];
} else {
  $all_ip = mysql_query($query_ip);
  $totalRows_ip = mysql_num_rows($all_ip);
}
$totalPages_ip = ceil($totalRows_ip/$maxRows_ip)-1;

$queryString_ip = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ip") == false && 
        stristr($param, "totalRows_ip") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ip = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ip = sprintf("&totalRows_ip=%d%s", $totalRows_ip, $queryString_ip);
?>
<div class="verdana_11">
Exibindo <?php echo ($startRow_ip + 1) ?> at&eacute; <?php echo min($startRow_ip + $maxRows_ip, $totalRows_ip) ?> de  <?php echo $totalRows_ip ?> registros
</div>
<table width="97%" border="0" align="center" cellpadding="6" cellspacing="0">
<tr class="verdana_11_bold">
                <td width="28%" height="0" align="left" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">IP de acesso</td>
    <td width="30%" height="0" align="center" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">N&ordm; de acessos</td>
    <td width="26%" height="0" align="center" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">&Uacute;ltimo acesso</td>
  </tr>
  <?php if ($totalRows_ip > 0) { // Show if recordset not empty ?>
<?php 
			  do { ?>
                <tr <?php if($row_ip['pol_aud_ip']!=NULL){ ?> id="linha_<?php echo $row_ip['pol_aud_ip']; ?>" class="verdana_11" onmouseover="return Popula('linha_<?php echo $row_ip['pol_aud_ip']; ?>')" onclick="location.href='regra.php?pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>&detalhes=true&ip=<?php echo $row_ip['pol_aud_ip']; ?>'" onmouseout="return Desativa('linha_<?php echo $row_ip['pol_aud_ip']; ?>')" title="header=[<span class='verdana_11'>Informa&ccedil;&otilde;es adicionais</span>] body=[<span class='verdana_11'><?php echo "Clique e veja detalhes dos acessos que vieram deste IP."; ?></span>]"<?php } ?>>
			<?php if($row_ip['pol_aud_ip']==NULL){ ?>
			<td align="left" style="border-bottom:dotted 1px #333333;"><img src="../images/apontador.gif" width="4" height="6" align="absmiddle" />&nbsp;Essa aplica&ccedil;&atilde;o nunca foi acessada.</td>
            <?php }else{ ?>
			<td align="left" style="border-bottom:dotted 1px #333333;"><img border="0" align="absmiddle" src="../images/onde_menor.gif" />&nbsp;&nbsp;<?php echo $row_ip['pol_aud_ip']; ?></td>
			<?php } ?>
                  <td align="center" style="border-bottom:dotted 1px #333333;"><?php if($row_ip['acessos']==0){echo "---";}else{echo $row_ip['acessos']; }?></td>
                  <td width="16%" align="center" style="border-bottom:dotted 1px #333333;"><?php if($row_ip['momento']==0){echo "---";}else{echo $row_ip['momento']; }?></td>
      </tr>
      <?php } while ($row_ip = mysql_fetch_assoc($ip)); ?>
                <?php } // Show if recordset not empty ?>
                <tr class="verdana_11">
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
</table>
<table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="verdana_11_bold">
    <td width="80" height="20" align="center" valign="middle" ><?php if ($pageNum_ip > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ip=%d%s", $currentPage, 0, $queryString_ip); ?>"><img src="/e-solution/servicos/policy/images/FIRST.GIF" alt="Primeira" border="0" align="absmiddle" />&nbsp;Primeira</a>
        <?php } // Show if not first page ?></td>
    <td width="80" align="center" valign="middle"><?php if ($pageNum_ip > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ip=%d%s", $currentPage, max(0, $pageNum_ip - 1), $queryString_ip); ?>"><img src="/e-solution/servicos/policy/images/PREVIOUS.GIF" alt="Anterior" border="0" align="absmiddle" />&nbsp;Anterior</a>
        <?php } // Show if not first page ?></td>
    <td width="80" align="center" valign="middle"><?php if ($pageNum_ip < $totalPages_ip) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ip=%d%s", $currentPage, min($totalPages_ip, $pageNum_ip + 1), $queryString_ip); ?>">Pr&oacute;xima&nbsp;<img src="/e-solution/servicos/policy/images/NEXT.GIF" alt="Pr&oacute;xima" border="0" align="absmiddle" /></a>
        <?php } // Show if not last page ?></td>
    <td align="center" valign="middle"><?php if ($pageNum_ip < $totalPages_ip) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ip=%d%s", $currentPage, $totalPages_ip, $queryString_ip); ?>">&Uacute;ltima&nbsp;<img src="/e-solution/servicos/policy/images/Last.gif" alt="&Uacute;ltima" border="0" align="absmiddle" /></a>
        <?php } // Show if not last page ?></td>
  </tr>
  
</table>
<?php
mysql_free_result($ip);
?>