<?php
require_once("../../../../Connections/policy.php");

// Global Functions
require_once(__DIR__ . "/../../../../../database/config/globalFunctions.php");

if(isset($_POST['pol_aud_ip'])){

		$pol_aud_acao 		= $_POST['pol_aud_acao'];
		$pol_aud_usuario	= $_POST['pol_aud_usuario'];
		$pol_aud_momento	= $_POST['pol_aud_momento'];
		$pol_aud_ip 		= $_POST['pol_aud_ip'];
		$pol_aud_nivel		= $_POST['pol_aud_nivel'];
		$pol_aud_relevancia	= $_POST['pol_aud_relevancia'];
		$pol_apl_codigo		= $_POST['pol_apl_codigo'];
		$pol_aud_ip_aplic	= $_POST['pol_aud_ip_aplic'];
		
		//verifica o boss
        $query_infoaplicacoes = "SELECT * FROM pol_aplicacao Where pol_apl_codigo = $pol_apl_codigo";
        list($infoaplicacoes, $row_infoaplicacoes, $totalRows_infoaplicacoes) = executeQuery($policy, $database_policy, $query_infoaplicacoes);

		if($totalRows_infoaplicacoes>0 && $pol_aud_relevancia >= $row_infoaplicacoes['pol_apl_relevancia'] && $row_infoaplicacoes['pol_apl_relevancia']!="-1"){	
			$insertSQL = "INSERT INTO pol_auditoria (pol_aud_acao, pol_aud_usuario, pol_aud_momento, pol_aud_ip, pol_aud_nivel, pol_aud_relevancia, pol_apl_codigo, pol_aud_ip_aplic) VALUES ('$pol_aud_acao','$pol_aud_usuario','$pol_aud_momento','$pol_aud_ip', '$pol_aud_nivel', $pol_aud_relevancia, '$pol_apl_codigo', '$pol_aud_ip_aplic')";

            list($infoaplicacoes, $row_infoaplicacoes, $totalRows_infoaplicacoes) = executeQuery($policy, $database_policy, $insertSQL);
		}
}
?>