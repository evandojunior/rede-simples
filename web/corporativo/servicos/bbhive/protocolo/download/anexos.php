<?php
 if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

$localizacao_documento =  explode("web",$_SESSION['caminhoFisico']);
$path = $localizacao_documento[0];

$codigo_usuario = $_SESSION['usuCod'];
$nome_arquivo 	= $_POST['bbh_pro_arquivo'];
$origem 		= $path. "database/servicos/bbhive/protocolo/protocolo_".$_POST['bbh_pro_codigo']."/".$nome_arquivo; 

//PROCEDIMENTO DE DUPLICAÇÃO DE ARQUIVO PARA DOWNLOAD PELO WEBSERVICE - APACHE/IIS
	//verifica se tem a pasta temp no datafiles
	$destino = $path."web/datafiles/servicos/bbhive/temp_transf";
		if(!file_exists($destino)){
			mkdir($destino,777);
			chmod($destino,0777);
		}
	//verifica se tem a pasta do usuário criada
	$destino.= "/".$_SESSION['usuCod'];
		if(!file_exists($destino)){
			mkdir($destino,777);
			chmod($destino,0777);
		} else {
		//REMOVE TODOS OS ARQUIVOS DESTE DIRETÓRIOS INCLUSIVE ELE MESMO
		$dirname = $destino;
		   $result=array();
			   if (substr($dirname,-1)!='/') {$dirname.='/';}    //Append slash if necessary
			   $handle = opendir($dirname);
			   while (false !== ($file = readdir($handle))) {
				   if ($file!='.' && $file!= '..') {    //Ignore . and ..
					   $path = $dirname.$file;
					   if (is_dir($path)) {    //Recurse if subdir, Delete if file
						   $result=array_merge($result,rmdirtree($path));
					   }else{
						   unlink($path);
						   $result[].=$path;
					   }
				   }
			   }
			   closedir($handle);
			   rmdir($dirname); 
		//=========================================
			mkdir($destino,777);
			chmod($destino,0777);
		}
		
		//COPIA O ARQUIVO DE ORIGEM PARA O DESTINO
		$destino = $destino."/".strtolower($nome_arquivo);
		
		copy($origem, $destino);

		//REDIRECIONA PARA DOWNLOAD DO ARQUIVO
		header("Location: /datafiles/servicos/bbhive/temp_transf/".$_SESSION['usuCod']."/".strtolower($nome_arquivo));
//=====================================================================================		

mysql_free_result($arquivo);
?>