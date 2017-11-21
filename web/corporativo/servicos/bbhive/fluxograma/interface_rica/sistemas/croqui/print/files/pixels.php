<?php if(!isset($_SESSION)){session_start();}
include($dirOnde."../../../../../../../../../Connections/bbhive.php");
include($dirOnde."../../../../../../includes/functions.php");

function getFileExtension($str) {
			$i = strrpos($str,".");
			if (!$i) { return ""; }
	
			$l = strlen($str) - $i;
			$ext = substr($str,$i+1,$l);
	
			return $ext;
}

	$codUsu				= $_SESSION['usuCod'];
	$codFluxo 			= $_SESSION['bbh_flu_codigo'];
	$Autor				= $_SESSION['usuApelido'];
	$caminhoFisico 		= $_SESSION['caminhoPadraoCroquiBBHIVE'];

	$tipArquivo 		= "jpg";
	$arqTitulo			= "CROQUI";
	$localizacao		= "/fluxo/fluxo_".$codFluxo."/arquivos";
	$dataModificado 	= date("Y-m-d H:i:s");
	$Descricao			= "Croqui";
	$obsAqrPublico		= "Observação Croqui";
	$nomeArquivo 		= "croqui_";
	$mimeType			= "application/octet-stream";
	$nmArquivoLogic		= "croqui_";


 ini_set("display_errors","on");
//error_reporting(0);
/**
 * Get the width and height of the destination image
 * from the POST variables and convert them into
 * integer values
 */
$w = (int)$_POST['width'];
$h = (int)$_POST['height'];

// create the image with desired width and height

$img = imagecreatetruecolor($w, $h);

// now fill the image with blank color
// do you remember i wont pass the 0xFFFFFF pixels 
// from flash?
imagefill($img, 0, 0, 0xFFFFFF);

$rows = 0;
$cols = 0;

// now process every POST variable which
// contains a pixel color
for($rows = 0; $rows < $h; $rows++){
	// convert the string into an array of n elements
	$c_row = explode(",", $_POST['px' . $rows]);
	for($cols = 0; $cols < $w; $cols++){
		// get the single pixel color value
		$value = $c_row[$cols];
		// if value is not empty (empty values are the blank pixels)
		if($value != ""){
			// get the hexadecimal string (must be 6 chars length)
			// so add the missing chars if needed
			$hex = $value;
			while(strlen($hex) < 6){
				$hex = "0" . $hex;
			}
			// convert value from HEX to RGB
			$r = hexdec(substr($hex, 0, 2));
			$g = hexdec(substr($hex, 2, 2));
			$b = hexdec(substr($hex, 4, 2));
			// allocate the new color
			// N.B. teorically if a color was already allocated 
			// we dont need to allocate another time
			// but this is only an example
			$test = imagecolorallocate($img, $r, $g, $b);
			// and paste that color into the image
			// at the correct position
			imagesetpixel($img, $cols, $rows, $test);
		}
	}
}

if(!isset($_SESSION['caminhoPadraoCroquiBBHIVE'])){
	// print out the correct header to the browser
	header("Content-type:image/jpeg");
	// display the image
	imagejpeg($img, "", 90);
	exit;
	
} else {
	$destinoImagem 	= $_SESSION['caminhoPadraoCroquiBBHIVE'];

	//--Fazer inserção na tabela de arquivos
	$insertSQL = sprintf("INSERT INTO bbh_arquivo (bbh_arq_autor, bbh_arq_descricao,bbh_arq_localizacao, bbh_arq_data_modificado, bbh_arq_versao, bbh_usu_codigo, bbh_flu_codigo, bbh_arq_compartilhado, bbh_arq_nome,bbh_arq_tipo, bbh_arq_titulo, bbh_arq_nome_logico,bbh_arq_mime) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
								   GetSQLValueString($Autor, "text"),
								   GetSQLValueString($Descricao, "text"),
								   GetSQLValueString($localizacao, "text"),
								   GetSQLValueString($dataModificado, "date"),
								   GetSQLValueString(1, "int"),
								   GetSQLValueString($codUsu, "int"),
								   GetSQLValueString($codFluxo, "int"),
								   GetSQLValueString(1, "int"),
								   GetSQLValueString($nomeArquivo, "text"),
								   GetSQLValueString($tipArquivo, "text"),
								   GetSQLValueString($arqTitulo, "text"),
								   GetSQLValueString($nmArquivoLogic, "text"),
								   GetSQLValueString($mimeType, "text"));

    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
	//
	//--Recupera o id do registro inserido
	$id = mysqli_insert_id($bbhive);
	
	//--Substitui XXXXXX pelo código do registro
	$destinoImagem 	= str_replace("XXXXXX",$id,$_SESSION['caminhoPadraoCroquiBBHIVE']);

	// Update do arquivo
		$updateSQL = "UPDATE bbh_arquivo SET bbh_arq_nome = '$nomeArquivo$id.jpg', bbh_arq_nome_logico = '$nmArquivoLogic$id.jpg' WHERE bbh_arq_codigo = $id";
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);

	//ImagePNG($img, $destinoImagem.$nomeImagem, 9);
	ImagePNG($img, $destinoImagem, 5);
	//--
	if(!file_exists($destinoImagem)){
		$erro = 1;
	}
	?>
	<script type="text/javascript">
	<?php if(!isset($erro)){ $_SESSION['edicao_croqui'] = '1'; ?>
		window.top.window.msgFinalizado();
	<?php } else { ?>
		alert('Falha ao gerar arquivo!!!');
	<?php } ?>
	</script>
<?php } ?>