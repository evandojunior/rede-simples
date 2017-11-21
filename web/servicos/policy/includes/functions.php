<?php
function arrumadata($data_errada)
 {return implode(preg_match("~\/~", $data_errada) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $data_errada) == 0 ? "-" : "/", $data_errada)));
}
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

/*==================================================================================================*/
function geraCodigo($tratado) {
	$laco = 19-strlen($tratado);
	$zero = "";
	
	for ( $a = 1; $a<=$laco; $a++  ) {
		$zero.=0;
	}
	return $tratado=$zero.$tratado;
}


//Convertendo um dado do tipo DateTime do mysql para o padrão Brasileiro.
function converteData($data_ori,$tipo='BR',$hora='true'){
	$data = explode(' ',$data_ori);
	if ($tipo == 'BR'){
	$resul = explode("-",$data[0]);
	$resul = $resul[2].'/'.$resul[1].'/'.$resul[0];
	}elseif ($tipo == 'EN'){
	$resul = explode("/",$data[0]);
	$resul = $resul[2].'-'.$resul[1].'-'.$resul[0];
	}
	
	if ($hora)
	return $resul.' '.$data[1];
	else
	return $resul;
}

	//Faz um switch para mostrar o mês em português
		function RetornaMes($mes){
			switch($mes){
				case "01" : $mescerto = "Janeiro"; break;
				case "02" : $mescerto = "Fevereiro"; break;
				case "03" : $mescerto = "Março"; break;
				case "04" : $mescerto = "Abril"; break;
				case "05" : $mescerto = "Maio"; break;
				case "06" : $mescerto = "Junho"; break;
				case "07" : $mescerto = "Julho"; break;
				case "08" : $mescerto = "Agosto"; break;
				case "09" : $mescerto = "Setembro"; break;
				case "10" : $mescerto = "Outubro"; break;
				case "11" : $mescerto = "Novembro"; break;
				case "12" : $mescerto = "Dezembro"; break;
				// default: $mescerto = "Não selecionado";
			}
			return($mescerto);
		}
		
	//Faz um switch para mostrar a semana em português
		function RetornaSemana($semana){
			switch($semana){
				case "Monday" 	 : $semanacerta = "Segunda"; break;
				case "Tuesday" 	 : $semanacerta = "Terça"; break;
				case "Wednesday" : $semanacerta = "Quarta"; break;
				case "Thursday"  : $semanacerta = "Quinta"; break;
				case "Friday"	 : $semanacerta = "Sexta"; break;
				case "Saturday"  : $semanacerta = "Sabado"; break;
				case "Sunday" 	 : $semanacerta = "Domingo"; break;
			}
			return($semanacerta);
		}


function redimencionaImg($ImagemOriginal, $IdAuditoria, $diretorio){
	// define a imagem a partir da qual será gerada a minuatura
	//$imagem = "imagem_original.jpg";
	$imagem = $ImagemOriginal;
	
	// **** configurações da miniatura *******
	$tamanho_fixo 	= "N";    // S ou N
	$largura_fixa 	= 192;    // usado somente com tamanho_fixo=S
	$altura_fixa 	= 144;   // usado somente com tamanho_fixo=S
	$percentual 	= 100;     // usado somente com tamanho_fixo=N
	// **************************************
	
	if(!file_exists($imagem)){
		echo "Arquivo da imagem n&atilde;o encontrado!";
		exit;
	}
	if($tamanho_fixo=="N" && ($percentual<1 && $percentual>100)){
		echo "O percentual deve ser um número entre 1 e 100!";
		exit;
	}
	
	// monta o nome do arquivo resultante
	$arquivo_miniatura = explode('.', $imagem);
	$arquivo_miniatura = $diretorio.$IdAuditoria.".png";
	
	// lê a imagem de origem e obtém suas dimensões
	$img_origem = ImageCreateFromPNG($imagem);
	$origem_x = ImagesX($img_origem);
	$origem_y = ImagesY($img_origem);
	
	// se não for tamanho fixo, calcula as dimensões da miniatura
	if($tamanho_fixo=="S"){
		$x = $largura_fixa;
		$y = $altura_fixa;
	}else{
		$x = intval ($origem_x * $percentual/100);
		$y = intval ($origem_y * $percentual/100);
	}
	
	// cria a imagem final, que irá conter a miniatura
	$img_final = ImageCreateTrueColor($x,$y);
	
	// copia a imagem original redimensionada para dentro da imagem final
	ImageCopyResampled($img_final, $img_origem, 0, 0, 0, 0, $x+1, $y+1, $origem_x , $origem_y);
	
	// salva o arquivo
	ImagePNG($img_final, $arquivo_miniatura);
	
	// libera a memória alocada para as duas imagens
	ImageDestroy($img_origem);
	ImageDestroy($img_final);
	
	//return $arquivo_miniatura." (".$x." x ".$y.")";
	return $arquivo_miniatura;
}

//GRAVA URL ASSINCRONA
if (!isset($_SESSION)) {
		  session_start();
}
$UrlAtual = $_SERVER['SCRIPT_NAME'];
$VariaveisUrl = "?1=1";
if(isset($_SESSION["UrlSelecionada"])){
	 $_SESSION["UrlAnterior"] = $_SESSION["UrlSelecionada"];
}
$_SESSION["UrlSelecionada"] = "";

 while(list($key, $value) = each($_GET)){
	$VariaveisUrl .= "&$key=$value";
  } 
$_SESSION["UrlSelecionada"] = $UrlAtual.$VariaveisUrl;

function arrumaDate($data_errada)
 {return implode(preg_match("~\/~", $data_errada) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $data_errada) == 0 ? "-" : "/", $data_errada)));
}

function sec2hms($sec){
	$sinal = '';
	if($sec<0){
		$sec = $sec*(-1);
		$sinal = '-';
	}
		$hms = "";
		$hours = intval(intval($sec) / 3600); 
		$hms .= str_pad($hours, 2, "0", STR_PAD_LEFT). ":";
		$minutes = intval(($sec / 60) % 60); 
		$hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";
		$seconds = intval($sec % 60); 
		$hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
    return $sinal.$hms;
  }
  
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
		
		 case "m": $difere = $segundos/60;    break;
		 case "H": $difere = $segundos/3600;    break;
		 case "h": $difere = round($segundos/3600);    break;
		 case "D": $difere = $segundos/86400;    break;
		 case "d": $difere = round($segundos/86400);    break;
		 case "w": $difere = round($segundos/604800);    break;
		}
	
	return $difere;
}
?>