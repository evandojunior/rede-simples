<?php
require_once("../../../../Connections/policy.php");

if($_SERVER['QUERY_STRING']!=""){
	$getURL = base64_decode($_SERVER['QUERY_STRING']);
		if(strpos($getURL,"email")>=0){
			$url   = explode("&",$getURL);	
			$url   = explode("=",$url[0]);
			$email = $url[1];
			
			$qt = explode("&",$getURL);	
			$qt = explode("=",$qt[1]);
			$qt	= $qt[1];

				$Sql = "SELECT date_format(pol_aud_momento,'%d/%m/%Y %H:%i:%s') AS momento, pol_aud_usuario, pol_aud_acao, pol_aud_ip, pol_aud_nivel, pol_aud_relevancia, pol_aud_codigo, pol_apl_nome FROM pol_auditoria RIGHT JOIN pol_aplicacao ON pol_auditoria.pol_apl_codigo = pol_aplicacao.pol_apl_codigo WHERE pol_aud_usuario = '$email' ORDER BY pol_aud_momento DESC LIMIT $qt,20";
				
				mysql_select_db($database_policy, $policy);
				$query_detalhegeral = $Sql;
				$detalhegeral = mysql_query($query_detalhegeral, $policy) or die(mysql_error());
				$row_detalhegeral = mysql_fetch_assoc($detalhegeral);
				$totalRows_detalhegeral = mysql_num_rows($detalhegeral);
				$totReg	= $totalRows_detalhegeral;

				function anteriorProximo($database_policy, $policy, $email){
						$Sql 	= "SELECT count(pol_aud_codigo) as total FROM pol_auditoria RIGHT JOIN pol_aplicacao ON pol_auditoria.pol_apl_codigo = pol_aplicacao.pol_apl_codigo WHERE pol_aud_usuario = '$email' ORDER BY pol_aud_momento";
						
						mysql_select_db($database_policy, $policy);
						$query_detalhegeral = $Sql;
						$detalhegeral = mysql_query($query_detalhegeral, $policy) or die(mysql_error());
						$row_detalhegeral = mysql_fetch_assoc($detalhegeral);
						$totalRows_detalhegeral = mysql_num_rows($detalhegeral);
						return $row_detalhegeral['total'];
				}
				
				if($totalRows_detalhegeral>0){
					//cria XML de resposta
					$doc = new DOMDocument("1.0", "iso-8859-1"); 
					$doc->preserveWhiteSpace = false; //descartar espacos em branco    
					$doc->formatOutput = false; //gerar um codigo bem legivel 
					
					$root = $doc->createElement('auditoria');//cria elemento pai de todos
					$root->setAttribute("total", anteriorProximo($database_policy, $policy, $email));

						do{
							//adiciona Noh
							$auditoria = $doc->createElement('logs');//cria elemento pai de todos
							$auditoria->setAttribute("pol_aud_codigo", $row_detalhegeral['pol_aud_codigo']);
							$auditoria->setAttribute("pol_apl_nome", utf8_encode($row_detalhegeral['pol_apl_nome']));
							$auditoria->setAttribute("momento", $row_detalhegeral['momento']);
							$auditoria->setAttribute("ip", $row_detalhegeral['pol_aud_ip']);
							$auditoria->setAttribute("pol_aud_acao", utf8_encode($row_detalhegeral['pol_aud_acao']));
							
							$root->appendChild($auditoria);
							
						} while ($row_detalhegeral = mysql_fetch_assoc($detalhegeral));
					
					$doc->appendChild($root);//adiciona noh no objeto XML	
					echo $doc->saveXML();
				}
		}
}
?>