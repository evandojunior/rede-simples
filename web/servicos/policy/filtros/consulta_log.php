<?php
if(isset($_POST['pol_aud_codigo']) && $_POST['pol_aud_codigo'] != ""){
	//adiciona linha de conexão com o banco de dados
	require_once("../../../../Connections/policy.php");
	
	$pol_aud_codigo = $_POST['pol_aud_codigo'];
	  //verifica se o código existe;
		///FAZER SELECT MYSQL
	mysql_select_db($database_policy, $policy);
	$query_infoEvento = "SELECT pol_aplicacao.pol_apl_codigo, pol_aplicacao.pol_apl_nome, pol_aud_codigo FROM pol_aplicacao
INNER JOIN pol_auditoria ON pol_aplicacao.pol_apl_codigo = pol_auditoria.pol_apl_codigo
WHERE pol_aud_codigo = " . $pol_aud_codigo ;
	$infoEvento = mysql_query($query_infoEvento, $policy) or die(mysql_error());
	$row_infoEvento = mysql_fetch_assoc($infoEvento);
	$totalRows_infoEvento = mysql_num_rows($infoEvento);
		//se existir monta url com parâmetros
		if($totalRows_infoEvento > 0){//TOTAL ROWS
			$url = "/e-solution/servicos/policy/detalhes/regra.php?pol_apl_nome=".$row_infoEvento['pol_apl_nome']."&pol_apl_codigo=".$row_infoEvento['pol_apl_codigo']."&impressao=true&impressaodet=".$pol_aud_codigo;
			header("Location:".$url);
		}else{
			//senão
			header("Location:".$_POST['url']."&msg=false");
		}
		
}else{
	header("Location: /e-solution/servicos/policy/index.php");
}
?>