<?php
	require_once("../includes/autentica.php");
	require_once("../includes/functions.php");
if (!isset($_SESSION)) {
  session_start();
}

mysqli_select_db($policy, $database_policy);
$query_pegacodigo = "SELECT pol_apl_codigo FROM pol_aplicacao ORDER BY pol_apl_codigo DESC";
$pegacodigo = mysqli_query($policy, $query_pegacodigo) or die(mysql_error());
$row_pegacodigo = mysqli_fetch_assoc($pegacodigo);
$totalRows_pegacodigo = mysqli_num_rows($pegacodigo);

mysqli_select_db($policy, $database_policy);
$query_strPolitica = "select * from pol_politica 
WHERE pol_apl_codigo = " .$_GET['pol_apl_codigo'] . " 
 order by pol_pol_titulo ASC, pol_pol_criacao DESC";
$strPolitica = mysqli_query($policy, $query_strPolitica) or die(mysql_error());
$row_strPolitica = mysqli_fetch_assoc($strPolitica);
$totalRows_strPolitica = mysqli_num_rows($strPolitica);

mysqli_select_db($policy, $database_policy);
$query_grafico = "select * from pol_grafico 
WHERE pol_graf_codigo = " .$_GET['pol_graf_codigo'] ;
$grafico = mysqli_query($policy, $query_grafico) or die(mysql_error());
$row_grafico = mysqli_fetch_assoc($grafico);
$totalRows_grafico = mysqli_num_rows($grafico);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ( isset ($_GET['pol_graf_codigo']) )  {
	
  $deleteSQL = "DELETE FROM pol_grafico WHERE pol_graf_codigo = " . $_GET['pol_graf_codigo'];
 
  mysqli_select_db($policy, $database_policy);
  $Result1 = mysqli_query($policy, $deleteSQL) or die(mysql_error());
 
  mysqli_select_db($policy, $database_policy);
 $query_ultimo = "SELECT pol_graf_codigo FROM pol_grafico
WHERE pol_graf_codigo = LAST_INSERT_ID()";
$ultimo = mysqli_query($policy, $query_ultimo) or die(mysql_error());
$row_ultimo = mysqli_fetch_assoc($ultimo);
$totalRows_ultimo = mysqli_num_rows($ultimo);
 
 $goTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $goTo .= (strpos($goTo, '?')) ? "&" : "?";
    $goTo .= $_SERVER['QUERY_STRING'];
 
  }
 header("Location: $goTo");

}

?>