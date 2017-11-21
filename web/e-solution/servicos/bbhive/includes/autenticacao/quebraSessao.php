<?php
/*Quebra Sessão Credencial=================================================================================*/
	function destroiCredencial($dir){
		function trataEmail($email){
			$email = str_replace("@","_",$email);
			$email = str_replace(".","_",$email);
			return $email;
		}
		require_once($dir);
		set_time_limit(0);
		$http=new http_class;
		$http->timeout=0;
		$http->data_timeout=0;
		$http->debug=0;
		$http->html_debug=1;
	
		$url= $_SESSION['EndURL_BBPASS']."/servicos/bbpass/credencial/gerencia_credencial/destroi_credencial.php?TS=".$_SERVER['REQUEST_TIME'];
		
		$error=$http->GetRequestArguments($url,$arguments);
		$arguments["RequestMethod"]	= "POST";
		$arguments["PostValues"]	= array("idLockLiberado"=>"","email"=>trataEmail(@$_SESSION['MM_Email_Padrao']));
		$arguments["Referer"]		= "";
		flush();
		$error=$http->Open($arguments);
	
		if($error==""){
			$error=$http->SendRequest($arguments);
		}
				for(;;){
						$error=$http->ReadReplyBody($body,30000);
						if($error!=""|| strlen($body)==0)
							break;
						return $body;
				}
					flush();
		if(strlen($error))
			//echo "<span class='verdana_11 color'>Erro inesperado, tente novamente!</span>";
		
		return $body;
	}
?>