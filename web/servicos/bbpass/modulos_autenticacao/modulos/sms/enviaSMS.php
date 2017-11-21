<?php
if(!isset($_SESSION)){session_start();}

	$sessao 	= session_id();
	$novachave  = substr($sessao,1,8);
	//prepara os parâmetros e coloca a chave no banco de dados
	$codigo    = $row_Login['bbp_adm_lock_sms_codigo'];
	$updateSQL = "UPDATE bbp_adm_lock_sms SET bbp_adm_lock_sms_chave = '$novachave' WHERE bbp_adm_lock_sms_codigo =".$row_Login['bbp_adm_lock_sms_codigo'];
    list($Result1, $row, $totalRows) = executeQuery($bbpass, $database_bbpass, $updateSQL);
	
	//função de envio do sms
	/*function SendSMS ($host, $port, $username, $password, $phoneNoRecip, $msgText) { 
		$fp = fsockopen($host, $port, $errno, $errstr);
		if (!$fp) {
		 //echo "errno: $errno \n";
		 //echo "errstr: $errstr\n";
			return $result;
		}
		fwrite($fp, "GET /PhoneNumber=" . rawurlencode($phoneNoRecip) . "&Text=" . rawurlencode($msgText) . " HTTP/1.0\n");
		//echo $aux3;
		if ($username != "") {
		   $auth = $username . ":" . $password;
	 //echo "auth: $auth\n";
		   $auth = base64_encode($auth);
	 //echo "auth: $auth\n";
		   fwrite($fp, "Authorization: Basic " . $auth . "\n");
		}
		fwrite($fp, "\n");
	  
		$res = "";
	 
		while(!feof($fp)) {
			$res .= fread($fp,1);
		}
		fclose($fp);
		return $res;
		//return $enviado;
	}*/

	//envia chave por SMS
	//SendSMS($ipAcessoSMS, 8800, "", "", $row_Login['bbp_adm_lock_sms_celular'], $novachave);
	function envia_dados($url, $dadosPost)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$dadosPost);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER,0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		//
		$data = curl_exec($ch);
		$curl_errno = curl_errno($ch);
		$curl_error = curl_error($ch);
		curl_close($ch);
		//--
		if($curl_errno > 0){
			$_SESSION['error'] = $curl_errno;
			return $curl_error;	
		} else {
			return $data;
		}
		//--
	}
	//--
	// Prepara as informações
	$variaveis = array( "destino=".$row_Login['bbp_adm_lock_sms_celular'],
						"mensagem=".$novachave );
						
	// Envia
	$resultado 		= envia_dados($ipAcessoSMS, join("&", $variaveis));
	
	//$enviado = 1;
	$enviado = $resultado;
	//nega autenticidade do usuário