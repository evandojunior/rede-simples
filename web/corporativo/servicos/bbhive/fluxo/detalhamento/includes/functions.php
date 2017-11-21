<?php

if(!function_exists("retornaData")){
	function retornaData($data){   
		return implode("/",array_reverse(explode("-",$data)));   
	}  
}
	/*function Real($valor){  
		$valorretorno=number_format($valor, 2, ',', '.');  
		return $valorretorno;  
	}*/
if(!function_exists("mysql_date_para_humano")){
	function mysql_date_para_humano($dt) {
		$yr=strval(substr($dt,0,4));
		$mo=strval(substr($dt,5,2));
		$da=strval(substr($dt,8,2));
		$hr=strval(substr($dt,11,2));
		$mi=strval(substr($dt,14,2));
		$se=strval(substr($dt,17,2));
		return date("d/m/Y", mktime ($hr,$mi,$se,$mo,$da,$yr));
	}
}

if(!function_exists("mysql_datetime_para_humano")){
	function mysql_datetime_para_humano($dt) {
		$yr=strval(substr($dt,0,4));
		$mo=strval(substr($dt,5,2));
		$da=strval(substr($dt,8,2));
		$hr=strval(substr($dt,11,2));
		$mi=strval(substr($dt,14,2));
		$se=strval(substr($dt,17,2));
		return date("d/m/Y H:i:s", mktime ($hr,$mi,$se,$mo,$da,$yr));
	}
}
?>