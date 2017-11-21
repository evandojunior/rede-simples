<?php
/*==============================AUTENTICA USUÁRIO=========================================*/
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = getCurrentPage();
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['bbp_adm_aut_usuario'])) {
  $loginUsername=$_POST['bbp_adm_aut_usuario'];
  $password=md5($_POST['bbp_adm_aut_senha']);
  $ip=$_POST['bbp_adm_aut_ip'];
  $MM_fldUserAuthorization = "bbh_adm_lock_log_nivel";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed  = "login.php?msg=true";
  $MM_redirecttoReferrer = true;

    //verifica se o IP é de demonstração
	$query_UserLogin = "SELECT bbp_adm_aut_usuario, bbp_adm_aut_senha, bbp_adm_aut_ip FROM bbp_adm_autenticacao WHERE bbp_adm_aut_usuario='$loginUsername' AND bbp_adm_aut_senha='$password'";
    list($UserLogin, $row_UserLogin, $totalRows_UserLogin) = executeQuery($bbpass, $database_bbpass, $query_UserLogin);

	if($totalRows_UserLogin>0){
		if($row_UserLogin['bbp_adm_aut_ip']=="0.0.0.0"){//verifica se o IP é de demonstração
			$ip = "0.0.0.0";
		}
	}

  $LoginRS__query=sprintf("SELECT bbp_adm_aut_codigo, bbp_adm_acesso, bbp_adm_aut_usuario, bbp_adm_nivel,bbp_adm_aut_usuario, bbp_adm_user FROM bbp_adm_autenticacao WHERE bbp_adm_aut_usuario=%s AND bbp_adm_aut_senha=%s AND bbp_adm_aut_ip=%s",
  GetSQLValueString($bbpass, $loginUsername, "text"), GetSQLValueString($bbpass, $password, "text"), GetSQLValueString($bbpass, $ip, "text"));

  list($LoginRS, $row_LoginRS, $loginFoundUser) = executeQuery($bbpass, $database_bbpass, $LoginRS__query);

  if ($loginFoundUser) {
    
    $loginStrGroup  = $row_LoginRS['bbp_adm_nivel'];
	include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/function.php");
    
    //declare two session variables and assign them
	$_SESSION['MM_Email_Padrao']		= $loginUsername;
    $_SESSION['MM_BBpassADM_name']  	= $loginUsername;
	$_SESSION['MM_BBpassADM_user']  	= $row_LoginRS['bbp_adm_user'];
    $_SESSION['MM_BBpassADM_Group'] 	= $loginStrGroup;	
    $_SESSION['MM_BBpassADM_Codigo'] 	= $row_LoginRS['bbp_adm_aut_codigo'];	
    $_SESSION['MM_BBpassADM_Email'] 	= $row_LoginRS['bbp_adm_aut_usuario'];	
	$_SESSION['EmailTratado'] 			= trataEmail($_SESSION['MM_BBpassADM_Email']);


	include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/perfil/gerencia_perfil.php");
	$usuario = new perfil();//instância classe
	$usuario->atualizaLogon($database_bbpass, $bbpass);
	
    if (isset($_SESSION['PrevUrl']) && !empty($_SESSION['PrevUrl'])) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
	
	/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Efetuou Login no BBPASS.";
		EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
	  ?>
		<span style="font-family:verdana;font-size:11px;color:#06F">Aguarde redirecionando...</span>
		<script type="text/javascript">
			location.href = "<?php echo $MM_redirectLoginSuccess; ?>";
		</script>
	  <?php die;
    //header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
	  ?>
		<span style="font-family:verdana;font-size:11px;color:#06F">Aguarde redirecionando...</span>
		<script type="text/javascript">
			location.href = "<?php echo $MM_redirectLoginFailed; ?>";
		</script>
	  <?php
    //header("Location: ". $MM_redirectLoginFailed );
  }
}
/*==============================AUTENTICA USUÁRIO=========================================*/
?>