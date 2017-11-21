<?php
/*==============================AUTENTICA USUÁRIO=========================================*/

// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

//if (isset($_SESSION['MM_Email_Padrao']) && !isset($_SESSION['MM_Policy_Codigo'])) {
if (isset($_POST['Email_Padrao'])) {
  $loginUsername=$_POST['Email_Padrao'];
  $MM_fldUserAuthorization = "pol_usu_nivel";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed  = "login.php?msg=true";
  $MM_redirecttoReferrer = true;

  $LoginRS__query=sprintf("SELECT pol_usu_codigo, pol_usu_identificacao, pol_usu_nivel FROM pol_usuario WHERE pol_usu_identificacao=%s", GetSQLValueString($policy, $loginUsername, "text"));
  list($LoginRS, $row_LoginRS, $loginFoundUser) = executeQuery($policy, $database_policy, $LoginRS__query);

  if ($loginFoundUser) {
    
    $loginStrGroup  = $row_LoginRS['pol_usu_nivel'];
	include($_SESSION['caminhoFisico']."/e-solution/servicos/policy/includes/functions.php");

    //declare two session variables and assign them
	$_SESSION['MM_Email_Padrao']	= $loginUsername;
	$_SESSION['MM_Username']		= $loginUsername;
    $_SESSION['MM_Policy_name']  	= $loginUsername;
    $_SESSION['MM_Policy_Group'] 	= $loginStrGroup;	
    $_SESSION['MM_Policy_Codigo'] 	= $row_LoginRS['pol_usu_codigo'];	
    $_SESSION['MM_Policy_Email'] 	= $row_LoginRS['pol_usu_identificacao'];	
	$_SESSION['EmailTratado'] 		= trataEmail($_SESSION['MM_Email_Padrao']);
	
    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Efetuou Login no POLICY.";
		EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
    //header("Location: " . $MM_redirectLoginSuccess );
	  ?>
		<span style="font-family:verdana;font-size:11px;color:#06F">Aguarde redirecionando...</span>
		<script type="text/javascript">
			location.href = "<?php echo $MM_redirectLoginSuccess; ?>";
		</script>
	  <?php
  }
  else {
	  //REDIRECIONA PARA TELA DE SUCESSO MAS COM A VARIÁVEL POPULADA COMO -1 / NÃO TEM PERFIL
	  $_SESSION['MM_Policy_name']  = true;	
	  $_SESSION['MM_Policy_Group'] = "-1";	

	  header("Location: ". $MM_redirectLoginSuccess );	
  }
}
/*==============================AUTENTICA USUÁRIO=========================================*/
?>