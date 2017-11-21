<?php
//REMOVE OS ARQUIVO CRIADOS A MAIS DE 5 MINUTOS, ISTO É REGRA
function removeFiles($diretorio){
	$caminho = $diretorio;
	 //verifica se é possível abrir diretório
		if ($handle = opendir($caminho)) {
		   //varre diretório em busca de arquivos
			while (false !== ($file = readdir($handle))) {
				$extensao[strtolower(strrchr($file, "."))] = 1; 
				if ($file != "." && $file != "..") {
				 $tam = strlen($file);
					//ext de 3 chars
					if( $file[($tam)-4] == '.' ){
						$extensao = substr($file,-3);
					}
					
					//verifica os arquivos com mais de 5 minutos e exclui
					$data1 = date("d/m/Y H:i", filemtime($caminho."\\".$file));
					$data2 = date("d/m/Y H:i");//"04/02/2006 11:30";
					
					//chama função e verifica diferenca de datas
					$Tempo = Diferenca($data1,$data2,"m"); 
						//remove arquivo maior que 5 minutos
						if($Tempo>5){
							//unlink($caminho."\\".$file);
							@chmod($caminho, 0777);
							@unlink($caminho . $file);
						}
						//echo date ("H:i:s", filemtime($caminho."\\".$file))."<hr>";
					}
			}
		 closedir($handle);
		}
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
		}
	
	return $difere;
}
?>