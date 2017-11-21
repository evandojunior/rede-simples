<?php
ob_start();
$espaco = $_POST['superior'];

isset($_POST['chk_cabecalho']) ? $cabeca=true : "";
$espaco = $_POST['superior'];
isset($_POST['chk_rodape']) ? $rodape=true : $espaco_inf = $_POST['inferior'];

//se tiver utilizando imagem verifico o a altura
/*if(isset($cabeca)){
	$img = "../../../../../datafiles/servicos/bbhive/corporativo/images/sistema/cabecalho.jpg";
	if(file_exists($img)){
		$tamanho 	= getimagesize($img);
		//$espaco		= $tamanho[1] / 2.8;
	}
}*/

//$mpdf->myvariable = file_get_contents('../../../../../datafiles/servicos/bbhive/corporativo/images/sistema/cabecalho.jpg');

//echo file_get_contents("http://www.iconfinder.net/search/8/?q=image");
//$html = ob_get_clean();
// pega o conteudo do buffer, insere na variavel e limpa a memória
//$html = ($html);
// converte o conteudo para uft-8
 define('MPDF_PATH', '');
 //define ('_MPDF_TEMP_PATH', 'tmp');
 include(MPDF_PATH.'mpdf.php');
// inclui a classe
  //if(isset($cabeca)){
   // $mpdf = new mPDF('', 'A4');
  //} else {
	$orientacao = $_POST['orientacao'];
	/*foreach($_POST as $indice=>$valor){
		echo $indice."=".$valor."<hr>";
	}exit;*/
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
	require_once("../../relatorios/painel/editor/gera.php");
// $mpdf->AddPage()
	//$mpdf->WriteHTML($html);
// escreve definitivamente o conteudo no PDF

	if(isset($_POST['MM_compactar'])){
	//lista as opções de imagens para gif
		$localizacao_documento 	= explode("web",$_SESSION['caminhoFisico']);
		$diretorioDestino 		= $localizacao_documento[0] . "database/servicos/bbhive/fluxo/fluxo_".$_POST['bbh_flu_codigo']."/documentos/".$bbh_rel_codigo."/";
		
		
		
		$mpdf->Output($diretorioDestino.'rel_'.$bbh_rel_codigo.'_'.trataCaracteres(strtolower($_SESSION['relNome'])).'.pdf', 'F');
		header("Location: ../../relatorios/painel/ZIP/zip.php?".md5(true));
		exit;
	} else {
		$mpdf->Output('relatorio_'.$bbh_rel_codigo.'.pdf', 'D');
//		$mpdf->Output();
		exit();
	}


//$mpdf->Output();
// imprime
 
//exit();
// finaliza o codigo
?>