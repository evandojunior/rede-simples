<?php
require_once("../../../../Connections/policy.php");

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
		mysql_select_db($database_policy, $policy);
		$query_infoaplicacoes = "SELECT * FROM pol_aplicacao Where pol_apl_codigo = $pol_apl_codigo";
		$infoaplicacoes = mysql_query($query_infoaplicacoes, $policy) or die(mysql_error());
		$row_infoaplicacoes = mysql_fetch_assoc($infoaplicacoes);
		$totalRows_infoaplicacoes = mysql_num_rows($infoaplicacoes);
			
		if($totalRows_infoaplicacoes>0 && $pol_aud_relevancia >= $row_infoaplicacoes['pol_apl_relevancia'] && $row_infoaplicacoes['pol_apl_relevancia']!="-1"){	
			$insertSQL = "INSERT INTO pol_auditoria (pol_aud_acao, pol_aud_usuario, pol_aud_momento, pol_aud_ip, pol_aud_nivel, pol_aud_relevancia, pol_apl_codigo, pol_aud_ip_aplic) VALUES ('$pol_aud_acao','$pol_aud_usuario','$pol_aud_momento','$pol_aud_ip', '$pol_aud_nivel', $pol_aud_relevancia, '$pol_apl_codigo', '$pol_aud_ip_aplic')";
	
			  mysql_select_db($database_policy, $policy);
			  $Result1 = mysql_query($insertSQL, $policy) or die(mysql_error());
		}
}
?>