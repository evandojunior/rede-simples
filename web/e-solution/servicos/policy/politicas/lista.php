<?php
require_once("includes/cabeca.php");

require_once("includes/gerencia_xml.php");

require_once('../../../../Connections/policy.php'); 
require_once("../includes/functions.php");

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
	$pol_pol_codigo = $_GET['pol_pol_codigo'];
	//le XML
	$xml 	= new gerenciaXML();
	$nmFile  = session_id();
	$file 	 = fopen($xml->diretorio().$nmFile.".xml", "w");//abre o arquivo
	$escreve = fwrite($file, $row_politica['pol_pol_xml']); //escreve no arquivo com a Hora
	fclose($file);//fecha o arquivo
	
	$doc = $xml->leituraXML($nmFile);
	$root 		= $doc->getElementsByTagName('politica')->item(0);
	$condicoes	= $root->getElementsByTagName('condicao')->item(0);
	$cond		= "";
	
	//condição=======================================================================================	
	foreach($condicoes->childNodes as $condicao){
		if($condicao->getAttribute("publicado")=="1"){
			$campo		= $condicao->getAttribute("campo");
			$aCondicao 	= utf8_decode($condicao->getAttribute("tipoCondicao"));
			$valor		= utf8_decode($condicao->getAttribute("valor"));

			//Exceto data e condição = > < <>
			if($condicao->getAttribute("campoData")=="1"){
				$valor = explode("|",$valor);
				$dataIni= arrumaDate($valor[0]);
				$dataFim= arrumaDate($valor[1]);
				
				$cond.= " AND $campo >='$dataIni' AND $campo <='$dataFim'";
			} else {
				//se like inicio
				if($condicao->getAttribute("tipoCondicao")=="inicio"){
					$cond.= " AND $campo LIKE '$valor%'";
					
				}else if($condicao->getAttribute("tipoCondicao")=="contenha"){
				//se like contenha
					$cond.= " AND $campo LIKE '%$valor%'";
					
				}else if($condicao->getAttribute("tipoCondicao")=="fim"){
				//se like fim
					$cond.= " AND $campo LIKE '%$valor'";
					
				}else{//qualquer outra
					$cond.= " AND $campo $aCondicao '$valor'";
				}
			}
		}
	}
	//ordenação=======================================================================================
	$ordenacao	= $root->getElementsByTagName('ordenacao')->item(0);
	$arrayOrdena= array();
	
	foreach($ordenacao->childNodes as $ordena){
		if($ordena->getAttribute("publicado")=="1"){
			$campo		= $ordena->getAttribute("campo");
			$ordem 		= $ordena->getAttribute("tipoCondicao");
			$valor		= $ordena->getAttribute("valor");

			array_push($arrayOrdena,$ordem."|".$campo."|".$valor);
		}
	}
	//ordena array
	sort($arrayOrdena);
	//varre array
	$Order="";
		for($a=0;$a<count($arrayOrdena);$a++){
			$informacoes = explode("|",$arrayOrdena[$a]);
			$Order.= ", ".$informacoes[1]." ".$informacoes[2];
		}
		
	$Ordenacao = count($arrayOrdena)>0?"ORDER BY" .substr($Order,1):"";
	$Condicoes = $cond;



	$Sql = "SELECT date_format(pol_aud_momento,'%d/%m/%Y %H:%i:%s') AS momento, pol_aud_usuario, pol_aud_acao, pol_aud_ip, pol_aud_nivel, pol_aud_relevancia, pol_aud_codigo, pol_apl_nome FROM pol_auditoria RIGHT JOIN pol_aplicacao ON pol_auditoria.pol_apl_codigo = pol_aplicacao.pol_apl_codigo WHERE pol_aplicacao.pol_apl_codigo = $colname_codigo $Condicoes $Ordenacao";

	mysqli_select_db($policy, $database_policy);
	$query_detalhegeral = $Sql;
	$query_limit_detalhegeral = sprintf("%s LIMIT %d, %d", $query_detalhegeral, $startRow_detalhegeral, $maxRows_detalhegeral);
$detalhegeral = mysqli_query($policy, $query_limit_detalhegeral) or die(mysql_error());
	
	$row_detalhegeral = mysqli_fetch_assoc($detalhegeral);
	
if (isset($_GET['totalRows_detalhegeral'])) {
  $totalRows_detalhegeral = $_GET['totalRows_detalhegeral'];
} else {
  $all_detalhegeral = mysqli_query($policy, $query_detalhegeral);
  $totalRows_detalhegeral = mysqli_num_rows($all_detalhegeral);
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

<div class="verdana_11" align="left"> &nbsp;&nbsp;Exibindo <?php echo ($startRow_detalhegeral + 1) ?> at&eacute; <?php echo min($startRow_detalhegeral + $maxRows_detalhegeral, $totalRows_detalhegeral) ?> de <?php echo $totalRows_detalhegeral ?> registros </div>
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
  
  <?php } while ($row_detalhegeral = mysqli_fetch_assoc($detalhegeral));
  }
  ?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" align="center"><?php if($totalRows_detalhegeral < 1){ echo "Nenhum resultado."; } ?></td>
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
        <a href="<?php printf("%s?pageNum_detalhegeral=%d%s", $currentPage, $totalPages_detalhegeral, $queryString_detalhegeral); ?>">&Uacute;ltima&nbsp;<img src="/e-solution/servicos/policy/images/Last.gif" alt="&Uacute;ltima" border="0" align="absmiddle" /></a>
        <?php } // Show if not last page ?></td>
  </tr>
  
</table>