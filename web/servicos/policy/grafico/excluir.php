<?php
	require_once("../includes/autentica.php");
	require_once("../includes/functions.php");
if (!isset($_SESSION)) {
  session_start();
}

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

mysql_select_db($database_policy, $policy);
$query_pegacodigo = "SELECT pol_apl_codigo FROM pol_aplicacao ORDER BY pol_apl_codigo DESC";
$pegacodigo = mysql_query($query_pegacodigo, $policy) or die(mysql_error());
$row_pegacodigo = mysql_fetch_assoc($pegacodigo);
$totalRows_pegacodigo = mysql_num_rows($pegacodigo);

mysql_select_db($database_policy, $policy);
$query_strPolitica = "select * from pol_politica 
WHERE pol_apl_codigo = " .$_GET['pol_apl_codigo'] . " 
 order by pol_pol_titulo ASC, pol_pol_criacao DESC";
$strPolitica = mysql_query($query_strPolitica, $policy) or die(mysql_error());
$row_strPolitica = mysql_fetch_assoc($strPolitica);
$totalRows_strPolitica = mysql_num_rows($strPolitica);

mysql_select_db($database_policy, $policy);
$query_grafico = "select * from pol_grafico 
WHERE pol_graf_codigo = " .$_GET['pol_graf_codigo'] ;
$grafico = mysql_query($query_grafico, $policy) or die(mysql_error());
$row_grafico = mysql_fetch_assoc($grafico);
$totalRows_grafico = mysql_num_rows($grafico);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ( isset ($_GET['pol_graf_codigo']) )  {
	
  $deleteSQL = "DELETE FROM pol_grafico WHERE pol_graf_codigo = " . $_GET['pol_graf_codigo'];
 
  mysql_select_db($database_policy, $policy);
  $Result1 = mysql_query($deleteSQL, $policy) or die(mysql_error());
 
  mysql_select_db($database_policy, $policy);
 $query_ultimo = "SELECT pol_graf_codigo FROM pol_grafico
WHERE pol_graf_codigo = LAST_INSERT_ID()";
$ultimo = mysql_query($query_ultimo, $policy) or die(mysql_error());
$row_ultimo = mysql_fetch_assoc($ultimo);
$totalRows_ultimo = mysql_num_rows($ultimo);
 
 $goTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $goTo .= (strpos($goTo, '?')) ? "&" : "?";
    $goTo .= $_SERVER['QUERY_STRING'];
 
  }
 header("Location: $goTo");

}

?>