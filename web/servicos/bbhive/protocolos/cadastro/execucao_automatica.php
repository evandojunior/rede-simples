<?php
	$arquivo = $_SESSION['caminhoFisico']."/datafiles/servicos/bbhive/setup/config.xml";
	if(file_exists($arquivo)){
		$doc = new DOMDocument("1.0", "iso-8859-1"); 
		$doc->preserveWhiteSpace = false; //descartar espacos em branco    
		$doc->formatOutput = false; //gerar um codigo bem legivel   
		$doc->load($arquivo);
		//-----	
		$root = $doc->getElementsByTagName("config")->item(0);
		$prot = $root->getElementsByTagName("protocolo")->item(0);
		//-----
		$aposReceber		= $prot->getAttribute("aposreceber");
		//--
			//Pasta que devo procurar
			$pasta = explode("servicos",str_replace("\\","/",dirname(__FILE__)));
			$pasta = $pasta[0]."servicos/bbhive/protocolos/execucao_automatica/";
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
								if(($diretorio == $aposReceber) && !isset($_GET['cadastroManual'])){
									//verifica se existe o arquivo titulo e executa
									if(file_exists($pasta.$diretorio."/executa.php") && file_exists($pasta.$diretorio."/titulo.php")){
										//--
										include($pasta.$diretorio."/titulo.php");
										//--
										$arquivosExecucao[$diretorio] = $titulo;
									}
									require_once($pasta.$diretorio."/executa.php");
								  exit;
								}
							}
						}
					 closedir($handle);
					}
			}
			//--
		//--
	}
?>