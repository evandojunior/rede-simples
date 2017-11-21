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
  $loginUsername		   = $_POST['Email_Padrao'];
  $MM_fldUserAuthorization = "bbh_adm_nivel";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed  = "login.php?msg=true";
  $MM_redirecttoReferrer = true;
  
  $LoginRS__query=sprintf("SELECT bbh_adm_codigo, bbh_adm_identificacao, bbh_adm_nivel, bbh_adm_nome, bbh_adm_ultimoAcesso, bbh_adm_sexo FROM bbh_administrativo WHERE bbh_adm_identificacao=%s and bbh_adm_nivel=484", GetSQLValueString($bbhive, $loginUsername, "text"));
  list($LoginRS, $row_LoginRS, $loginFoundUser) = executeQuery($bbhive, $database_bbhive, $LoginRS__query);
  
  $_SESSION['BBhive_verificado'] = true;
  
  if ($loginFoundUser) {

    $loginStrGroup  = $row_LoginRS['bbh_adm_nivel'];
	include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");
	
	//ATUALIZA A MERDA DO ACESSO------------------------------------------------------
		$updateSQL = "UPDATE bbh_administrativo SET bbh_adm_ultimoAcesso='".date("Y-m-d H:i:s")."' WHERE bbh_adm_codigo=".$row_LoginRS['bbh_adm_codigo'];
      list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	//TEM COISAS MAIS IMPORTANTE DO QUE ISSO------------------------------------------
	
    //declare two session variables and assign them
	$_SESSION['MM_Email_Padrao']	= $loginUsername;
    $_SESSION['MM_BBhive_name']  	= $loginUsername;
	$_SESSION['MM_BBhive_Group'] 	= $loginStrGroup;	

    $_SESSION['MM_BBhive_Codigo'] 	= $row_LoginRS['bbh_adm_codigo'];
	$_SESSION['MM_BBhive_Aministrativo'] 	= $row_LoginRS['bbh_adm_codigo'];	
    $_SESSION['MM_BBhive_Email'] 	= $row_LoginRS['bbh_adm_identificacao'];	
	$_SESSION['EmailTratado'] 		= trataEmail($_SESSION['MM_Email_Padrao']);
	
	$_SESSION['es_acesso'] 			= 1;
	$_SESSION['es_usuNome']			= $row_LoginRS['bbh_adm_nome'];
	$_SESSION['es_usuCod']			= $row_LoginRS['bbh_adm_codigo'];
	$_SESSION['es_ultimoAcesso']	= $row_LoginRS['bbh_adm_ultimoAcesso'];
	$_SESSION['es_sexoUsuario']		= $row_LoginRS['bbh_adm_sexo'];
	$_SESSION['MM_Username'] 		= "1";
	$_SESSION['MM_UserGroup'] 		= "1";
	$_SESSION['MM_User_email'] 		= "ok";

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Efetuou Login no BBHIVE.";
		EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
	  ?>
		<span style="font-family:verdana;font-size:11px;color:#06F">Aguarde redirecionando...</span>
		<script type="text/javascript">
			location.href = "<?php echo $MM_redirectLoginSuccess; ?>";
		</script>
	  <?php
    //header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
	  //REDIRECIONA PARA TELA DE SUCESSO MAS COM A VARIÁVEL POPULADA COMO -1 / NÃO TEM PERFIL
	  $_SESSION['MM_BBhive_name']  = true;	
	  $_SESSION['MM_BBhive_Group'] = "-1";	

	  header("Location: ". $MM_redirectLoginSuccess );	
  }
}
/*==============================AUTENTICA USUÁRIO=========================================*/
?>