<?php
require_once('../../../../Connections/bbhive.php');
require_once('../../includes/functions.php');

$colname_arquivo = "-1";
if (isset($_GET['file'])) {
  $colname_arquivo = $_GET['file'];
}
$query_arquivo = sprintf("SELECT * FROM bbh_arquivo WHERE bbh_arq_codigo = %s", GetSQLValueString($bbhive, $colname_arquivo, "int"));
list($arquivo, $row_arquivo, $totalRows_arquivo) = executeQuery($bbhive, $database_bbhive, $query_arquivo);

$localizacao_documento =  explode("web",$_SESSION['caminhoFisico']);
$path = $localizacao_documento[0];

$codigo_usuario = $_SESSION['usuCod'];
$origem = $path."database/servicos/bbhive" . $row_arquivo['bbh_arq_localizacao'] ."/". ($row_arquivo['bbh_arq_nome']); 
$nome_arquivo = $row_arquivo['bbh_arq_nome'];

//PROCEDIMENTO DE DUPLICAÇÃO DE ARQUIVO PARA DOWNLOAD PELO WEBSERVICE - APACHE/IIS
	//verifica se tem a pasta temp no datafiles
	$destino = $path."web/datafiles/servicos/bbhive/temp_transf";
		if(!file_exists($destino)){
			mkdir($destino,777);
			chmod($destino,0777);
		}
	//verifica se tem a pasta do usuário criada
	$destino.= "/".$_SESSION['MM_BBhive_Codigo'];
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
		$destino = $destino."/".($nome_arquivo);
		copy($origem, $destino);
		//REDIRECIONA PARA DOWNLOAD DO ARQUIVO
		header("Location: /datafiles/servicos/bbhive/temp_transf/".$_SESSION['MM_BBhive_Codigo']."/".($nome_arquivo));
//=====================================================================================		

mysqli_free_result($arquivo);
?>