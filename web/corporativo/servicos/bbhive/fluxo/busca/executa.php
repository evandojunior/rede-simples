<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
//recebe protocolo e fluxo
$bbh_pro_codigo = $_POST['bbh_pro_codigo'];
$bbh_flu_codigo = $_POST['bbh_flu_codigo'];

//anexa fluxo ao protocolo e muda seu status
			$updateSQL = "UPDATE bbh_protocolos SET bbh_pro_status='4', bbh_pro_obs='$bbh_pro_obs', bbh_pro_recebido='".$_SESSION['MM_User_email']."', bbh_pro_dt_recebido='".date("Y-m-d H:i:s")."', bbh_flu_codigo = $bbh_flu_codigo WHERE bbh_pro_codigo = $bbh_pro_codigo";
            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
			
//volta para lista de fluxos		
			$retorno ="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1&protocolo=1|protocolo/index.php?todos=true','menuEsquerda|conteudoGeral');limpaAmbiente()";
			echo "<var style='display:none'>".$retorno."</var>";
			exit;

?>