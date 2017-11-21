<?php
if(!isset($_SESSION)){ session_start(); } 
 include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
 include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
 include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
//--
	
//function upload($campo, $arquivo, $maximo = 5242880, $permitidos = array())
function upload($campo, $database_bbhive, $bbhive , $maximo = 99999999999999999, $permitidos = array())
{
	$tmp_name 		= $campo['tmp_name'];
	$error    		= $campo['error'];
	$size     		= $campo['size'];
	$type     		= $campo['type'];
	$bbh_rel_codigo	= $_SESSION['upl_rel_codigo'];
	$bbh_flu_codigo	= $_SESSION['upl_flu_codigo'];
	$bbh_par_momento= date('Y-m-d');
	$bbh_par_autor	= $_SESSION['usuNome'];
	$tmpMax 		= ini_get('max_execution_time');
	//--------------------------------------
	$localizacao_documento = explode("web",$_SESSION['caminhoFisico']);
	//--
	$diretorio = $localizacao_documento[0] . "database/servicos/bbhive/fluxo/fluxo_".$bbh_flu_codigo;
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
	$diretorio.= "/documentos";
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
	$diretorio.= "/".$bbh_rel_codigo;
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	//--------------------------------------
	
	if ((!is_uploaded_file($tmp_name)) || ($error != 0) || ($size == 0) || ($size > $maximo))
		return false; // Não passou pela validação básica

	if ((is_array($permitidos)) && (!empty($permitidos))) {
		if (!in_array($type, $permitidos))
			return false; // tipo de arquivo nÃ£o permitido
	}
	
	//seleciona ordenação do modelo
		$query_ordenacao_paragrafos = "SELECT MAX(bbh_par_ordem) ultimo_paragrafo FROM bbh_paragrafo WHERE bbh_rel_codigo = $bbh_rel_codigo";
    	list($ordenacao_paragrafos, $row_ordenacao_paragrafos, $totalRows_ordenacao_paragrafos) = executeQuery($bbhive, $database_bbhive, $query_ordenacao_paragrafos);
		$ordenacao = $row_ordenacao_paragrafos['ultimo_paragrafo']+1;
	
	//-- INSERE PARAGRÁFO SÓ PARA SABER O ID DO REGISTRO
		$insertSQL = "INSERT INTO bbh_paragrafo (bbh_rel_codigo, bbh_par_ordem, bbh_par_momento, bbh_par_autor) VALUES ($bbh_rel_codigo, $ordenacao ,'$bbh_par_momento','$bbh_par_autor')";
    	list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);

	//-- RECUPERA O ID DO REGISTROS PARA NOMEAR O ARQUIVO
		$query_Par = "select bbh_par_codigo from bbh_paragrafo Where bbh_par_codigo = LAST_INSERT_ID()";
    	list($Par, $row_Par, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_Par);
		$bbh_par_codigo = $row_Par['bbh_par_codigo'];
	//--
		preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf){1}$/i", $campo["name"], $ext);
        // Gera um nome único para a imagem
		$nmImage			= (str_replace($ext[0],"",$campo["name"]));
		$nm					= $nmImage;
		//--
		$bbh_par_titulo		= trataCaracteres($nmImage);
		$bbh_par_nmArquivo	= $bbh_par_titulo. "." . $ext[1];
		$bbh_par_arquivo 	= $bbh_par_codigo. "." . $ext[1];
		$bbh_par_legenda	= $nmImage;
		//---------------------------------
		$diretorio  .= "/".$bbh_par_arquivo;
	//--
		$nmImage			= isset($_SESSION['arquivos_externos']) ? "Bl@ck_arquivo_ANEXO*~" : $nmImage;
		$parParagrafo		= isset($_SESSION['arquivos_externos']) ? $nm : ''; 
		$bbh_par_tipo_anexo	= isset($_SESSION['arquivos_externos']) ? $ext[1].".gif" : ''; 
	//--
		$updateSQL = "UPDATE bbh_paragrafo SET bbh_par_titulo='".$nmImage."', bbh_par_nmArquivo='".$bbh_par_arquivo."', bbh_par_arquivo='$bbh_par_arquivo',bbh_par_paragrafo='$parParagrafo', bbh_par_legenda='$bbh_par_legenda', bbh_par_tipo_anexo='$bbh_par_tipo_anexo' WHERE bbh_par_codigo = $bbh_par_codigo";
    	list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
		
	// faz upload
	$c=0;
		
	while (move_uploaded_file($tmp_name, $diretorio)) {
		// aguarda o envio...
				if($c == 30){
					$tmpMax = $tmpMax + 1;
					set_time_limit($tmpMax);
					$c = -1;
				}
				$c++;
	}

	return true;
}

$campo   = $_FILES['file'];// $_FILES['Filedata'];
//$arquivo = "uploads/".$campo['name'];

//echo upload($campo, $arquivo, $database_bbhive, $bbhive);
echo upload($campo, $database_bbhive, $bbhive);
?>
