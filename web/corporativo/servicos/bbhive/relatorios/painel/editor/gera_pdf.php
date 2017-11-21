<?php
ob_start();
$espaco = $_POST['superior'];

ini_set('memory_limit', '256M');

 define('MPDF_PATH', '');
 //define ('_MPDF_TEMP_PATH', 'tmp');
 include(MPDF_PATH.'../../../includes/HTML_PDF/mpdf.php');
// inclui a classe

	$orientacao = $_POST['orientacao'];

	if($orientacao == "L"){
    	$mpdf = new  mPDF('','A4-L', 0, '', $_POST['esquerda'], $_POST['direita'], $espaco , $_POST['inferior'], 9, 9, 'L');
	} else {
    	$mpdf = new  mPDF('','A4', 0, '', $_POST['esquerda'], $_POST['direita'], $espaco , $_POST['inferior'], 9, 9, 'P');
	}
  //}
// cria o objeto
$mpdf->allow_charset_conversion		= true;
//$mpdf->displayDefaultOrientation 	= true;
// permite a conversao (opcional)
$mpdf->charset_in='UTF-8';
// converte todo o PDF para utf-8
//$mpdf->useSubstitutionsMB = true;
$mpdf->showImageErrors = true;		
	//inclui a página com contéudo html
	require_once("gera.php");
	//--
	if(!empty($conteudo)){//está variável está em gera.php
		$mpdf->Output($diretorioDestino.'rel_'.$bbh_rel_codigo.'_'.trataCaracteres(strtolower($_SESSION['relNome'])).'.pdf', 'F');
	}
	//$mpdf->Output($diretorioDestino.'rel_cruz.pdf', 'F');
	//exit;
?>