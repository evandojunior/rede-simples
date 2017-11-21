<?php
#
require('fpdf/fpdf.php');
#
//definindo a fonte !
#
define('FPDF_FONTPATH','fpdf/font/');
#
//instancia a classe.. P=Retrato, mm =tipo de medida utilizada no casso milimetros, tipo de folha =A4
#
//P=Reatrato
//L=Paisagem
	//PADRÕES DE PÁGINAS
	//'a3'=>array(841.89,1190.55)
	//'a4'=>array(595.28,841.89)
	//'a5'=>array(420.94,595.28)
	//'letter'=>array(612,792)
	//'legal'=>array(612,1008)
	//"tabloid"=> array(792.00, 1224.00)
	//"extra"=>array(1124.00, 1740.00)

//$pdf=new FPDF('L','mm','legal'); //Diz como será o formato do PDF
$orientacao = "L";//$_GET['orientacao'];
$tamanho	= "a4";//$_GET['tamanho'];

$pdf=new FPDF($orientacao,'mm',$tamanho); //Diz como será o formato do PDF

$pdf->tituloCabecalho = "Cabecalho";
$pdf->textCabecalho = "Texto";
$pdf->empresa = "";

$pdf->AddPage(); //Cria uma página em branco do PDF
$pdf->SetFont('Arial','B',8); //Seta a fonte
$pdf->SetTextColor(0,0,0); // Cor da fonte em RGB
$pdf->SetFillColor(255,255,255); // Cor do fundo em RGB
$data = date("d") . "/" . date("m") . "/" . date("Y");
$pdf->Cell(100,6,mysqli_fetch_assoc('Relatório emitido em ').$data,0,1,'L',1); //Texto
//$pdf->Ln(1); //Quebra de linha

$pdf->SetFont('Arial','B',16); //Nova fonte
$pdf->SetTextColor(28,28,28); //Define a cor do texto em RGB
$pdf->SetFillColor(220,220,220); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(0,6,$titulo_relatorio,1,1,'C',1); // Texto escrito
$pdf->Ln(5); //Quebra de linhas

$pdf->SetFont('Arial','B',8); //Seta a fonte

		
	$pdf->SetFillColor(255,255,255); //Define a cor do preenchimento da célula em RGB
	$pdf->Cell($largura,6, $vrCampo,1,0,'L',1);
	$pdf->Ln(6);

$pdf->Output('relatorio.pdf','D');
?>