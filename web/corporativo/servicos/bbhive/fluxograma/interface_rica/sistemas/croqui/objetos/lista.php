<?php if(!isset($_SESSION)){ session_start(); }
//Responde em XML para montar a palheta
 	function listaDiretorios($dir){
		$resultado = array();
	   // atribui o valor de $dir para $file em loop 
	   foreach($dir as $file ){
		 // verifica se o valor de $file é diferente de '.' ou '..'
		 // e é um diretório (isDir)
		 if (!$file->isDot() && $file->isDir()){
		// atribuição a variável $dname
			$dname = $file->getFilename();
			// imprime o nome do diretório
			$resultado[$dname]['pequeno'] = @listaArquivos($dir .'/'. $diretorio . 'pequeno/');
			$resultado[$dname]['grande']  = @listaArquivos($dir .'/'. $diretorio . 'grande/');
			ksort($resultado); 
		 }
	   }
	   //--
	   return $resultado;
	}
	//--
	function listaArquivos($diretorio) {
		$resultado = array();
		if (is_dir($diretorio)) {
			if ($dir = opendir($diretorio)) {
				while(false !== ($arq = readdir($dir))) {
					if (is_file($diretorio . $arq)) {
						 $resultado[$arq] = $diretorio . $arq;
					}
				}
				ksort($resultado);
			}
		}
	 return $resultado;	
	}
//-------------------------------------------------------------------------------------
   // atribuição a variável $dir
   $dir 				= new DirectoryIterator( str_replace("\\","/",dirname(__FILE__)) );
   $res 				= listaDiretorios($dir);
   //--
//-------------------------------------------------------------------------------------
	echo '<?xml version="1.0" encoding="iso-8859-1"?>';
	echo '<objetos>';
	//--
	$c = 1; $a=0;
		foreach($res as $i => $v){
			echo '<no nome="'.$i.'">';
			//--
				foreach($v as $m => $k){
					echo '<elemento nome="'.$m.'">';
					//--
					 
						foreach($k as $y => $z){
							echo '<swf_'.$c.' id="'.$c.'" nome="'.$y.'" caminho="'.$z.'" />';
							$c++;
						}
					//--
					echo '</elemento>';
				}
			//--
			echo '</no>';
			$a++;
		}
	//--
	echo '</objetos>';

?>