<?php

function calc_idade($nascimento){
	$hoje = date("d-m-Y"); //pega a data d ehoje
	$aniv = explode("-", $nascimento); //separa a data de nascimento em array, utilizando o símbolo de - como separador
	$atual = explode("-", $hoje); //separa a data de hoje em array
	  
	$idade = $atual[2] - $aniv[2];
	
		if($aniv[1] > $atual[1]) //verifica se o mês de nascimento é maior que o mês atual
		{
			$idade--; //tira um ano, já que ele não fez aniversário ainda
		}
		elseif($aniv[1] == $atual[1] && $aniv[0] > $atual[0]) //verifica se o dia de hoje é maior que o dia do aniversário
		{
			$idade--; //tira um ano se não fez aniversário ainda
		}
		return $idade; //retorna a idade da pessoa em anos
} 
function trataEmail($email){
	$email = str_replace("@","_",$email);
	$email = str_replace(".","_",$email);
	return $email;
}

/*========================================================================================================*/
function Diferenca($data1, $data2="",$tipo=""){
	
		if($data2==""){
			$data2 = date("d/m/Y H:i");
		}
		
		if($tipo==""){
			$tipo = "h";
		}
		
		for($i=1;$i<=2;$i++){
		${"dia".$i} = substr(${"data".$i},0,2);
		${"mes".$i} = substr(${"data".$i},3,2);
		${"ano".$i} = substr(${"data".$i},6,4);
		${"horas".$i} = substr(${"data".$i},11,2);
		${"minutos".$i} = substr(${"data".$i},14,2);
		}
		
		$segundos = mktime($horas2,$minutos2,0,$mes2,$dia2,$ano2) - mktime($horas1,$minutos1,0,$mes1,$dia1,$ano1);
		
		switch($tipo){
		 case "s": $difere = $segundos/1; break;				//segundo
		 case "m": $difere = $segundos/60; break;				//minuto
		 case "H": $difere = $segundos/3600; break;				//hora
		 case "h": $difere = round($segundos/3600); break;		//hora
		 case "D": $difere = $segundos/86400; break;   			//dia
		 case "d": $difere = round($segundos/86400); break;   	//dia
		 case "M": $difere = round($segundos/2592000); break;	//mes
		}
	
	return $difere;
}