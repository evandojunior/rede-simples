<?php 
if (!isset($_SESSION)) { session_start(); }

	if(isset($_GET['Principal'])){
		$_SESSION['urlEnviaAnteriorCorp'] = $_GET['urlP'];
		$_SESSION['exPaginaAnteriorCorp'] = $_GET['exibicaoP'];
	
	} elseif(isset($_GET['novo'])) {
	
		$urlGeral 	= $_SERVER['QUERY_STRING'];
		$PosicaoURL	= strpos($_SERVER['QUERY_STRING'],"url");
		$URLI 		= substr($urlGeral,$PosicaoURL);
		$PosicaoExib= strpos($URLI,"exibicao");

		$URL 	= substr($urlGeral,$PosicaoURL+4, $PosicaoExib-5);
		$EXIB 	= substr($URLI,$PosicaoExib+9);
		
		if(isset($_SESSION['urlEnviaCorp'])){
			$_SESSION['urlAnteriorCorp']= NULL;
			$_SESSION['exAnteriorCorp']	= NULL;
			$_SESSION['urlAnteriorCorp']= $_SESSION['urlEnviaCorp'];
			$_SESSION['exAnteriorCorp']	= $_SESSION['exPaginaCorp'];
		} else {
			$_SESSION['urlAnteriorCorp']= NULL;
			$_SESSION['exAnteriorCorp']	= NULL;
			$_SESSION['urlAnteriorCorp']= $URL;
			$_SESSION['exAnteriorCorp']	= $EXIB;
		}
		
		$_SESSION['urlEnviaCorp'] 	= $URL;
		$_SESSION['exPaginaCorp'] 	= $EXIB;
	}
?>