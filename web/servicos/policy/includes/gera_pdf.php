<?php
#
require_once("../../../../Connections/policy.php");
require_once('functions.php');
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
$orientacao = "P";
$tamanho	= "a4";

$pdf=new FPDF($orientacao,'mm',$tamanho); //Diz como será o formato do PDF

$pdf->tituloCabecalho = "Cabecalho";
$pdf->textCabecalho = "Texto";
$pdf->empresa = "";

$pdf->AddPage(); //Cria uma página em branco do PDF
$pdf->SetTextColor(0,0,0); // Cor da fonte em RGB
$pdf->SetFillColor(255,255,255); // Cor do fundo em RGB
$data = date("d") . "/" . date("m") . "/" . date("Y");
//$pdf->Ln(1); //Quebra de linha

//===Select icone da aplicacao===//

mysql_select_db($database_policy, $policy);
$query_icone = "SELECT pol_apl_icone FROM pol_aplicacao WHERE pol_aplicacao.pol_apl_codigo = ".$_POST['pol_apl_codigo']." GROUP BY pol_aplicacao.pol_apl_codigo";
$icone = mysql_query($query_icone, $policy) or die(mysql_error());
$row_icone = mysql_fetch_assoc($icone);
$totalRows_icone = mysql_num_rows($icone);

//=====Fim Select icone da aplicacao====///

$pdf->SetTextColor(28,28,28); //Define a cor do texto em RGB
$pdf->SetFillColor(255,255,255); //Define a cor do preenchimento da célula em RGB
//$pdf->Cell(30,6,('Relatório emitido em '),0,0,'L',1); //Texto
$pdf->Image('../../../../datafiles/servicos/policy/aplicacoes/'.$row_icone['pol_apl_icone'].'',0,0);
$pdf->SetFont('Arial','B',16); //Nova fonte
$pdf->Cell(185,6,"Relatório de acesso - ".$_POST['pol_apl_nome'],0,2,'C',0); // Texto escrito
$pdf->Ln(1); //Quebra de linhas
$pdf->SetFont('Arial','B',8); //Seta a fonte
$pdf->Cell(149,6,'Relatório emitido em '.$data,0,1,'C',0); //Texto
$pdf->Ln(5); //Quebra de linhas


$pdf->SetFont('Arial','B',8); //Seta a fonte
$pdf->SetFillColor(245,245,245); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(25,6,("Usuário"),1,0,'L',1);
$pdf->SetFont('Arial','',8); //Seta a fonte
$pdf->SetFillColor(255,255,255); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(165,6,$_POST['pol_aud_usuario'],1,0,'L',1);
$pdf->Ln(6);

$pdf->SetFont('Arial','B',8); //Seta a fonte
$pdf->SetFillColor(245,245,245); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(25,6,("Ação"),1,0,'L',1);
$pdf->SetFont('Arial','',8); //Seta a fonte
$pdf->SetFillColor(255,255,255); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(165,6,$_POST['pol_aud_acao'],1,0,'L',1);
$pdf->Ln(6);

$pdf->SetFont('Arial','B',8); //Seta a fonte
$pdf->SetFillColor(245,245,245); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(25,6,("Momento"),1,0,'L',1);
$pdf->SetFont('Arial','',8); //Seta a fonte
$pdf->SetFillColor(255,255,255); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(165,6,$_POST['momento'],1,0,'L',1);
$pdf->Ln(6);

$pdf->SetFont('Arial','B',8); //Seta a fonte
$pdf->SetFillColor(245,245,245); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(25,6,("Localização"),1,0,'L',1);
$pdf->SetFont('Arial','',8); //Seta a fonte
$pdf->SetFillColor(255,255,255); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(165,6,$_POST['pol_aud_ip'],1,0,'L',1);
$pdf->Ln(6);

$pdf->SetFont('Arial','B',8); //Seta a fonte
$pdf->SetFillColor(245,245,245); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(25,6,("Relevância"),1,0,'L',1);
$pdf->SetFont('Arial','',8); //Seta a fonte
$pdf->SetFillColor(255,255,255); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(165,6,$_POST['pol_aud_relevancia'],1,0,'L',1);
$pdf->Ln(6);

$pdf->SetFont('Arial','B',8); //Seta a fonte
$pdf->SetFillColor(245,245,245); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(25,6,("Nível da ação"),1,0,'L',1);
$pdf->SetFont('Arial','',8); //Seta a fonte
$pdf->SetFillColor(255,255,255); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(165,6,$_POST['pol_aud_nivel'],1,0,'L',1);
$pdf->Ln(6);

$pdf->SetFont('Arial','B',8); //Seta a fonte
$pdf->SetFillColor(245,245,245); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(25,6,("Aplicação"),1,0,'L',1);
$pdf->SetFont('Arial','',8); //Seta a fonte
$pdf->SetFillColor(255,255,255); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(165,6,$_POST['pol_apl_nome'],1,0,'L',1);
$pdf->Ln(10);

if(isset($_POST['pol_aud_obs'])){$obs=$_POST['pol_aud_obs'];}else{$obs="";}
$pdf->SetFont('Arial','B',8); //Seta a fonte
$pdf->SetFillColor(245,245,245); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(0,5,("Observações sobre o evento:"),1,0,'L',1);
$pdf->Ln(6);
$pdf->SetFont('Arial','',8); //Seta a fonte
$pdf->SetFillColor(255,255,255); //Define a cor do preenchimento da célula em RGB
//$pdf->Write(4,$obs);
$pdf->Cell(0,4,$obs,1,0,'L',1);
$pdf->Ln(6);

//Código de barras
$tratado = geraCodigo($_POST['pol_aud_codigo']);
$pdf->Image('../../../../datafiles/servicos/policy/documentos/codigo_barra/'.$tratado.'.png');
$pdf->Ln(2);
$pdf->Write(1,$tratado);

$pdf->Output('relatorio'.$_POST['pol_aud_codigo'].'.pdf','D');//D-download / I-tela
?>