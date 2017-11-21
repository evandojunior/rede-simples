<?php 
if (!isset($_SESSION)) { session_start(); }

	if(isset($_GET['Principal'])){
		$_SESSION['urlEnviaAnteriorPub'] = $_GET['urlP'];
		$_SESSION['exPaginaAnteriorPub'] = $_GET['exibicaoP'];
	
	} elseif(isset($_GET['novo'])) {
	
		$urlGeral 	= $_SERVER['QUERY_STRING'];
		$PosicaoURL	= strpos($_SERVER['QUERY_STRING'],"url");
		$URLI 		= substr($urlGeral,$PosicaoURL);
		$PosicaoExib= strpos($URLI,"exibicao");

		$URL 	= substr($urlGeral,$PosicaoURL+4, $PosicaoExib-5);
		$EXIB 	= substr($URLI,$PosicaoExib+9);
		
		if(isset($_SESSION['urlEnviaPub'])){
			$_SESSION['urlAnteriorPub']= NULL;
			$_SESSION['exAnteriorPub']	= NULL;
			$_SESSION['urlAnteriorPub']= $_SESSION['urlEnviaPub'];
			$_SESSION['exAnteriorPub']	= $_SESSION['exPaginaPub'];
		} else {
			$_SESSION['urlAnteriorPub']= NULL;
			$_SESSION['exAnteriorPub']	= NULL;
			$_SESSION['urlAnteriorPub']= $URL;
			$_SESSION['exAnteriorPub']	= $EXIB;
		}

		$_SESSION['urlEnviaPub'] 	= $URL;
		$_SESSION['exPaginaPub'] 	= $EXIB;
		

	}
?>