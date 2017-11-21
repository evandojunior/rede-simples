<?php
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

echo '<div style="display:none">';
		require_once("../../../includes/pdf_to_html/public_html/demo/index.php");
echo '</div>';
echo '<script>document.convertePDF.submit();</script>';
?>
