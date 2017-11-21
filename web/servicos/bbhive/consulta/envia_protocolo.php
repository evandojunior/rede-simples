<?php 
if(!isset($_SESSION)){ session_start(); }
//recebe por post e coloca na sessão do público
 $nvVetor = array();
 $nvVetor['bbh_flu_pai']			= $_GET['id'];
 $nvVetor['bbh_pro_flagrante'] 		= 0;
 $nvVetor['bbh_pro_identificacao'] 	= "";
 $nvVetor['bbh_pro_autoridade'] 	= "";
 $nvVetor['bbh_pro_titulo'] 		= "";
 $nvVetor['bbh_pro_data'] 			= "";
 $nvVetor['bbh_pro_descricao'] 		= "";
 
 $_SESSION['pacoteNovoProtocolo'] 	= $nvVetor;
 
 //redireciona para página de preenchimento do protocolo
 $_SESSION['urlEnviaAnterior'] = NULL;
 unset($_SESSION['urlEnviaAnterior']);
 //--
?><var style="display:none">location.href="/servicos/bbhive/index.php";</var>