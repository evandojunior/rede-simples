<?php
ini_set("display_errors",true);

$thisPath	= strtolower(__FILE__);
$thisPath	= str_replace('\\','/', $thisPath);
$thisPath	= explode('web', $thisPath);
$thisPath	= (string) array_shift($thisPath);
$thisPath	= rtrim( $thisPath, '/') .'/';
$pathTmp	= $thisPath.'web/datafiles/servicos/bbpass/tema/tmp';
$pathOrigem	= $thisPath.'database/servicos/bbpass/tema/temas';
$arqOrigem	= $pathOrigem . '/' . preg_replace('/[^a-zA-Z0-9_\.]/', '_',$_GET['arquivo']);

//-- Verifica se existe a pasta temas
if(!file_exists($pathTmp ) )
	mkdir( $pathTmp, 0777, true );	

@chmod( $pathTmp, 0777 );

$temas_files = glob($pathTmp.'/'.'*.zip');
	foreach($temas_files as $temas){
		if(round(((time() - filemtime($temas))/60)/60) >=2 ){
			unlink($temas);
	}
}

copy($arqOrigem, $pathTmp . '/' . $_GET['arquivo']);
header("Location: /datafiles/servicos/bbpass/tema/tmp/" . $_GET['arquivo']);
?>