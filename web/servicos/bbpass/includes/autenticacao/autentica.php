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
unset($_SESSION['PrevUrl']);

if (isset($_POST['email'])) {
  $loginUsername=$_POST['email'];
  $password=md5($_POST['senha']); echo "<br/>";
  $MM_fldUserAuthorization = "bbh_adm_lock_log_nivel";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed  = "login.php?msg=true";
  $MM_redirecttoReferrer = true;

  //--Verifica qual método de autenticação está sendo usado
  
	//recupera dados do lock
	$esteLock = file_get_contents($_SESSION['EndURL_BBPASS']."/servicos/bbpass/includes/autenticacao/validaLock.php?i=".$_SESSION['idLockLoginSenha']);

	/*exit($dados);
	require_once($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/modulo/gerencia_modulo.php");
	$modulo = new Modulo();
	$modulo->dadosModulo($database_bbpass, $bbpass, $_SESSION['idLockLoginSenha']);
	$esteLock = $modulo->bbp_adm_loc_arquivo;*/
	//--
	if($esteLock=='login_chave.php'){
		//--CHAVE DE ACESS
		$LoginRS__query=sprintf("SELECT bbp_adm_lock_log_codigo, bbp_adm_lock_log_chave, bbp_adm_lock_log_senha, bbh_adm_lock_log_nivel FROM bbp_adm_lock_loginchave WHERE bbp_adm_lock_log_chave=%s AND bbp_adm_lock_log_senha=%s",
  GetSQLValueString($bbpass, $loginUsername, "text"), GetSQLValueString($bbpass, $password, "text"));
		
	} elseif($esteLock=='login.php'){
		//--E-MAIL E SENHA
		$LoginRS__query=sprintf("SELECT bbp_adm_lock_log_codigo, bbp_adm_lock_log_email, bbp_adm_lock_log_senha, bbh_adm_lock_log_nivel FROM bbp_adm_lock_loginsenha WHERE bbp_adm_lock_log_email=%s AND bbp_adm_lock_log_senha=%s",
  GetSQLValueString($bbpass, $loginUsername, "text"), GetSQLValueString($bbpass, $password, "text"));
	}
	
  /*$LoginRS__query=sprintf("SELECT bbp_adm_lock_log_codigo, bbp_adm_lock_log_email, bbp_adm_lock_log_senha, bbh_adm_lock_log_nivel FROM bbp_adm_lock_loginsenha WHERE bbp_adm_lock_log_email=%s AND bbp_adm_lock_log_senha=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); */

    list($LoginRS, $row_LoginRS, $loginFoundUser) = executeQuery($bbpass, $database_bbpass, $LoginRS__query);

  //--
  if ($loginFoundUser) {
    
    $loginStrGroup  = $row_LoginRS['bbh_adm_lock_log_nivel'];
	include($_SESSION['caminhoFisico']."/servicos/bbpass/includes/function.php");

    //declare two session variables and assign them
	$_SESSION['MM_Email_Padrao']	= $loginUsername;
    $_SESSION['MM_BBpass_name']  	= $loginUsername;
    $_SESSION['MM_BBpass_Group'] 	= $loginStrGroup;	
	//--
	if($esteLock=='login.php'){
    	$_SESSION['MM_BBpass_Codigo'] 	= $row_LoginRS['bbp_adm_lock_log_codigo'];	
    	$_SESSION['MM_BBpass_Email'] 	= $row_LoginRS['bbp_adm_lock_log_email'];
		//--
	} elseif($esteLock=='login_chave.php'){
		$_SESSION['MM_BBpass_Codigo'] 	= $row_LoginRS['bbp_adm_lock_log_codigo'];
		$_SESSION['MM_BBpass_Chave'] 	= $row_LoginRS['bbp_adm_lock_log_chave'];
		$_SESSION['MM_BBpass_Email']	= $_SESSION['MM_BBpass_Chave'];
		//--
	}
	
	$_SESSION['EmailTratado'] 		= trataEmail($_SESSION['MM_BBpass_Email']);

	include($_SESSION['caminhoFisico']."/servicos/bbpass/perfil/gerencia_perfil.php");
	$usuario = new perfil();//instância classe
	$usuario->atualizaLogon($database_bbpass, $bbpass);
	
	//monta XML de sessão para autenticação das demais aplicações
	$idLockLiberado = $_SESSION['idLockLoginSenha'];
	include($_SESSION['caminhoFisico']."/servicos/bbpass/credencial/gerencia_credencial/libera_credencial.php");
	
    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
	
/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Efetuou Login no (Ambiente Público) BBPASS.";
		EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
	  ?>
		<span style="font-family:verdana;font-size:11px;color:#06F">Aguarde redirecionando...</span>
		<script type="text/javascript">
			location.href = "<?php echo $MM_redirectLoginSuccess; ?>";
		</script>
	  <?php exit;
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
