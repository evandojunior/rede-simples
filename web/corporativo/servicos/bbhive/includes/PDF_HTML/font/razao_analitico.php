<?php require_once('../../../../../Connections/contabil.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

function Real($valor){  
    $valorretorno=number_format($valor, 2, ',', '.');  
    return $valorretorno;  
}

function normatizaCep($codigo)
{
	$codigoUnitario = explode(".",$codigo);
	$codigoPadrao = "";
	for($cont = 0; $cont < count($codigoUnitario); $cont++)
	{
		$codigoPadrao .= (int)$codigoUnitario[$cont] . ".";	
	}
		
	return substr($codigoPadrao,0,strlen($codigoPadrao)-1);
}


//Inclusão da classe Profundidade que faz o algoritmo de busca em profundidade

require('pdf.php');
$pdf=new pdf(); //Diz como será o formato do PDF
$codigo_empresa = $_GET['con_emp_codigo'];

$data_inico = $_GET['theDate'];
$data_inico = substr($_GET['theDate'],6,4) . "-";
$data_inico .= substr($_GET['theDate'],3,2) . "-";
$data_inico .= substr($_GET['theDate'],0,2);

$data_fim = substr($_GET['theDate2'],6,4) . "-";
$data_fim .= substr($_GET['theDate2'],3,2) . "-";
$data_fim .= substr($_GET['theDate2'],0,2);

if($_GET['plano_contas']=="1"){//busca de acordo com estrutura do plano de contas

		require_once('../../rotinas/razao/includes/classe_razao.php');
		
		
		if(isset($_GET['con_gru_emp_codigo']))
		{
        
		$codigo_grupo = $_GET['con_gru_emp_codigo'];	
		//Criação do objeto Profundidade
		$Profundidade = new Profundidade($contabil);
		//Chamada ao método buscaEmProfundidade que popula um array com todos as contas
		$Profundidade->buscaEmProfundidade($codigo_empresa,$codigo_grupo);
		//Acessando a variável contasLancamento que é array resultante da chamada da função buscaProfundidade
		$contasLancamento = $Profundidade->contasLancamento;
		$contasLancamento = array_unique($contasLancamento);
		//Obtendo informações do grupo
		
		mysql_select_db($database_contabil, $contabil);
		$query_grupo_pai = sprintf("select cont_grupo_empresa_$codigo_empresa.con_gru_emp_conta,cont_grupo_empresa_$codigo_empresa.con_gru_emp_codigo_conta
		FROM cont_grupo_empresa_$codigo_empresa
		where con_gru_emp_codigo = %s", GetSQLValueString($codigo_grupo, "int"));
		$grupo_pai = mysqli_query($query_grupo_pai, $contabil) or die(mysqli_error($bbhive));
		$row_grupo_pai = mysqli_fetch_assoc($grupo_pai);
		$totalRows_grupo_pai = mysqli_num_rows($grupo_pai);
		  
		}else{
			 //Se não tiver vindo do grupo, veio da conta, então tem apenas uma conta de lançamenento.
			 $contasLancamento = array();
			 array_push($contasLancamento,$_GET['con_con_emp_codigo']);
			
		
		}
} else {// busca exclusiva pelo nome da conta, acrescentando no array o código das mesmas.

	$SaldoGeral = 0;
	mysql_select_db($database_contabil, $contabil);
	$query_ContaNome = "select con_con_emp_codigo from cont_conta_empresa_".$_GET['con_emp_codigo']."
Where con_con_emp_conta LIKE '%".$_GET['nm_conta']."%'";
	$ContaNome = mysqli_query($query_ContaNome, $contabil) or die(mysqli_error($bbhive));
	$row_ContaNome = mysqli_fetch_assoc($ContaNome);
	$totalRows_ContaNome = mysqli_num_rows($ContaNome);

	$contasLancamento = array();
	if($totalRows_ContaNome>0){
		do{
			array_push($contasLancamento,$row_ContaNome['con_con_emp_codigo']);
		}while($row_ContaNome = mysqli_fetch_assoc($ContaNome));
	} else {
		echo "N&atilde;o h&aacute; contas com este nome!!!";
		exit;
	}
}
$SaldosTotais = 0;
for($contadorContas = 0; $contadorContas < count($contasLancamento); $contadorContas++)
{
	
$colname_conta_escohida = $contasLancamento[$contadorContas];

$string_provisionamento = " AND (con_lan_emp_provisionado != 1 || con_lan_emp_provisionado IS NULL)";

$string_encerramento = "";
if(!isset($_GET['encerramento']))
{
	$string_encerramento = " AND con_lan_emp_encerramento IS NULL";
}

mysql_select_db($database_contabil, $contabil);
$query_saldo_anterior = "SELECT date_format(cont_lancamento_empresa_$codigo_empresa.con_lan_data,'%d/%m/%Y') as data,       cont_lancamento_empresa_$codigo_empresa.con_lan_emp_codigo as codigo_lancamento,       debito.con_con_emp_codigo as codigo_debito,debito.con_con_emp_conta as debito,       credito.con_con_emp_codigo as codigo_credito,credito.con_con_emp_conta as credito,       cont_lancamento_empresa_$codigo_empresa.con_his_lan_descricao,       cont_lancamento_empresa_$codigo_empresa.con_lan_observacao,       cont_lancamento_empresa_$codigo_empresa.con_lan_valor
 FROM cont_lancamento_empresa_$codigo_empresa  INNER JOIN cont_conta_empresa_$codigo_empresa as debito ON debito.con_con_emp_codigo = cont_lancamento_empresa_$codigo_empresa.con_lan_conta_debito INNER JOIN cont_conta_empresa_$codigo_empresa as credito ON credito.con_con_emp_codigo = cont_lancamento_empresa_$codigo_empresa.con_lan_conta_credito WHERE (con_lan_conta_credito = $colname_conta_escohida or con_lan_conta_debito = $colname_conta_escohida)  and (cont_lancamento_empresa_$codigo_empresa.con_lan_data < '$data_inico') 
 $string_provisionamento $string_encerramento
ORDER BY cont_lancamento_empresa_$codigo_empresa.con_lan_data";
$saldo_anterior = mysqli_query($query_saldo_anterior, $contabil) or die(mysqli_error($bbhive));
$row_saldo_anterior = mysqli_fetch_assoc($saldo_anterior);
$totalRows_saldo_anterior = mysqli_num_rows($saldo_anterior);

mysql_select_db($database_contabil, $contabil);
$query_razao = "SELECT date_format(cont_lancamento_empresa_$codigo_empresa.con_lan_data,'%d/%m/%Y') as data,       cont_lancamento_empresa_$codigo_empresa.con_lan_emp_codigo as codigo_lancamento,
debito.con_con_emp_codigo as codigo_debito,debito.con_con_emp_conta as debito,debito.con_con_emp_codigo_conta as codigo_conta_debito, credito.con_con_emp_codigo as codigo_credito, credito.con_con_emp_codigo_conta as codigo_conta_credito ,credito.con_con_emp_conta as credito,       cont_lancamento_empresa_$codigo_empresa.con_his_lan_descricao,       cont_lancamento_empresa_$codigo_empresa.con_lan_observacao,       cont_lancamento_empresa_$codigo_empresa.con_lan_valor,
cont_lancamento_empresa_$codigo_empresa.con_lan_emp_campo_adicional_1,
cont_lancamento_empresa_$codigo_empresa.con_lan_emp_campo_adicional_2,
cont_lancamento_empresa_$codigo_empresa.con_lan_emp_campo_adicional_3 

FROM cont_lancamento_empresa_$codigo_empresa  INNER JOIN cont_conta_empresa_$codigo_empresa as debito ON debito.con_con_emp_codigo = cont_lancamento_empresa_$codigo_empresa.con_lan_conta_debito INNER JOIN cont_conta_empresa_$codigo_empresa as credito ON credito.con_con_emp_codigo = cont_lancamento_empresa_$codigo_empresa.con_lan_conta_credito WHERE (con_lan_conta_credito = $colname_conta_escohida or con_lan_conta_debito = $colname_conta_escohida)  and (cont_lancamento_empresa_$codigo_empresa.con_lan_data >= '$data_inico' and cont_lancamento_empresa_$codigo_empresa.con_lan_data <= '$data_fim')
$string_provisionamento $string_encerramento
ORDER BY cont_lancamento_empresa_$codigo_empresa.con_lan_data";
$razao = mysqli_query($query_razao, $contabil) or die(mysqli_error($bbhive));
$row_razao = mysqli_fetch_assoc($razao);
$totalRows_razao = mysqli_num_rows($razao);


mysql_select_db($database_contabil, $contabil);
$query_conta_escohida = sprintf("select cont_grupo_empresa_$codigo_empresa.con_gru_emp_conta,cont_grupo_empresa_$codigo_empresa.con_gru_emp_codigo_conta, cont_conta_empresa_$codigo_empresa.* from cont_conta_empresa_$codigo_empresa  inner join cont_grupo_empresa_$codigo_empresa on cont_grupo_empresa_$codigo_empresa.con_gru_emp_codigo = cont_conta_empresa_$codigo_empresa.con_gru_emp_codigo where con_con_emp_codigo = %s", GetSQLValueString($colname_conta_escohida, "int"));
$conta_escohida = mysqli_query($query_conta_escohida, $contabil) or die(mysqli_error($bbhive));
$row_conta_escohida = mysqli_fetch_assoc($conta_escohida);
$totalRows_conta_escohida = mysqli_num_rows($conta_escohida);

$colname_empresa = "-1";
if (isset($_GET['con_emp_codigo'])) {
  $colname_empresa = $_GET['con_emp_codigo'];
}
mysql_select_db($database_contabil, $contabil);
$query_empresa = sprintf("SELECT * FROM con_empresa WHERE con_emp_codigo = %s", GetSQLValueString($colname_empresa, "int"));
$empresa = mysqli_query($query_empresa, $contabil) or die(mysqli_error($bbhive));
$row_empresa = mysqli_fetch_assoc($empresa);
$totalRows_empresa = mysqli_num_rows($empresa);

	
//Laço para saber o saldo atual baseado nos lançamentos anteriores
$credito = 0;
$debito = 0;
$saldo = 0;
$total_debito = 0;
$total_credito = 0;
do{


	if($colname_conta_escohida == $row_saldo_anterior['codigo_debito'])
	{

			$debito = $debito + $row_saldo_anterior['con_lan_valor'];
			$conta = $row_saldo_anterior['credito'];

	}else{
			$credito = $credito + $row_saldo_anterior['con_lan_valor'];

			$conta = $row_saldo_anterior['debito'];

	}
				
}while($row_saldo_anterior = mysqli_fetch_assoc($saldo_anterior));
$saldo =  $credito - $debito;

if($row_conta_escohida['con_con_emp_expira'] == ""){ 
	$expira =  "___";
}else{
 	$expira = $row_conta_escohida['con_con_emp_expira'];
}
  
if($row_conta_escohida['con_con_emp_natureza'] == "D")
 { $natureza =  "Devedora"; }else{ $natureza =  "Credora"; }

if($row_conta_escohida['con_con_exercicio'] == ""){ $exercicio =  "___"; }else{ $exercicio =  $row_conta_escohida['con_con_exercicio']; } 

$pdf->tituloCabecalho = "Razão Analítico";
$pdf->textCabecalho = "Conta : " . normatizaCep($row_conta_escohida['con_con_emp_codigo_conta']) . " - " .$row_conta_escohida['con_con_emp_conta'];
$pdf->textCabecalho2 = "Esta conta é do grupo : " .normatizaCep($row_conta_escohida['con_gru_emp_codigo_conta'])  . " - " . $row_conta_escohida['con_gru_emp_conta'] ;
$pdf->textCabecalho3 = "A natureza desta conta é " . $natureza;
$pdf->textCabecalho4 = "Ela expira em : " . $expira;
$pdf->textCabecalho5 = "Exercício da conta : " . $exercicio;
$pdf->empresa = $codigo_empresa;




$pdf->AddPage(); //Cria uma página em branco do PDF
$pdf->SetWidths(array(21,13,100,23,23,24));
$pdf->SetTextColor(0,0,0); //Define a cor do texto em RGB
$pdf->SetFont('Arial','B',9); //Nova fonte
$pdf->SetFillColor(255,255,255); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(0,6,'Periodo: '.$_GET['theDate'].' a '. $_GET['theDate2'],0,1,'L',1); // Texto escrito
$pdf->SetTextColor(255,255,255); //Define a cor do texto em RGB
$pdf->SetFillColor(98,98,98); //Define a cor do preenchimento da célula em RGB
if($saldo < 0)
{
	$saldo_exibir = Real($saldo  * -1) . " D";
}else if($saldo == 0)
{
	$saldo_exibir = Real($saldo  * -1);
}else{
	$saldo_exibir = Real($saldo) . " C";
}

$pdf->Cell(0,5,'Saldo anterior da conta: '.$saldo_exibir,1,1,'R',1); // Texto escrito
$pdf->Ln(2);
$pdf->SetTextColor(0,0,0); //Define a cor do texto em RGB
$pdf->SetFillColor(223,223,223); //Define a cor do preenchimento da célula em RGB
$pdf->Cell(21,5,'Data',1,0,'C',1);
$pdf->Cell(13,5,'Doc',1,0,'C',1);
$pdf->Cell(100,5,'Lancamento contra partida',1,0,'L',1);
$pdf->Cell(23,5,'Debito',1,0,'R',1);
$pdf->Cell(23,5,'Credito',1,0,'R',1);
$pdf->Cell(24,5,'Saldo',1,0,'R',1);
// Início dos dados
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(244,244,242);


$debito = "";
$credito = "";
$conta = "";
$codigo_conta = "";
$saldo_corrente = $saldo;
$contador_cor = 0;


if($totalRows_razao > 0){
		//---Inicio do Laço
		do{
		
						//Definindo os valores de débito e crédito:
						if($colname_conta_escohida == $row_razao['codigo_debito'])
						{
							$debito = $row_razao['con_lan_valor'];
							$credito = "0,00";
							$conta = $row_razao['credito'];	
							$codigo_conta = $row_razao['codigo_conta_credito'];					
						}else{
		
							$debito = "0,00";
							$credito = $row_razao['con_lan_valor'];
							$conta = $row_razao['debito'];
							$codigo_conta = $row_razao['codigo_conta_debito'];	
						}
						
						$total_debito += $debito;
						$total_credito += $credito; 
				  
					 $saldo_corrente = trim($saldo_corrente) - $debito;
		
					$saldo_corrente = trim($saldo_corrente) + $credito; 
					if($saldo_corrente < 1)
					{
						if(Real($saldo_corrente*-1) == "-0,00")
						{
						
							$mostraSaldo = "0,00 D";
						 }else{
							$mostraSaldo = Real($saldo_corrente*-1) . " D";
						 }
		
					}else{
						$mostraSaldo =  Real($saldo_corrente) . " C";
					}
		
			$pdf->Row(array($row_razao['data'] . "|C",$row_razao['codigo_lancamento'] . "|C",normatizaCep($codigo_conta) . " - " . $conta . "    - Histórico - " . $row_razao['con_his_lan_descricao']  ." - Descrição - " . $row_razao['con_lan_observacao'] . " " . $row_razao['con_lan_emp_campo_adicional_1'] . " " . $row_razao['con_lan_emp_campo_adicional_2'] .  " " . $row_razao['con_lan_emp_campo_adicional_3'] ." " . "|L",Real($debito) . "|R",Real($credito) . "|R",$mostraSaldo . "|R"));
		
				
				  
		 } while ($row_razao = mysqli_fetch_assoc($razao));
		
		
		$pdf->Row(array("Total","","",Real($total_debito)."|R",Real($total_credito)."|R",""));
		
		//Fim dos dados
		$pdf->SetTextColor(255,255,255); //Define a cor do texto em RGB
		$pdf->SetFillColor(98,98,98); //Define a cor do preenchimento da célula em RGB
		if($saldo_corrente < 0)
		{
			$saldo_final = Real($saldo_corrente * -1) . " D";
		}else if($saldo_corrente == 0){
			$saldo_final = Real($saldo_corrente * -1);
		}else{
			$saldo_final = Real($saldo_corrente) . " C";
		}
		$SaldosTotais += $saldo_corrente;
		
		$pdf->Cell(0,6,'Saldo da  conta em : '. $saldo_final,1,1,'R',1); // Texto escrito
}else{
		$pdf->Cell(0,6,'Não há histórico de lançamentos no período selecionado.',1,1,'L',1); // Texto escrito
}

}

if(isset($_GET['con_gru_emp_codigo']))
{
		if($SaldosTotais > 0)
		{
			$saldo_exibir = Real($SaldosTotais) . " C";
		}else if($SaldosTotais == 0)
		{
			$saldo_exibir = Real($SaldosTotais);
		}else{
			$saldo_exibir = Real($SaldosTotais *-1) . " D";
		}
		$pdf->Ln(2);
		$pdf->SetTextColor(255,255,255); //Define a cor do texto em RGB
		$pdf->SetFillColor(98,98,98); //Define a cor do preenchimento da célula em RGB

$pdf->Cell(180,5,'Total do grupo '. normatizaCep($row_grupo_pai['con_gru_emp_codigo_conta']) . " - " . $row_grupo_pai['con_gru_emp_conta'],1,0,'L',1);

$pdf->Cell(24,5,$saldo_exibir,0,0,'R',1);


}

$pdf->Output(); //Fim

?>