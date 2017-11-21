<?php if(!isset($_SESSION)){ session_start(); }
/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
$bbh_par_titulo = $_POST['bbh_par_titulo'];
	if(empty($bbh_par_titulo)){
		echo mysqli_fetch_assoc('<script type="text/javascript">alert(\'Informe o tÃ­tulo deste parÃ¡grafo.\');</script>');
	  exit;
	}
//se o cÃ³digo do relatÃ³rio estiver na sessÃ£o Ã© ediÃ§Ã£o senÃ£o inserÃ§Ã£o
	if(isset($_SESSION['bbh_par_codigo']) && !empty($_SESSION['bbh_par_codigo'])){
		$bbh_par_codigo = $_SESSION['bbh_par_codigo']; 
	} else {
		$insert = true;
	}

require_once("../../../relatorios/painel/paragrafos/executaEditor.php");	
exit;
//===================================================================================
if ( isset( $_POST ) )
	$postArray = &$_POST ;			// 4.1.0 or later, use $_POST
else
	$postArray = &$HTTP_POST_VARS ;	// prior to 4.1.0, use HTTP_POST_VARS

foreach ( $postArray as $sForm => $value )
{
	if ( get_magic_quotes_gpc() )
		$postedValue = ( ( $value ) ) ;
	else
		$postedValue = ( $value ) ;
}
		$urlFisico = "../../../../../../datafiles/servicos/bbhive/modelo.html";
		$file = fopen($urlFisico, "w");//abre o arquivo
		$escreve = fwrite($file, $postedValue); //escreve no arquivo
		fclose($file);//fecha o arquivo

echo "JÃ CRIEI O ARQUIVO EMERSON!<hr>";
echo '<a href="/datafiles/servicos/bbhive/modelo.html" target="_blank">Visualizar arquivo</a><br>';
echo 'URL: http://projeto12.backsitecom.br/datafiles/servicos/bbhive/modelo.html';

exit;
?>