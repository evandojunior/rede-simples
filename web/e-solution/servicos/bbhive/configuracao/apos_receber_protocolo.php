<?php
//Pasta que devo procurar
$pasta = explode("e-solution",str_replace("\\","/",dirname(__FILE__)));
$pasta = $pasta[0]."/servicos/bbhive/protocolos/execucao_automatica/";
//--
$arquivosExecucao = array();
//--
if(file_exists($pasta)){
		if ($handle = opendir($pasta)) {
		   //varre diretório em busca de arquivos
			while (false !== ($file = readdir($handle))) {
				$extensao[strtolower(strrchr($file, "."))] = 1; 
				if ($file != "." && $file != "..") {
				 $tam = strlen($file);
					//ext de 3 chars
					if( $file[($tam)-4] == '.' ){
						$extensao = substr($file,-3);
					}
					//verifica os diretorios
					$diretorio = $file;
					//--
						//verifica se existe o arquivo titulo e executa
						if(file_exists($pasta.$diretorio."/executa.php") && file_exists($pasta.$diretorio."/titulo.php")){
							//--
							include($pasta.$diretorio."/titulo.php");
							//--
							$arquivosExecucao[$diretorio] = $titulo;
						}
				}
			}
		 closedir($handle);
		}
}
//--
natcasesort($arquivosExecucao);	?>