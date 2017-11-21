<?php
/*==============================EFETUA LOGOFF DO USUÁRIO=========================================*/
	//initialize the session
	if (!isset($_SESSION)) {
	  session_start();
	}
	
	// ** Logout the current user. **
	$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
	if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
	  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
	}
	
	if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
		//destrói os locks liberados
		 require_once("quebraSessao.php");
		 destroiCredencial($dirPadrao[0]."web/Connections/policy/http.php");//função do setup
		 
		//destrói todas as funções - INICIO
		@session_regenerate_id();
			foreach ($_SESSION as $campo => $valor){ 
				$_SESSION[$campo] = NULL;
				 unset($_SESSION[$campo]);
			}
		//destrói todas as funções - FIM
		
	   //$logoutGoTo = "/".detalhaDiretorio($dirPadrao[1])."servicos/".$apl_atual."/login.php?abandona=sim";//esta no aquivo que faz as inclusões
	   $logoutGoTo = "/".detalhaDiretorio($dirPadrao[1])."servicos/".$apl_atual."/logoutRegeneration.php?abandona=sim";//esta no aquivo que faz as inclusões
	   
	if ($logoutGoTo) {
	  ?>
		<span style="font-family: Verdana, Geneva, sans-serif;font-size: 14px;color: #00F;">Aguarde o redirecionamento...</span>
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