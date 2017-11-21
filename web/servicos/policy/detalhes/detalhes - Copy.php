<?php 	require_once("../includes/autentica.php");
 	  require_once("../includes/functions.php");
//var_dump($_GET);
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
$maxRows_detalhegeral = 100;
$pageNum_detalhegeral = 0;
if (isset($_GET['pageNum_detalhegeral'])) {
  $pageNum_detalhegeral = $_GET['pageNum_detalhegeral'];
}
$startRow_detalhegeral = $pageNum_detalhegeral * $maxRows_detalhegeral;

$colname_codigo = "-1";
if (isset($_GET['pol_apl_codigo'])) {
  $colname_codigo = $_GET['pol_apl_codigo'];
}

//Condições para resultado
if(!isset($_GET['sqlWhere'])){
	
	$CondicaoSQL = "1=1";
	
	if(isset($_GET['quemdet'])){
		$CondicaoSQL = " and pol_aud_usuario='".$_GET['quemdet']."'";
	} elseif(isset($_GET['relevanciadet'])){
		$CondicaoSQL = " and pol_aud_relevancia=".$_GET['relevanciadet'];
	} elseif(isset($_GET['dia'])){
		$CondicaoSQL = " and DATE_FORMAT(pol_aud_momento, '%d%m%Y')=".$_GET['dia'];
	} elseif(isset($_GET['ip'])){
		$CondicaoSQL = " and pol_aud_ip='".$_GET['ip']."'";
	} elseif(isset($_GET['acao'])){
		$CondicaoSQL = " and pol_aud_acao='".$_GET['acao']."'";
	} else { echo "Ocorreu um erro inesperado, entre em contato com o administrador do sistema."; }

$Sql = "SELECT date_format(pol_aud_momento,'%d/%m/%Y %H:%i:%s') AS momento, pol_aud_usuario, pol_aud_acao, pol_aud_ip, pol_aud_nivel, pol_aud_relevancia, pol_aud_codigo, pol_apl_nome FROM pol_auditoria RIGHT JOIN pol_aplicacao ON pol_auditoria.pol_apl_codigo = pol_aplicacao.pol_apl_codigo WHERE pol_aplicacao.pol_apl_codigo = $colname_codigo $CondicaoSQL ORDER BY pol_aud_momento DESC";
} else {
	/*$Ordenacao="ORDER BY momento DESC";
	$Contador = 0;
	$Order= array();
	
		if(isset($_GET['chk_quem'])){
			$Order[$_GET['order_quem']]=" pol_aud_usuario ".$_GET['estr_quem'];
			$Contador = $Contador + 1;
		}
		
		if(isset($_GET['chk_quando'])){
		 $Order[$_GET['order_quando']]=" momento ".$_GET['estr_quando'];
			$Contador = $Contador + 1;
		}
		
		if(isset($_GET['chk_onde'])){
			$Order[$_GET['order_onde']]=" pol_aud_ip ".$_GET['estr_onde'];
			$Contador = $Contador + 1;
		}
		
		if(isset($_GET['chk_oque'])){
			$Order[$_GET['order_oque']]=" pol_aud_acao ".$_GET['estr_oque'];
			$Contador = $Contador + 1;
		}
		if(isset($_GET['chk_relevancia'])){
			$Order[$_GET['order_relevancia']]=" pol_aud_relevancia ".$_GET['estr_relevancia'];
			$Contador = $Contador + 1;
		}

	if($Contador>0){
		ksort($Order);
		$Ordenacao = "ORDER BY" . implode(",", $Order);
	}

	foreach($_GET as $indice=>$valor){
		echo $indice."=".$valor."&";
	}
	$Condicoes = $_GET['sqlWhere'];


$Sql = "SELECT date_format(pol_aud_momento,'%d/%m/%Y %H:%i:%s') AS momento, pol_aud_usuario, pol_aud_acao, pol_aud_ip, pol_aud_nivel, pol_aud_relevancia, pol_aud_codigo, pol_apl_nome FROM pol_auditoria RIGHT JOIN pol_aplicacao ON pol_auditoria.pol_apl_codigo = pol_aplicacao.pol_apl_codigo WHERE pol_aplicacao.pol_apl_codigo = $colname_codigo $Condicoes $Ordenacao";*/
	echo "SELECT DA JULIA E DO WILLIAN";
	exit;
}
	mysql_select_db($database_policy, $policy);
	$query_detalhegeral = $Sql;
	$query_limit_detalhegeral = sprintf("%s LIMIT %d, %d", $query_detalhegeral, $startRow_detalhegeral, $maxRows_detalhegeral);
$detalhegeral = mysql_query($query_limit_detalhegeral, $policy) or die(mysql_error());
	
	$row_detalhegeral = mysql_fetch_assoc($detalhegeral);
	
if (isset($_GET['totalRows_detalhegeral'])) {
  $totalRows_detalhegeral = $_GET['totalRows_detalhegeral'];
} else {
  $all_detalhegeral = mysql_query($query_detalhegeral);
  $totalRows_detalhegeral = mysql_num_rows($all_detalhegeral);
}
$totalPages_detalhegeral = ceil($totalRows_detalhegeral/$maxRows_detalhegeral)-1;

$queryString_detalhegeral = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_detalhegeral") == false && 
        stristr($param, "totalRows_detalhegeral") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_detalhegeral = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_detalhegeral = sprintf("&totalRows_detalhegeral=%d%s", $totalRows_detalhegeral, $queryString_detalhegeral);

