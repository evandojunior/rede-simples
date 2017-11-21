<?php
/**
* Include que deve ser incluido no cabeçalho de cada arquivo php,
* Possui funções para tratar erros.
*
* @author Gregui Shigunov
* @since 01/08/2007
*/

/**
* Função executada a cada excessão levantada no PHP
*
* @param int $err_no
* @param String $err_desc
* @param String $err_file
* @param int $err_line
*/
function salvarErro($err_no, $err_desc, $err_file, $err_line) {
	$d 		= explode("web",str_replace("\\","/",strtolower(dirname(__FILE__))));
	$apl 	=  resolveDiretorio($d[1]);
	$d 		= $d[0]."web/datafiles/servicos/".$apl;
/*
1 E_ERROR
2 E_WARNING
4 E_PARSE
8 E_NOTICE
16 E_CORE_ERROR
32 E_CORE_WARNING
64 E_COMPILE_ERROR
128 E_COMPILE_WARNING
256 E_USER_ERROR
512 E_USER_WARNING
1024 E_USER_NOTICE
2047 E_ALL
2048 E_STRICT
*/
	if ($err_no != 2048) {
		//logar($arquivo, "$t  $err_no: $err_desc, file:$err_file, linha $err_line \n");
		logar($apl, $d, date("d/m/Y H:i:s") . " ($apl) $err_no: $err_desc, file:$err_file, linha $err_line");
	}
}

/**
* Loga as informações no arquivo txt
*
* @param String $strQuery
* @return Array com objetos de retorno da consulta
*/
function logar($apl, $d, $strTexto) {
	$t = date("H:i:s");

	//chmod ($d."/log.txt", 0777);
	$arquivo = fopen($d."/log.txt","a");
	fwrite($arquivo, $strTexto."<br>\r\n");
	fclose($arquivo);
	//--
	echo "<script type='text/javascript'>alert('Ocorreu um erro inesperado, consulte o arquivo de log.');</script>";
	echo "<var style='display:none'>alert('Ocorreu um erro inesperado, consulte o arquivo de log.');</var>";
	echo "<a href='/datafiles/servicos/".$apl."/log.txt' target='_blank'>Clique aqui para consultar o arquivo de log!</a>";
	exit;
}

// Tipos de erros que serão tratadas
/*error_reporting (E_ALL);

//informa qual o método que irá tratar as excessões levantadas pelo php
set_error_handler ("salvarErro");*/

?>
