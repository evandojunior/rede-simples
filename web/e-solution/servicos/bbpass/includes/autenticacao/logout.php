<?php
/*==============================EFETUA LOGOFF DO USUÁRIO=========================================*/
	//initialize the session
	if (!isset($_SESSION)) {
	  session_start();
	}
	
	// ** Logout the current user. **
	$logoutAction = getCurrentPage()."?doLogout=true";
	if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
	
	/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Efetuou Logoff do BBPASS.";
		EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
	
	  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
	}
	
	if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
		//destrói todas as funções - INICIO
		@session_regenerate_id();
			foreach ($_SESSION as $campo => $valor){ 
				$_SESSION[$campo] = NULL;
				 unset($_SESSION[$campo]);
			} 
		//destrói todas as funções - FIM
		
	  $logoutGoTo = "/e-solution/servicos/bbpass/login.php?abandona=sim";
	  if ($logoutGoTo) {
	  ?>
		<span style="font-family:verdana;font-size:11px;color:#06F">Aguarde redirecionando...</span>
		<script type="text/javascript">
			location.href = "<?php echo $logoutGoTo; ?>";
		</script>
	  <?php
		//header("Location: $logoutGoTo");
		exit;
	  }
	}
/*===============================================================================================*/
?>