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

//if (isset($_SESSION['MM_Email_Padrao']) && !isset($_SESSION['MM_Policy_Codigo'])) {
if (isset($_POST['Email_Padrao'])) {
  $_SESSION['MM_Email_Padrao'] = $_POST['Email_Padrao'];
  $loginUsername=$_POST['Email_Padrao'];
  $MM_fldUserAuthorization = "bbh_usu_nivel";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed  = "login.php?msg=true";
  $MM_redirecttoReferrer = true;

  $LoginRS__query=sprintf("SELECT COALESCE(MAX(p.bbh_per_pub),0) as pub,
	u.bbh_usu_codigo, u.bbh_usu_identificacao, u.bbh_usu_nivel, u.bbh_usu_apelido 
	FROM bbh_usuario as u
	 LEFT JOIN bbh_usuario_perfil as up on u.bbh_usu_codigo = up.bbh_usu_codigo
	 LEFT JOIN bbh_perfil as p on up.bbh_per_codigo = p.bbh_per_codigo
	  WHERE bbh_usu_identificacao=%s AND bbh_usu_ativo='1' and bbh_usu_nivel=584
		 GROUP BY u.bbh_usu_codigo
		  HAVING pub = 0", GetSQLValueString($bbhive, $loginUsername, "text"));

    list($LoginRS, $row_LoginRS, $loginFoundUser) = executeQuery($bbhive, $database_bbhive, $LoginRS__query);
  
  if ($loginFoundUser) {

//    $loginStrGroup  = "584";//mysql_result($LoginRS,0,'bbh_adm_nivel');
	$loginStrGroup  = $row_LoginRS['bbh_usu_nivel'];
	include($_SESSION['caminhoFisico']."/servicos/bbhive/includes/functions.php");

	//ATUALIZA A MERDA DO ACESSO------------------------------------------------------
	$updateSQL = "UPDATE bbh_usuario SET bbh_usu_ultimoAcesso='".date("Y-m-d H:i:s")."' WHERE bbh_usu_codigo=".$row_LoginRS['bbh_usu_codigo'];
	list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	//TEM COISAS MAIS IMPORTANTE DO QUE ISSO------------------------------------------
	
    //declare two session variables and assign them
	$_SESSION['MM_Email_Padrao']	= $loginUsername;
    $_SESSION['MM_BBhive_name']  	= $loginUsername;
    $_SESSION['MM_BBhive_Group'] 	= $loginStrGroup;	
    $_SESSION['MM_BBhive_Codigo'] 	= $row_LoginRS['bbh_usu_codigo'];
	$_SESSION['MM_BBhive_Publico'] 	= $row_LoginRS['bbh_usu_codigo'];	
    $_SESSION['MM_BBhive_Email'] 	= $row_LoginRS['bbh_usu_identificacao'];	
	$_SESSION['EmailTratado'] 		= trataEmail($_SESSION['MM_Email_Padrao']);
	
	$_SESSION['pub_acesso'] 		= 1;
	$_SESSION['pub_usuNome']		= $_SESSION['MM_Email_Padrao'];
	$_SESSION['pub_usuApelido']		= $row_LoginRS['bbh_usu_apelido'];
	$_SESSION['pub_usuCod']			= 0;
	$_SESSION['pub_ultimoAcesso']	= 0;
	$_SESSION['pub_sexoUsuario']	= 1;
    $_SESSION['MM_Username'] 		= $loginUsername;
    $_SESSION['MM_UserGroup'] 		= $loginStrGroup;
	$_SESSION['MM_User_email'] 		= $_SESSION['pub_usuNome'];
			
    if (isset($_SESSION['PrevUrl']) && !empty($_SESSION['PrevUrl'])) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Efetuou Login no BBHIVE.";
		EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
   // header("Location: " . $MM_redirectLoginSuccess );
	  ?>
		<span style="font-family:verdana;font-size:11px;color:#06F">Aguarde redirecionando...</span>
		<script type="text/javascript">
			location.href = "<?php echo $MM_redirectLoginSuccess; ?>";
		</script>
	  <?php die;
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