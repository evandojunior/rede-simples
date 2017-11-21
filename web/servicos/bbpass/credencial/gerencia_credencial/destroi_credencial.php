<?php
	if(!isset($_SESSION)){session_start();}
	$divisor = "web";//padrão letra minuscula
	$dirPadrao = explode($divisor,str_replace("\\","/",dirname(__FILE__)));
	$dirOnde = $dirPadrao[0];

	//em qual aplicação estou======================================================================
	$apl_atual 	 = "bbpass";
	$dirDinamico = $dirPadrao[0]."web/Connections/bbpass.php";
	require_once($dirDinamico);
	
	$idLockLiberado = isset($_POST['idLockLiberado'])?$_POST['idLockLiberado']:$idLockLiberado;//utilizado por todos
	if(isset($_POST['idLockLiberado'])){
			$_SESSION['EmailTratado']	=$_POST['email']; 
			$_SESSION['caminhoFisico'] 	=$caminhoFisico;
	}
	
	include($_SESSION['caminhoFisico']."/servicos/bbpass/credencial/gerencia_credencial/gerencia.php");
	$gerencia->inicio();//grava informações nas variáveis
	$gerencia->destroiLock($gerencia->emailLogado,$gerencia->caminhoXML,$idLockLiberado);
?>