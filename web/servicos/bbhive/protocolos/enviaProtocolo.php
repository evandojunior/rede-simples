<?php if(!isset($_SESSION)){ session_start(); }
//recebe por post e coloca na sessão do público
 $nvVetor = array();
 $nvVetor['bbh_flu_pai']			= $_POST['bbh_flu_pai'];
 $nvVetor['bbh_pro_flagrante'] 		= 0;//$_POST['bbh_pro_flagrante'];
 $nvVetor['bbh_pro_identificacao'] 	= $_POST['bbh_pro_identificacao'];
 $nvVetor['bbh_pro_autoridade'] 	= $_POST['bbh_pro_autoridade'];
 $nvVetor['bbh_pro_titulo'] 		= $_POST['bbh_pro_titulo'];
 $nvVetor['bbh_pro_data'] 			= $_POST['bbh_pro_data'];
 $nvVetor['bbh_pro_descricao'] 		= $_POST['bbh_pro_descricao'];
 
 $_SESSION['pacoteNovoProtocolo'] 			= $nvVetor;
 
 $_SESSION['ligacaoAmbientePublico']		= $_SESSION['urlEnvia'];
 $_SESSION['ligacaoAmbientePublicoEnvia']	= $_SESSION['exPagina'];
 $_SESSION['ligacaoAmbientePublicoAnt']		= $_SESSION['urlEnviaAnterior'];
 $_SESSION['ligacaoAmbientePublicoExPag']	= $_SESSION['exPaginaAnterior'];
 
 //redireciona para página de preenchimento do protocolo
 //header('Location: ../login.php');
 $_SESSION['urlEnviaAnterior'] = NULL;
 unset($_SESSION['urlEnviaAnterior']);
 //--
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Aguarde...</title>
<meta http-equiv="Refresh" content="0;URL=../index.php" />
</head>

<body>Aguarde...
</body>
</html>