?>
<?php if(isset($_GET['sqlWhere'])){ ?>
    <span class="verdana_11_bold" id="voltar" style="margin-left:500px; margin-top:-35px; position:absolute "><a href='#' onclick="return LoadFiltros(<?php echo $_GET['pol_apl_codigo']; ?>);">.: Voltar :.</a></span>
<?php } ?>
<input type="hidden" name="aplicacao" id="aplicacao" />

<div class="verdana_11"> Exibindo <?php echo ($startRow_detalhegeral + 1) ?> at&eacute; <?php echo min($startRow_detalhegeral + $maxRows_detalhegeral, $totalRows_detalhegeral) ?> de <?php echo $totalRows_detalhegeral ?> registros </div>
<table width="97%" cellpadding="1" cellspacing="0">
<tr align="left">
  <td width="1%" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">&nbsp;</td>
  <td width="20%" background="/e-solution/servicos/policy/images/barra_horizontal.jpg"><strong>Quando</strong></td>
  <td width="15%" background="/e-solution/servicos/policy/images/barra_horizontal.jpg"><strong>Quem</strong></td>
  <td background="/e-solution/servicos/policy/images/barra_horizontal.jpg"><strong>O qu&ecirc;</strong></td>
  <td width="13%" background="/e-solution/servicos/policy/images/barra_horizontal.jpg"><strong>Onde</strong></td>
  <td width="4%" height="24" align="center" background="/e-solution/servicos/policy/images/barra_horizontal.jpg"><strong><img src="/e-solution/servicos/policy/images/relevancia_menor.gif" width="20" height="20" /></strong></td>
  </tr>
  <?php if ($totalRows_detalhegeral > 0) {
  do {
   
    ?>
<tr align="left" id="linha_<?php echo $row_detalhegeral['pol_aud_codigo']; ?>" class="verdana_11" onmouseover="return Popula('linha_<?php echo $row_detalhegeral['pol_aud_codigo']; ?>')" onclick="location.href='/e-solution/servicos/policy/detalhes/regra.php?pol_apl_nome=<?php echo $row_detalhegeral['pol_apl_nome']; ?>&pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>&impressao=true&impressaodet=<?php echo $row_detalhegeral['pol_aud_codigo']; ?>'" onmouseout="return Desativa('linha_<?php echo $row_detalhegeral['pol_aud_codigo']; ?>')" title="header=[<span class='verdana_11'>Informa&ccedil;&otilde;es adicionais</span>] body=[<span class='verdana_11'><?php echo "Clique e veja informa&ccedil;&otilde;es deste evento."; ?></span>]">
  <td width="1%" align="left" style="border-bottom:1px dotted #003333;"><img src="/e-solution/servicos/policy/images/apontador.gif" align="absmiddle" /></td>
  <td align="left" style="border-bottom:1px dotted #003333;"><?php echo $row_detalhegeral['momento']; ?></td>
  <td style="border-bottom:1px dotted #003333;"><?php echo $row_detalhegeral['pol_aud_usuario']; ?></td>
  <td style="border-bottom:1px dotted #003333;"><?php echo $row_detalhegeral['pol_aud_acao']; ?></td>
  <td style="border-bottom:1px dotted #003333;"><?php echo $row_detalhegeral['pol_aud_ip']; ?></td>
  <td style="border-bottom:1px dotted #003333;" height="24" align="center"><strong><?php echo $row_detalhegeral['pol_aud_relevancia']; ?></strong></td>
  </tr>
  
  <?php } while ($row_detalhegeral = mysql_fetch_assoc($detalhegeral));
  }
  ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php if($totalRows_detalhegeral < 1){ echo "Nenhum resultado."; } ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
</table>
<table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="verdana_11_bold">
    <td width="80" height="20" align="center" valign="middle" ><?php if ($pageNum_detalhegeral > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_detalhegeral=%d%s", $currentPage, 0, $queryString_detalhegeral); ?>"><img src="/e-solution/servicos/policy/images/FIRST.GIF" alt="Primeira" border="0" align="absmiddle" />&nbsp;Primeira</a>
        <?php } // Show if not first page ?></td>
    <td width="80" align="center" valign="middle"><?php if ($pageNum_detalhegeral > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_detalhegeral=%d%s", $currentPage, max(0, $pageNum_detalhegeral - 1), $queryString_detalhegeral); ?>"><img src="/e-solution/servicos/policy/images/PREVIOUS.GIF" alt="Anterior" border="0" align="absmiddle" />&nbsp;Anterior</a>
        <?php } // Show if not first page ?></td>
    <td width="80" align="center" valign="middle"><?php if ($pageNum_detalhegeral < $totalPages_detalhegeral) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_detalhegeral=%d%s", $currentPage, min($totalPages_detalhegeral, $pageNum_detalhegeral + 1), $queryString_detalhegeral); ?>">Pr&oacute;xima&nbsp;<img src="/e-solution/servicos/policy/images/NEXT.GIF" alt="Pr&oacute;xima" border="0" align="absmiddle" /></a>
        <?php } // Show if not last page ?></td>
    <td align="center" valign="middle"><?php if ($pageNum_detalhegeral < $totalPages_detalhegeral) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_detalhegeral=%d%s", $currentPage, $totalPages_detalhegeral, $queryString_detalhegeral); ?>">&Uacute;ltima&nbsp;<img src="/e-solution/servicos/policy/images/LAST.GIF" alt="&Uacute;ltima" border="0" align="absmiddle" /></a>
        <?php } // Show if not last page ?></td>
  </tr>
  
</table>