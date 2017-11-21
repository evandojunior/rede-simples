<?php 	require_once("../includes/autentica.php"); ?>
<?php

$currentPage = $_SERVER["PHP_SELF"];
$maxRows_acao = 50;
$pageNum_acao = 0;
if (isset($_GET['pageNum_acao'])) {
  $pageNum_acao = $_GET['pageNum_acao'];
}
$startRow_acao = $pageNum_acao * $maxRows_acao;

$colname_acao = "-1";
if (isset($_GET['pol_apl_codigo'])) {
  $colname_acao = $_GET['pol_apl_codigo'];
}
mysqli_select_db($policy, $database_policy);
$query_acao = "SELECT date_format(MAX(pol_aud_momento),'%d/%m/%Y %H:%i:%s') AS momento, pol_aud_acao, COUNT(pol_aud_codigo) AS acessos, pol_apl_nome, max(pol_aud_codigo) as codigo FROM pol_auditoria RIGHT JOIN pol_aplicacao ON pol_auditoria.pol_apl_codigo = pol_aplicacao.pol_apl_codigo WHERE pol_aplicacao.pol_apl_codigo = $colname_acao GROUP BY pol_aud_acao ORDER BY acessos DESC";
$query_limit_acao = sprintf("%s LIMIT %d, %d", $query_acao, $startRow_acao, $maxRows_acao);
$acao = mysqli_query($policy, $query_limit_acao) or die(mysql_error());
$row_acao = mysqli_fetch_assoc($acao);

if (isset($_GET['totalRows_acao'])) {
  $totalRows_acao = $_GET['totalRows_acao'];
} else {
  $all_acao = mysqli_query($policy, $query_acao);
  $totalRows_acao = mysqli_num_rows($all_acao);
}
$totalPages_acao = ceil($totalRows_acao/$maxRows_acao)-1;

$queryString_acao = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_acao") == false && 
        stristr($param, "totalRows_acao") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_acao = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_acao = sprintf("&totalRows_acao=%d%s", $totalRows_acao, $queryString_acao);

function verificaApontamento($database_policy, $policy, $idApl, $acao){
	$sqlApont = "select ap.apo_codigo from pol_apontamento as ap where ap.pol_apl_codigo = $idApl and ap.pol_aud_acao = '".mysqli_real_escape_string($acao)."'";
	mysqli_select_db($policy, $database_policy);
	$Apont 			 = mysqli_query($policy, $sqlApont) or die(mysql_error());
	return mysqli_num_rows($Apont);
}
?>
<div class="verdana_11">
Exibindo <?php echo ($startRow_acao + 1) ?> at&eacute; <?php echo min($startRow_acao + $maxRows_acao, $totalRows_acao) ?> de  <?php echo $totalRows_acao ?> registros
</div>
<table width="97%" border="0" align="center" cellpadding="6" cellspacing="0">
<tr class="verdana_11_bold">
                <td width="54%" height="0" align="left" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">Mensagem</td>
    <td width="19%" height="0" align="center" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">N&ordm; de acessos</td>
    <td width="21%" height="0" align="center" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">&Uacute;ltimo acesso</td>
    <td width="3%" align="center" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">&nbsp;</td>
    <td width="3%" align="center" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">&nbsp;</td>
  </tr>
  <?php if ($totalRows_acao > 0) { // Show if recordset not empty ?>
<?php 
			  do { ?>
                <tr id="linha_<?php echo $row_acao['pol_aud_acao']; ?>" class="verdana_11">
			<td align="left" style="border-bottom:dotted 1px #333333; cursor:pointer" onclick="location.href='regra.php?pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>&detalhes=true&acao=<?php echo $row_acao['pol_aud_acao']; ?>'" onmouseout="return Desativa('linha_<?php echo $row_acao['pol_aud_acao']; ?>')" title="header=[<span class='verdana_11'>Informa&ccedil;&otilde;es adicionais</span>] body=[<span class='verdana_11'><?php echo "Clique e veja detalhes da a&ccedil;&atilde;o"; ?></span>]"><img border="0" align="absmiddle" src="../images/oque_menor.gif" />&nbsp;&nbsp;<?php echo $a=$row_acao['pol_aud_acao']; ?></td>
			<td align="center" style="border-bottom:dotted 1px #333333;"><?php if($row_acao['acessos']==0){echo "---";}else{echo $row_acao['acessos']; }?></td>
                  <td width="21%" align="center" style="border-bottom:dotted 1px #333333;"><?php if($row_acao['momento']==0){echo "---";}else{echo $row_acao['momento']; }?></td>
                  <td width="3%" align="center" style="border-bottom:dotted 1px #333333;">&nbsp;</td>
                  <td width="3%" align="center" style="border-bottom:dotted 1px #333333;"><a href="medir.php?codigo=<?php echo $row_acao['codigo'];?>&<?php echo $_SERVER['QUERY_STRING']; ?>"><img border="0" align="absmiddle" src="../images/regua<?php echo verificaApontamento($database_policy, $policy, $_GET['pol_apl_codigo'], $a)>0?"":"_off";?>.png" title="Medir" /></a></td>
              </tr>
              <?php } while ($row_acao = mysqli_fetch_assoc($acao)); ?>
<?php } // Show if recordset not empty ?>
                <tr class="verdana_11">
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td colspan="3" align="center">&nbsp;</td>
                </tr>
</table>


<table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="verdana_11_bold">
    <td width="80" height="20" align="center" valign="middle" ><?php if ($pageNum_acao > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_acao=%d%s", $currentPage, 0, $queryString_acao); ?>"> <img src="/e-solution/servicos/policy/images/FIRST.GIF" border=0 align="absmiddle"> Primeira </a>
        <?php } // Show if not first page ?></td>
    <td width="80" align="center" valign="middle"><?php if ($pageNum_acao > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_acao=%d%s", $currentPage, max(0, $pageNum_acao - 1), $queryString_acao); ?>"> <img src="/e-solution/servicos/policy/images/PREVIOUS.GIF" border=0 align="absmiddle"> Anterior </a>
        <?php } // Show if not first page ?></td>
    <td width="80" align="center" valign="middle"><?php if ($pageNum_acao < $totalPages_acao) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_acao=%d%s", $currentPage, min($totalPages_acao, $pageNum_acao + 1), $queryString_acao); ?>">  Pr&oacute;xima <img src="/e-solution/servicos/policy/images/NEXT.GIF" border=0 align="absmiddle"></a>
        <?php } // Show if not last page ?></td>
    <td align="center" valign="middle"><?php if ($pageNum_acao < $totalPages_acao) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_acao=%d%s", $currentPage, $totalPages_acao, $queryString_acao); ?>">   &Uacute;ltima <img src="/e-solution/servicos/policy/images/Last.gif" border=0 align="absmiddle"></a>
        <?php } // Show if not last page ?></td>
  </tr>
  
</table>
<br/>
<?php
mysqli_free_result($acao);
?>