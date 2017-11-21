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