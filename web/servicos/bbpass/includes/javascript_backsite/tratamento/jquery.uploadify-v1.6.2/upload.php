<?php if(!isset($_SESSION)){session_start();}
// Uploadify v1.6.2
// Copyright (C) 2009 by Ronnie Garcia
// Co-developed by Travis Nickels
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	
	//diretorio
	$diretorio = explode("web",str_replace("\\","/",dirname(__FILE__)));
	$diretorio = $diretorio[0]."web/datafiles/servicos/bbpass/images/usuarios";
	
	if(!file_exists($diretorio)){
		mkdir($diretorio,777);
		chmod($diretorio,0777);
	}

	$diretorio.= "/".$_SESSION['MM_BBpass_Codigo'];
	
	if(!file_exists($diretorio)){
		mkdir($diretorio,777);
		chmod($diretorio,0777);
	}
	
	//$targetFile = $diretorio ."/". $_FILES['Filedata']['name'];
	$targetFile = $diretorio ."/". $_SESSION['MM_BBpass_Codigo'].".jpg";
	// Uncomment the following line if you want to make the directory if it doesn't exist
	// mkdir(str_replace('//','/',$targetPath), 0755, true);
	
	move_uploaded_file($tempFile,$targetFile);
}
echo "1";
?>