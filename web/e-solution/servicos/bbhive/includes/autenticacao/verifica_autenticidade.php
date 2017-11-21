<?php
/*==============================VERIFICA SESSÃO DO USUÁRIO USUÁRIO=========================================*/
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers 	= "-1,484";//SOMENTE PARA BBhive - E-SOLUTION
$MM_donotCheckaccess 	= "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 

  return $isValid; 
}

/*=========================================ESTRUTURA BBPASS========================================*/
	//recupera o diretório da aplicação, sendo que não sei em qual aplicação estou
	$divisor 		= "web";//padrão letra minuscula
	$dirbbPacote 	= explode($divisor,str_replace("\\","/",dirname(__FILE__)));
	$dirPacotebb	= $dirbbPacote[1];
	require_once($dirbbPacote[0]."web/Connections/setup.php");
	//em qual aplicação estou======================================================================
	$apl_atual 	 = resolveDiretorio($dirPacotebb);
	$dirDinamico = "/".detalhaDiretorio($dirPacotebb)."servicos/".$apl_atual."/";
/*=========================================ESTRUTURA BBPASS========================================*/

$MM_restrictGoTo = $dirDinamico."login.php";
if (!((isset($_SESSION['MM_BBhive_name'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_BBhive_name'], $_SESSION['MM_BBhive_Group'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  //header("Location: ". $MM_restrictGoTo); 
  ?>
	<span style="font-family:verdana;font-size:11px;color:#06F">Aguarde redirecionando...</span>
	<script type="text/javascript">
		location.href = "<?php echo $MM_restrictGoTo; ?>";
	</script>
  <?php
  exit;
}
/*==============================VERIFICA SESSÃO DO USUÁRIO USUÁRIO=========================================*/
 ?>