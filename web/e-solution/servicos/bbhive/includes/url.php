<?php 
if (!isset($_SESSION)) { session_start(); }

	if(isset($_GET['Principal'])){
		$_SESSION['urlEnviaAnteriorAdm'] = $_GET['urlP'];
		$_SESSION['exPaginaAnteriorAdm'] = $_GET['exibicaoP'];
	
	} elseif(isset($_GET['novo'])) {
	
		$urlGeral 	= $_SERVER['QUERY_STRING'];
		$PosicaoURL	= strpos($_SERVER['QUERY_STRING'],"url");
		$URLI 		= substr($urlGeral,$PosicaoURL);
		$PosicaoExib= strpos($URLI,"exibicao");

		$URL 	= substr($urlGeral,$PosicaoURL+4, $PosicaoExib-5);
		$EXIB 	= substr($URLI,$PosicaoExib+9);
		
		if(isset($_SESSION['urlEnvia'])){
			$_SESSION['urlAnteriorAdm']= NULL;
			$_SESSION['exAnteriorAdm']	= NULL;
			$_SESSION['urlAnteriorAdm']= $_SESSION['urlEnvia'];
			$_SESSION['exAnteriorAdm']	= $_SESSION['exPagina'];
		} else {
			$_SESSION['urlAnteriorAdm']= NULL;
			$_SESSION['exAnteriorAdm']	= NULL;
			$_SESSION['urlAnteriorAdm']= $URL;
			$_SESSION['exAnteriorAdm']	= $EXIB;
		}
		
		$_SESSION['urlEnviaAdm'] 	= $URL;
		$_SESSION['exPaginaAdm'] 	= $EXIB;
		

	}
?>