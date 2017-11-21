<?php
require_once('../../../../Connections/policy.php'); 
require_once("../includes/autentica.php");
	
	
mysqli_select_db($policy, $database_policy);
$query_dados = "SELECT COUNT(p.pol_aud_codigo) AS acessos, 
date_format(MAX(p.pol_aud_momento),'%d/%m/%Y %H:%i:%s') AS momento, (select pa.pol_aud_ip from pol_auditoria as pa where pa.pol_aud_codigo = max(p.pol_aud_codigo)) as ip
FROM pol_auditoria as p where p.pol_apl_codigo = ".$cd=$_GET['pol_apl_codigo'];
$dados = mysqli_query($policy, $query_dados) or die(mysql_error());
$row_dados = mysqli_fetch_assoc($dados);
//--
	$ip = empty($row_dados['ip']) ? "Sem informaÃ§Ãµes":$row_dados['ip'];
	$ac = empty($row_dados['acessos']) ? "Sem informaÃ§Ãµes":$row_dados['acessos']." acessos";
	$ul = empty($row_dados['momento']) ? "Sem informaÃ§Ãµes":$row_dados['momento'];
//--
	echo utf8_decode($ip);	
	echo "<var style='display:none'>
			document.getElementById('acessos_$cd').innerHTML = '".utf8_decode($ac)."';
			document.getElementById('ultimo_$cd').innerHTML = '".utf8_decode($ul)."';
		</var>";
//document.getElementById('ip_$cd').innerHTML = '';
?>